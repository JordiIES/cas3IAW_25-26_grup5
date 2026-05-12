<?php
require_once '../includes/session.php';
require_once '../config.php';
checkProfessorat();

$id = $_GET['id'] ?? null;
if (!$id) { header('Location: dispositius.php'); exit; }

$stmt = $pdo->prepare("
    SELECT m.*, t.tipus, t.model, u.nom AS aula
    FROM Material m
    JOIN TipusMaterial t ON m.idTipus = t.id
    JOIN Ubicacions u ON m.idUbicacio = u.id
    WHERE m.id = ?
");
$stmt->execute([$id]);
$material = $stmt->fetch();
if (!$material) { header('Location: dispositius.php'); exit; }

$tipus = $pdo->query("SELECT * FROM TipusMaterial")->fetchAll();
$ubicacions = $pdo->query("SELECT * FROM Ubicacions")->fetchAll();

$assignacio = $pdo->prepare("
    SELECT a.id AS idAssignacio, al.nom, al.cognom1, al.cognom2, a.dataInici
    FROM Assignacions a
    JOIN Alumnes al ON a.idAlumne = al.id
    WHERE a.idMaterial = ? AND a.dataFinal IS NULL
");
$assignacio->execute([$id]);
$assignat = $assignacio->fetch();

$incidencies = $pdo->prepare("
    SELECT i.*, e.estat
    FROM Incidencies i
    JOIN Estats e ON i.idEstat = e.id
    WHERE i.idDispositiu = ?
    ORDER BY i.dataOberta DESC
");
$incidencies->execute([$id]);
$incidencies = $incidencies->fetchAll();

if (isset($_POST['actualitzar'])) {
    $pdo->prepare("UPDATE Material SET idTipus=?, idInventari=?, etiquetaDepInf=?, numSerie=?, macEthernet=?, macWifi=?, SACE=?, dataAdquisicio=?, idUbicacio=? WHERE id=?")
        ->execute([
            $_POST['idTipus'],
            $_POST['idInventari'],
            $_POST['etiquetaDepInf'] ?: null,
            $_POST['numSerie'] ?: null,
            $_POST['macEthernet'] ?: null,
            $_POST['macWifi'] ?: null,
            $_POST['SACE'] ?: null,
            $_POST['dataAdquisicio'] ?: null,
            $_POST['idUbicacio'],
            $id
        ]);
    header('Location: dispositius.php?missatge=actualitzat');
    exit;
}

if (isset($_POST['eliminar'])) {
    $pdo->prepare("DELETE FROM Assignacions WHERE idMaterial = ?")->execute([$id]);
    $pdo->prepare("DELETE FROM Incidencies WHERE idDispositiu = ?")->execute([$id]);
    $pdo->prepare("DELETE FROM Material WHERE id = ?")->execute([$id]);
    header('Location: dispositius.php');
    exit;
}

if (isset($_POST['desvincular'])) {
    $pdo->prepare("UPDATE Assignacions SET dataFinal = CURDATE() WHERE id = ?")
        ->execute([$_POST['idAssignacio']]);
    header('Location: gestionar_material.php?id=' . $id);
    exit;
}

$navLinks = ['Dispositius' => 'dispositius.php', 'Inici' => 'dashboard.php'];
require_once '../includes/header.php';
?>
<div class="container">
    <h2>Gestionar material</h2>

    <div class="card">
        <h3>Dades del dispositiu</h3>
        <form method="POST">
            <div class="form-grid">
                <div>
                    <label>Tipus</label>
                    <select name="idTipus">
                        <?php foreach ($tipus as $t): ?>
                            <option value="<?= $t['id'] ?>" <?= $material['idTipus'] == $t['id'] ? 'selected' : '' ?>>
                                <?= $t['tipus'] ?> - <?= $t['model'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label>Ubicació</label>
                    <select name="idUbicacio">
                        <?php foreach ($ubicacions as $u): ?>
                            <option value="<?= $u['id'] ?>" <?= $material['idUbicacio'] == $u['id'] ? 'selected' : '' ?>>
                                <?= $u['nom'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label>Num. Inventari</label>
                    <input type="text" name="idInventari" value="<?= $material['idInventari'] ?>" required>
                </div>
                <div>
                    <label>Etiqueta Dep. Inf.</label>
                    <input type="text" name="etiquetaDepInf" value="<?= $material['etiquetaDepInf'] ?>">
                </div>
                <div>
                    <label>Num. Sèrie</label>
                    <input type="text" name="numSerie" value="<?= $material['numSerie'] ?>">
                </div>
                <div>
                    <label>MAC Ethernet</label>
                    <input type="text" name="macEthernet" value="<?= $material['macEthernet'] ?>">
                </div>
                <div>
                    <label>MAC Wifi</label>
                    <input type="text" name="macWifi" value="<?= $material['macWifi'] ?>">
                </div>
                <div>
                    <label>SACE</label>
                    <input type="text" name="SACE" value="<?= $material['SACE'] ?>">
                </div>
                <div>
                    <label>Data adquisició</label>
                    <input type="date" name="dataAdquisicio" value="<?= $material['dataAdquisicio'] ?>">
                </div>
            </div>
            <div class="botons">
                <button class="btn" type="submit" name="actualitzar">Guardar canvis</button>
                <button class="btn-danger" type="submit" name="eliminar"
                    onclick="return confirm('Segur que vols eliminar aquest dispositiu?')">
                    Eliminar dispositiu
                </button>
            </div>
        </form>
    </div>

    <div class="card">
        <h3>Alumne assignat</h3>
        <?php if ($assignat): ?>
            <p><?= $assignat['nom'] ?> <?= $assignat['cognom1'] ?> <?= $assignat['cognom2'] ?> — des del <?= $assignat['dataInici'] ?></p>
            <form method="POST" style="margin-top:10px;">
                <input type="hidden" name="idAssignacio" value="<?= $assignat['idAssignacio'] ?>">
                <button class="btn-danger" type="submit" name="desvincular"
                    onclick="return confirm('Segur que vols desvincular aquest alumne?')">
                    Desvincular
                </button>
            </form>
        <?php else: ?>
            <p style="color:#888; font-size:14px;">Cap alumne assignat.</p>
        <?php endif; ?>
    </div>

    <div class="card">
        <h3>Incidències</h3>
        <a class="btn" href="nova_incidencia.php?idMaterial=<?= $id ?>" style="margin-bottom:16px; display:inline-block;">+ Nova incidència</a>
        <?php if (empty($incidencies)): ?>
            <p style="color:#888; font-size:14px;">Cap incidència registrada.</p>
        <?php else: ?>
        <table>
            <tr>
                <th>Informació</th>
                <th>Data oberta</th>
                <th>Data tancada</th>
                <th>Estat</th>
                <th>Accions</th>
            </tr>
            <?php foreach ($incidencies as $i): ?>
            <tr>
                <td><?= $i['informacio'] ?></td>
                <td><?= $i['dataOberta'] ?></td>
                <td><?= $i['dataTancada'] ?? '-' ?></td>
                <td>
                    <?php
                    $classe = match($i['estat']) {
                        'Tancada' => 'badge-actiu',
                        'En procés' => 'badge-warning',
                        default => 'badge-finalitzat'
                    };
                    ?>
                    <span class="badge <?= $classe ?>"><?= $i['estat'] ?></span>
                </td>
                <td><a class="btn" href="gestionar_incidencia.php?id=<?= $i['id'] ?>">Gestionar</a></td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
<?php require_once '../includes/footer.php'; ?>
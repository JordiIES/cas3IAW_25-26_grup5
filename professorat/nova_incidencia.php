<?php
require_once '../includes/session.php';
require_once '../config.php';
checkProfessorat();

$idMaterial = $_GET['idMaterial'] ?? null;

$materials = $pdo->query("
    SELECT m.id, t.tipus, t.model, m.idInventari
    FROM Material m
    JOIN TipusMaterial t ON m.idTipus = t.id
    ORDER BY t.tipus
")->fetchAll();

$alumnes = $pdo->query("SELECT * FROM Alumnes ORDER BY cognom1")->fetchAll();

$alumneAssignat = null;
if ($idMaterial) {
    $stmt = $pdo->prepare("
        SELECT al.id, al.nom, al.cognom1
        FROM Assignacions a
        JOIN Alumnes al ON a.idAlumne = al.id
        WHERE a.idMaterial = ? AND a.dataFinal IS NULL
    ");
    $stmt->execute([$idMaterial]);
    $alumneAssignat = $stmt->fetch();
}

$error = '';

if (isset($_POST['crear'])) {
    if (empty($_POST['informacio'])) {
        $error = 'La informació de la incidència és obligatòria';
    } elseif (empty($_POST['idMaterial'])) {
        $error = 'Has de seleccionar un dispositiu';
    } else {
        $idAlumne = $_POST['idAlumneAuto'] ?? ($_POST['idAlumne'] ?? null);
        $pdo->prepare("INSERT INTO Incidencies (informacio, dataOberta, idAlumne, idDispositiu, idEstat) VALUES (?,CURDATE(),?,?,1)")
            ->execute([$_POST['informacio'], $idAlumne, $_POST['idMaterial']]);
        header('Location: incidencies.php?missatge=creada');
        exit;
    }
}

$navLinks = ['Incidències' => 'incidencies.php', 'Inici' => 'dashboard.php'];
require_once '../includes/header.php';
?>
<div class="container">
    <h2>Nova incidència</h2>
    <div class="card">
        <?php if ($error): ?>
            <div class="missatge" style="background:#e74c3c; margin-bottom:16px;"><?= $error ?></div>
        <?php endif; ?>
        <form method="POST">
            <input type="hidden" name="idMaterial" value="<?= $idMaterial ?>">
            <div class="form-grid">
                <div>
                    <label>Dispositiu</label>
                    <select required onchange="window.location='nova_incidencia.php?idMaterial='+this.value">
                        <option value="">-- Selecciona un dispositiu --</option>
                        <?php foreach ($materials as $m): ?>
                            <option value="<?= $m['id'] ?>" <?= $idMaterial == $m['id'] ? 'selected' : '' ?>>
                                <?= $m['tipus'] ?> - <?= $m['model'] ?> (<?= $m['idInventari'] ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <?php if ($idMaterial): ?>
                    <?php if ($alumneAssignat): ?>
                        <div>
                            <label>Alumne assignat</label>
                            <input type="text" value="<?= $alumneAssignat['nom'] ?> <?= $alumneAssignat['cognom1'] ?>" disabled style="background:#f5f5f5;">
                            <input type="hidden" name="idAlumneAuto" value="<?= $alumneAssignat['id'] ?>">
                        </div>
                    <?php else: ?>
                        <div>
                            <label>Alumne (opcional)</label>
                            <select name="idAlumne">
                                <option value="">-- Cap alumne --</option>
                                <?php foreach ($alumnes as $a): ?>
                                    <option value="<?= $a['id'] ?>"><?= $a['nom'] ?> <?= $a['cognom1'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>

                <div style="grid-column: span 2">
                    <label>Informació</label>
                    <textarea name="informacio" rows="4" style="width:100%; padding:8px; border:1px solid #ccc; border-radius:4px; font-size:14px;" required></textarea>
                </div>
            </div>
            <button class="btn" type="submit" name="crear" style="margin-top:14px;">Crear incidència</button>
        </form>
    </div>
</div>
<?php require_once '../includes/footer.php'; ?>
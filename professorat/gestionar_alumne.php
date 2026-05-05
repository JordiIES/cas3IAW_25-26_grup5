<?php
require_once '../includes/session.php';
require_once '../config.php';
checkProfessorat();

$id = $_GET['id'] ?? null;
if (!$id) { header('Location: alumnes.php'); exit; }

$stmt = $pdo->prepare("SELECT * FROM Alumnes WHERE id = ?");
$stmt->execute([$id]);
$alumne = $stmt->fetch();
if (!$alumne) { header('Location: alumnes.php'); exit; }

$missatge = '';

if (isset($_POST['eliminar'])) {
    $pdo->prepare("DELETE FROM Assignacions WHERE idAlumne = ?")->execute([$id]);
    $pdo->prepare("DELETE FROM Alumnes WHERE id = ?")->execute([$id]);
    header('Location: alumnes.php');
    exit;
}

if (isset($_POST['desvincular'])) {
    $pdo->prepare("UPDATE Assignacions SET dataFinal = CURDATE() WHERE id = ?")
        ->execute([$_POST['idAssignacio']]);
    $missatge = 'Dispositiu desvinculat correctament';
}

if (isset($_POST['actualitzar'])) {
    $pdo->prepare("UPDATE Alumnes SET nom=?, cognom1=?, cognom2=?, correu=?, grupClasse=? WHERE id=?")
        ->execute([$_POST['nom'], $_POST['cognom1'], $_POST['cognom2'], $_POST['correu'], $_POST['grupClasse'], $id]);
    header('Location: alumnes.php?missatge=actualitzat');
    exit;
}

$stmt2 = $pdo->prepare("
    SELECT a.id AS idAssignacio, t.tipus, t.model, m.idInventari,
           a.dataInici, a.dataFinal, u.nom AS aula
    FROM Assignacions a
    JOIN Material m ON a.idMaterial = m.id
    JOIN TipusMaterial t ON m.idTipus = t.id
    JOIN Ubicacions u ON m.idUbicacio = u.id
    WHERE a.idAlumne = ?
    ORDER BY a.dataInici DESC
");
$stmt2->execute([$id]);
$dispositius = $stmt2->fetchAll();

$navLinks = ['Torna a alumnes' => 'alumnes.php', 'Inici' => 'dashboard.php'];
require_once '../includes/header.php';
?>
<div class="container">
    <h2>Gestionar alumne</h2>

    <div class="card">
        <h3>Dades de l'alumne</h3>
        <?php if ($missatge): ?>
            <div class="missatge"><?= $missatge ?></div>
        <?php endif; ?>
        <form method="POST">
            <div class="form-grid">
                <div>
                    <label>Nom</label>
                    <input type="text" name="nom" value="<?= $alumne['nom'] ?>" required>
                </div>
                <div>
                    <label>Primer cognom</label>
                    <input type="text" name="cognom1" value="<?= $alumne['cognom1'] ?>" required>
                </div>
                <div>
                    <label>Segon cognom</label>
                    <input type="text" name="cognom2" value="<?= $alumne['cognom2'] ?>">
                </div>
                <div>
                    <label>Correu</label>
                    <input type="email" name="correu" value="<?= $alumne['correu'] ?>" required>
                </div>
                <div>
                    <label>Grup classe</label>
                    <select name="grupClasse">
                        <option value="ASIX1" <?= $alumne['grupClasse'] === 'ASIX1' ? 'selected' : '' ?>>ASIX 1</option>
                        <option value="ASIX2" <?= $alumne['grupClasse'] === 'ASIX2' ? 'selected' : '' ?>>ASIX 2</option>
                        <option value="DAW1" <?= $alumne['grupClasse'] === 'DAW1' ? 'selected' : '' ?>>DAW 1</option>
                        <option value="DAW2" <?= $alumne['grupClasse'] === 'DAW2' ? 'selected' : '' ?>>DAW 2</option>
                    </select>
                </div>
            </div>
            <div class="botons">
                <button class="btn" type="submit" name="actualitzar">Guardar canvis</button>
                <button class="btn-danger" type="submit" name="eliminar"
                    onclick="return confirm('Segur que vols eliminar aquest alumne?')">
                    Eliminar alumne
                </button>
            </div>
        </form>
    </div>

    <div class="card">
        <h3>Dispositius assignats</h3>
        <?php if (empty($dispositius)): ?>
            <p style="color:#888; font-size:14px;">Aquest alumne no té dispositius assignats.</p>
        <?php else: ?>
        <table>
            <tr>
                <th>Tipus</th>
                <th>Model</th>
                <th>Inventari</th>
                <th>Aula</th>
                <th>Data inici</th>
                <th>Estat</th>
                <th>Accions</th>
            </tr>
            <?php foreach ($dispositius as $d): ?>
            <tr>
                <td><?= $d['tipus'] ?></td>
                <td><?= $d['model'] ?></td>
                <td><?= $d['idInventari'] ?></td>
                <td><?= $d['aula'] ?></td>
                <td><?= $d['dataInici'] ?></td>
                <td>
                    <?php if ($d['dataFinal'] === null): ?>
                        <span class="badge badge-actiu">Actiu</span>
                    <?php else: ?>
                        <span class="badge badge-finalitzat">Finalitzat</span>
                    <?php endif; ?>
                </td>
                <td>
                    <?php if ($d['dataFinal'] === null): ?>
                    <form method="POST">
                        <input type="hidden" name="idAssignacio" value="<?= $d['idAssignacio'] ?>">
                        <button class="btn-sm" type="submit" name="desvincular"
                            onclick="return confirm('Segur que vols desvincular aquest dispositiu?')">
                            Desvincular
                        </button>
                    </form>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>

<script>
const original = {
    nom: "<?= $alumne['nom'] ?>",
    cognom1: "<?= $alumne['cognom1'] ?>",
    cognom2: "<?= $alumne['cognom2'] ?>",
    correu: "<?= $alumne['correu'] ?>",
    grupClasse: "<?= $alumne['grupClasse'] ?>"
};

document.querySelector('[name="actualitzar"]').addEventListener('click', function(e) {
    const canviat =
        document.querySelector('[name="nom"]').value !== original.nom ||
        document.querySelector('[name="cognom1"]').value !== original.cognom1 ||
        document.querySelector('[name="cognom2"]').value !== original.cognom2 ||
        document.querySelector('[name="correu"]').value !== original.correu ||
        document.querySelector('[name="grupClasse"]').value !== original.grupClasse;

    if (!canviat) {
        e.preventDefault();
        alert('No has fet cap canvi!');
    }
});
</script>

<?php require_once '../includes/footer.php'; ?>
<?php
require_once '../includes/session.php';
require_once '../config.php';
checkProfessorat();

$id = $_GET['id'] ?? null;
if (!$id) { header('Location: incidencies.php'); exit; }

$stmt = $pdo->prepare("
    SELECT i.*, a.nom, a.cognom1, a.cognom2,
           t.tipus, t.model, m.idInventari
    FROM Incidencies i
    LEFT JOIN Alumnes a ON i.idAlumne = a.id
    JOIN Material m ON i.idDispositiu = m.id
    JOIN TipusMaterial t ON m.idTipus = t.id
    WHERE i.id = ?
");
$stmt->execute([$id]);
$incidencia = $stmt->fetch();
if (!$incidencia) { header('Location: incidencies.php'); exit; }

$estats = $pdo->query("SELECT * FROM Estats")->fetchAll();

if (isset($_POST['actualitzar'])) {
    $dataTancada = $_POST['dataTancada'] ?: null;
    $pdo->prepare("UPDATE Incidencies SET idEstat=?, informacio=?, dataTancada=? WHERE id=?")
        ->execute([$_POST['idEstat'], $_POST['informacio'], $dataTancada, $id]);
    header('Location: incidencies.php?missatge=actualitzat');
    exit;
}

if (isset($_POST['eliminar'])) {
    $pdo->prepare("DELETE FROM Incidencies WHERE id = ?")->execute([$id]);
    header('Location: incidencies.php');
    exit;
}

$navLinks = ['Incidències' => 'incidencies.php', 'Inici' => 'dashboard.php'];
require_once '../includes/header.php';
?>
<div class="container">
    <h2>Gestionar incidència</h2>

    <div class="card">
        <h3>Informació del dispositiu</h3>
        <p><strong>Alumne:</strong> <?= $incidencia['nom'] ?> <?= $incidencia['cognom1'] ?> <?= $incidencia['cognom2'] ?></p>
        <p style="margin-top:8px"><strong>Dispositiu:</strong> <?= $incidencia['tipus'] ?> <?= $incidencia['model'] ?> (<?= $incidencia['idInventari'] ?>)</p>
    </div>

    <div class="card">
        <h3>Dades de la incidència</h3>
        <form method="POST">
            <div class="form-grid">
                <div>
                    <label>Estat</label>
                    <select name="idEstat">
                        <?php foreach ($estats as $e): ?>
                            <option value="<?= $e['id'] ?>" <?= $incidencia['idEstat'] == $e['id'] ? 'selected' : '' ?>>
                                <?= $e['estat'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label>Data tancada</label>
                    <input type="date" name="dataTancada" value="<?= $incidencia['dataTancada'] ?>">
                </div>
                <div style="grid-column: span 2">
                    <label>Informació</label>
                    <textarea name="informacio" rows="4" style="width:100%; padding:8px; border:1px solid #ccc; border-radius:4px; font-size:14px;"><?= $incidencia['informacio'] ?></textarea>
                </div>
            </div>
            <div class="botons">
                <button class="btn" type="submit" name="actualitzar">Guardar canvis</button>
                <button class="btn-danger" type="submit" name="eliminar"
                    onclick="return confirm('Segur que vols eliminar aquesta incidència?')">
                    Eliminar incidència
                </button>
            </div>
        </form>
    </div>
</div>

<script>
const original = {
    idEstat: "<?= $incidencia['idEstat'] ?>",
    informacio: `<?= addslashes($incidencia['informacio']) ?>`,
    dataTancada: "<?= $incidencia['dataTancada'] ?>"
};

document.querySelector('[name="actualitzar"]').addEventListener('click', function(e) {
    const canviat =
        document.querySelector('[name="idEstat"]').value !== original.idEstat ||
        document.querySelector('[name="informacio"]').value !== original.informacio ||
        document.querySelector('[name="dataTancada"]').value !== original.dataTancada;

    if (!canviat) {
        e.preventDefault();
        alert('No has fet cap canvi!');
    }
});
</script>
<?php require_once '../includes/footer.php'; ?>
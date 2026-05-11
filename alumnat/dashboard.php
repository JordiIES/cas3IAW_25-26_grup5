<?php
require_once '../includes/session.php';
require_once '../config.php';
checkAlumnat();

$stmt = $pdo->prepare("
    SELECT t.tipus, t.model, m.idInventari, u.nom AS aula,
           a.dataInici, a.dataFinal
    FROM Assignacions a
    JOIN Material m ON a.idMaterial = m.id
    JOIN TipusMaterial t ON m.idTipus = t.id
    JOIN Ubicacions u ON m.idUbicacio = u.id
    WHERE a.idAlumne = ?
    ORDER BY a.dataInici DESC
");
$stmt->execute([$_SESSION['idAlumne']]);
$dispositius = $stmt->fetchAll();

$navLinks = [];
require_once '../includes/header.php';
?>
<div class="container">
    <h2>Els meus dispositius</h2>
    <?php if (empty($dispositius)): ?>
        <p style="text-align:center; color:#888;">No tens cap dispositiu assignat.</p>
    <?php else: ?>
    <table>
        <tr>
            <th>Tipus</th>
            <th>Model</th>
            <th>Inventari</th>
            <th>Aula</th>
            <th>Data inici</th>
            <th>Estat</th>
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
        </tr>
        <?php endforeach; ?>
    </table>
    <?php endif; ?>
</div>
<?php require_once '../includes/footer.php'; ?>
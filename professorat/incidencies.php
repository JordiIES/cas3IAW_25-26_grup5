<?php
require_once '../includes/session.php';
require_once '../config.php';
checkProfessorat();
$stmt = $pdo->query("
    SELECT i.id, i.informacio, i.dataOberta, i.dataTancada,
           a.nom, a.cognom1,
           t.tipus, t.model, m.idInventari,
           e.estat
    FROM Incidencies i
    LEFT JOIN Alumnes a ON i.idAlumne = a.id
    JOIN Material m ON i.idDispositiu = m.id
    JOIN TipusMaterial t ON m.idTipus = t.id
    JOIN Estats e ON i.idEstat = e.id
    ORDER BY i.dataOberta DESC
");
$incidencies = $stmt->fetchAll();
$navLinks = ['Inici' => 'dashboard.php'];
require_once '../includes/header.php';
?>
<div class="container">
    <?php if (isset($_GET['missatge']) && $_GET['missatge'] === 'actualitzat'): ?>
        <div class="missatge" id="missatge" style="margin-bottom: 16px;">Incidència actualitzada correctament</div>
        <script>setTimeout(() => document.getElementById('missatge').style.display = 'none', 2000);</script>
    <?php endif; ?>
    <?php if (isset($_GET['missatge']) && $_GET['missatge'] === 'creada'): ?>
        <div class="missatge" id="missatge" style="margin-bottom: 16px;">Incidència creada correctament</div>
        <script>setTimeout(() => document.getElementById('missatge').style.display = 'none', 3000);</script>
    <?php endif; ?>
    <h2>Incidències</h2>
    <table>
        <tr>
            <th>Alumne</th>
            <th>Dispositiu</th>
            <th>Informació</th>
            <th>Data oberta</th>
            <th>Data tancada</th>
            <th>Estat</th>
            <th>Accions</th>
        </tr>
        <?php foreach ($incidencies as $i): ?>
        <tr>
            <td><?= $i['nom'] ? $i['nom'] . ' ' . $i['cognom1'] : '-' ?></td>
            <td><?= $i['tipus'] ?> <?= $i['model'] ?> (<?= $i['idInventari'] ?>)</td>
            <td><?= $i['informacio'] ?></td>
            <td><?= $i['dataOberta'] ?></td>
            <td><?= $i['dataTancada'] ?? '-' ?></td>
            <td>
                <?php
                $classe = match($i['estat']) {
                    'Tancada' => 'badge-actiu',
                    'En procés' => 'badge badge-warning',
                    default => 'badge-finalitzat'
                };
                ?>
                <span class="badge <?= $classe ?>"><?= $i['estat'] ?></span>
            </td>
            <td><a class="btn" href="gestionar_incidencia.php?id=<?= $i['id'] ?>">Gestionar</a></td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>
<?php require_once '../includes/footer.php'; ?>
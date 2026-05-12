<?php
require_once '../includes/session.php';
require_once '../config.php';
checkProfessorat();

$ubicacions = $pdo->query("SELECT * FROM Ubicacions")->fetchAll();
$filtreAula = $_GET['aula'] ?? '';

$sql = "
    SELECT m.id, t.tipus, t.model, m.idInventari, u.nom AS aula,
           a.nom AS alumNom, a.cognom1, e.estat
    FROM Material m
    JOIN TipusMaterial t ON m.idTipus = t.id
    JOIN Ubicacions u ON m.idUbicacio = u.id
    LEFT JOIN Assignacions ass ON ass.idMaterial = m.id AND ass.dataFinal IS NULL
    LEFT JOIN Alumnes a ON ass.idAlumne = a.id
    LEFT JOIN Incidencies i ON i.idDispositiu = m.id AND i.idEstat != 3
    LEFT JOIN Estats e ON i.idEstat = e.id
";

if ($filtreAula) {
    $sql .= " WHERE u.id = " . (int)$filtreAula;
}

$sql .= " ORDER BY u.nom, t.tipus";

$dispositius = $pdo->query($sql)->fetchAll();

$navLinks = ['+ Nou maquinari' => 'nou_material.php', 'Inici' => 'dashboard.php'];
require_once '../includes/header.php';
?>
<div class="container">
    <?php if (isset($_GET['missatge']) && $_GET['missatge'] === 'creat'): ?>
        <div class="missatge" id="missatge" style="margin-bottom:16px;">Maquinari creat correctament</div>
        <script>setTimeout(() => document.getElementById('missatge').style.display = 'none', 3000);</script>
    <?php endif; ?>
    <?php if (isset($_GET['missatge']) && $_GET['missatge'] === 'actualitzat'): ?>
        <div class="missatge" id="missatge" style="margin-bottom:16px;">Maquinari actualitzat correctament</div>
        <script>setTimeout(() => document.getElementById('missatge').style.display = 'none', 3000);</script>
    <?php endif; ?>
    <h2>Dispositius</h2>
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:16px;">
        <form method="GET" style="display:flex; gap:10px; align-items:center;">
            <label>Filtrar per aula:</label>
            <select name="aula" onchange="this.form.submit()">
                <option value="">Totes</option>
                <?php foreach ($ubicacions as $u): ?>
                    <option value="<?= $u['id'] ?>" <?= $filtreAula == $u['id'] ? 'selected' : '' ?>><?= $u['nom'] ?></option>
                <?php endforeach; ?>
            </select>
        </form>
        <span style="font-size:14px; color:#555;">Total: <?= count($dispositius) ?> dispositius</span>
    </div>
    <table>
        <tr>
            <th>Tipus</th>
            <th>Model</th>
            <th>Inventari</th>
            <th>Aula</th>
            <th>Alumne assignat</th>
            <th>Incidència</th>
            <th>Accions</th>
        </tr>
        <?php foreach ($dispositius as $d): ?>
        <tr>
            <td><?= $d['tipus'] ?></td>
            <td><?= $d['model'] ?></td>
            <td><?= $d['idInventari'] ?></td>
            <td><?= $d['aula'] ?></td>
            <td><?= $d['alumNom'] ? $d['alumNom'] . ' ' . $d['cognom1'] : '-' ?></td>
            <td>
                <?php if ($d['estat']): ?>
                    <span class="badge badge-finalitzat"><?= $d['estat'] ?></span>
                <?php else: ?>
                    <span class="badge badge-actiu">OK</span>
                <?php endif; ?>
            </td>
            <td><a class="btn" href="gestionar_material.php?id=<?= $d['id'] ?>">Gestionar</a></td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>
<?php require_once '../includes/footer.php'; ?>
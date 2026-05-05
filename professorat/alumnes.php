<?php
require_once '../includes/session.php';
require_once '../config.php';
checkProfessorat();

$stmt = $pdo->query("SELECT * FROM Alumnes ORDER BY cognom1, cognom2");
$alumnes = $stmt->fetchAll();

$navLinks = ['Inici' => 'dashboard.php'];
require_once '../includes/header.php';
?>
<div class="container">
    <?php if (isset($_GET['missatge']) && $_GET['missatge'] === 'actualitzat'): ?>
        <div class="missatge" id="missatge" style="margin-bottom: 16px;">Alumne actualitzat correctament</div>
        <script>
            setTimeout(() => {
                document.getElementById('missatge').style.display = 'none';
            }, 1500);
        </script>
    <?php endif; ?>
    <h2>Llista d'alumnes</h2>
    <input type="text" id="cercador" placeholder="Cercar alumne...">
    <table>
        <tr>
            <th>Nom</th>
            <th>Cognoms</th>
            <th>Correu</th>
            <th>Grup</th>
            <th>Accions</th>
        </tr>
        <?php foreach ($alumnes as $alumne): ?>
        <tr>
            <td><?= $alumne['nom'] ?></td>
            <td><?= $alumne['cognom1'] ?> <?= $alumne['cognom2'] ?></td>
            <td><?= $alumne['correu'] ?></td>
            <td><?= $alumne['grupClasse'] ?></td>
            <td><a class="btn" href="gestionar_alumne.php?id=<?= $alumne['id'] ?>">Gestionar</a></td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>
<script>
document.getElementById('cercador').addEventListener('keyup', function() {
    const input = this.value.toLowerCase();
    document.querySelectorAll('table tr:not(:first-child)').forEach(fila => {
        fila.style.display = fila.textContent.toLowerCase().includes(input) ? '' : 'none';
    });
});
</script>
<?php require_once '../includes/footer.php'; ?>
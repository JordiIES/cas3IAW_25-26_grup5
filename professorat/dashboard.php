<?php
require_once '../includes/session.php';
require_once '../config.php';
checkProfessorat();

$navLinks = ['+ Nou alumne' => 'nou_alumne.php', '+ Nou maquinari' => 'nou_material.php'];
require_once '../includes/header.php';
?>
<div class="container">
    <h2>Benvingut, <?= $_SESSION['usuari'] ?></h2>
    <div class="menu-grid">
        <a class="menu-card" href="dispositius.php">Dispositius per aula</a>
        <a class="menu-card" href="alumnes.php">Gestió d'alumnes</a>
        <a class="menu-card" href="incidencies.php">Incidències</a>
    </div>
</div>
<?php require_once '../includes/footer.php'; ?>
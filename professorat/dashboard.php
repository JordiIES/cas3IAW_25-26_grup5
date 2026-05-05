<?php
require_once '../includes/session.php';
require_once '../config.php';
checkProfessorat();
?>
<!DOCTYPE html>
<html lang="ca">
<head>
<meta charset="UTF-8">
<title>Institut Montsià - Professorat</title>
<link rel="icon" type="image/png" href="../img/logo.png">
<style>
* {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}
body {
    font-family: Arial, sans-serif;
    background-color: #d8d6d6ff;
    min-height: 100vh;
}
.navbar {
    background: white;
    padding: 14px 30px;
    display: flex;
    align-items: center;
    gap: 16px;
    box-shadow: 0 1px 4px rgba(0,0,0,0.1);
}
.navbar img {
    width: 40px;
}
.navbar h1 {
    font-size: 18px;
    color: #333;
    flex: 1;
}
.navbar a {
    color: #555;
    text-decoration: none;
    font-size: 14px;
    padding: 4px;
    border-radius: 4px;
}
.navbar a:hover {
    background-color: #b9b9b960;
    color: #555;
}
.navbar a.logout {
    color: #e74c3c;
}
.navbar a.logout:hover {
    background-color: #b9b9b960;
    color: #da2612ff;
}
.container {
    padding: 30px;
    max-width: 900px;
    margin: 0 auto;
}
.container h2 {
    margin-bottom: 20px;
    color: #333;
    text-align: center;
}
.menu-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 16px;
}
.menu-card {
    background: white;
    padding: 24px;
    border-radius: 8px;
    text-align: center;
    text-decoration: none;
    color: #333;
    font-size: 15px;
}
.menu-card:hover {
    background: #4a90d9;
    color: white;
}
</style>
</head>
<body>
<div class="navbar">
    <img src="../img/logo.png" alt="logo">
    <h1>Institut Montsià</h1>
    <a href="nou_alumne.php">+ Nou alumne</a>
    <a href="nou_material.php">+ Nou maquinari</a>
    <a href="../logout.php" class="logout">Logout</a>
</div>
<div class="container">
    <h2>Benvingut, <?= $_SESSION['usuari'] ?></h2>
    <div class="menu-grid">
        <a class="menu-card" href="dispositius.php">Dispositius per aula</a>
        <a class="menu-card" href="alumnes.php">Gestió d'alumnes</a>
        <a class="menu-card" href="incidencies.php">Incidències</a>
    </div>
</div>
</body>
</html>
<?php
require_once '../includes/session.php';
require_once '../config.php';
checkProfessorat();

$stmt = $pdo->query("SELECT * FROM Alumnes ORDER BY cognom1, cognom2");
$alumnes = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title>Institut Montsià - Alumnes</title>
    <link rel="icon" type="image/png" href="../img/logo.png">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }

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

        .navbar img { width: 40px; }
        .navbar h1 { font-size: 18px; color: #333; flex: 1; }

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
            padding: 4px;
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

        #cercador {
            width: 100%;
            padding: 10px;
            margin-bottom: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 10px;
            overflow: hidden;
        }

        th {
            background-color: #4a90d9;
            color: white;
            padding: 12px;
            text-align: left;
        }

        td {
            padding: 10px 12px;
            border-bottom: 1px solid #eee;
        }

        tr:hover { background-color: #f5f5f5; }

        .btn {
            padding: 6px 12px;
            background: #4a90d9;
            color: white;
            border: none;
            border-radius: 4px;
            text-decoration: none;
            font-size: 13px;
        }

        .btn:hover { background: #357abd; }
    </style>
</head>
<body>
    <div class="navbar">
        <img src="../img/logo.png" alt="logo">
        <h1>Institut Montsià</h1>
        <a href="dashboard.php">Inici</a>
        <a href="../logout.php" class="logout">Logout</a>
    </div>

    <div class="container">
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
            const files = document.querySelectorAll('table tr:not(:first-child)');
            files.forEach(fila => {
                const text = fila.textContent.toLowerCase();
                fila.style.display = text.includes(input) ? '' : 'none';
            });
        });
    </script>
</body>
</html>
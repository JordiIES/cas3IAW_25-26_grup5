<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title>Institut Montsià</title>
    <link rel="icon" type="image/png" href="/cas3/img/logo.png">
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
        .navbar a:hover { background-color: #b9b9b960; color: #555; }
        .navbar a.logout { color: #e74c3c; }
        .navbar a.logout:hover { background-color: #b9b9b960; color: #da2612ff; }
        .container {
            padding: 30px;
            max-width: 900px;
            margin: 0 auto;
        }
        h2 { margin-bottom: 20px; color: #333; text-align: center; }
        h3 { margin-bottom: 14px; color: #333; }
        .card {
            background: white;
            border-radius: 10px;
            padding: 24px;
            margin-bottom: 24px;
        }
        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
        }
        label { display: block; font-size: 13px; color: #555; margin-bottom: 4px; }
        input[type="text"], input[type="email"] {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
        }
        table { width: 100%; border-collapse: collapse; background: white; border-radius: 10px; overflow: hidden; }
        th { background-color: #4a90d9; color: white; padding: 10px 12px; text-align: left; }
        td { padding: 10px 12px; border-bottom: 1px solid #eee; font-size: 14px; }
        tr:hover { background-color: #f5f5f5; }
        .btn { padding: 8px 16px; background: #4a90d9; color: white; border: none; border-radius: 4px; text-decoration: none; font-size: 14px; cursor: pointer; margin-top: 14px; }
        .btn:hover { background: #357abd; }
        .btn-danger { padding: 8px 16px; background: #e74c3c; color: white; border: none; border-radius: 4px; font-size: 14px; cursor: pointer; margin-top: 14px; }
        .btn-danger:hover { background: #c0392b; }
        .btn-sm { padding: 4px 10px; background: #e74c3c; color: white; border: none; border-radius: 4px; font-size: 12px; cursor: pointer; }
        .btn-sm:hover { background: #c0392b; }
        .missatge { padding: 10px; border-radius: 4px; margin-bottom: 16px; text-align: center; font-size: 14px; background: #2ecc71; color: white; }
        .badge { padding: 4px 8px; border-radius: 4px; font-size: 12px; white-space: nowrap; }
        .badge-actiu { background: #d4edda; color: #155724; }
        .badge-finalitzat { background: #f8d7da; color: #721c24; }
        #cercador { width: 100%; padding: 10px; margin-bottom: 16px; border: 1px solid #ccc; border-radius: 4px; font-size: 14px; }
        .menu-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; }
        .menu-card { background: white; padding: 24px; border-radius: 8px; text-align: center; text-decoration: none; color: #333; font-size: 15px; }
        .menu-card:hover { background: #4a90d9; color: white; }
        .botons { display: flex; gap: 10px; }
        .badge-warning { background: #fff3cd; color: #856404; }
        
        select {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
        }
    </style>
</head>
<body>
<div class="navbar">
    <img src="/cas3/img/logo.png" alt="logo">
    <h1>Institut Montsià</h1>
    <?php if (isset($navLinks)) foreach ($navLinks as $link => $url): ?>
        <a href="<?= $url ?>"><?= $link ?></a>
    <?php endforeach; ?>
    <a href="/cas3/logout.php" class="logout">Logout</a>
</div>
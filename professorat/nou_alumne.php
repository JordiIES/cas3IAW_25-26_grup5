<?php
require_once '../includes/session.php';
require_once '../config.php';
checkProfessorat();

$error = '';
$dispositius = $pdo->query("
    SELECT m.id, t.tipus, t.model, m.idInventari
    FROM Material m
    JOIN TipusMaterial t ON m.idTipus = t.id
    LEFT JOIN Assignacions a ON a.idMaterial = m.id AND a.dataFinal IS NULL
    WHERE a.id IS NULL
    ORDER BY t.tipus
")->fetchAll();

if (isset($_POST['crear'])) {
    $nom = $_POST['nom'];
    $cognom1 = $_POST['cognom1'];
    $cognom2 = $_POST['cognom2'];
    $correu = $_POST['correu'];
    $grupClasse = $_POST['grupClasse'];

    $check = $pdo->prepare("SELECT id FROM Alumnes WHERE correu = ?");
    $check->execute([$correu]);
    if ($check->fetch()) {
        $error = 'Ja existeix un alumne amb aquest correu';
    } else {
        $pdo->prepare("INSERT INTO Alumnes (nom, cognom1, cognom2, correu, grupClasse) VALUES (?,?,?,?,?)")
            ->execute([$nom, $cognom1, $cognom2, $correu, $grupClasse]);
        $idAlumne = $pdo->lastInsertId();

        if (!empty($_POST['idMaterial'])) {
            $pdo->prepare("INSERT INTO Assignacions (idMaterial, idAlumne, dataInici) VALUES (?,?,CURDATE())")
                ->execute([$_POST['idMaterial'], $idAlumne]);
        }

        header('Location: alumnes.php?missatge=creat');
        exit;
    }
}

$navLinks = ['Alumnes' => 'alumnes.php', 'Inici' => 'dashboard.php'];
require_once '../includes/header.php';
?>
<div class="container">
    <h2>Nou alumne</h2>
    <div class="card">
        <?php if ($error): ?>
            <div class="missatge" style="background:#e74c3c; margin-bottom:16px;"><?= $error ?></div>
        <?php endif; ?>
        <form method="POST">
            <div class="form-grid">
                <div>
                    <label>Nom</label>
                    <input type="text" name="nom" required>
                </div>
                <div>
                    <label>Primer cognom</label>
                    <input type="text" name="cognom1" required>
                </div>
                <div>
                    <label>Segon cognom</label>
                    <input type="text" name="cognom2">
                </div>
                <div>
                    <label>Correu</label>
                    <input type="email" name="correu" required>
                </div>
                <div>
                    <label>Grup classe</label>
                    <select name="grupClasse">
                        <option value="ASIX1">ASIX 1</option>
                        <option value="ASIX2">ASIX 2</option>
                        <option value="DAW1">DAW 1</option>
                        <option value="DAW2">DAW 2</option>
                    </select>
                </div>
                <div>
                    <label>Assignar dispositiu (opcional)</label>
                    <select name="idMaterial">
                        <option value="">-- Cap dispositiu --</option>
                        <?php foreach ($dispositius as $d): ?>
                            <option value="<?= $d['id'] ?>"><?= $d['tipus'] ?> - <?= $d['model'] ?> (<?= $d['idInventari'] ?>)</option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <button class="btn" type="submit" name="crear" style="margin-top:14px;">Crear alumne</button>
        </form>
    </div>
</div>
<?php require_once '../includes/footer.php'; ?>
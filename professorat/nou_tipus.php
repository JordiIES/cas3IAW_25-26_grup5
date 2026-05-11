<?php
require_once '../includes/session.php';
require_once '../config.php';
checkProfessorat();

$error = '';

if (isset($_POST['crear'])) {
    $check = $pdo->prepare("SELECT id FROM TipusMaterial WHERE tipus = ? AND model = ?");
    $check->execute([$_POST['tipus'], $_POST['model']]);
    if ($check->fetch()) {
        $error = 'Ja existeix aquest tipus i model';
    } else {
        $pdo->prepare("INSERT INTO TipusMaterial (tipus, model, origen) VALUES (?,?,?)")
            ->execute([$_POST['tipus'], $_POST['model'], $_POST['origen']]);
        header('Location: nou_material.php?missatge=tipuscreat');
        exit;
    }
}

$navLinks = ['Nou maquinari' => 'nou_material.php', 'Inici' => 'dashboard.php'];
require_once '../includes/header.php';
?>
<div class="container">
    <h2>Nou tipus de material</h2>
    <div class="card">
        <?php if ($error): ?>
            <div class="missatge" style="background:#e74c3c; margin-bottom:16px;"><?= $error ?></div>
        <?php endif; ?>
        <form method="POST">
            <div class="form-grid">
                <div>
                    <label>Tipus</label>
                    <input type="text" name="tipus" placeholder="Ex: Portàtil" required>
                </div>
                <div>
                    <label>Model</label>
                    <input type="text" name="model" placeholder="Ex: HP ProBook 450" required>
                </div>
                <div>
                    <label>Origen</label>
                    <select name="origen">
                        <option value="DEP">DEP</option>
                        <option value="GENE">GENE</option>
                    </select>
                </div>
            </div>
            <button class="btn" type="submit" name="crear" style="margin-top:14px;">Crear tipus</button>
        </form>
    </div>
</div>
<?php require_once '../includes/footer.php'; ?>
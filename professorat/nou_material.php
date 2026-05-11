<?php
require_once '../includes/session.php';
require_once '../config.php';
checkProfessorat();

$tipus = $pdo->query("SELECT * FROM TipusMaterial")->fetchAll();
$ubicacions = $pdo->query("SELECT * FROM Ubicacions")->fetchAll();
$error = '';

if (isset($_POST['crear'])) {
    $check = $pdo->prepare("SELECT id FROM Material WHERE idInventari = ?");
    $check->execute([$_POST['idInventari']]);
    if ($check->fetch()) {
        $error = 'Ja existeix un dispositiu amb aquest inventari';
    } else {
        $pdo->prepare("INSERT INTO Material (idTipus, idInventari, etiquetaDepInf, numSerie, macEthernet, macWifi, SACE, dataAdquisicio, idUbicacio) VALUES (?,?,?,?,?,?,?,?,?)")
            ->execute([
                $_POST['idTipus'],
                $_POST['idInventari'],
                $_POST['etiquetaDepInf'] ?: null,
                $_POST['numSerie'] ?: null,
                $_POST['macEthernet'] ?: null,
                $_POST['macWifi'] ?: null,
                $_POST['SACE'] ?: null,
                $_POST['dataAdquisicio'] ?: null,
                $_POST['idUbicacio']
            ]);
        header('Location: dispositius.php?missatge=creat');
        exit;
    }
}

$navLinks = ['Inici' => 'dashboard.php'];
require_once '../includes/header.php';
?>
<div class="container">
    <h2>Nou maquinari</h2>
    <div class="card">
        <?php if ($error): ?>
            <div class="missatge" style="background:#e74c3c; margin-bottom:16px;"><?= $error ?></div>
        <?php endif; ?>
        <form method="POST">
            <div class="form-grid">
                <div>
                    <label>Tipus</label>
                    <div style="display:flex; gap:8px; align-items:center;">
                        <select name="idTipus" style="flex:1">
                            <?php foreach ($tipus as $t): ?>
                                <option value="<?= $t['id'] ?>"><?= $t['tipus'] ?> - <?= $t['model'] ?></option>
                            <?php endforeach; ?>
                        </select>
                        <a class="btn" href="nou_tipus.php" style="margin-top:0; white-space:nowrap; padding:8px 10px;">+ Nou tipus</a>
                    </div>
                </div>
                <div>
                    <label>Ubicació</label>
                    <select name="idUbicacio">
                        <?php foreach ($ubicacions as $u): ?>
                            <option value="<?= $u['id'] ?>"><?= $u['nom'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label>Num. Inventari</label>
                    <input type="text" name="idInventari" required>
                </div>
                <div>
                    <label>Etiqueta Dep. Inf.</label>
                    <input type="text" name="etiquetaDepInf">
                </div>
                <div>
                    <label>Num. Sèrie</label>
                    <input type="text" name="numSerie">
                </div>
                <div>
                    <label>MAC Ethernet</label>
                    <input type="text" name="macEthernet">
                </div>
                <div>
                    <label>MAC Wifi</label>
                    <input type="text" name="macWifi">
                </div>
                <div>
                    <label>SACE</label>
                    <input type="text" name="SACE">
                </div>
                <div>
                    <label>Data adquisició</label>
                    <input type="date" name="dataAdquisicio">
                </div>
            </div>
            <button class="btn" type="submit" name="crear" style="margin-top:14px;">Crear maquinari</button>
        </form>
    </div>
</div>
<?php require_once '../includes/footer.php'; ?>
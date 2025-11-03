<?php
include 'includes/auth.php';
include 'includes/db_connect.php';

$id = (int)($_GET['id'] ?? 0);
if (!$id) {
    header('Location: patients.php');
    exit;
}

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'] ?? '';
    $date_naissance = $_POST['date_naissance'] ?? '';
    $age = $_POST['age'] ?? '';
    $sex = $_POST['sex'] ?? '';
    $adresse = $_POST['adresse'] ?? '';
    $maladie = $_POST['maladie'] ?? '';
    $telephone = $_POST['telephone'] ?? '';

    $stmt = $conn->prepare("UPDATE patients SET nom=?,date_naissance=?,age=?,sex=?,adresse=?,maladie=?,telephone=? WHERE id = ?");
    $stmt->bind_param('sssssssi',$nom,$date_naissance,$age,$sex,$adresse,$maladie,$telephone,$id);
    if (!$stmt->execute()) {
        $errors[] = 'خطأ: ' . $stmt->error;
    } else {
        header('Location: patients.php');
        exit;
    }
    $stmt->close();
}

$stmt = $conn->prepare("SELECT * FROM patients WHERE id = ?");
$stmt->bind_param('i',$id);
$stmt->execute();
$res = $stmt->get_result();
$patient = $res->fetch_assoc();
if (!$patient) {
    header('Location: patients.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>تعديل مريض</title><link rel="stylesheet" href="assets/style.css"></head>
<link rel="stylesheet" href="assets/style.css">

<body>
<header class="header-inner"><h1>تعديل المريض</h1><a class="logout-btn" href="patients.php">العودة</a></header>
<main class="table">
  <?php if($errors): ?><div class="error"><?= implode('<br>', $errors) ?></div><?php endif; ?>
  <form method="POST" class="form-inline">
    <input name="nom" value="<?= htmlspecialchars($patient['nom']) ?>" required>
    <input name="date_naissance" type="date" value="<?= htmlspecialchars($patient['date_naissance']) ?>">
    <input name="age" value="<?= htmlspecialchars($patient['age']) ?>">
    <select name="sex"><option <?= $patient['sex']=='ذكر'?'selected':'' ?>>ذكر</option><option <?= $patient['sex']=='أنثى'?'selected':'' ?>>أنثى</option></select>
    <input name="telephone" value="<?= htmlspecialchars($patient['telephone']) ?>">
    <input name="adresse" value="<?= htmlspecialchars($patient['adresse']) ?>">
    <input name="maladie" value="<?= htmlspecialchars($patient['maladie']) ?>">
    <button type="submit">حفظ</button>
  </form>
</main>
</body>
</html>

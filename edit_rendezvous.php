<?php
include 'includes/auth.php';
include 'includes/db_connect.php';
$id = (int)($_GET['id'] ?? 0);
if (!$id) header('Location: rendezvous.php');

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $patient = $_POST['patient'] ?? '';
    $motif = $_POST['motif'] ?? '';
    $date = $_POST['date'] ?? '';
    $heure = $_POST['heure'] ?? '';
    $remarque = $_POST['remarque'] ?? '';

    $stmt = $conn->prepare("UPDATE rendezvous SET patient=?,motif=?,date=?,heure=?,remarque=? WHERE id=?");
    $stmt->bind_param('sssssi',$patient,$motif,$date,$heure,$remarque,$id);
    if (!$stmt->execute()) $errors[] = $stmt->error;
    else{ header('Location: rendezvous.php'); exit; }
}

$stmt = $conn->prepare("SELECT * FROM rendezvous WHERE id = ?");
$stmt->bind_param('i',$id);
$stmt->execute();
$res = $stmt->get_result();
$row = $res->fetch_assoc();
if (!$row) header('Location: rendezvous.php');
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>تعديل موعد</title><link rel="stylesheet" href="assets/style.css"></head>
<body>
<header class="header-inner"><h1>تعديل الموعد</h1><a class="logout-btn" href="rendezvous.php">العودة</a></header>
<main class="table">
  <?php if($errors): ?><div class="error"><?= implode('<br>',$errors) ?></div><?php endif; ?>
  <form method="POST" class="form-inline">
    <input name="patient" value="<?= htmlspecialchars($row['patient']) ?>" required>
    <input name="motif" value="<?= htmlspecialchars($row['motif']) ?>" required>
    <input name="date" type="date" value="<?= htmlspecialchars($row['date']) ?>" required>
    <input name="heure" type="time" value="<?= htmlspecialchars($row['heure']) ?>" required>
    <input name="remarque" value="<?= htmlspecialchars($row['remarque']) ?>">
    <button type="submit">حفظ</button>
  </form>
</main>
</body>
</html>

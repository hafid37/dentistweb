<?php
include 'includes/auth.php';
include 'includes/db_connect.php';

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add') {
    $patient = $_POST['patient'] ?? '';
    $motif = $_POST['motif'] ?? '';
    $date = $_POST['date'] ?? '';
    $heure = $_POST['heure'] ?? '';
    $remarque = $_POST['remarque'] ?? '';

    $stmt = $conn->prepare("INSERT INTO rendezvous (patient,motif,date,heure,remarque) VALUES (?,?,?,?,?)");
    $stmt->bind_param('sssss',$patient,$motif,$date,$heure,$remarque);
    if (!$stmt->execute()) $errors[] = $stmt->error;
    $stmt->close();
}

if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM rendezvous WHERE id = ?");
    $stmt->bind_param('i',$id);
    $stmt->execute();
    $stmt->close();
    header('Location: rendezvous.php');
    exit;
}

$res = $conn->query("SELECT * FROM rendezvous ORDER BY date DESC, heure DESC");
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>المواعيد</title><link rel="stylesheet" href="assets/style.css"><script src="assets/script.js"></script></head>
<body>
<header><div class="header-inner"><h1>المواعيد</h1><a class="logout-btn" href="dashboard.php">العودة</a></div></header>

<main>
  <div class="table">
    <div class="notice">أضف موعدًا جديدًا:</div>
    <?php if($errors): ?><div class="error"><?= implode('<br>',$errors) ?></div><?php endif; ?>
    <form method="POST" class="form-inline">
      <input name="patient" placeholder="اسم المريض" required>
      <input name="motif" placeholder="السبب" required>
      <input name="date" type="date" required>
      <input name="heure" type="time" required>
      <input name="remarque" placeholder="ملاحظة">
      <input type="hidden" name="action" value="add">
      <button type="submit">إضافة</button>
    </form>
  </div>

  <div class="table">
    <h3>قائمة المواعيد</h3>
    <table>
      <thead><tr><th>المريض</th><th>السبب</th><th>تاريخ</th><th>الساعة</th><th>ملاحظة</th><th>إجراءات</th></tr></thead>
      <tbody>
        <?php while($row = $res->fetch_assoc()): ?>
          <tr>
            <td><?= htmlspecialchars($row['patient']) ?></td>
            <td><?= htmlspecialchars($row['motif']) ?></td>
            <td><?= htmlspecialchars($row['date']) ?></td>
            <td><?= htmlspecialchars($row['heure']) ?></td>
            <td><?= htmlspecialchars($row['remarque']) ?></td>
            <td class="actions">
              <a href="edit_rendezvous.php?id=<?= $row['id'] ?>">تعديل</a>
              <a href="rendezvous.php?delete=<?= $row['id'] ?>" onclick="return confirmDelete('حذف الموعد؟')">حذف</a>
            </td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</main>
</body>
</html>

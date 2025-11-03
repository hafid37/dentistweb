<?php
include 'includes/auth.php';
include 'includes/db_connect.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['soin'])) {
    $soin = $_POST['soin'];
    $dent = $_POST['dent'] ?? '';
    $stmt = $conn->prepare("INSERT INTO soins (soin,dent) VALUES (?,?)");
    $stmt->bind_param('ss',$soin,$dent);
    $stmt->execute();
    $stmt->close();
}
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM soins WHERE id = ?");
    $stmt->bind_param('i',$id);
    $stmt->execute();
    header('Location: soins.php'); exit;
}
$res = $conn->query("SELECT * FROM soins ORDER BY id DESC");
?>
<!DOCTYPE html><html lang="ar" dir="rtl"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>العلاجات</title><link rel="stylesheet" href="assets/style.css"></head><body>
<header class="header-inner"><h1>العلاجات</h1><a class="logout-btn" href="dashboard.php">العودة</a></header>
<main class="table">
  <form method="POST" class="form-inline"><input name="soin" placeholder="اسم العلاج" required><input name="dent" placeholder="السن (اختياري)"><button type="submit">إضافة</button></form>
  <h3>قائمة العلاجات</h3>
  <table><thead><tr><th>العلاج</th><th>السن</th><th>إجراءات</th></tr></thead><tbody>
    <?php while($r = $res->fetch_assoc()): ?>
      <tr><td><?= htmlspecialchars($r['soin']) ?></td><td><?= htmlspecialchars($r['dent']) ?></td><td class="actions"><a href="?delete=<?= $r['id'] ?>" onclick="return confirm('حذف؟')">حذف</a></td></tr>
    <?php endwhile; ?>
  </tbody></table>
</main></body></html>

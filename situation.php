<?php
include 'includes/auth.php';
include 'includes/db_connect.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nom'])) {
    $nom = $_POST['nom']; $soin = $_POST['soin'] ?? ''; $dent = $_POST['dent'] ?? ''; $cout = floatval($_POST['cout'] ?? 0); $versement = floatval($_POST['versement'] ?? 0);
    $reste = $cout - $versement; $date = $_POST['date'] ?? date('Y-m-d');
    $user = $_SESSION['user'];
    $stmt = $conn->prepare("INSERT INTO situation (nom,soin,dent,cout,versement,reste,date,user) VALUES (?,?,?,?,?,?,?,?)");
    $stmt->bind_param('sssdidss',$nom,$soin,$dent,$cout,$versement,$reste,$date,$user);
    $stmt->execute(); $stmt->close();
}
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete']; $stmt = $conn->prepare("DELETE FROM situation WHERE id = ?"); $stmt->bind_param('i',$id); $stmt->execute(); header('Location: situation.php'); exit;
}
$res = $conn->query("SELECT * FROM situation ORDER BY id DESC");
?>
<!DOCTYPE html><html lang="ar" dir="rtl"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>الوضعيات المالية</title><link rel="stylesheet" href="assets/style.css"></head><body>
<header class="header-inner"><h1>الوضعيات المالية</h1><a class="logout-btn" href="dashboard.php">العودة</a></header>
<main class="table">
<form method="POST" class="form-inline"><input name="nom" placeholder="اسم المريض" required><input name="soin" placeholder="الشفاء/العلاج"><input name="dent" placeholder="السن"><input name="cout" placeholder="التكلفة" type="number" step="0.01"><input name="versement" placeholder="المدفوع" type="number" step="0.01"><button type="submit">إضافة</button></form>
<h3>قائمة الوضعيات</h3>
<table><thead><tr><th>الاسم</th><th>العلاج</th><th>التكلفة</th><th>مدفوع</th><th>الباقي</th><th>التاريخ</th><th>المستخدم</th><th>إجراءات</th></tr></thead><tbody>
<?php while($r = $res->fetch_assoc()): ?>
<tr><td><?= htmlspecialchars($r['nom']) ?></td><td><?= htmlspecialchars($r['soin']) ?></td><td><?= htmlspecialchars($r['cout']) ?></td><td><?= htmlspecialchars($r['versement']) ?></td><td><?= htmlspecialchars($r['reste']) ?></td><td><?= htmlspecialchars($r['date']) ?></td><td><?= htmlspecialchars($r['user']) ?></td><td class="actions"><a href="?delete=<?= $r['id'] ?>" onclick="return confirm('حذف؟')">حذف</a></td></tr>
<?php endwhile; ?>
</tbody></table>
</main></body></html>

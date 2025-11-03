<?php
include 'includes/auth.php';
include 'includes/db_connect.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nom'])) {
    $nom = $_POST['nom']; $dci = $_POST['dci'] ?? ''; $dosage = $_POST['dosage'] ?? '';
    $stmt = $conn->prepare("INSERT INTO medicaments (nom,dci,dosage) VALUES (?,?,?)");
    $stmt->bind_param('sss',$nom,$dci,$dosage); $stmt->execute(); $stmt->close();
}
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete']; $stmt = $conn->prepare("DELETE FROM medicaments WHERE id = ?"); $stmt->bind_param('i',$id); $stmt->execute(); header('Location: medicaments.php'); exit;
}
$res = $conn->query("SELECT * FROM medicaments ORDER BY id DESC");
?>
<!DOCTYPE html><html lang="ar" dir="rtl"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>الأدوية</title><link rel="stylesheet" href="assets/style.css"></head><body>
<header class="header-inner"><h1>الأدوية</h1><a class="logout-btn" href="dashboard.php">العودة</a></header>
<main class="table">
<form method="POST" class="form-inline"><input name="nom" placeholder="اسم الدواء" required><input name="dci" placeholder="DCI"><input name="dosage" placeholder="الجرعة"><button type="submit">إضافة</button></form>
<h3>قائمة الأدوية</h3>
<table><thead><tr><th>الاسم</th><th>DCI</th><th>الجرعة</th><th>إجراءات</th></tr></thead><tbody>
<?php while($r = $res->fetch_assoc()): ?>
<tr><td><?= htmlspecialchars($r['nom']) ?></td><td><?= htmlspecialchars($r['dci']) ?></td><td><?= htmlspecialchars($r['dosage']) ?></td><td class="actions"><a href="?delete=<?= $r['id'] ?>" onclick="return confirm('حذف؟')">حذف</a></td></tr>
<?php endwhile; ?>
</tbody></table>
</main></body></html>

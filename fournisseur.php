<?php
include 'includes/auth.php';
include 'includes/db_connect.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nom'])) {
    $nom = $_POST['nom']; $tel = $_POST['telephone'] ?? ''; $adresse = $_POST['adresse'] ?? '';
    $stmt = $conn->prepare("INSERT INTO fournisseur (nom,telephone,adresse) VALUES (?,?,?)");
    $stmt->bind_param('sss',$nom,$tel,$adresse); $stmt->execute(); $stmt->close();
}
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete']; $stmt = $conn->prepare("DELETE FROM fournisseur WHERE id = ?"); $stmt->bind_param('i',$id); $stmt->execute(); header('Location: fournisseur.php'); exit;
}
$res = $conn->query("SELECT * FROM fournisseur ORDER BY id DESC");
?>
<!DOCTYPE html><html lang="ar" dir="rtl"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>الموردون</title><link rel="stylesheet" href="assets/style.css"></head><body>
<header class="header-inner"><h1>الموردون</h1><a class="logout-btn" href="dashboard.php">العودة</a></header>
<main class="table">
<form method="POST" class="form-inline"><input name="nom" placeholder="الاسم" required><input name="telephone" placeholder="الهاتف"><input name="adresse" placeholder="العنوان"><button type="submit">إضافة</button></form>
<h3>قائمة الموردين</h3>
<table><thead><tr><th>الاسم</th><th>الهاتف</th><th>العنوان</th><th>إجراءات</th></tr></thead><tbody>
<?php while($r = $res->fetch_assoc()): ?>
<tr><td><?= htmlspecialchars($r['nom']) ?></td><td><?= htmlspecialchars($r['telephone']) ?></td><td><?= htmlspecialchars($r['adresse']) ?></td><td class="actions"><a href="?delete=<?= $r['id'] ?>" onclick="return confirm('حذف؟')">حذف</a></td></tr>
<?php endwhile; ?>
</tbody></table>
</main></body></html>

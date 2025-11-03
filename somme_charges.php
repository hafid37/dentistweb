<?php
include 'includes/auth.php';
include 'includes/db_connect.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['fournisseur'])) {
    $fournisseur = $_POST['fournisseur']; $article = $_POST['article'] ?? ''; $prix = floatval($_POST['prix'] ?? 0); $qnt = intval($_POST['qnt'] ?? 1);
    $total = $prix * $qnt; $versement = floatval($_POST['versement'] ?? 0); $reste = $total - $versement; $date = $_POST['date'] ?? date('Y-m-d');
    $stmt = $conn->prepare("INSERT INTO somme_charges (fournisseur,article,prix,qnt,total,versement,reste,date) VALUES (?,?,?,?,?,?,?,?)");
    $stmt->bind_param('ssddddds',$fournisseur,$article,$prix,$qnt,$total,$versement,$reste,$date); $stmt->execute(); $stmt->close();
}
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete']; $stmt = $conn->prepare("DELETE FROM somme_charges WHERE id = ?"); $stmt->bind_param('i',$id); $stmt->execute(); header('Location: somme_charges.php'); exit;
}
$res = $conn->query("SELECT * FROM somme_charges ORDER BY id DESC");
?>
<!DOCTYPE html><html lang="ar" dir="rtl"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>المصاريف</title><link rel="stylesheet" href="assets/style.css"></head><body>
<header class="header-inner"><h1>المصاريف</h1><a class="logout-btn" href="dashboard.php">العودة</a></header>
<main class="table">
<form method="POST" class="form-inline"><input name="fournisseur" placeholder="المورد" required><input name="article" placeholder="المادة"><input name="prix" placeholder="السعر" type="number" step="0.01"><input name="qnt" placeholder="الكمية" type="number"><input name="versement" placeholder="المدفوع" type="number" step="0.01"><button type="submit">إضافة</button></form>
<h3>قائمة المصاريف</h3>
<table><thead><tr><th>المورد</th><th>المادة</th><th>السعر</th><th>كمية</th><th>المجموع</th><th>مدفوع</th><th>الباقي</th><th>تاريخ</th><th>إجراءات</th></tr></thead><tbody>
<?php while($r = $res->fetch_assoc()): ?>
<tr><td><?= htmlspecialchars($r['fournisseur']) ?></td><td><?= htmlspecialchars($r['article']) ?></td><td><?= htmlspecialchars($r['prix']) ?></td><td><?= htmlspecialchars($r['qnt']) ?></td><td><?= htmlspecialchars($r['total']) ?></td><td><?= htmlspecialchars($r['versement']) ?></td><td><?= htmlspecialchars($r['reste']) ?></td><td><?= htmlspecialchars($r['date']) ?></td><td class="actions"><a href="?delete=<?= $r['id'] ?>" onclick="return confirm('حذف؟')">حذف</a></td></tr>
<?php endwhile; ?>
</tbody></table>
</main></body></html>

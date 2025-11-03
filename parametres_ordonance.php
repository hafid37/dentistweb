<?php
include 'includes/auth.php';
include 'includes/db_connect.php';
$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['titre'])) {
    $titre = $_POST['titre']; $nom = $_POST['nom'] ?? ''; $specialite = $_POST['specialite'] ?? ''; $adresse = $_POST['adresse'] ?? ''; $telephone = $_POST['telephone'] ?? '';
    $stmt = $conn->prepare("INSERT INTO parametres_ordonance (titre,nom,specialite,adresse,telephone) VALUES (?,?,?,?,?)");
    $stmt->bind_param('sssss',$titre,$nom,$specialite,$adresse,$telephone); if ($stmt->execute()) $msg='تم الحفظ'; else $msg='خطأ: '.$stmt->error; $stmt->close();
}
$res = $conn->query("SELECT * FROM parametres_ordonance ORDER BY id DESC");
?>
<!DOCTYPE html><html lang="ar" dir="rtl"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>إعدادات الوصفات</title><link rel="stylesheet" href="assets/style.css"></head><body>
<header class="header-inner"><h1>إعدادات الوصفات</h1><a class="logout-btn" href="dashboard.php">العودة</a></header>
<main class="table">
<?php if($msg): ?><div class="notice"><?= htmlspecialchars($msg) ?></div><?php endif; ?>
<form method="POST" class="form-inline"><input name="titre" placeholder="عنوان (مثال: عيادة د. فلان)" required><input name="nom" placeholder="الاسم"><input name="specialite" placeholder="التخصص"><input name="adresse" placeholder="العنوان"><input name="telephone" placeholder="الهاتف"><button type="submit">حفظ</button></form>
<h3>المحفوظ</h3>
<table><thead><tr><th>العنوان</th><th>الاسم</th><th>التخصص</th><th>العنوان</th><th>الهاتف</th></tr></thead><tbody>
<?php while($r = $res->fetch_assoc()): ?>
<tr><td><?= htmlspecialchars($r['titre']) ?></td><td><?= htmlspecialchars($r['nom']) ?></td><td><?= htmlspecialchars($r['specialite']) ?></td><td><?= htmlspecialchars($r['adresse']) ?></td><td><?= htmlspecialchars($r['telephone']) ?></td></tr>
<?php endwhile; ?>
</tbody></table>
</main></body></html>

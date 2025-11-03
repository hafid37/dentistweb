<?php
include 'config.php'; // هذا الملف يجب أن يحتوي على الاتصال بقاعدة البيانات
?>

<table>
    <tr>
        <th>ID</th>
        <th>اسم المستخدم</th>
        <th>الدور</th>
        <th>الإجراءات</th>
    </tr>
    <?php
    $result = mysqli_query($conn, "SELECT * FROM comptes");
    if (!$result) {
        die("خطأ في جملة SQL: " . mysqli_error($conn));
    }

    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['id']) . "</td>";
        echo "<td>" . htmlspecialchars($row['nom']) . "</td>";
        echo "<td>مدير النظام</td>";
        echo "<td><a href='delete_user.php?id=" . $row['id'] . "' class='delete-btn'>🗑 حذف</a></td>";
        echo "</tr>";
    }
    ?>
</table>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<title>إدارة المستخدمين</title>
<link rel="stylesheet" href="assets/style.css">
</head>
<body class="dashboard-body">
<div class="sidebar">
  <h2>💎 العيادة</h2>
  <ul>
    <li><a href="dashboard.php">🏠 الرئيسية</a></li>
      <li><a href="patients.php">👨‍⚕️ المرضى</a></li>
      <li><a href="rendezvous.php">📅 المواعيد</a></li>
      <li><a href="soins.php">🦷 العلاجات</a></li>
      <li><a href="medicaments.php">💊 الأدوية</a></li>
      <li><a href="fournisseur.php">👨‍🔧 الموردون</a></li>
      <li><a href="situation.php">💰 الوضعيات</a></li>
      <li><a href="somme_charges.php">🧾 المصاريف</a></li>
      <li><a href="compte.php">🧍 المستخدمون</a></li>
      <li><a href="parametres_ordonance.php">⚙️ الإعدادات</a></li>
    <li><a href="logout.php">🚪 خروج</a></li>
  </ul>
</div>

<main class="main-content">
<h1>🧍 إدارة المستخدمين</h1>
<p>يمكنك هنا عرض أو حذف المستخدمين</p>

<table border="1" cellpadding="10" cellspacing="0" style="width:100%; text-align:center; background:white; border-radius:10px;">
<tr style="background:#0ea5e9; color:white;">
  <th>ID</th>
  <th>اسم المستخدم</th>
  <th>الدور</th>
  <th>الإجراءات</th>
</tr>

<?php while($row = mysqli_fetch_assoc($result)): ?>
<tr>
  <td><?= $row["id"] ?></td>
  <td><?= $row["username"] ?></td>
  <td><?= $row["password"] ?></td>
  <td>
    <a href="?delete=<?= $row["id"] ?>" style="color:#dc2626; text-decoration:none;" onclick="return confirm('هل تريد حذف هذا المستخدم؟')">🗑 حذف</a>
  </td>
</tr>
<?php endwhile; ?>
</table>
</main>
</body>
</html>
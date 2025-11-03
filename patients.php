<?php
include 'includes/auth.php';
include 'includes/db_connect.php';

$errors = [];
// Add patient
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add') {
    $nom = $_POST['nom'] ?? '';
    $date_naissance = $_POST['date_naissance'] ?? '';
    $age = $_POST['age'] ?? '';
    $sex = $_POST['sex'] ?? '';
    $adresse = $_POST['adresse'] ?? '';
    $maladie = $_POST['maladie'] ?? '';
    $telephone = $_POST['telephone'] ?? '';

    $stmt = $conn->prepare("INSERT INTO patients (nom,date_naissance,age,sex,adresse,maladie,telephone) VALUES (?,?,?,?,?,?,?)");
    $stmt->bind_param('sssssss',$nom,$date_naissance,$age,$sex,$adresse,$maladie,$telephone);
    if (!$stmt->execute()) {
        $errors[] = 'خطأ أثناء إضافة المريض: ' . $stmt->error;
    }
    $stmt->close();
}

// Delete
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM patients WHERE id = ?");
    $stmt->bind_param('i',$id);
    $stmt->execute();
    $stmt->close();
    header('Location: patients.php');
    exit;
}

// Fetch patients
$res = $conn->query("SELECT * FROM patients ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>المرضى - عيادة الأسنان</title>
<link rel="stylesheet" href="assets/style.css">
<script src="assets/script.js"></script>
</head>
<body>
<header>
  <div class="header-inner">
    <h1>المرضى</h1>
    <div><a href="dashboard.php" class="logout-btn">العودة</a></div>
  </div>
</header>

<main>
  <div class="table">
    <div class="notice">أضف مريضًا جديدًا:</div>
    <?php if($errors): ?>
      <div class="error"><?= implode('<br>', array_map('htmlspecialchars', $errors)) ?></div>
    <?php endif; ?>
    <form method="POST" class="form-inline">
      <input name="nom" placeholder="الاسم الكامل" required>
      <input name="date_naissance" type="date" placeholder="تاريخ الولادة">
      <input name="age" placeholder="العمر">
      <select name="sex" required>
        <option value="ذكر">ذكر</option>
        <option value="أنثى">أنثى</option>
      </select>
      <input name="telephone" placeholder="الهاتف">
      <input name="adresse" placeholder="العنوان">
      <input name="maladie" placeholder="الملاحظات / المرض">
      <input type="hidden" name="action" value="add">
      <button type="submit">إضافة</button>
    </form>
  </div>

  <div class="table">
    <h3>قائمة المرضى</h3>
    <table>
      <thead><tr><th>الاسم</th><th>تاريخ الولادة</th><th>العمر</th><th>الجنس</th><th>الهاتف</th><th>تاريخ الإضافة</th><th>إجراءات</th></tr></thead>
      <tbody>
        <?php while($row = $res->fetch_assoc()): ?>
          <tr>
            <td><?= htmlspecialchars($row['nom']) ?></td>
            <td><?= htmlspecialchars($row['date_naissance']) ?></td>
            <td><?= htmlspecialchars($row['age']) ?></td>
            <td><?= htmlspecialchars($row['sex']) ?></td>
            <td><?= htmlspecialchars($row['telephone']) ?></td>
            <td><?= htmlspecialchars($row['date_premiere_visite']) ?></td>
            <td class="actions">
              <a href="edit_patient.php?id=<?= $row['id'] ?>">تعديل</a>
              <a href="patients.php?delete=<?= $row['id'] ?>" onclick="return confirmDelete('حذف المريض سيزيل بياناته نهائيا. متابعة؟')">حذف</a>
            </td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</main>
</body>
</html>

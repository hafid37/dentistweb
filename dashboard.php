<?php
session_start();
if (!isset($_SESSION["users"])) {
  header("Location: login.php");
  exit();
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>لوحة التحكم - عيادة الأسنان</title>
  <link rel="stylesheet" href="style.css">
  <script defer>
    function toggleSidebar() {
      document.querySelector('.sidebar').classList.toggle('active');
    }
  </script>
</head>

<body class="dashboard-body">

  <!-- زر القائمة في الهاتف -->
  <button class="menu-toggle" onclick="toggleSidebar()">☰</button>
  <!-- الشريط الجانبي -->
  <aside class="sidebar">
    <h2>💎 العيادة</h2>
    <ul>
      <li><a href="patients.php">👨‍⚕️ المرضى</a></li>
      <li><a href="rendezvous.php">📅 المواعيد</a></li>
      <li><a href="soins.php">🦷 العلاجات</a></li>
      <li><a href="medicaments.php">💊 الأدوية</a></li>
      <li><a href="fournisseur.php">👨‍🔧 الموردون</a></li>
      <li><a href="situation.php">💰 الوضعيات</a></li>
      <li><a href="somme_charges.php">🧾 المصاريف</a></li>
      <li><a href="comptes.php">🧍 المستخدمون</a></li>
      <li><a href="parametres_ordonance.php">⚙️ الإعدادات</a></li>
    </ul>

    <div class="logout-area">
      <p>مرحبًا، <strong><?= $_SESSION["user"] ?></strong> 👋</p>
      <span>مدير النظام</span>
      <a href="logout.php" class="logout-btn">خروج</a>
    </div>
  </aside>

  <!-- المحتوى الرئيسي -->
  <main class="main-content">
    <section class="main-toolbar">
      <h1>لوحة التحكم</h1>
      <p>مرحبًا بك في نظام إدارة العيادة 💙</p>
      <div class="toolbar-actions">
        <a href="rendezvous.php" class="primary-btn">موعد جديد</a>
        <a href="patients.php" class="ghost-btn">إضافة مريض</a>
      </div>
    </section>

    <section class="quick-links">
      <a href="patients.php" class="quick-card">
        <span>👥</span>
        <strong>إدارة المرضى</strong>
        <small>اطلع على بيانات المرضى وسجل الزيارات</small>
      </a>

      <a href="rendezvous.php" class="quick-card">
        <span>🗓️</span>
        <strong>جدولة المواعيد</strong>
        <small>تابع المواعيد القادمة واليومية</small>
      </a>

      <a href="soins.php" class="quick-card">
        <span>🦷</span>
        <strong>خدمات العلاجات</strong>
        <small>أضف وعدل المعلومات العلاجية</small>
      </a>

      <a href="somme_charges.php" class="quick-card">
        <span>💼</span>
        <strong>متابعة المصاريف</strong>
        <small>راقب المصاريف والتقارير المالية</small>
      </a>
    </section>
  </main>
<script>
function toggleSidebar() {
  document.querySelector(".sidebar").classList.toggle("active");
}
</script>

</body>
</html>

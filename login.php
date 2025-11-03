<?php
session_start();

/*
  login.php
  يتوقع وجود ملف config.php في نفس المجلد يحتوي متغير $conn (mysqli connection)
  يتوقع وجود جدول `comptes` بالأعمدة: id, nom, password
*/

// استدعاء ملف الاتصال (أنشئيه إذا لم يكن موجوداً - مثال أسفل)
require_once __DIR__ . '/config.php';

// منع الوصول لو كان المستخدم مسجّلًا بالفعل
if (isset($_SESSION['user'])) {
    header('Location: dashboard.php');
    exit();
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if ($username === '' || $password === '') {
        $error = 'الرجاء إدخال اسم المستخدم وكلمة المرور.';
    } else {
        // نستخدم جدول comptes كما هو موجود في القاعدة
        $sql = "SELECT id, nom, password FROM comptes WHERE nom = ? LIMIT 1";
        $stmt = mysqli_prepare($conn, $sql);

        if ($stmt === false) {
            // خطأ في تحضير الاستعلام: نطبع رسالة مفيدة للمطور
            $error = 'خطأ في جملة SQL: ' . htmlspecialchars(mysqli_error($conn));
        } else {
            mysqli_stmt_bind_param($stmt, 's', $username);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if ($row = mysqli_fetch_assoc($result)) {
                $dbPass = $row['password'];

                // إذا كانت كلمات المرور مخزنة بالنص العادي (غير موصى به) — نقارن مباشرة
                // أما الأفضل فأن تكون مشفرة بواسطة password_hash ثم نستخدم password_verify
                $isMatch = false;
                if (password_needs_rehash($dbPass, PASSWORD_DEFAULT)) {
                    // هذا يعني أن $dbPass ليس hash صالح، ربما نص عادي => قارن مباشرة
                    $isMatch = ($password === $dbPass);
                } else {
                    // نجرب التحقق بالـ password_verify (إذا كانت كلمة المرور مخزنة كهاش)
                    $isMatch = password_verify($password, $dbPass) || ($password === $dbPass);
                }

                if ($isMatch) {
                    // تسجيل الجلسة
                    $_SESSION['user'] = $row['nom'];
                    $_SESSION['user_id'] = $row['id'];
                    header('Location: dashboard.php');
                    exit();
                } else {
                    $error = 'اسم المستخدم أو كلمة المرور غير صحيحة.';
                }
            } else {
                $error = 'المستخدم غير موجود.';
            }

            mysqli_stmt_close($stmt);
        }
    }
}
?>
<!doctype html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>تسجيل الدخول - عيادة الأسنان</title>
  <link rel="stylesheet" href="assets/style.css">
  <style>
    /* لمشاهدة سريعة: ستايل بسيط مؤقت إن لم يكن لديك CSS */
    body{font-family:"Cairo",sans-serif;background:linear-gradient(135deg,#dbeafe,#bae6fd);min-height:100vh;display:flex;align-items:center;justify-content:center;margin:0}
    .card{background:#fff;padding:36px;border-radius:14px;box-shadow:0 8px 30px rgba(2,6,23,0.12);width:100%;max-width:380px}
    .card h2{color:#0ea5e9;margin:0 0 6px}
    .card p{color:#64748b;margin:0 0 18px}
    .card input{width:100%;padding:12px;margin-bottom:12px;border:1px solid #e2e8f0;border-radius:10px}
    .btn{width:100%;padding:12px;border:none;background:#0ea5e9;color:#fff;border-radius:10px;font-weight:600;cursor:pointer}
    .error{background:#fee2e2;color:#991b1b;padding:10px;border-radius:8px;margin-bottom:12px}
    .link{display:block;text-align:center;margin-top:10px;color:#0ea5e9;text-decoration:none}
  </style>
</head>
<body>
  <div class="card">
  <h1> نظام إدارة عيادة الأسنان </h1>
<p>تحكم شامل في المرضى والمواعيد والعلاجات ضمن لوحة تحكم واحدة.</p>
    <h2>💎 تسجيل الدخول </h2>
    <p><p>مرحبًا بك</p></p>

    <?php if ($error !== ''): ?>
      <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="post" action="">
      <input type="text" name="username" placeholder="اسم المستخدم" required>
      <input type="password" name="password" placeholder="كلمة المرور" required>
      <button class="btn" type="submit">تسجيل الدخول</button>
    </form>

    <a class="link" href="register.php">إنشاء حساب جديد</a>
  </div>
</body>
</html>

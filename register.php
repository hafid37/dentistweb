<?php
session_start();
include("config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);
    $confirm = trim($_POST["confirm"]);

    if ($password !== $confirm) {
        $error = "⚠️ كلمتا المرور غير متطابقتين";
    } elseif (strlen($password) < 4) {
        $error = "⚠️ كلمة المرور يجب أن تكون على الأقل 4 أحرف";
    } else {
        $hashed = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ss", $username, $hashed);

        if (mysqli_stmt_execute($stmt)) {
            $_SESSION["user"] = $username;
            $_SESSION["role"] = "admin";
            header("Location: dashboard.php");
            exit();
        } else {
            $error = "⚠️ اسم المستخدم موجود مسبقًا أو خطأ في التسجيل";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>تسجيل مستخدم جديد - عيادة الأسنان</title>
<link rel="stylesheet" href="assets/style.css">

<style>
body {
  background: linear-gradient(135deg, #dbeafe 0%, #bae6fd 100%);
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
  font-family: "Cairo", sans-serif;
}

.register-card {
  background: #ffffff;
  border-radius: 20px;
  padding: 40px;
  box-shadow: 0 8px 25px rgba(0,0,0,0.1);
  width: 100%;
  max-width: 420px;
  text-align: center;
  animation: fadeIn 1s ease;
}

.register-card h2 {
  margin-bottom: 15px;
  color: #0ea5e9;
}

.register-card p {
  color: #64748b;
  margin-bottom: 30px;
}

.register-card input {
  width: 100%;
  padding: 12px;
  margin-bottom: 20px;
  border: 2px solid #e2e8f0;
  border-radius: 10px;
  font-size: 15px;
  transition: border-color 0.3s;
}

.register-card input:focus {
  border-color: #0ea5e9;
  outline: none;
}

.register-btn {
  width: 100%;
  background: #0ea5e9;
  color: white;
  border: none;
  padding: 12px;
  border-radius: 10px;
  font-size: 16px;
  cursor: pointer;
  font-weight: bold;
  transition: background 0.3s, transform 0.2s;
}

.register-btn:hover {
  background: #0284c7;
  transform: translateY(-2px);
}

.error {
  color: #dc2626;
  margin-bottom: 15px;
  background: #fee2e2;
  padding: 8px;
  border-radius: 8px;
  font-size: 14px;
}

.success {
  color: #166534;
  background: #dcfce7;
  padding: 8px;
  border-radius: 8px;
  margin-bottom: 15px;
  font-size: 14px;
}

a.login-link {
  display: block;
  margin-top: 15px;
  text-decoration: none;
  color: #0ea5e9;
  font-weight: bold;
}

a.login-link:hover {
  text-decoration: underline;
}

@keyframes fadeIn {
  from { opacity: 0; transform: translateY(20px); }
  to { opacity: 1; transform: translateY(0); }
}

/* للهواتف */
@media (max-width: 480px) {
  .register-card {
    padding: 30px 25px;
    border-radius: 15px;
  }
}
</style>
</head>
<body>
<div class="register-card">
  <h2>🧍‍♀️ إنشاء حساب جديد</h2>
  <p>سجلي حسابك للوصول إلى لوحة التحكم</p>

  <?php if (!empty($error)): ?>
    <div class="error"><?= $error ?></div>
  <?php endif; ?>

  <?php if (!empty($success)): ?>
    <div class="success"><?= $success ?></div>
  <?php endif; ?>

  <form method="POST" action="">
    <input type="text" name="username" placeholder="اسم المستخدم" required>
    <input type="password" name="password" placeholder="كلمة المرور" required>
    <input type="password" name="confirm" placeholder="تأكيد كلمة المرور" required>
    <button type="submit" class="register-btn">إنشاء الحساب</button>
  </form>

  <a href="login.php" class="login-link">لديك حساب؟ تسجيل الدخول</a>
</div>
</body>
</html>

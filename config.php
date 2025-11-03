<?php
// إعدادات الاتصال بقاعدة البيانات
$servername = "localhost";
$username = "root";
$password = "";
$database = "dentist";

// إنشاء الاتصال
$conn = mysqli_connect($servername, $username, $password, $database);

// التحقق من الاتصال
if (!$conn) {
    die("❌ فشل الاتصال بقاعدة البيانات: " . mysqli_connect_error());
}

// تفعيل اللغة العربية بشكل صحيح
mysqli_set_charset($conn, "utf8mb4");
?>


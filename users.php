<?php
session_start();
include 'config.php'; // هذا الملف يجب أن يحتوي على الاتصال بقاعدة البيانات

// التحقق من أن المستخدم مسجل دخول
if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit();
}

// حذف مستخدم
if (isset($_GET["delete"])) {
    $id = intval($_GET["delete"]);
    mysqli_query($conn, "DELETE FROM users WHERE id=$id");
    header("Location: users.php");
    exit();
}

// جلب جميع المستخدمين
$result = mysqli_query($conn, "SELECT * FROM comptes ORDER BY id DESC");
?>


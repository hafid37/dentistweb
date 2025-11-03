<?php
// DB connection - update credentials if needed
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "dentist";

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("فشل الاتصال بقاعدة البيانات: " . $conn->connect_error);
}
$conn->set_charset("utf8mb4");
?>

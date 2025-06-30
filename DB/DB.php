<?php
// إعدادات الاتصال بقاعدة البيانات
$host = '127.0.0.1';      // عنوان السيرفر - عادة localhost في XAMPP/WAMP
$db   = 'system';  // ← ضع هنا اسم قاعدة البيانات الخاصة بك
$user = 'root';           // اسم المستخدم الافتراضي في XAMPP
$pass = '';               // كلمة المرور - تترك فارغة عادة في XAMPP

// إنشاء الاتصال
$conn = new mysqli($host, $user, $pass, $db);

// التحقق من الاتصال
if ($conn->connect_error) {
    die("فشل الاتصال بقاعدة البيانات: " . $conn->connect_error);
}

// تعيين الترميز إلى utf8 لضمان دعم اللغة العربية
$conn->set_charset("utf8");
?>
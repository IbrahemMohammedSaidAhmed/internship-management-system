<?php
// مسار مجلد الرفع
$uploadDir = __DIR__ . '/company/uploads';

// إنشاء المجلد إذا لم يكن موجودًا
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

// التحقق من وجود متغير الملف
if (!isset($_GET['file'])) {
    die("الملف غير محدد.");
}

// الحصول على اسم الملف مع تنظيفه للحماية
$filename = basename($_GET['file']);

// بناء المسار الكامل للملف
$filepath = $uploadDir . '/' . $filename;

// التحقق من وجود الملف
if (!file_exists($filepath)) {
    die("الملف غير موجود.");
}

// تحديد نوع الملف MIME type
$finfo = finfo_open(FILEINFO_MIME_TYPE);
$contentType = finfo_file($finfo, $filepath);
finfo_close($finfo);

// تعيين نوع المحتوى
if (!$contentType) {
    $contentType = "application/octet-stream";
}

// تهيئة الهيدر لعرض الملف في المتصفح
header("Content-Type: $contentType");
header("Content-Disposition: inline; filename=\"$filename\"");
header("Content-Length: " . filesize($filepath));

// قراءة محتوى الملف وإرساله
readfile($filepath);
exit;

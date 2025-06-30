<?php
// بداية ملف register.php
session_start();

$success_message = "";
$error_message = "";

// إعداد اتصال بقاعدة البيانات
$host = "localhost";
$dbname = "system";
$user = "root";  // غيرها حسب إعداداتك
$pass = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("فشل الاتصال بقاعدة البيانات: " . $e->getMessage());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // استلام البيانات مع تعقيمها
    $full_name = htmlspecialchars(trim($_POST['name']));
    $university_id = htmlspecialchars(trim($_POST['id']));
    $major = htmlspecialchars(trim($_POST['major']));
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $phone = htmlspecialchars(trim($_POST['phone']));
    $organization = htmlspecialchars(trim($_POST['organization']));

    // رفع الملف (إن وُجد)
    $document_path = null;
    if (isset($_FILES['documents']) && $_FILES['documents']['error'] == UPLOAD_ERR_OK) {
        $upload_dir = "uploads/";
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }
        $tmp_name = $_FILES['documents']['tmp_name'];
        $filename = basename($_FILES['documents']['name']);
        $target_file = $upload_dir . time() . "_" . preg_replace("/[^a-zA-Z0-9_\.-]/", "_", $filename);

        if (move_uploaded_file($tmp_name, $target_file)) {
            $document_path = $target_file;
        } else {
            $error_message = "فشل رفع المستند.";
        }
    }

    if (!$error_message) {
        // إدخال البيانات في قاعدة البيانات
        $stmt = $pdo->prepare("INSERT INTO students_training 
            (full_name, university_id, major, email, phone, organization, document_path)
            VALUES (?, ?, ?, ?, ?, ?, ?)");

        if ($stmt->execute([$full_name, $university_id, $major, $email, $phone, $organization, $document_path])) {
            // إنشاء إشعار جديد
            $notif_msg = "تم تسجيل طالب جديد: $full_name";
            $stmt2 = $pdo->prepare("INSERT INTO notifications_students (message) VALUES (?)");
            $stmt2->execute([$notif_msg]);

            $success_message = "تم إرسال التسجيل بنجاح.";
        } else {
            $error_message = "حدث خطأ أثناء حفظ البيانات.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>التسجيل في التدريب</title>
    <style>
        /* نفس التنسيق السابق */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #003366;
            color: white;
            padding: 20px;
            text-align: center;
        }

        .container {
            max-width: 700px;
            margin: 40px auto;
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #003366;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
            color: #333;
        }

        input[type="text"],
        input[type="email"],
        input[type="tel"],
        select,
        input[type="file"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 16px;
        }

        .btn {
            background-color: #003366;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
            width: 100%;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #0059b3;
        }

        .success-message {
            text-align: center;
            padding: 15px;
            margin-bottom: 20px;
            background-color: #d4edda;
            color: #155724;
            border-radius: 6px;
            border: 1px solid #c3e6cb;
        }

        .error-message {
            text-align: center;
            padding: 15px;
            margin-bottom: 20px;
            background-color: #f8d7da;
            color: #721c24;
            border-radius: 6px;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>
<body>

<header>
    <h1>التسجيل في التدريب الميداني</h1>
</header>

<div class="container">
    <h2>نموذج تسجيل الطالب</h2>

    <?php if ($success_message): ?>
        <div class="success-message"><?= $success_message ?></div>
    <?php elseif ($error_message): ?>
        <div class="error-message"><?= $error_message ?></div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data" action="">
        <div class="form-group">
            <label for="name">الاسم الكامل</label>
            <input type="text" id="name" name="name" required>
        </div>

        <div class="form-group">
            <label for="id">الرقم الجامعي</label>
            <input type="text" id="id" name="id" required>
        </div>

        <div class="form-group">
            <label for="major">التخصص</label>
            <input type="text" id="major" name="major" required>
        </div>

        <div class="form-group">
            <label for="email">البريد الإلكتروني</label>
            <input type="email" id="email" name="email" required>
        </div>

        <div class="form-group">
            <label for="phone">رقم الجوال</label>
            <input type="tel" id="phone" name="phone" required>
        </div>

        <div class="form-group">
            <label for="organization">الجهة التدريبية المرغوبة</label>
            <input type="text" id="organization" name="organization" required>
        </div>

        <div class="form-group">
            <label for="documents">تحميل المستندات</label>
            <input type="file" id="documents" name="documents">
        </div>

        <button class="btn" type="submit">إرسال النموذج</button>
    </form>
</div>

</body>
</html>

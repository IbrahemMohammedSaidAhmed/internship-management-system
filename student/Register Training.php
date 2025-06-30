<?php
session_start();
$host = "localhost";
$user = "root";
$pass = "";
$db = "system";

$conn = new mysqli($host, $user, $pass, $db);
$conn->set_charset("utf8mb4");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"] ?? '';
    $student_id = $_POST["student_id"] ?? '';
    $major = $_POST["major"] ?? '';
    $email = $_POST["email"] ?? '';
    $phone = $_POST["phone"] ?? '';
    $organization = $_POST["organization"] ?? '';
    $document_name = '';

    if (isset($_FILES['documents']) && $_FILES['documents']['error'] == 0) {
        $uploadDir = 'uploads/';
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
        $document_name = time() . '_' . basename($_FILES['documents']['name']);
        move_uploaded_file($_FILES['documents']['tmp_name'], $uploadDir . $document_name);
    }

    $stmt = $conn->prepare("INSERT INTO students (full_name, student_id, major, email, phone, organization, document_name) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $name, $student_id, $major, $email, $phone, $organization, $document_name);
    $stmt->execute();
    $stmt->close();

    $_SESSION['success_message'] = "✅ تم إرسال النموذج بنجاح.";
    header("Location: Register Training.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>التسجيل في التدريب</title>
    <style>
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

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
        }
    </style>
</head>
<body>

<header>
    <h1>التسجيل في التدريب الميداني</h1>
</header>

<div class="container">
    <?php if (!empty($_SESSION['success_message'])): ?>
        <div class="alert-success">
            <?= $_SESSION['success_message']; unset($_SESSION['success_message']); ?>
        </div>
    <?php endif; ?>

    <h2>نموذج تسجيل الطالب</h2>
    <form method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="name">الاسم الكامل</label>
            <input type="text" id="name" name="name" required>
        </div>

        <div class="form-group">
            <label for="student_id">الرقم الجامعي</label>
            <input type="text" id="student_id" name="student_id" required>
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
            <label for="organization">مجال التدريب</label>
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

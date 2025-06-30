<?php
session_start();
// التحقق من تسجيل الدخول
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// إعداد الاتصال بقاعدة البيانات
$host = "localhost";
$user = "root";
$pass = "";
$db = "system";

$conn = new mysqli($host, $user, $pass, $db);
$conn->set_charset("utf8mb4");

// جلب بيانات الطالب بناءً على اسم المستخدم من الجلسة
$username = $_SESSION['username'];
$stmt = $conn->prepare("SELECT * FROM students WHERE username = ? LIMIT 1");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$student = $result->fetch_assoc();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>تقييمي النهائي</title>
    <style>
        body {
            font-family: 'Cairo', sans-serif;
            background-color: #f0f2f5;
            margin: 0;
        }
        .navbar {
            background-color: #005baa;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: #fff;
        }
        .navbar h1 {
            margin: 0;
        }
        .navbar .logout {
            background-color: #ff4d4d;
            border: none;
            color: white;
            padding: 8px 16px;
            border-radius: 5px;
            cursor: pointer;
        }
        .header {
            text-align: center;
            padding: 40px 20px 20px;
            background: linear-gradient(to left, #007acc, #00b4db);
            color: white;
        }
        .header h2 {
            margin: 0;
        }
        .container {
            margin: 30px auto;
            padding: 20px;
            background: white;
            max-width: 600px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        .info-row {
            margin-bottom: 20px;
        }
        .info-row label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }
        .info-row div {
            background-color: #f9f9f9;
            padding: 10px;
            border-radius: 5px;
        }
    </style>
</head>
<body>

<div class="navbar">
    <h1>نظام التدريب الميداني</h1>
    <form method="post" action="logout.php">
        <button type="submit" class="logout">تسجيل الخروج</button>
    </form>
</div>

<div class="header">
    <h2>تقييمي النهائي</h2>
    <p>مرحبًا بك، هنا يمكنك الاطلاع على تقييمك النهائي وملاحظات المشرف.</p>
</div>

<div class="container">
    <?php if ($student): ?>
        <div class="info-row">
            <label>اسم الطالب:</label>
            <div><?= htmlspecialchars($student['full_name']) ?></div>
        </div>
        <div class="info-row">
            <label>درجة التقييم:</label>
            <div><?= $student['evaluation_score'] !== null ? htmlspecialchars($student['evaluation_score']) : 'لم يتم التقييم بعد' ?></div>
        </div>
        <div class="info-row">
            <label>ملاحظات المشرف:</label>
            <div><?= $student['evaluation_notes'] !== null ? nl2br(htmlspecialchars($student['evaluation_notes'])) : 'لا توجد ملاحظات' ?></div>
        </div>
    <?php else: ?>
        <p style="color: red;">تعذر العثور على بياناتك في النظام. الرجاء التواصل مع الإدارة.</p>
    <?php endif; ?>
</div>

</body>
</html>

<?php
session_start();

// مثال لضبط student_id في الجلسة (للتجربة فقط)
// في النظام الحقيقي، يجب ضبطها عند تسجيل الدخول
if (!isset($_SESSION['student_id'])) {
    $_SESSION['student_id'] = 1;  // عدّل الرقم هنا حسب رقم طالب في قاعدة بياناتك
}

$student_id = $_SESSION['student_id'];

// بيانات الاتصال بقاعدة البيانات
$host = "localhost";
$user = "root";
$pass = "";
$db = "system";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("فشل الاتصال بقاعدة البيانات: " . $conn->connect_error);
}
$conn->set_charset("utf8mb4");

// جلب عدد الإشعارات غير المقروءة
$sql = "SELECT COUNT(*) AS unread_count FROM notifications WHERE student_id = ? AND is_read = 0";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $student_id);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();
$unread_count = $data['unread_count'] ?? 0;

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>لوحة تحكم الطالب</title>
    <style>
        body {
            margin: 0;
            font-family: 'Cairo', sans-serif;
            background-color: #f0f2f5;
            color: #333;
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
            font-size: 24px;
        }
        .navbar .logout {
            background-color: #ff4d4d;
            border: none;
            color: white;
            padding: 8px 16px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
        }
        .header {
            text-align: center;
            padding: 40px 20px 20px;
            background: linear-gradient(to left, #007acc, #00b4db);
            color: white;
        }
        .header h2 {
            margin: 0;
            font-size: 28px;
        }
        .dashboard {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
            padding: 30px;
        }
        .card {
            background-color: #fff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            text-align: center;
            transition: transform 0.3s ease;
            position: relative;
        }
        .card:hover {
            transform: translateY(-5px);
        }
        .card a {
            text-decoration: none;
            color: #005baa;
            font-weight: bold;
            display: inline-block;
            position: relative;
            padding-right: 25px;
        }
        .card a:hover {
            background-color: #e0f0ff;
            border-radius: 5px;
        }
        /* التنبيه الأحمر (النقطة) */
        .notification-badge {
            position: absolute;
            top: -8px;
            right: 0px;
            background: red;
            color: white;
            font-size: 12px;
            padding: 3px 7px;
            border-radius: 50%;
            font-weight: bold;
            min-width: 22px;
            text-align: center;
            line-height: 1;
            box-shadow: 0 0 3px rgba(0,0,0,0.3);
        }
        .card p {
            font-size: 14px;
            color: #666;
            margin-top: 8px;
        }
        @media (max-width: 600px) {
            .navbar h1 {
                font-size: 18px;
            }
        }
    </style>
</head>
<body>

<div class="navbar">
    <h1>نظام التدريب الميداني</h1>
    <form method="post" action="logout.php" style="margin:0;">
        <button class="logout" type="submit">تسجيل الخروج</button>
    </form>
</div>

<div class="header">
    <h2>مرحباً بك، طالبنا العزيز </h2>
    <p>في لوحة التحكم الخاصة بك يمكنك إدارة كل ما يتعلق بتدريبك الميداني</p>
</div>

<div class="dashboard">
    <div class="card">
        <h3><a href="Training Data.php">بيانات التدريب</a></h3>
        <p>عرض وتحديث معلومات جهة التدريب والمشرف.</p>
    </div>
    <div class="card">
        <h3><a href="Weekly report.php">التقارير الأسبوعية</a></h3>
        <p>رفع التقارير ومتابعة الملاحظات من المشرف.</p>
    </div>
    <div class="card">
        <h3><a href="/company/Evaluation.php">التقييم</a></h3>
        <p>مشاهدة التقييم النهائي وملاحظات المشرفين.</p>
    </div>
    <div class="card">
        <h3>
            <a href="Notification.php" style="position: relative;">
                إشعارات
                <?php if ($unread_count > 0): ?>
                    <span class="notification-badge"><?= htmlspecialchars($unread_count) ?></span>
                <?php endif; ?>
            </a>
        </h3>
        <p>متابعة التنبيهات الجديدة والتعليمات الصادرة.</p>
    </div>
    <div class="card">
        <h3><a href="Register Training.php">التسجيل للتدريب للشركات</a></h3>
        <p>تسجيل التدريب لدى الشركة.</p>
    </div>
    <div class="card">
        <h3><a href="Register training University.php">رفع الطلب</a></h3>
        <p>ارسال طلب التدريب للكلية.</p>
    </div>
</div>

</body>
</html>
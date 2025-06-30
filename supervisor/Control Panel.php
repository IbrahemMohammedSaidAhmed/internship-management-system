<?php
// الاتصال بقاعدة البيانات
$host = "localhost";
$dbname = "system";
$user = "root";
$pass = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("فشل الاتصال بقاعدة البيانات: " . $e->getMessage());
}

// جلب عدد الإشعارات غير المقروءة
$stmt = $pdo->prepare("SELECT COUNT(*) FROM notifications_students WHERE is_read = 0");
$stmt->execute();
$unread_count = $stmt->fetchColumn();
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>لوحة تحكم المشرف</title>
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

        .card h3 {
            color: #005baa;
            margin-bottom: 10px;
        }

        .card p {
            font-size: 14px;
            color: #666;
        }

        .badge {
            position: absolute;
            top: 15px;
            left: 15px;
            background-color: red;
            color: white;
            border-radius: 50%;
            padding: 5px 10px;
            font-size: 12px;
            font-weight: bold;
            box-shadow: 0 0 3px rgba(0,0,0,0.3);
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
    <a href="logout.php">
    <button class="logout">تسجيل الخروج</button></a>
</div>

<div class="header">
    <h2>مرحباً بك، مشرفنا العزيز </h2>
    <p>في لوحة التحكم الخاصة بك يمكنك إدارة كل ما يتعلق بتدريب الطلاب</p>
</div>

<div class="dashboard">
    <div class="card" onclick="location.href='student management.php'">
        <h3>إدارة الطلاب</h3>
        <p>عرض بيانات الطلاب وتقييم أدائهم.</p>
    </div>
    <div class="card" onclick="location.href='Evaluation.php'">
        <h3>التقييم النهائي</h3>
        <p>إعطاء التقييم النهائي للطلاب بناءً على أدائهم.</p>
    </div>
    <div class="card" onclick="location.href='Notification.php'">
        <h3>إشعارات</h3>
        <p>إرسال إشعارات أو تعليمات للطلاب.</p>
        <?php if ($unread_count > 0): ?>
            <span class="badge"><?= $unread_count ?></span>
        <?php endif; ?>
    </div>
</div>

</body>
</html>

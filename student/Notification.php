<?php
session_start();

// تأكد من تسجيل الدخول (تعديل هذا حسب نظام تسجيلك)
if (!isset($_SESSION['student_id'])) {
    die("الرجاء تسجيل الدخول لعرض الإشعارات.");
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "system";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("فشل الاتصال بقاعدة البيانات: " . $conn->connect_error);
}

$student_id = $_SESSION['student_id'];

$notifications = [];
$sql = "SELECT message, created_at FROM notifications WHERE student_id = ? ORDER BY created_at DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $student_id);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $notifications[] = $row;
}
$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>الإشعارات</title>
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

        .notifications-container {
            width: 80%;
            margin: 30px auto;
            background-color: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .notification {
            background-color: #f9f9f9;
            padding: 15px;
            margin-top: 10px;
            border-radius: 5px;
            box-shadow: 0 1px 5px rgba(0, 0, 0, 0.1);
            position: relative;
        }

        .notification:hover {
            background-color: #e8f3ff;
        }

        .notification h4 {
            margin: 0;
            font-size: 18px;
            color: #005baa;
        }

        .notification-time {
            font-size: 12px;
            color: #999;
            margin-top: 5px;
        }

        .notification.approved {
            border-left: 6px solid #28a745;
            background-color: #e6f4ea;
        }

        .notification.approved h4 {
            color: #1e7e34;
        }

        .notification.rejected {
            border-left: 6px solid #dc3545;
            background-color: #f8d7da;
        }

        .notification.rejected h4 {
            color: #721c24;
        }

        @media (max-width: 600px) {
            .notifications-container {
                width: 90%;
            }
        }
    </style>
</head>
<body>

<div class="navbar">
    <h1>نظام التدريب الميداني</h1>
</div>

<div class="header">
    <h2>الإشعارات</h2>
    <p>اطلع على أحدث الإشعارات المتعلقة بتدريبك الميداني.</p>
</div>

<div class="notifications-container">

    <?php if (empty($notifications)): ?>
        <div class="notification">
            <h4>لا توجد إشعارات حالياً</h4>
            <p>لم يتم إرسال أي إشعار حتى الآن.</p>
        </div>
    <?php else: ?>
        <?php foreach ($notifications as $note): ?>
            <?php
            $typeClass = '';
            if (stripos($note['message'], 'رفض') !== false) {
                $typeClass = 'rejected';
            } elseif (stripos($note['message'], 'موافقة') !== false) {
                $typeClass = 'approved';
            }
            ?>
            <div class="notification <?= $typeClass ?>">
                <h4><?= htmlspecialchars($note['message']) ?></h4>
                <div class="notification-time"><?= htmlspecialchars($note['created_at']) ?></div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

</div>

</body>
</html>

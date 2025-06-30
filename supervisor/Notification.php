<?php
// الاتصال بقاعدة البيانات
$conn = new mysqli("localhost", "root", "", "system");
if ($conn->connect_error) {
die("فشل الاتصال بقاعدة البيانات: " . $conn->connect_error);
}

// تحديث الحالة إذا تم الضغط على زر موافقة أو رفض
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'], $_POST['student_id'])) {
$id = (int)$_POST['student_id'];
$action = $_POST['action'] === 'approve' ? 'approved' : 'rejected';
$conn->query("UPDATE students_training SET status='$action' WHERE id=$id");
}

// جلب الطلاب المسجلين
$result = $conn->query("SELECT * FROM students_training WHERE status='pending'");
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

        .notification-list {
            margin: 20px;
        }

        .notification-item {
            background-color: #fff;
            padding: 15px;
            margin-bottom: 10px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .notification-item .details {
            flex-grow: 1;
            margin-right: 20px;
        }

        .notification-item .details p {
            margin: 0;
            font-size: 16px;
        }

        .notification-item .details span {
            color: #555;
            font-size: 14px;
        }

        .notification-item .actions {
            text-align: right;
        }

        .view-btn, .delete-btn {
            background-color: #007acc;
            color: white;
            border: none;
            padding: 6px 12px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            margin-left: 5px;
        }

        .view-btn:hover, .delete-btn:hover {
            background-color: #005baa;
        }

        .delete-btn {
            background-color: #ff4d4d;
        }

        .delete-btn:hover {
            background-color: #d32f2f;
        }

        @media (max-width: 600px) {
            .notification-item {
                flex-direction: column;
                align-items: flex-start;
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
    <h2>الطلاب المسجلين</h2>
    <p>قم بمراجعة طلبات تسجيل الطلاب واتخاذ القرار المناسب.</p>
</div>

<div class="notification-list">
    <?php while ($row = $result->fetch_assoc()): ?>
    <div class="notification-item">
        <div class="details">
            <p><strong>الاسم: <?= htmlspecialchars($row['full_name']) ?></strong></p>
            <span>تاريخ التسجيل: <?= $row['registration_date'] ?></span>
        </div>
        <div class="actions">
            <form method="POST" style="display:inline;">
                <input type="hidden" name="student_id" value="<?= $row['id'] ?>">
                <button class="view-btn" name="action" value="approve">موافقة</button>
                <button class="delete-btn" name="action" value="reject">رفض</button>
            </form>
        </div>
    </div>
    <?php endwhile; ?>
</div>

</body>
</html>

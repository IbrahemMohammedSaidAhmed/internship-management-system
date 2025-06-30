<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "system";

$conn = new mysqli($host, $user, $pass, $db);
$conn->set_charset("utf8mb4");

$result = $conn->query("SELECT * FROM students WHERE status = 'تمت الموافقة' ORDER BY created_at DESC");

$message = "";
$evaluate_id = $_GET['evaluate'] ?? null;
$student_to_evaluate = null;

$send_notify_id = $_GET['send_notify'] ?? null;
$student_to_notify = null;

// حفظ التقييم عند الإرسال
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['evaluation_submit'])) {
        $student_id = $_POST['student_id'];
        $score = $_POST['score'];
        $notes = $_POST['notes'];

        $stmt = $conn->prepare("UPDATE students SET evaluation_score = ?, evaluation_notes = ? WHERE id = ?");
        $stmt->bind_param("ssi", $score, $notes, $student_id);
        $stmt->execute();
        $stmt->close();

        $message = " تم حفظ التقييم بنجاح.";
    } elseif (isset($_POST['notification_submit'])) {
        // استلام الإشعار و الملاحظات
        $student_id = $_POST['student_id'];
        $notification_notes = $_POST['notification_notes'];

        // هنا يمكن تنفيذ عملية الإرسال أو الحفظ في قاعدة البيانات
        // مثال: حفظ إشعار في جدول notifications (إذا موجود)
        // أو يمكنك إرسال بريد إلكتروني، أو أي عملية أخرى.

        // مثال حفظ في جدول notifications (تأكد أن الجدول موجود)
        /*
        $stmt = $conn->prepare("INSERT INTO notifications (student_id, notes, created_at) VALUES (?, ?, NOW())");
        $stmt->bind_param("is", $student_id, $notification_notes);
        $stmt->execute();
        $stmt->close();
        */

        // أو فقط رسالة تأكيد
        $message = " تم إرسال الإشعار بنجاح.";

        // إلغاء عرض نموذج الإشعار بعد الإرسال
        $send_notify_id = null;
    }
}

// جلب بيانات الطالب المحدد للتقييم
if ($evaluate_id) {
    $stmt = $conn->prepare("SELECT * FROM students WHERE id = ?");
    $stmt->bind_param("i", $evaluate_id);
    $stmt->execute();
    $res = $stmt->get_result();
    $student_to_evaluate = $res->fetch_assoc();
    $stmt->close();
}

// جلب بيانات الطالب المحدد للإشعار
if ($send_notify_id) {
    $stmt = $conn->prepare("SELECT * FROM students WHERE id = ?");
    $stmt->bind_param("i", $send_notify_id);
    $stmt->execute();
    $res = $stmt->get_result();
    $student_to_notify = $res->fetch_assoc();
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>لوحة الشركة - الطلاب المتدربين</title>
    <style>
        body {
            font-family: 'Cairo', sans-serif;
            background-color: #f5f7fa;
            margin: 0;
            padding: 0;
        }

        .navbar {
            background-color: #0077b6;
            color: white;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar h1 {
            margin: 0;
        }

        .container {
            padding: 30px;
            max-width: 1000px;
            margin: auto;
        }

        h2 {
            color: #0077b6;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: white;
            border-radius: 10px;
            overflow: hidden;
        }

        th, td {
            padding: 15px;
            border-bottom: 1px solid #eee;
            text-align: center;
        }

        th {
            background-color: #edf6f9;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        .btn {
            padding: 7px 15px;
            background-color: #00b4d8;
            color: white;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            font-size: 14px;
            cursor: pointer;
        }

        .btn:hover {
            background-color: #0096c7;
        }

        .alert {
            background-color: #d4edda;
            color: #155724;
            padding: 15px;
            border-radius: 6px;
            margin: 20px 0;
            border: 1px solid #c3e6cb;
            text-align: center;
        }

        .evaluation-form, .notification-form {
            background-color: white;
            padding: 20px;
            margin-top: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 6px;
            font-weight: bold;
        }

        input[type="text"],
        textarea {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border-radius: 6px;
            border: 1px solid #ccc;
            resize: vertical;
        }
    </style>
</head>
<body>

<div class="navbar">
    <h1>لوحة الشركة</h1>
    <a href="logout.php">
    <button class="btn">تسجيل الخروج</button></a>
</div>

<div class="container">
    <h2>الطلاب المتدربون في الشركة</h2>

    <?php if ($message): ?>
        <div class="alert"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <table>
        <thead>
        <tr>
            <th>الاسم</th>
            <th>التخصص</th>
            <th>البريد الإلكتروني</th>
            <th>رقم الجوال</th>
            <th>التقارير</th>
            <th>التقييم</th>
            <th>إشعار</th>
        </tr>
        </thead>
        <tbody>
        <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row['full_name']) ?></td>
                <td><?= htmlspecialchars($row['major']) ?></td>
                <td><?= htmlspecialchars($row['email']) ?></td>
                <td><?= htmlspecialchars($row['phone']) ?></td>
                <td><a href="Weekly%20Report.php" class="btn">عرض</a></td>
                <td><a href="?evaluate=<?= $row['id'] ?>" class="btn">تقييم</a></td>
                <td><a href="?send_notify=<?= $row['id'] ?>" class="btn">إرسال</a></td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>

    <?php if ($student_to_evaluate): ?>
        <div class="evaluation-form">
            <h3>تقييم الطالب: <?= htmlspecialchars($student_to_evaluate['full_name']) ?> (<?= htmlspecialchars($student_to_evaluate['major']) ?>)</h3>
            <form method="post">
                <input type="hidden" name="student_id" value="<?= $student_to_evaluate['id'] ?>">
                <input type="hidden" name="evaluation_submit" value="1">
                <div class="form-group">
                    <label>الدرجة (من 100)</label>
                    <input type="text" name="score" required>
                </div>
                <div class="form-group">
                    <label>ملاحظات</label>
                    <textarea name="notes" rows="4"></textarea>
                </div>
                <button type="submit" class="btn">حفظ التقييم</button>
            </form>
        </div>
    <?php endif; ?>

    <?php if ($student_to_notify): ?>
        <div class="notification-form">
            <h3>إرسال إشعار للطالب: <?= htmlspecialchars($student_to_notify['full_name']) ?></h3>
            <form method="post">
                <input type="hidden" name="student_id" value="<?= $student_to_notify['id'] ?>">
                <input type="hidden" name="notification_submit" value="1">
                <div class="form-group">
                    <label>الملاحظات</label>
                    <textarea name="notification_notes" rows="5" required placeholder="اكتب الملاحظات هنا..."></textarea>
                </div>
                <button type="submit" class="btn">إرسال الإشعار</button>
            </form>
        </div>
    <?php endif; ?>

</div>

</body>
</html>


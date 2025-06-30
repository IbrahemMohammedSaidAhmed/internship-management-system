<?php
session_start();

$host = "localhost";
$user = "root";
$pass = "";
$db = "system";

$conn = new mysqli($host, $user, $pass, $db);
$conn->set_charset("utf8mb4");

function sendNotification($conn, $student_id, $message) {
    $stmt = $conn->prepare("INSERT INTO notifications (student_id, message) VALUES (?, ?)");
    $stmt->bind_param("is", $student_id, $message);
    $stmt->execute();
    $stmt->close();
}

if (isset($_GET['approve'])) {
    $id = intval($_GET['approve']);
    $conn->query("UPDATE students SET status='تمت الموافقة' WHERE id=$id");

    // احصل على student_id من جدول students
    $result = $conn->query("SELECT student_id FROM students WHERE id=$id LIMIT 1");
    if ($row = $result->fetch_assoc()) {
        sendNotification($conn, $row['student_id'], "تمت الموافقة على طلبك للتدريب.");
    }

    header("Location: ".$_SERVER['PHP_SELF']); exit;
}

if (isset($_GET['reject'])) {
    $id = intval($_GET['reject']);
    $conn->query("UPDATE students SET status='تم الرفض' WHERE id=$id");

    $result = $conn->query("SELECT student_id FROM students WHERE id=$id LIMIT 1");
    if ($row = $result->fetch_assoc()) {
        sendNotification($conn, $row['student_id'], "تم رفض طلبك للتدريب.");
    }

    header("Location: ".$_SERVER['PHP_SELF']); exit;
}

$result = $conn->query("SELECT * FROM students ORDER BY created_at DESC");
?>


<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>طلبات التدريب - الشركة</title>
    <style>
        body { font-family: 'Cairo', sans-serif; background-color: #f4f6f9; margin: 0; padding: 0; }
        .navbar { background-color: #007bff; padding: 15px; color: white; text-align: center; }
        .container { padding: 30px; max-width: 1000px; margin: auto; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; background: white; box-shadow: 0 2px 8px rgba(0,0,0,0.05); }
        th, td { padding: 15px; text-align: center; border-bottom: 1px solid #eee; }
        th { background-color: #f1f1f1; color: #333; }
        .status { font-weight: bold; }
        .approved { color: #28a745; }
        .rejected { color: #dc3545; }
        .pending { color: #ffc107; }
    </style>
</head>
<body>
<div class="navbar">
    <h2>طلبات التدريب الواردة من الطلاب</h2>
</div>
<div class="container">
    <table>
        <thead>
        <tr>
            <th>اسم الطالب</th>
            <th>الرقم الجامعي</th>
            <th>التخصص</th>
            <th>البريد الإلكتروني</th>
            <th>رقم الجوال</th>
            <th>الجهة</th>
            <th>تاريخ التقديم</th>
            <th>المستند</th>
            <th>الحالة</th>
            <th>الإجراء</th>

        </tr>
        </thead>
        <tbody>
        <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row['full_name']) ?></td>
                <td><?= htmlspecialchars($row['student_id']) ?></td>
                <td><?= htmlspecialchars($row['major']) ?></td>
                <td><?= htmlspecialchars($row['email']) ?></td>
                <td><?= htmlspecialchars($row['phone']) ?></td>
                <td><?= htmlspecialchars($row['organization']) ?></td>
                <td><?= htmlspecialchars($row['created_at']) ?></td>
                <td><?= $row['document_name'] ? "<a href='uploads/{$row['document_name']}' target='_blank'>عرض</a>" : "-" ?></td>
                <td class="status <?= $row['status'] == 'تمت الموافقة' ? 'approved' : ($row['status'] == 'تم الرفض' ? 'rejected' : 'pending') ?>">
                    <?= htmlspecialchars($row['status']) ?>
                </td>
                <td>
                    <a href="?approve=<?= $row['id'] ?>" style="color: #28a745; text-decoration: none; margin: 0 5px;">✔️ موافقة</a>
                   <a href="?reject=<?= $row['id'] ?>" style="color: #dc3545; text-decoration: none; margin: 0 5px;">❌ رفض</a>
                </td>

            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>
</body>
</html>

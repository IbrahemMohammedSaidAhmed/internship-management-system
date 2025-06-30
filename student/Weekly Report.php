<?php
$host = 'localhost';
$db = 'system';
$user = 'root';
$pass = '';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("فشل الاتصال بقاعدة البيانات: " . $conn->connect_error);
}

$message = "";
$rating = null;  // لتخزين درجة التقييم

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['reportFile'])) {
    $studentName = $_POST['studentName'];
    $reportTitle = $_POST['reportTitle'];

    $uploadDir = 'uploads/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $fileName = time() . '_' . basename($_FILES['reportFile']['name']);
    $targetFile = $uploadDir . $fileName;

    $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
    $allowedTypes = ['pdf', 'doc', 'docx', 'txt'];

    if (in_array($fileType, $allowedTypes)) {
        if (move_uploaded_file($_FILES['reportFile']['tmp_name'], $targetFile)) {
            $stmt = $conn->prepare("INSERT INTO reports (student_name, report_title, file_path, created_at) VALUES (?, ?, ?, NOW())");
            $stmt->bind_param("sss", $studentName, $reportTitle, $targetFile);
            if ($stmt->execute()) {
                $message = " تم رفع التقرير بنجاح!";

                // بعد الرفع، نبحث عن تقييم التقرير الجديد (إذا موجود)
                $report_id = $stmt->insert_id;
                $stmt->close();

                // جلب التقييم
                $stmt2 = $conn->prepare("SELECT rating FROM reports WHERE id = ?");
                $stmt2->bind_param("i", $report_id);
                $stmt2->execute();
                $stmt2->bind_result($rating);
                $stmt2->fetch();
                $stmt2->close();

            } else {
                $message = " خطأ في حفظ البيانات.";
            }
        } else {
            $message = " حدث خطأ أثناء رفع الملف.";
        }
    } else {
        $message = " نوع الملف غير مدعوم.";
    }
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8" />
    <title>رفع تقرير الطالب</title>
    <style>
        body { font-family: 'Cairo', sans-serif; background: #f0f0f0; padding: 20px; }
        .container { background: white; padding: 20px; border-radius: 10px; width: 90%; margin: auto; box-shadow: 0 0 10px #ccc; }
        h2 { color: #005baa; }
        form { display: flex; flex-direction: column; gap: 15px; }
        input, button {
            padding: 10px; font-size: 16px; border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            background-color: #007acc;
            color: white;
            border: none;
            cursor: pointer;
        }
        button:hover { background-color: #005baa; }
        .message { margin-top: 10px; font-weight: bold; color: green; }
        .rating {
            margin-top: 15px;
            font-size: 18px;
            font-weight: bold;
            color: #005baa;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>رفع تقرير التدريب الميداني</h2>

    <?php if ($message): ?>
        <div class="message"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <?php if ($rating !== null): ?>
        <div class="rating">درجة تقييم التقرير: <?= htmlspecialchars($rating) ?></div>
    <?php elseif ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
        <div class="rating">لم يتم تقييم التقرير بعد.</div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data">
        <input type="text" name="studentName" placeholder="اسم الطالب" required />
        <input type="text" name="reportTitle" placeholder="عنوان التقرير" required />
        <input type="file" name="reportFile" accept=".pdf,.doc,.docx,.txt" required />
        <button type="submit">رفع التقرير</button>
    </form>
</div>
</body>
</html>

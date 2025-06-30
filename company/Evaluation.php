<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "system";

$conn = new mysqli($host, $user, $pass, $db);
$conn->set_charset("utf8mb4");

// جلب الطلاب الذين لديهم تقييم نهائي
$result = $conn->query("SELECT * FROM students WHERE status = 'تمت الموافقة' AND evaluation_score IS NOT NULL ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>التقييم النهائي - الشركة</title>
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

        .evaluation {
            padding: 30px;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .student-card {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .student-card h3 {
            font-size: 20px;
            color: #333;
        }

        .student-card p {
            font-size: 14px;
            color: #666;
        }

        .student-card .btn {
            padding: 8px 16px;
            background-color: #005baa;
            color: white;
            border-radius: 5px;
            text-decoration: none;
            font-size: 14px;
        }

        .student-card .btn:hover {
            background-color: #003f75;
        }

        .evaluation-status {
            margin-top: 10px;
            font-weight: bold;
            color: #888;
        }

        .evaluation-status.pass {
            color: green;
        }

        .evaluation-status.fail {
            color: red;
        }

        .evaluation-status.pending {
            color: orange;
        }
    </style>
</head>
<body>

<div class="navbar">
    <h1>نظام التدريب الميداني</h1>
</div>

<div class="header">
    <h2>التقييم النهائي للطلاب</h2>
    <p>هنا يمكنك متابعة التقييمات النهائية الخاصة بالطلاب وتقديم ملاحظاتك.</p>
</div>

<div class="evaluation">
    <?php while($row = $result->fetch_assoc()):
        // تصنيف التقييم لونيًا
        $status_class = "pending";
        if ($row['evaluation_score'] === "مقبول") {
            $status_class = "pass";
        } elseif ($row['evaluation_score'] === "غير مقبول") {
            $status_class = "fail";
        }
        ?>
        <div class="student-card">
            <h3>الطالب: <?= htmlspecialchars($row['full_name']) ?></h3>
            <p>التقييم النهائي: <span class="evaluation-status <?= $status_class ?>">
            <?= htmlspecialchars($row['evaluation_score']) ?>
        </span></p>
            <p>التقييم من المشرف: "<?= nl2br(htmlspecialchars($row['evaluation_notes'])) ?>"</p>
            <a href="evaluation-form.php?id=<?= $row['id'] ?>" class="btn">عرض التقييم الكامل</a>
        </div>
    <?php endwhile; ?>
</div>

</body>
</html>



<?php
$host = 'localhost';
$db = 'system';
$user = 'root';
$pass = '';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("فشل الاتصال بقاعدة البيانات: " . $conn->connect_error);
}

// عرض رسالة بعد الحفظ
$message = "";
if (isset($_GET['saved']) && $_GET['saved'] == '1') {
    $message = " تم حفظ التقييم بنجاح.";
}

// معالجة إرسال التقييم والملاحظات
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['report_id'])) {
    $report_id = intval($_POST['report_id']);
    $rating = intval($_POST['rating'] ?? 0);
    $notes = $conn->real_escape_string($_POST['notes'] ?? '');

    if ($rating >= 1 && $rating <= 5) {
        $sql_update = "UPDATE reports SET rating = $rating, notes = '$notes' WHERE id = $report_id";
        $conn->query($sql_update);
        header("Location: ?saved=1");
        exit;
    } else {
        $message = " التقييم يجب أن يكون بين 1 و 5.";
    }
}

// جلب التقارير
$sql = "SELECT * FROM reports ORDER BY created_at DESC";
$result = $conn->query($sql);

// تحديد التقرير المفتوح للتقييم
$activeReportId = isset($_GET['rate']) ? intval($_GET['rate']) : 0;
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>عرض تقارير الطلاب</title>
    <style>
        body { font-family: 'Cairo', sans-serif; background: #f0f0f0; padding: 20px; }
        .container { background: white; padding: 20px; border-radius: 10px; width: 90%; margin: auto; box-shadow: 0 0 10px #ccc; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 10px; text-align: center; vertical-align: top; }
        th { background-color: #005baa; color: white; }
        a.btn, button.btn {
            background: #007acc;
            color: white;
            padding: 6px 12px;
            text-decoration: none;
            border-radius: 5px;
            margin: 2px;
            cursor: pointer;
            border: none;
        }
        a.btn:hover, button.btn:hover { background: #005baa; }
        form.rate-form {
            margin-top: 10px;
            background: #eef6fc;
            padding: 10px;
            border-radius: 8px;
            text-align: right;
        }
        form.rate-form label {
            display: block;
            margin: 5px 0 3px 0;
            font-weight: bold;
        }
        form.rate-form select, form.rate-form textarea {
            width: 100%;
            padding: 5px;
            border-radius: 5px;
            border: 1px solid #ccc;
            resize: vertical;
        }
        form.rate-form textarea {
            min-height: 60px;
        }
        .message {
            margin: 10px 0;
            padding: 10px;
            border-radius: 5px;
            background: #d4edda;
            color: #155724;
            font-weight: bold;
        }
        h3.section-title {
            margin-top: 50px;
            color: #333;
            border-bottom: 2px solid #005baa;
            padding-bottom: 5px;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>التقارير المرفوعة من الطلاب</h2>

    <?php if (!empty($message)): ?>
        <div class="message"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <table>
        <thead>
        <tr>
            <th>اسم الطالب</th>
            <th>عنوان التقرير</th>
            <th>تاريخ الرفع</th>
            <th>عرض</th>
            <th>تقييم</th>
        </tr>
        </thead>
        <tbody>
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['student_name']) ?></td>
                    <td><?= htmlspecialchars($row['report_title']) ?></td>
                    <td><?= htmlspecialchars($row['created_at']) ?></td>
                    <td>
                        <a class="btn" href="view.php?file=<?= urlencode(basename($row['file_path'])) ?>" target="_blank">عرض</a>
                    </td>
                    <td>
                        <?php if ($activeReportId === intval($row['id'])): ?>
                            <form method="post" class="rate-form">
                                <input type="hidden" name="report_id" value="<?= $row['id'] ?>">
                                <label for="rating_<?= $row['id'] ?>">التقييم (1-5):</label>
                                <select id="rating_<?= $row['id'] ?>" name="rating" required>
                                    <option value="">اختر</option>
                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                        <option value="<?= $i ?>" <?= ($row['rating'] == $i) ? 'selected' : '' ?>><?= $i ?></option>
                                    <?php endfor; ?>
                                </select>
                                <label for="notes_<?= $row['id'] ?>">الملاحظات:</label>
                                <textarea id="notes_<?= $row['id'] ?>" name="notes" placeholder="أدخل ملاحظاتك هنا..."><?= htmlspecialchars($row['notes']) ?></textarea>
                                <button type="submit" class="btn">حفظ</button>
                            </form>
                        <?php else: ?>
                            <a class="btn" href="?rate=<?= $row['id'] ?>">تقييم</a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="5">لا توجد تقارير حالياً.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>

    <?php
    // إعادة تنفيذ الاستعلام لعرض التقييمات بشكل مستقل
    $result = $conn->query($sql);
    ?>

    <h3 class="section-title">التقييمات والملاحظات</h3>
    <table>
        <thead>
        <tr>
            <th>اسم الطالب</th>
            <th>عنوان التقرير</th>
            <th>التقييم</th>
            <th>الملاحظات</th>
        </tr>
        </thead>
        <tbody>
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <?php if (!empty($row['rating'])): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['student_name']) ?></td>
                        <td><?= htmlspecialchars($row['report_title']) ?></td>
                        <td><?= intval($row['rating']) ?></td>
                        <td><?= nl2br(htmlspecialchars($row['notes'])) ?></td>
                    </tr>
                <?php endif; ?>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="4">لا توجد تقييمات حالياً.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>
</body>
</html>

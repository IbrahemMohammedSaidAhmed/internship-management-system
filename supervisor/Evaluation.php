<<?php
// إعداد الاتصال بقاعدة البيانات
$host = "localhost";
$user = "root";
$pass = "";
$db = "system";

$conn = new mysqli($host, $user, $pass, $db);
$conn->set_charset("utf8mb4");

// تحديث التقييم إذا تم إرسال النموذج
$update_message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_evaluation'])) {
    $student_id = (int) $_POST['student_id'];
    $new_score = trim($_POST['evaluation_score']);
    $new_notes = trim($_POST['evaluation_notes']);

    $stmt = $conn->prepare("UPDATE students SET evaluation_score = ?, evaluation_notes = ? WHERE id = ?");
    $stmt->bind_param("ssi", $new_score, $new_notes, $student_id);
    if ($stmt->execute()) {
        $update_message = "تم تحديث التقييم بنجاح.";
    } else {
        $update_message = "حدث خطأ أثناء التحديث.";
    }
    $stmt->close();
}

// جلب بيانات الطلاب
$sql = "SELECT * FROM students WHERE status = 'تمت الموافقة' AND evaluation_score IS NOT NULL ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>التقييم النهائي</title>
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
        .search-bar {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }
        .search-bar input {
            padding: 10px;
            width: 50%;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 16px;
        }
        .table-container {
            margin: 0 20px;
            overflow-x: auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 12px;
            text-align: center;
        }
        th {
            background-color: #005baa;
            color: white;
        }
        tr:hover {
            background-color: #f5f5f5;
        }
        .view-btn, .edit-btn, .save-btn {
            padding: 6px 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            color: white;
        }
        .view-btn {
            background-color: #007acc;
        }
        .view-btn:hover {
            background-color: #005baa;
        }
        .edit-btn {
            background-color: #ffcc00;
            color: #000;
        }
        .edit-btn:hover {
            background-color: #ffaa00;
        }
        .save-btn {
            background-color: #007acc;
            padding: 8px 16px;
        }
        .save-btn:hover {
            background-color: #005baa;
        }
        .notes-section, .edit-section {
            margin: 20px;
        }
        .notes-textarea, .edit-textarea {
            width: 100%;
            height: 100px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
        }
        .edit-section {
            display: none;
            background-color: #fff;
            border: 1px solid #ddd;
            padding: 20px;
            border-radius: 10px;
        }
        .alert {
            background-color: #d4edda;
            color: #155724;
            padding: 10px;
            margin: 20px;
            border-radius: 5px;
            border: 1px solid #c3e6cb;
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
    <h2>التقييم النهائي</h2>
    <p>هنا يمكنك متابعة التقييمات النهائية للطلاب المرافقين لك.</p>
</div>

<?php if (!empty($update_message)): ?>
    <div class="alert"><?= $update_message ?></div>
<?php endif; ?>

<div class="search-bar">
    <input type="text" placeholder="ابحث عن تقييم..." />
</div>

<div class="table-container">
    <table>
        <thead>
        <tr>
            <th>الطالب</th>
            <th>التقييم النهائي</th>
            <th>التفاصيل</th>
            <th>ملاحظات المشرف</th>
            <th>تعديل التقييم</th>
        </tr>
        </thead>
        <tbody>
        <?php if ($result->num_rows > 0): ?>
            <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['full_name']) ?></td>
                    <td><?= htmlspecialchars($row['evaluation_score']) ?></td>
                    <td>
                        <button class="view-btn" onclick="viewFinalEvaluation('<?= htmlspecialchars($row['full_name']) ?>')">عرض التقييم</button>
                    </td>
                    <td>
                        <button class="view-btn" onclick="viewNotes(`<?= htmlspecialchars($row['evaluation_notes']) ?>`)">عرض الملاحظات</button>
                    </td>
                    <td>
                        <button class="edit-btn" onclick="showEditForm(<?= $row['id'] ?>, '<?= htmlspecialchars($row['evaluation_score']) ?>', `<?= htmlspecialchars($row['evaluation_notes']) ?>`)">تعديل</button>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="5">لا توجد تقييمات متاحة حالياً.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- نموذج تعديل التقييم -->
<div class="edit-section" id="editSection">
    <h3>تعديل التقييم</h3>
    <form method="post">
        <input type="hidden" name="student_id" id="editStudentId">
        <label for="evaluation_score">درجة التقييم:</label><br>
        <input type="text" name="evaluation_score" id="editScore" style="width: 100%; padding: 10px; margin: 10px 0;" required><br>

        <label for="evaluation_notes">ملاحظات:</label><br>
        <textarea name="evaluation_notes" id="editNotes" class="edit-textarea" required></textarea><br>

        <button type="submit" name="update_evaluation" class="save-btn">حفظ التعديلات</button>
    </form>
</div>

<!-- ملاحظات إضافية -->
<div class="notes-section">
    <h3>ملاحظات المشرف</h3>
    <textarea class="notes-textarea" placeholder="أضف ملاحظاتك حول التقييم هنا..."></textarea>
    <br>
    <button class="save-btn" onclick="saveNotes()">حفظ الملاحظات</button>
</div>

<script>
    function viewFinalEvaluation(studentName) {
        alert("عرض التقييم النهائي لـ " + studentName);
    }

    function viewNotes(notes) {
        alert("ملاحظات المشرف:\n\n" + notes);
    }

    function showEditForm(id, score, notes) {
        document.getElementById("editStudentId").value = id;
        document.getElementById("editScore").value = score;
        document.getElementById("editNotes").value = notes;
        document.getElementById("editSection").style.display = "block";
        window.scrollTo({ top: document.getElementById("editSection").offsetTop, behavior: 'smooth' });
    }

    function saveNotes() {
        alert("تم حفظ الملاحظات بنجاح");
    }
</script>

</body>
</html>


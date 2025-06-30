<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>بيانات التدريب</title>
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

        .container {
            width: 80%;
            margin: 30px auto;
            background-color: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            font-size: 16px;
            color: #333;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            margin-top: 5px;
            border-radius: 5px;
            border: 1px solid #ddd;
        }

        .form-group textarea {
            height: 100px;
            resize: vertical;
        }

        .form-group button {
            background-color: #007acc;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
        }

        .form-group button:hover {
            background-color: #005baa;
        }

        .output-box {
            margin-top: 30px;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            padding: 20px;
            border-radius: 10px;
        }

        .output-box h3 {
            margin-top: 0;
            color: #007acc;
        }

        @media (max-width: 600px) {
            .container {
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
    <h2>بيانات التدريب الميداني</h2>
    <p>قم بإدخال أو تحديث بيانات التدريب الميداني الخاصة بك</p>
</div>

<div class="container">
    <form method="POST">
        <div class="form-group">
            <label for="trainingOrg">اسم جهة التدريب</label>
            <input type="text" id="trainingOrg" name="trainingOrg" placeholder="أدخل اسم جهة التدريب" required />
        </div>

        <div class="form-group">
            <label for="supervisor">اسم المشرف</label>
            <input type="text" id="supervisor" name="supervisor" placeholder="أدخل اسم المشرف" required />
        </div>

        <div class="form-group">
            <label for="location">موقع التدريب</label>
            <input type="text" id="location" name="location" placeholder="أدخل موقع التدريب" required />
        </div>

        <div class="form-group">
            <label for="startDate">تاريخ بداية التدريب</label>
            <input type="date" id="startDate" name="startDate" required />
        </div>

        <div class="form-group">
            <label for="endDate">تاريخ نهاية التدريب</label>
            <input type="date" id="endDate" name="endDate" required />
        </div>

        <div class="form-group">
            <label for="description">وصف التدريب</label>
            <textarea id="description" name="description" placeholder="أدخل وصف التدريب" required></textarea>
        </div>

        <div class="form-group">
            <button type="submit" name="submit">حفظ التغييرات</button>
        </div>
    </form>

    <?php if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])): ?>
        <div class="output-box">
            <h3>تم حفظ البيانات بنجاح:</h3>
            <p><strong>اسم جهة التدريب:</strong> <?= htmlspecialchars($_POST['trainingOrg']) ?></p>
            <p><strong>اسم المشرف:</strong> <?= htmlspecialchars($_POST['supervisor']) ?></p>
            <p><strong>موقع التدريب:</strong> <?= htmlspecialchars($_POST['location']) ?></p>
            <p><strong>تاريخ البداية:</strong> <?= htmlspecialchars($_POST['startDate']) ?></p>
            <p><strong>تاريخ النهاية:</strong> <?= htmlspecialchars($_POST['endDate']) ?></p>
            <p><strong>وصف التدريب:</strong> <?= nl2br(htmlspecialchars($_POST['description'])) ?></p>
        </div>
    <?php endif; ?>
</div>

</body>
</html>

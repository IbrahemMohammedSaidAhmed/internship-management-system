<?php
// عدّاد التقارير غير المراجعة
$reportsFile = __DIR__ . '/reports.json';
$unreviewedCount = 0;

if (file_exists($reportsFile)) {
    $data = json_decode(file_get_contents($reportsFile), true);
    foreach ($data as $report) {
        if (isset($report['status']) && $report['status'] === 'قيد المراجعة') {
            $unreviewedCount++;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>لوحة تحكم الشركة</title>
    <style>
        body {
            margin: 0;
            font-family: 'Cairo', sans-serif;
            background-color: #f4f6f9;
            color: #333;
        }

        .navbar {
            background-color: #00695c;
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
            background-color: #f44336;
            border: none;
            color: white;
            padding: 8px 16px;
            border-radius: 5px;
            cursor: pointer;
        }

        .header {
            text-align: center;
            padding: 30px 20px;
            background: linear-gradient(to left, #009688, #4db6ac);
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
            position: relative;
            background-color: #fff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            text-align: center;
            transition: transform 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card h3 {
            color: #00695c;
            margin-bottom: 10px;
        }

        .card p {
            font-size: 14px;
            color: #666;
        }

        .badge {
            position: absolute;
            top: 10px;
            left: 10px;
            background: red;
            color: white;
            font-size: 12px;
            padding: 4px 8px;
            border-radius: 50px;
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="navbar">
    <h1>نظام التدريب - شركة</h1>
    <a href="logout.php">
    <button class="logout">تسجيل الخروج</button>
    </a>
</div>

<div class="header">
    <h2>مرحباً بك في لوحة تحكم الشركة </h2>
    <p>يمكنك متابعة الطلاب، تقييمهم، ومراجعة التقارير الأسبوعية من هنا.</p>
</div>

<div class="dashboard">
    <div class="card" onclick="location.href='Training Application.php'">
        <h3>طلبات التدريب</h3>
        <p>عرض طلبات التدريب من الطلاب والموافقة أو الرفض.</p>
    </div>

    <div class="card" onclick="location.href='Student Training in the company.php'">
        <h3>قائمة الطلاب</h3>
        <p>عرض معلومات الطلاب المتدربين في الشركة.</p>
    </div>

    <div class="card" onclick="location.href='Weekly Report.php'">
        <?php if ($unreviewedCount > 0): ?>
            <div class="badge"><?= $unreviewedCount ?></div>
        <?php endif; ?>
        <h3>التقارير الأسبوعية</h3>
        <p>مراجعة تقارير الطلاب وإضافة ملاحظات.</p>
    </div>

    <div class="card" onclick="location.href='Evaluation.php'">
        <h3>التقييم</h3>
        <p>تقييم أداء الطلاب وتحديد الدرجة النهائية.</p>
    </div>

    <div class="card" onclick="location.href='Notification.php'">
        <h3>الإشعارات</h3>
        <p>مراجعة التعليمات أو إرسال ملاحظات للطلاب.</p>
    </div>

    <div class="card">
        <h3>الملف الشخصي</h3>
        <p>تعديل بيانات الشركة أو تغيير كلمة المرور.</p>
    </div>

</div>

</body>
</html>

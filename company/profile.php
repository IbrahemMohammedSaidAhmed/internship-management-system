<?php
$submitted = false;
$name = "شركة ";
$email = "xxx@example.com";
$phone = "+1234567890";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["save"])) {
    $name = htmlspecialchars($_POST["company_name"]);
    $email = htmlspecialchars($_POST["company_email"]);
    $phone = htmlspecialchars($_POST["company_phone"]);
    $submitted = true;
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>الملف الشخصي - الشركة</title>
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

        .profile-container {
            padding: 30px;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .profile-container .section {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .profile-container .section h3 {
            font-size: 20px;
            color: #333;
        }

        .profile-container .section p {
            font-size: 14px;
            color: #666;
        }

        .profile-container .section .input-group {
            margin-bottom: 15px;
        }

        .profile-container .section .input-group label {
            font-size: 14px;
            color: #333;
            display: block;
            margin-bottom: 5px;
        }

        .profile-container .section .input-group input,
        .profile-container .section .input-group select {
            padding: 8px;
            font-size: 14px;
            width: 100%;
            border-radius: 5px;
            border: 1px solid #ccc;
            margin-bottom: 10px;
        }

        .profile-container .section .button {
            padding: 8px 16px;
            background-color: #005baa;
            color: white;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            border: none;
        }

        .profile-container .section .button:hover {
            background-color: #003f75;
        }

        .profile-container .section .info {
            font-size: 14px;
            color: #666;
            margin-top: 10px;
        }
    </style>
</head>
<body>

<div class="navbar">
    <h1>نظام التدريب الميداني</h1>
</div>

<div class="header">
    <h2>الملف الشخصي - الشركة</h2>
    <p>هنا يمكنك تحديث بيانات الحساب الخاصة بك.</p>
</div>

<div class="profile-container">

    <form method="POST">
        <div class="section">
            <h3>معلومات الشركة</h3>
            <div class="input-group">
                <label for="company-name">اسم الشركة</label>
                <input type="text" id="company-name" name="company_name" value="<?= $name ?>" />
            </div>
            <div class="input-group">
                <label for="company-email">البريد الإلكتروني</label>
                <input type="email" id="company-email" name="company_email" value="<?= $email ?>" />
            </div>
            <div class="input-group">
                <label for="company-phone">رقم الهاتف</label>
                <input type="text" id="company-phone" name="company_phone" value="<?= $phone ?>" />
            </div>
            <button class="button" type="submit" name="save">حفظ البيانات</button>
        </div>
    </form>

    <div class="section">
        <h3>تغيير كلمة المرور</h3>
        <div class="input-group">
            <label for="current-password">كلمة المرور الحالية</label>
            <input type="password" id="current-password" placeholder="أدخل كلمة المرور الحالية" />
        </div>
        <div class="input-group">
            <label for="new-password">كلمة المرور الجديدة</label>
            <input type="password" id="new-password" placeholder="أدخل كلمة المرور الجديدة" />
        </div>
        <div class="input-group">
            <label for="confirm-password">تأكيد كلمة المرور الجديدة</label>
            <input type="password" id="confirm-password" placeholder="تأكيد كلمة المرور الجديدة" />
        </div>
        <button class="button">تغيير كلمة المرور</button>
    </div>

    <!-- ℹ️ معلومات إضافية -->
    <div class="section">
        <h3>معلومات إضافية</h3>
        <p class="info">يمكنك تعديل بيانات الشركة مثل الاسم والبريد الإلكتروني ورقم الهاتف من خلال التواصل مع الدعم الفني في حال وجود أي تغييرات.</p>
    </div>
</div>

<!-- ✅ عرض البيانات بعد الحفظ -->
<?php if ($submitted): ?>
    <div class="profile-container">
        <div class="section">
            <h3>تم حفظ البيانات بنجاح</h3>
            <p><strong>اسم الشركة:</strong> <?= $name ?></p>
            <p><strong>البريد الإلكتروني:</strong> <?= $email ?></p>
            <p><strong>رقم الهاتف:</strong> <?= $phone ?></p>
        </div>
    </div>
<?php endif; ?>

</body>
</html>

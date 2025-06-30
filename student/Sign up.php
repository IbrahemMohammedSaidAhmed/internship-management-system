<?php
// ملف signup.php

session_start();

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullname = trim($_POST['fullname']);
    $email = trim($_POST['email']);
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    // تحقق من تطابق كلمات المرور
    if ($password !== $confirmPassword) {
        $error = 'كلمتا المرور غير متطابقتين';
    } elseif (empty($fullname) || empty($email) || empty($username) || empty($password)) {
        $error = 'يرجى تعبئة كل الحقول';
    } else {
        // تخزين المستخدم في ملف (users.txt)
        $usersFile = 'users.txt';

        // اقرأ المستخدمين الموجودين
        $users = file_exists($usersFile) ? file($usersFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) : [];

        // تحقق من وجود اسم مستخدم أو بريد إلكتروني مكرر
        $exists = false;
        foreach ($users as $userLine) {
            list($uUsername, $uPasswordHash, $uFullname, $uEmail) = explode(',', $userLine);
            if ($uUsername === $username) {
                $error = 'اسم المستخدم موجود بالفعل';
                $exists = true;
                break;
            }
            if ($uEmail === $email) {
                $error = 'البريد الإلكتروني مستخدم بالفعل';
                $exists = true;
                break;
            }
        }

        if (!$exists) {
            // تشفير كلمة المرور
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);

            // حفظ المستخدم في الملف: اسم_المستخدم,كلمة_المرور_المشفرة,الاسم_الكامل,البريد_الإلكتروني
            $line = $username . ',' . $passwordHash . ',' . $fullname . ',' . $email . "\n";
            file_put_contents($usersFile, $line, FILE_APPEND);

            $success = 'تم إنشاء الحساب بنجاح، يمكنك الآن تسجيل الدخول.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>إنشاء حساب جديد</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(to right, #0066cc, #66b3ff);
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }
        .signup-container {
            background-color: white;
            padding: 40px 30px;
            border-radius: 12px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 450px;
        }
        h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #004080;
        }
        .form-group {
            margin-bottom: 18px;
        }
        label {
            font-weight: bold;
            display: block;
            margin-bottom: 6px;
        }
        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 16px;
        }
        .btn {
            background-color: #004080;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            width: 100%;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .btn:hover {
            background-color: #0066cc;
        }
        .footer-text {
            text-align: center;
            margin-top: 15px;
            font-size: 14px;
            color: #666;
        }
        .footer-text a {
            color: #004080;
            text-decoration: none;
        }
        .error-message {
            color: red;
            text-align: center;
            margin-bottom: 15px;
        }
        .success-message {
            color: green;
            text-align: center;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>

<div class="signup-container">
    <h2>إنشاء حساب جديد</h2>

    <?php if ($error): ?>
        <div class="error-message"><?= htmlspecialchars($error) ?></div>
    <?php elseif ($success): ?>
        <div class="success-message"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

    <form method="POST" action="">
        <div class="form-group">
            <label for="fullname">الاسم الكامل</label>
            <input type="text" id="fullname" name="fullname" required value="<?= htmlspecialchars($_POST['fullname'] ?? '') ?>">
        </div>

        <div class="form-group">
            <label for="email">البريد الإلكتروني</label>
            <input type="email" id="email" name="email" required value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
        </div>

        <div class="form-group">
            <label for="username">اسم المستخدم</label>
            <input type="text" id="username" name="username" required value="<?= htmlspecialchars($_POST['username'] ?? '') ?>">
        </div>

        <div class="form-group">
            <label for="password">كلمة المرور</label>
            <input type="password" id="password" name="password" required>
        </div>

        <div class="form-group">
            <label for="confirmPassword">تأكيد كلمة المرور</label>
            <input type="password" id="confirmPassword" name="confirmPassword" required>
        </div>

        <button type="submit" class="btn">إنشاء الحساب</button>
    </form>

    <div class="footer-text">
        لديك حساب بالفعل؟ <a href="login.php">سجّل الدخول</a>
    </div>
</div>

</body>
</html>

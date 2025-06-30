<?php
session_start();

$error = '';

// الاتصال بقاعدة البيانات
$servername = "localhost";
$db_username = "root"; // اسم المستخدم لقاعدة البيانات
$db_password = "";     // كلمة المرور (فارغة غالبًا في localhost)
$dbname = "system";

// إنشاء الاتصال
$conn = mysqli_connect($servername, $db_username, $db_password, $dbname);

// التحقق من الاتصال
if (!$conn) {
    die("فشل الاتصال بقاعدة البيانات: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if (empty($username) || empty($password)) {
        $error = 'يرجى تعبئة كل الحقول';
    } else {
        // البحث عن المستخدم
        $query = "SELECT * FROM users_supervisor WHERE username = '$username'";
        $result = mysqli_query($conn, $query);

        if ($result && mysqli_num_rows($result) === 1) {
            $user = mysqli_fetch_assoc($result);
            if (password_verify($password, $user['password_hash'])) {
                // تسجيل الدخول ناجح
                $_SESSION['username'] = $user['username'];
                $_SESSION['fullname'] = $user['fullname'];
                header("Location: control Panel.php"); // صفحة لوحة التحكم
                exit;
            } else {
                $error = 'كلمة المرور غير صحيحة';
            }
        } else {
            $error = 'اسم المستخدم غير موجود. الرجاء إنشاء حساب.';
        }
    }
}
?>


<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>تسجيل الدخول</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(to right, #0059b3, #66a3ff);
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .login-container {
            background-color: white;
            padding: 40px 30px;
            border-radius: 12px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #003366;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
            display: block;
            margin-bottom: 6px;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 16px;
        }

        .btn {
            background-color: #003366;
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
            background-color: #0059b3;
        }

        .footer-text {
            text-align: center;
            margin-top: 15px;
            font-size: 14px;
            color: #666;
        }

        .footer-text a {
            color: #003366;
            text-decoration: none;
        }

        .error-message {
            color: red;
            text-align: center;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>

<div class="login-container">
    <h2>تسجيل الدخول</h2>

    <?php if ($error): ?>
        <div class="error-message"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" action="">
        <div class="form-group" >
            <label for="username">اسم المستخدم</label>
            <input type="text" id="username" name="username" required value="<?= htmlspecialchars($_POST['username'] ?? '') ?>">
        </div>

        <div class="form-group">
            <label for="password">كلمة المرور</label>
            <input type="password" id="password" name="password" required>
        </div>

        <button type="submit" class="btn">دخول</button>
    </form>

    <div class="footer-text">
        ليس لديك حساب؟ <a href="sign up.php">سجّل الآن</a>
    </div>
</div>

</body>
</html>

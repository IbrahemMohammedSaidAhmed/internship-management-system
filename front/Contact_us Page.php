<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>اتصل بنا - التدريب الميداني</title>
  <style>
    body {
      font-family: 'Cairo', sans-serif;
      background-color: #f9f9f9;
      margin: 0;
      padding: 0;
      direction: rtl;
    }

    header {
      background-color: #003366;
      color: white;
      padding: 20px 0;
      text-align: center;
      box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }

    nav {
      background-color: #0059b3;
      display: flex;
      justify-content: center;
      padding: 10px 0;
    }

    nav a {
      color: white;
      text-decoration: none;
      margin: 0 15px;
      font-weight: bold;
      transition: color 0.3s ease;
    }

    nav a:hover {
      color: #ffcc00;
    }

    .container {
      max-width: 900px;
      margin: 40px auto;
      background-color: white;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }

    h2 {
      color: #003366;
      margin-bottom: 20px;
    }

    .form-group {
      margin-bottom: 15px;
    }

    .form-group label {
      font-weight: bold;
      display: block;
      margin-bottom: 5px;
    }

    .form-group input, .form-group textarea {
      width: 100%;
      padding: 10px;
      border-radius: 5px;
      border: 1px solid #ddd;
      margin-top: 5px;
      font-size: 16px;
    }

    .form-group textarea {
      resize: vertical;
      min-height: 100px;
    }

    .btn {
      background-color: #003366;
      color: white;
      padding: 10px 20px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      width: 100%;
      font-size: 16px;
    }

    .btn:hover {
      background-color: #0059b3;
    }

    footer {
      background-color: #003366;
      color: white;
      text-align: center;
      padding: 15px 0;
      margin-top: 40px;
    }
  </style>
</head>
<body>

<header>
  <h1>منصة التدريب الميداني</h1>
</header>

<nav>
  <a href="Home%20Page.php">الرئيسية</a>
  <a href="About_us%20Page.php">من نحن</a>
  <a href="Contact_us%20Page.php">اتصل بنا</a>
  <a href="Training%20Guide%20Page.php">دليل التدريب</a>
  <a href="../student/Login.php">تسجيل الدخول</a>
</nav>
<div class="container">
  <h2>اتصل بنا</h2>
  <p>إذا كان لديك أي استفسار أو ترغب في الحصول على مزيد من المعلومات، يمكنك التواصل معنا عبر النموذج التالي.</p>

  <form>
    <div class="form-group">
      <label for="name">الاسم الكامل</label>
      <input type="text" id="name" name="name" placeholder="أدخل اسمك الكامل" required>
    </div>

    <div class="form-group">
      <label for="email">البريد الإلكتروني</label>
      <input type="email" id="email" name="email" placeholder="أدخل بريدك الإلكتروني" required>
    </div>

    <div class="form-group">
      <label for="message">الرسالة</label>
      <textarea id="message" name="message" placeholder="اكتب رسالتك هنا" required></textarea>
    </div>

    <button type="submit" class="btn">إرسال الرسالة</button>
  </form>
</div>

<footer>
  &copy; 2025 جميع الحقوق محفوظة - منصة التدريب الميداني
</footer>

</body>
</html>

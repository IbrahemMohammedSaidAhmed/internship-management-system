<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>الصفحة الرئيسية - التدريب الميداني</title>
  <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700&display=swap" rel="stylesheet">
  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body {
      font-family: 'Cairo', sans-serif;
      background-color: #f4f6f9;
      color: #333;
      line-height: 1.6;
    }

    /* شريط التنقل */
    .navbar {

      position: fixed;
      width: 100%;
      background: rgba(30, 64, 175, 0.95);
      color: white;
      padding: 15px 40px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      z-index: 999;
      box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    }

    .navbar h1 {
      font-size: 22px;
    }

    .nav-links {
      display: flex;
      gap: 25px;
    }

    .nav-links a {
      color: white;
      text-decoration: none;
      font-weight: 600;
      transition: 0.3s;
    }

    .nav-links a:hover {
      color: #ffd700;
    }

    /* البانر الترحيبي */
    .hero {
      background-image: url('../img/img.png');
      background-size: cover;
      background-position: center;
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      text-align: center;
      color: white;
      padding: 0 20px;
    }

    .hero h2 {
      font-size: 40px;
      margin-bottom: 20px;
      text-shadow: 1px 1px 4px rgba(0,0,0,0.5);
    }

    .hero p {
      font-size: 20px;
      max-width: 700px;
      margin: auto;
      background-color: rgba(0, 0, 0, 0.4);
      padding: 20px;
      border-radius: 10px;
    }

    /* محتوى الأقسام */
    .section {
      padding: 60px 20px;
      max-width: 1100px;
      margin: auto;
    }

    .section h3 {
      font-size: 26px;
      color: #1e40af;
      margin-bottom: 15px;
    }

    .card {
      background-color: white;
      padding: 25px;
      border-radius: 10px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.07);
      margin-bottom: 30px;
      transition: 0.3s;
    }

    .card:hover {
      transform: translateY(-5px);
    }

    .card ul {
      padding-right: 20px;
      margin-top: 10px;
    }

    footer {
      background-color: #1e40af;
      color: white;
      text-align: center;
      padding: 20px;
      font-size: 14px;
      margin-top: 50px;
    }
    .dropdown {
        position: relative;
        display: inline-block;
        font-family: Arial, sans-serif;
    }

    /* رابط رئيسي بدون خلفية أو إطار */
    .dropdown a.main-link {
        color: #f1f1f1;
        padding: 10px;
        text-decoration: none;
        display: inline-block;
    }

    .dropdown a.main-link:hover {
        color: #0077cc;
    }

    /* محتوى القائمة المنسدلة */
    .dropdown-content {
        display: none;
        position: absolute;
        background-color: white;
        min-width: 200px;
        box-shadow: 0px 8px 16px rgba(0,0,0,0.1);
        z-index: 1;
        border: 1px solid #ddd;
    }

    .dropdown-content a {
        color: black;
        padding: 10px 15px;
        text-decoration: none;
        display: block;
        text-align: right;
    }

    .dropdown-content a:hover {
        background-color: #f1f1f1;
    }

    .dropdown:hover .dropdown-content {
        display: block;
    }
  </style>
</head>
<body>

<!-- الشريط العلوي -->
<?php include "../front/menu/menu.php"?>

<!-- بانر ترحيبي -->
<div class="hero">
  <div>
    <h2>مرحبًا بكم في منصة التدريب الميداني</h2>
    <p>نهدف إلى تمكين طلابنا من تطبيق المعرفة النظرية في بيئة عمل حقيقية، وبناء مستقبل مهني واعد عبر شراكات استراتيجية مع المؤسسات.</p>
  </div>
</div>

<!-- قسم التدريب -->
<div class="section">
  <div class="card">
    <h3>ما هو التدريب الميداني؟</h3>
    <p>التدريب الميداني هو تجربة تعليمية عملية تساعد الطلاب على ربط المفاهيم الأكاديمية بالواقع المهني، من خلال الانخراط الفعلي في بيئات العمل المناسبة لتخصصاتهم.</p>
  </div>

  <div class="card">
    <h3>أهداف التدريب:</h3>
    <ul>
      <li>تمكين الطالب من تطبيق المهارات والمعارف في الواقع المهني.</li>
      <li>تعزيز الثقة بالنفس ومهارات التواصل.</li>
      <li>التعرّف على بيئة العمل ومتطلباتها.</li>
      <li>رفع جاهزية الخريجين لسوق العمل.</li>
    </ul>
  </div>
</div>

<!-- تذييل -->
<footer>
  © 2025 جميع الحقوق محفوظة - جامعة الأقصى
</footer>

</body>
</html>

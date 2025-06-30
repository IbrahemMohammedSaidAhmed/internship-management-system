<?php
// الاتصال بقاعدة البيانات
$conn = new mysqli("localhost", "root", "", "system");
if ($conn->connect_error) {
die("فشل الاتصال بقاعدة البيانات: " . $conn->connect_error);
}

// جلب الطلاب الذين تم قبول تدريبهم
$result = $conn->query("SELECT * FROM students_training WHERE status='approved'");
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>إدارة الطلاب</title>
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
      margin: 0 20px 40px;
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

    .view-btn {
      padding: 6px 12px;
      background-color: #007acc;
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }

    .view-btn:hover {
      background-color: #005baa;
    }

    @media (max-width: 600px) {
      .search-bar input {
        width: 80%;
      }
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
  <h2>إدارة الطلاب المقبولين</h2>
  <p>هنا يمكنك إدارة الطلاب المتدربين تحت إشرافك ومتابعة تقاريرهم وأدائهم</p>
</div>

<div class="search-bar">
  <input type="text" id="searchInput" placeholder="ابحث عن طالب..." onkeyup="searchTable()" />
</div>

<div class="table-container">
  <table id="studentsTable">
    <thead>
    <tr>
      <th>الاسم</th>
      <th>التخصص</th>
      <th>حالة التدريب</th>
      <th>التقييمات</th>
      <th>إجراءات</th>
    </tr>
    </thead>
    <tbody>
    <?php while ($row = $result->fetch_assoc()): ?>
    <tr>
      <td><?= htmlspecialchars($row['full_name']) ?></td>
      <td><?= htmlspecialchars($row['major'] ?? '-') ?></td>
      <td><?= ($row['status'] == 'approved') ? 'مقبول' : htmlspecialchars($row['status']) ?></td>
      <td><a href="Evaluation.php">عرض التقييم</a></td>
      <td><button class="view-btn" onclick="viewStudentDetails('<?= htmlspecialchars($row['full_name']) ?>')">عرض التفاصيل</button></td>
    </tr>
    <?php endwhile; ?>
    </tbody>
  </table>
</div>

<script>
  function viewStudentDetails(studentName) {
    alert("عرض تفاصيل الطالب: " + studentName);
    // هنا يمكنك إضافة نافذة أو صفحة تفاصيل حسب الحاجة
  }

  // بحث في الجدول
  function searchTable() {
    const input = document.getElementById("searchInput").value.toLowerCase();
    const table = document.getElementById("studentsTable");
    const trs = table.tBodies[0].getElementsByTagName("tr");

    for (let i = 0; i < trs.length; i++) {
      const tds = trs[i].getElementsByTagName("td");
      let show = false;
      for (let j = 0; j < tds.length - 1; j++) { // نبحث في كل الأعمدة ما عدا عمود الإجراءات
        if (tds[j].textContent.toLowerCase().indexOf(input) > -1) {
          show = true;
          break;
        }
      }
      trs[i].style.display = show ? "" : "none";
    }
  }
</script>

</body>
</html>

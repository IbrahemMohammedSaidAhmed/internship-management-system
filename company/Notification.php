<?php
$notificationsFile = __DIR__ . '/notifications.json';
$notifications = [];

if (file_exists($notificationsFile)) {
    $notifData = file_get_contents($notificationsFile);
    $notifications = json_decode($notifData, true) ?? [];
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8" />
    <title>إشعارات الشركة</title>
    <style>
        body { font-family: 'Cairo', sans-serif; background-color: #f0f2f5; }
        .navbar { background-color: #005baa; padding: 15px; color: white; text-align: center; font-size: 24px; }
        .header { text-align: center; padding: 30px; background: linear-gradient(to left, #007acc, #00b4db); color: white; }
        .notifications { width: 90%; margin: 20px auto; }
        .notification-item { background: white; padding: 20px; border-radius: 8px; margin-bottom: 15px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        .notification-title { font-size: 18px; font-weight: bold; }
        .notification-date { font-size: 12px; color: #888; }
        .notification-message { font-size: 14px; margin-top: 5px; }
        .btn { display: inline-block; margin-top: 10px; padding: 6px 12px; background-color: #005baa; color: white; border-radius: 5px; text-decoration: none; }
    </style>
</head>
<body>
<div class="navbar">نظام التدريب الميداني</div>
<div class="header"><h2>إشعارات الشركة</h2></div>
<div class="notifications">
    <?php if (count($notifications) === 0): ?>
        <p style="text-align:center;">لا توجد إشعارات حالياً.</p>
    <?php else: ?>
        <?php foreach (array_reverse($notifications) as $notif): ?>
            <div class="notification-item">
                <div class="notification-title"><?= htmlspecialchars($notif['title']) ?></div>
                <div class="notification-date"><?= htmlspecialchars($notif['date']) ?></div>
                <div class="notification-message"><?= htmlspecialchars($notif['message']) ?></div>
                <a class="btn" href="<?= htmlspecialchars($notif['link']) ?>">عرض</a>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
</body>
</html>


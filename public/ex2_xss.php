<?php
// @author 🐈‍⬛ Siam Thanat Hack Co., Ltd. (STH)

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use STH\SecurityExercises\SecurityHeaders;

error_reporting(E_ALL);
ini_set('display_errors', '1');

// เปลี่ยนโหมดด้วยพารามิเตอร์ ?secure=1 (ค่าเริ่มต้น) หรือ ?secure=0
$secure = filter_input(INPUT_GET, 'secure', FILTER_VALIDATE_BOOL) ?? true;
$name   = $_GET['name'] ?? '';

// Set security headers based on mode
SecurityHeaders::setDemoHeaders($secure);

function e(string $s): string {
    return htmlspecialchars($s, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}
?>
<!doctype html>
<meta charset="utf-8">
<title>XSS Demo</title>
<h1>Reflected XSS Demo (<?= $secure ? 'SECURE' : 'INSECURE' ?>)</h1>

<form method="get">
  <label>ชื่อ: <input name="name" value="<?= $secure ? e($name) : $name ?>"></label>
  <input type="hidden" name="secure" value="<?= $secure ? '1' : '0' ?>">
  <button type="submit">Submit</button>
</form>

<p>สวัสดี, 
<?php if ($secure): ?>
  <?= e($name) ?>
<?php else: ?>
  <?= $name /* ไม่ปลอดภัย: อาจรันสคริปต์ */ ?>
<?php endif; ?>
</p>

<p>ตัวอย่างทดสอบ (INSECURE): เพิ่มใน URL <code>?secure=0&amp;name=&lt;script&gt;alert(1)&lt;/script&gt;</code></p>

<?php
// @author 🐈‍⬛ Siam Thanat Hack Co., Ltd. (STH)

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use STH\SecurityExercises\SecurityHeaders;

session_start();

error_reporting(E_ALL);
ini_set('display_errors', '1');

// โหมดสาธิต: ?secure=1 (ค่าเริ่มต้น) จะตรวจ token, ?secure=0 จะไม่ตรวจ (ไม่ปลอดภัย)
$secure = filter_input(INPUT_GET, 'secure', FILTER_VALIDATE_BOOL) ?? true;

// Set security headers based on mode
SecurityHeaders::setDemoHeaders($secure);

// จำลอง User Login Session
$_SESSION['email'] ??= 'victim@example.com';

// สร้าง CSRF Token
$_SESSION['csrf_token'] ??= bin2hex(random_bytes(32));

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($secure) {
        $token = $_POST['csrf_token'] ?? '';
        if (!hash_equals($_SESSION['csrf_token'], $token)) {
            http_response_code(403);
            exit('CSRF validation failed');
        }
        // Rorate CSRF Token หลังใช้
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    $newEmail = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    if ($newEmail) {
        $_SESSION['email'] = $newEmail;
    }
}
?>
<!doctype html>
<meta charset="utf-8">
<title>CSRF Demo</title>
<h1>CSRF Demo (<?= $secure ? 'SECURE' : 'INSECURE' ?>)</h1>

<p>Current email: <strong><?= htmlspecialchars($_SESSION['email'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></strong></p>

<form method="post">
  <label>Change email:
    <input name="email" type="email" required>
  </label>
  <?php if ($secure): ?>
    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>">
  <?php endif; ?>
  <button type="submit">Update</button>
</form>

<p>สาธิตโจมตี: สร้างไฟล์ <code>attacker.html</code> ในเครื่องคุณที่มีเนื้อหา:</p>
<pre>&lt;form action="http://127.0.0.1:8000/ex5_csrf.php?secure=0" method="post"&gt;
  &lt;input type="hidden" name="email" value="attacker@evil.tld"&gt;
  &lt;script&gt;document.forms[0].submit();&lt;/script&gt;
&lt;/form&gt;</pre>
<p>ขณะเหยื่อ (Victim) ล็อกอินและเปิด attacker.html เบราว์เซอร์จะยิง CSRF</p>

<?php
// @author 🐈‍⬛ Siam Thanat Hack Co., Ltd. (STH)

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use STH\SecurityExercises\SecurityHeaders;

error_reporting(E_ALL);
ini_set('display_errors', '1');

// In-memory SQLite เพื่อให้รัน Standalone ได้
$pdo = new PDO('sqlite::memory:');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->exec("
    CREATE TABLE students (id INTEGER PRIMARY KEY, name TEXT, email TEXT);
    INSERT INTO students (name, email) VALUES
        ('Alice','alice@example.com'),
        ('Bob','bob@example.com'),
        ('Charlie','charlie@example.com');
");

$secure = filter_input(INPUT_GET, 'secure', FILTER_VALIDATE_BOOL) ?? true;
$q = $_GET['q'] ?? '';

// Set security headers based on mode
SecurityHeaders::setDemoHeaders($secure);

function e(string $s): string { return htmlspecialchars($s, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); }
?>
<!doctype html>
<meta charset="utf-8">
<title>SQL Injection Demo</title>
<h1>SQL Injection Demo (<?= $secure ? 'SECURE' : 'INSECURE' ?>)</h1>

<form method="get">
  <label>ค้นหาชื่อนักศึกษาแบบเท่ากับ (exact): <input name="q" value="<?= e($q) ?>"></label>
  <input type="hidden" name="secure" value="<?= $secure ? '1' : '0' ?>">
  <button type="submit">Search</button>
</form>

<?php
if ($secure) {
    $stmt = $pdo->prepare('SELECT name,email FROM students WHERE name = :name');
    $stmt->execute([':name' => $q]);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    // ไม่ปลอดภัย: ต่อสตริงจากผู้ใช้ลง SQL โดยตรง
    // ตัวอย่าง "ไม่ปลอดภัย" มีไว้เพื่อการศึกษาในสภาพแวดล้อมทดสอบภายในเท่านั้น อย่านำไปใช้ในระบบจริง
    $sql = "SELECT name,email FROM students WHERE name = '$q'";
    $rows = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    echo "<p>Executed SQL (INSECURE): <code>" . e($sql) . "</code></p>";
}
?>

<table border="1" cellpadding="6">
  <tr><th>Name</th><th>Email</th></tr>
  <?php foreach ($rows as $r): ?>
    <tr><td><?= e($r['name']) ?></td><td><?= e($r['email']) ?></td></tr>
  <?php endforeach; ?>
</table>

<p>ลองโหมด INSECURE ด้วยพารามิเตอร์:
<code>?secure=0&amp;q=' OR '1'='1' -- </code></p>

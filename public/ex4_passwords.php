<?php
// @author 🐈‍⬛ Siam Thanat Hack Co., Ltd. (STH)

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use STH\SecurityExercises\SecurityHeaders;

session_start();

error_reporting(E_ALL);
ini_set('display_errors', '1');

// Set secure headers
SecurityHeaders::setSecureHeaders(true);

// DB ชั่วคราวในหน่วยความจำ
$pdo = new PDO('sqlite::memory:');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->exec("CREATE TABLE users (id INTEGER PRIMARY KEY, username TEXT UNIQUE, passhash TEXT);");

// ใส่ผู้ใช้ตัวอย่าง alice / P@ssw0rd!
$hash = password_hash('P@ssw0rd!', PASSWORD_DEFAULT);
$insert = $pdo->prepare("INSERT INTO users (username, passhash) VALUES (?, ?)");
$insert->execute(['alice', $hash]);

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $u = $_POST['username'] ?? '';
    $p = $_POST['password'] ?? '';
    $stmt = $pdo->prepare('SELECT passhash FROM users WHERE username = ?');
    $stmt->execute([$u]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    $ok = $row && password_verify($p, $row['passhash']);
    $message = $ok ? 'Login OK' : 'Invalid credentials';
}
?>
<!doctype html>
<meta charset="utf-8">
<title>Password Hashing Demo</title>
<h1>Password Hashing + Verify Demo</h1>

<form method="post">
  <label>Username: <input name="username" value="alice"></label><br>
  <label>Password: <input name="password" type="password" value="P@ssw0rd!"></label><br>
  <button type="submit">Login</button>
</form>

<p><?= htmlspecialchars($message, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></p>

<p><strong>หมายเหตุ:</strong> ห้ามใช้ MD5/SHA-1 เก็บรหัสผ่าน ให้ใช้ <code>password_hash()</code> และปรับแต่ง cost ตาม Performance เครื่อง</p>

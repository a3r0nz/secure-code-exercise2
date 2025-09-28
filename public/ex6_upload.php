<?php
// @author 🐈‍⬛ Siam Thanat Hack Co., Ltd. (STH)

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use STH\SecurityExercises\SecurityHeaders;

error_reporting(E_ALL);
ini_set('display_errors', '1');

// Set secure headers
SecurityHeaders::setSecureHeaders(true);

// โฟลเดอร์เก็บไฟล์นอก webroot: สร้าง ../../private_uploads ล่วงหน้า หรือให้สคริปต์สร้าง
$uploadDir = __DIR__ . '/../../private_uploads';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0700, true);
}

$maxBytes = 1 * 1024 * 1024; // 1 MB
$allowedExt  = ['jpg','jpeg','png'];
$allowedMime = ['image/jpeg','image/png'];

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file'])) {
    $f = $_FILES['file'];

    if ($f['error'] !== UPLOAD_ERR_OK) {
        $message = 'Upload error code: ' . $f['error'];
    } elseif ($f['size'] > $maxBytes) {
        $message = 'File too large';
    } else {
        $ext = strtolower(pathinfo($f['name'], PATHINFO_EXTENSION));
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mime  = $finfo->file($f['tmp_name']) ?: 'application/octet-stream';

        if (!in_array($ext, $allowedExt, true)) {
            $message = 'Extension not allowed';
        } elseif (!in_array($mime, $allowedMime, true)) {
            $message = 'MIME type not allowed';
        } elseif (!is_uploaded_file($f['tmp_name'])) {
            $message = 'Invalid upload';
        } else {
            $newName = bin2hex(random_bytes(16)) . '.' . $ext;
            $dest = $uploadDir . DIRECTORY_SEPARATOR . $newName;
            if (move_uploaded_file($f['tmp_name'], $dest)) {
                $message = "Saved as $newName (stored outside webroot)";
            } else {
                $message = 'Failed to move uploaded file';
            }
        }
    }
}
?>
<!doctype html>
<meta charset="utf-8">
<title>Secure Upload Demo</title>
<h1>Secure File Upload Demo</h1>

<form method="post" enctype="multipart/form-data">
  <input type="file" name="file" accept=".jpg,.jpeg,.png" required>
  <button type="submit">Upload</button>
</form>

<p><?= htmlspecialchars($message, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></p>

<p><strong>อย่าทำ:</strong> อนุญาตให้อัปโหลด <code>.php</code> ไฟล์ไปไว้ใน webroot (เสี่ยงโดน web shell)</p>

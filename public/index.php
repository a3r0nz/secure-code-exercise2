<?php
// @author 🐈‍⬛ Siam Thanat Hack Co., Ltd. (STH)

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use STH\SecurityExercises\SecurityHeaders;

// Set secure headers
SecurityHeaders::setSecureHeaders(true);
?>
<!doctype html>
<html lang="th">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PHP Security Exercises - STH</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            line-height: 1.6;
            background: #f8f9fa;
        }
        .container {
            background: white;
            border-radius: 8px;
            padding: 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h1 {
            color: #2c3e50;
            text-align: center;
            margin-bottom: 10px;
        }
        .subtitle {
            text-align: center;
            color: #7f8c8d;
            margin-bottom: 30px;
        }
        .exercises {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin-top: 30px;
        }
        .exercise-card {
            border: 1px solid #e1e8ed;
            border-radius: 8px;
            padding: 20px;
            background: #fdfdfd;
            transition: all 0.3s ease;
        }
        .exercise-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            border-color: #3498db;
        }
        .exercise-title {
            font-size: 1.2em;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 10px;
        }
        .exercise-desc {
            color: #5d6d7e;
            margin-bottom: 15px;
            font-size: 0.95em;
        }
        .exercise-links {
            display: flex;
            gap: 10px;
        }
        .btn {
            padding: 8px 16px;
            text-decoration: none;
            border-radius: 4px;
            font-size: 0.9em;
            font-weight: 500;
            transition: all 0.2s ease;
        }
        .btn-primary {
            background: #3498db;
            color: white;
        }
        .btn-primary:hover {
            background: #2980b9;
        }
        .btn-danger {
            background: #e74c3c;
            color: white;
        }
        .btn-danger:hover {
            background: #c0392b;
        }
        .security-notice {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 6px;
            padding: 15px;
            margin: 20px 0;
        }
        .security-notice strong {
            color: #856404;
        }
        .footer {
            text-align: center;
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #eee;
            color: #95a5a6;
        }
        .owasp-link {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background: #27ae60;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .owasp-link:hover {
            background: #229954;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>PHP Security Exercises</h1>
        <p class="subtitle">การศึกษาช่องโหว่ความปลอดภัยเว็บและวิธีการป้องกัน</p>

        <div class="security-notice">
            <strong>⚠️ คำเตือน:</strong> โปรเจคนี้มีไว้เพื่อการศึกษาเท่านั้น ไม่ควรใช้ในระบบจริง
            การทดสอบช่องโหว่ควรทำในสภาพแวดล้อมที่ปลอดภัยเท่านั้น
        </div>

        <div class="exercises">
            <div class="exercise-card">
                <div class="exercise-title">Exercise 1: OOP Basics + PSR-4</div>
                <div class="exercise-desc">
                    การใช้งาน Object-Oriented Programming พร้อม PSR-4 Autoloading<br>
                    แสดงการใช้ namespace และการโหลดคลาสอัตโนมัติ
                </div>
                <div class="exercise-links">
                    <a href="ex1_oop_basics.php" class="btn btn-primary">เรียกใช้</a>
                </div>
            </div>

            <div class="exercise-card">
                <div class="exercise-title">Exercise 2: Cross-Site Scripting (XSS)</div>
                <div class="exercise-desc">
                    การป้องกันการโจมตี XSS ด้วยการ encode ข้อมูลก่อนแสดงผล<br>
                    เปรียบเทียบระหว่างโหมดปลอดภัยและไม่ปลอดภัย
                </div>
                <div class="exercise-links">
                    <a href="ex2_xss.php?secure=1" class="btn btn-primary">โหมดปลอดภัย</a>
                    <a href="ex2_xss.php?secure=0" class="btn btn-danger">โหมดไม่ปลอดภัย</a>
                </div>
            </div>

            <div class="exercise-card">
                <div class="exercise-title">Exercise 3: SQL Injection</div>
                <div class="exercise-desc">
                    การป้องกันการโจมตี SQL Injection ด้วย Prepared Statements<br>
                    เปรียบเทียบกับการต่อ string โดยตรง (ไม่ปลอดภัย)
                </div>
                <div class="exercise-links">
                    <a href="ex3_sql_injection.php?secure=1" class="btn btn-primary">โหมดปลอดภัย</a>
                    <a href="ex3_sql_injection.php?secure=0" class="btn btn-danger">โหมดไม่ปลอดภัย</a>
                </div>
            </div>

            <div class="exercise-card">
                <div class="exercise-title">Exercise 4: Password Hashing</div>
                <div class="exercise-desc">
                    การเก็บรหัสผ่านอย่างปลอดภัยด้วย password_hash() และ password_verify()<br>
                    ทดสอบด้วย username: alice, password: P@ssw0rd!
                </div>
                <div class="exercise-links">
                    <a href="ex4_passwords.php" class="btn btn-primary">ทดสอบ Login</a>
                </div>
            </div>

            <div class="exercise-card">
                <div class="exercise-title">Exercise 5: CSRF Protection</div>
                <div class="exercise-desc">
                    การป้องกันการโจมตี Cross-Site Request Forgery ด้วย CSRF Token<br>
                    แสดงวิธีการตรวจสอบและป้องกันการโจมตีแบบ CSRF
                </div>
                <div class="exercise-links">
                    <a href="ex5_csrf.php?secure=1" class="btn btn-primary">โหมดปลอดภัย</a>
                    <a href="ex5_csrf.php?secure=0" class="btn btn-danger">โหมดไม่ปลอดภัย</a>
                </div>
            </div>

            <div class="exercise-card">
                <div class="exercise-title">Exercise 6: Secure File Upload</div>
                <div class="exercise-desc">
                    การอัปโหลดไฟล์อย่างปลอดภัย ตรวจสอบนามสกุล MIME type และเก็บนอก webroot<br>
                    รองรับเฉพาะไฟล์รูปภาพ (JPG, PNG) ขนาดไม่เกิน 1MB
                </div>
                <div class="exercise-links">
                    <a href="ex6_upload.php" class="btn btn-primary">ทดสอบอัปโหลด</a>
                </div>
            </div>
        </div>

        <div style="text-align: center;">
            <a href="https://cheatsheetseries.owasp.org/IndexTopTen.html" target="_blank" class="owasp-link">
                📚 OWASP Top 10 Cheat Sheets
            </a>
        </div>

        <div class="footer">
             
            <p>PHP Security Exercises with PSR-4 Autoloading</p>
        </div>
    </div>
</body>
</html>
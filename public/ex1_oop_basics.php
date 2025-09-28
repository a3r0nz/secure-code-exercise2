<?php
// @author 🐈‍⬛ Siam Thanat Hack Co., Ltd. (STH)

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use STH\SecurityExercises\Student;
use STH\SecurityExercises\SecurityHeaders;

error_reporting(E_ALL);
ini_set('display_errors', '1');

// Set secure headers
SecurityHeaders::setSecureHeaders(true);

$alice = new Student(id: 'S001', name: 'Alice', gpa: 3.5);
$alice->enroll('CSC101');
$alice->enroll('SEC201');

echo $alice, PHP_EOL;

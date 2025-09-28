# PHP Security Exercises

A collection of PHP security demonstration exercises covering common web vulnerabilities and their prevention techniques, organized with PSR-4 autoloading standards.

## Project Structure

```
├── composer.json          # PSR-4 autoloading configuration
├── src/                   # Classes following PSR-4 standard
│   └── Student.php        # Student class with namespace STH\SecurityExercises
├── public/                # Web-accessible scripts
│   ├── ex1_oop_basics.php # OOP demonstration with autoloading
│   ├── ex2_xss.php        # XSS prevention demo
│   ├── ex3_sql_injection.php # SQL injection prevention
│   ├── ex4_passwords.php  # Password hashing demo
│   ├── ex5_csrf.php       # CSRF protection demo
│   └── ex6_upload.php     # Secure file upload
├── vendor/                # Autoloader (PSR-4 compatible)
│   └── autoload.php       # Custom PSR-4 autoloader
└── private_uploads/       # Upload storage (outside webroot)
```

## Overview

This project contains 6 educational PHP scripts that demonstrate both vulnerable and secure implementations of common web security issues. Each exercise is designed to help developers understand security risks and learn proper defensive coding practices.

## Files

### ex1_oop_basics.php

Basic Object-Oriented Programming example demonstrating PSR-4 autoloading.

- Uses the Student class from `src/Student.php` with namespace `STH\SecurityExercises`
- Demonstrates proper input validation and type declarations
- Shows PSR-4 autoloading with `require_once __DIR__ . '/../vendor/autoload.php'`

### ex2_xss.php

Cross-Site Scripting (XSS) demonstration

- **Secure mode** (`?secure=1`): Uses `htmlspecialchars()` for output encoding
- **Insecure mode** (`?secure=0`): Shows vulnerable direct output
- Test payload: `?secure=0&name=<script>alert(1)</script>`

### ex3_sql_injection.php

SQL Injection demonstration using in-memory SQLite

- **Secure mode** (`?secure=1`): Uses prepared statements with parameter binding
- **Insecure mode** (`?secure=0`): Shows vulnerable string concatenation
- Test payload: `?secure=0&q=' OR '1'='1' --`

### ex4_passwords.php

Password hashing demonstration

- Uses PHP's `password_hash()` and `password_verify()` functions
- Default credentials: `alice` / `P@ssw0rd!`
- Demonstrates secure password storage practices

### ex5_csrf.php

Cross-Site Request Forgery (CSRF) protection

- **Secure mode** (`?secure=1`): Implements CSRF token validation
- **Insecure mode** (`?secure=0`): Vulnerable to CSRF attacks
- Includes example attack payload for testing

### ex6_upload.php

Secure file upload implementation

- Validates file extensions (jpg, jpeg, png only)
- Checks MIME types using `finfo`
- Stores files outside webroot (`../private_uploads`)
- Generates random filenames to prevent conflicts
- Size limit: 1MB

## Security Features

- **Input Validation**: All user inputs are properly validated
- **Output Encoding**: HTML special characters are escaped
- **Prepared Statements**: SQL queries use parameter binding
- **CSRF Protection**: Token-based request validation
- **Secure File Handling**: Multiple layers of upload validation
- **Password Security**: Modern hashing algorithms

## Setup

1. Install dependencies (optional, autoloader is included):
   ```bash
   composer install
   ```

## Usage

1. Start a local PHP server from the project root:

   ```bash
   php -S localhost:8000 -t public
   ```

2. Access the exercises:

   - http://localhost:8000/ex1_oop_basics.php
   - http://localhost:8000/ex2_xss.php
   - http://localhost:8000/ex3_sql_injection.php
   - http://localhost:8000/ex4_passwords.php
   - http://localhost:8000/ex5_csrf.php
   - http://localhost:8000/ex6_upload.php

3. Toggle security modes using `?secure=0` or `?secure=1` parameter

## Testing Vulnerabilities

⚠️ **Warning**: Only test these vulnerabilities in a controlled, isolated environment for educational purposes.

### XSS Testing

```
http://localhost:8000/ex2_xss.php?secure=0&name=<script>alert('XSS')</script>
```

### SQL Injection Testing

```
http://localhost:8000/ex3_sql_injection.php?secure=0&q=' OR '1'='1' --
```

### CSRF Testing

Create an `attacker.html` file:

```html
<form action="http://localhost:8000/ex5_csrf.php?secure=0" method="post">
  <input type="hidden" name="email" value="attacker@evil.tld" />
  <script>
    document.forms[0].submit();
  </script>
</form>
```

## Learning Resources

For additional information on web security best practices, refer to:

- [OWASP Top 10 Cheat Sheets](https://cheatsheetseries.owasp.org/IndexTopTen.html)
- [OWASP Cheat Sheet Series](https://cheatsheetseries.owasp.org/)

## Author

6752600210 Chawan Watthanakitjakul

## Disclaimer

This code is for educational purposes only. Do not use insecure modes in production environments. Always implement proper security measures in real applications.

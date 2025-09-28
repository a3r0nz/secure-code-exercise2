<?php
// @author 🐈‍⬛ Siam Thanat Hack Co., Ltd. (STH)

declare(strict_types=1);

namespace STH\SecurityExercises;

final class SecurityHeaders
{
    public static function setSecureHeaders(bool $isDevelopment = true): void
    {
        // Prevent clickjacking attacks
        header('X-Frame-Options: DENY');

        // Prevent MIME type sniffing
        header('X-Content-Type-Options: nosniff');

        // Enable XSS filtering (legacy browsers)
        header('X-XSS-Protection: 1; mode=block');

        // Control referrer information
        header('Referrer-Policy: strict-origin-when-cross-origin');

        // Remove server information
        header_remove('X-Powered-By');

        if (!$isDevelopment) {
            // HSTS - only enable in production with HTTPS
            header('Strict-Transport-Security: max-age=31536000; includeSubDomains; preload');
        }

        // Content Security Policy
        self::setContentSecurityPolicy($isDevelopment);
    }

    public static function setContentSecurityPolicy(bool $isDevelopment = true): void
    {
        $nonce = base64_encode(random_bytes(16));

        // Store nonce for use in inline scripts/styles
        if (!isset($_SESSION)) {
            session_start();
        }
        $_SESSION['csp_nonce'] = $nonce;

        $csp = [
            "default-src 'self'",
            "script-src 'self' 'nonce-{$nonce}'",
            "style-src 'self' 'unsafe-inline'", // Allow inline styles for demo purposes
            "img-src 'self' data:",
            "connect-src 'self'",
            "font-src 'self'",
            "object-src 'none'",
            "base-uri 'self'",
            "form-action 'self'",
            "frame-ancestors 'none'",
        ];

        if ($isDevelopment) {
            // More relaxed CSP for development
            $csp[] = "script-src 'self' 'unsafe-inline' 'unsafe-eval'";
        }

        header('Content-Security-Policy: ' . implode('; ', $csp));
    }

    public static function getNonce(): string
    {
        if (!isset($_SESSION)) {
            session_start();
        }
        return $_SESSION['csp_nonce'] ?? '';
    }

    public static function setDemoHeaders(bool $secure = true): void
    {
        if ($secure) {
            self::setSecureHeaders(true);
        } else {
            // Deliberately insecure headers for demonstration
            header('X-Frame-Options: ALLOWALL');
            header('X-Content-Type-Options: '); // Remove header
            header('X-XSS-Protection: 0'); // Disable XSS protection

            // Very permissive CSP
            header('Content-Security-Policy: default-src *; script-src * \'unsafe-inline\' \'unsafe-eval\'; style-src * \'unsafe-inline\'');
        }
    }
}
<?php
/**
 * DockGate Proxy Fix for Laravel
 * Force logic to accept Reverse Proxy (DockGate) headers
 */
 
// Only run if we are detecting the DockGate Tunnel headers
if (!empty($_SERVER['HTTP_X_FORWARDED_HOST'])) {
    
    // 1. Force HTTPS detection
    $_SERVER['HTTPS'] = 'on';
    $_SERVER['SERVER_PORT'] = 443;
    
    // 2. Override Host
    $host = trim(explode(',', $_SERVER['HTTP_X_FORWARDED_HOST'])[0]);
    $_SERVER['HTTP_HOST'] = $host;
    
    // 3. Override APP_URL (Dynamic) for generic helpers
    $proto = 'https';
    if (!empty($_SERVER['HTTP_X_FORWARDED_PROTO'])) {
         $proto = trim(explode(',', $_SERVER['HTTP_X_FORWARDED_PROTO'])[0]);
    }
    $fullUrl = $proto . '://' . $host;
    
    // Force ENV if not already hardcoded static
    // Note: Laravel reads .env very early, but we can override $_ENV and $_SERVER
    if (!defined('DOCKGATE_URL_SET')) {
        define('DOCKGATE_URL_SET', true);
        putenv("APP_URL={$fullUrl}");
        $_ENV['APP_URL'] = $fullUrl;
        $_SERVER['APP_URL'] = $fullUrl;
        
        // Also force ASSET_URL empty to ensure it uses APP_URL base
        putenv("ASSET_URL={$fullUrl}");
        $_ENV['ASSET_URL'] = $fullUrl;
        $_SERVER['ASSET_URL'] = $fullUrl;
    }
    
    // 4. Trust All Proxies (Crucial for Request::secure() to work with X-Forwarded-Proto)
    // We hook into Laravel's Request if possible, but simpler method is to rely on the above globals
    // which usually trick the Request capture.
}
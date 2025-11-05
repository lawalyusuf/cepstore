<?php

/**
 * WordPress base configuration (CI-friendly).
 * Uses env vars if present; otherwise leaves ${...} placeholders
 * that your GitHub Actions job renders with envsubst.
 */

/** ---------------- Database ---------------- */
define('DB_NAME',     getenv('WP_DB_NAME') ?: '${WP_DB_NAME}');
define('DB_USER',     getenv('WP_DB_USER') ?: '${WP_DB_USER}');
define('DB_PASSWORD', getenv('WP_DB_PASSWORD') ?: '${WP_DB_PASSWORD}');
define('DB_HOST',     getenv('WP_DB_HOST') ?: '${WP_DB_HOST}');
define('DB_CHARSET',  'utf8');
define('DB_COLLATE',  '');

/** --------------- URLs (proxy aware) --------------- */
/* Derive site/home on web requests; safe for CLI and cron */
if (!defined('WP_CLI') && isset($_SERVER['HTTP_HOST'])) {
    $https = (
        (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ||
        (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https')
    );
    $scheme = $https ? 'https' : 'http';
    $host   = $_SERVER['HTTP_HOST'];
    define('WP_SITEURL', "{$scheme}://{$host}");
    define('WP_HOME',    "{$scheme}://{$host}");
}

/** --------- Authentication keys & salts --------- */
/* Rendered by CI or taken from real env on server */
define('WP_AUTH_KEY',         getenv('WP_AUTH_KEY')         ?: '${WP_AUTH_KEY}');
define('WP_SECURE_AUTH_KEY',  getenv('WP_SECURE_AUTH_KEY')  ?: '${WP_SECURE_AUTH_KEY}');
define('WP_LOGGED_IN_KEY',    getenv('WP_LOGGED_IN_KEY')    ?: '${WP_LOGGED_IN_KEY}');
define('WP_NONCE_KEY',        getenv('WP_NONCE_KEY')        ?: '${WP_NONCE_KEY}');
define('WP_AUTH_SALT',        getenv('WP_AUTH_SALT')        ?: '${WP_AUTH_SALT}');
define('WP_SECURE_AUTH_SALT', getenv('WP_SECURE_AUTH_SALT') ?: '${WP_SECURE_AUTH_SALT}');
define('WP_LOGGED_IN_SALT',   getenv('WP_LOGGED_IN_SALT')   ?: '${WP_LOGGED_IN_SALT}');
define('WP_NONCE_SALT',       getenv('WP_NONCE_SALT')       ?: '${WP_NONCE_SALT}');

/** --------------- Table prefix --------------- */
$table_prefix = getenv('WP_TABLE_PREFIX') ?: 'wp_';

/** --------------- Debug / hardening --------------- */
/* Keep current behavior; allow override via env if needed */
define('WP_DEBUG', filter_var(getenv('WP_DEBUG') ?: false, FILTER_VALIDATE_BOOLEAN));

/* Optional hardening (safe defaults). Toggle via env if needed. */
defined('DISALLOW_FILE_EDIT') || define('DISALLOW_FILE_EDIT', true); // disallow theme/plugin editor
// defined('FS_METHOD') || define('FS_METHOD', 'direct');             // only if your host needs it
// defined('FORCE_SSL_ADMIN') || define('FORCE_SSL_ADMIN', true);     // enable if admin should be HTTPS-only

/** --------------- Bootstrap --------------- */
if (!defined('ABSPATH')) {
    define('ABSPATH', __DIR__ . '/');
}
require_once ABSPATH . 'wp-settings.php';

<?php

declare(strict_types=1);

require __DIR__ . '/wordpress/vendor/autoload.php';

use Dotenv\Dotenv;
use Symfony\Component\HttpFoundation\Request;

// Load the environment variables.
Dotenv::createImmutable(realpath(__DIR__))->safeLoad();

// Set the environment type.
define('WP_ENVIRONMENT_TYPE', $_ENV['WP_ENVIRONMENT_TYPE']??'production');

// Set the default WordPress theme.
define('WP_DEFAULT_THEME', $_ENV['WP_DEFAULT_THEME']??'wordplate');

// For developers: WordPress debugging mode.
$isDebugModeEnabled = (boolean)($_ENV['WP_DEBUG']?? false);
define('WP_DEBUG', $isDebugModeEnabled);
define('WP_DEBUG_LOG', (boolean)($_ENV['WP_DEBUG_LOG']?? false));
define('WP_DEBUG_DISPLAY', $_ENV['WP_DEBUG_DISPLAY']?? $isDebugModeEnabled);
define('SCRIPT_DEBUG', $_ENV['SCRIPT_DEBUG']?? $isDebugModeEnabled);

// The database configuration with database name, username, password,
// hostname charset and database collate type.
define('DB_NAME', $_ENV['DB_NAME']);
define('DB_USER', $_ENV['DB_USER']);
define('DB_PASSWORD', $_ENV['DB_PASSWORD']);
define('DB_HOST', $_ENV['DB_HOST']?? '127.0.0.1');
define('DB_CHARSET', $_ENV['DB_CHARSET']??'utf8mb4');
define('DB_COLLATE', $_ENV['DB_COLLATE']?? 'utf8mb4_unicode_ci');

// Set the unique authentication keys and salts.
define('AUTH_KEY', $_ENV['AUTH_KEY']);
define('SECURE_AUTH_KEY', $_ENV['SECURE_AUTH_KEY']);
define('LOGGED_IN_KEY', $_ENV['LOGGED_IN_KEY']);
define('NONCE_KEY', $_ENV['NONCE_KEY']);
define('AUTH_SALT', $_ENV['AUTH_SALT']);
define('SECURE_AUTH_SALT', $_ENV['SECURE_AUTH_SALT']);
define('LOGGED_IN_SALT', $_ENV['LOGGED_IN_SALT']);
define('NONCE_SALT', $_ENV['NONCE_SALT']);

// Detect HTTPS behind a reverse proxy or a load balancer.
if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https') {
    $_SERVER['HTTPS'] = 'on';
}

// Set the home url to the current domain.
define('WP_HOME', $_ENV['WP_HOME']?? Request::createFromGlobals()->getSchemeAndHttpHost());

// Set the WordPress directory path.
define('WP_SITEURL', $_ENV['WP_SITEURL']?? sprintf('%s/%s', WP_HOME, $_ENV['WP_DIR']?? 'wordpress'));

// Set the WordPress content directory path.
define('WP_CONTENT_DIR', $_ENV['WP_CONTENT_DIR']?? __DIR__);
define('WP_CONTENT_URL', $_ENV['WP_CONTENT_URL']?? WP_HOME);

// Disable WordPress auto updates.
define('AUTOMATIC_UPDATER_DISABLED', (boolean)($_ENV['AUTOMATIC_UPDATER_DISABLED']?? true));

// Disable WP-Cron (wp-cron.php) for faster performance.
define('DISABLE_WP_CRON', (boolean)($_ENV['DISABLE_WP_CRON']?? false));

// Prevent file edititing from the dashboard.
define('DISALLOW_FILE_EDIT', (boolean)($_ENV['DISALLOW_FILE_EDIT']?? true));

// Disable plugin and theme updates and installation from the dashboard.
define('DISALLOW_FILE_MODS', (boolean)($_ENV['DISALLOW_FILE_MODS']?? true));

// Cleanup WordPress image edits.
define('IMAGE_EDIT_OVERWRITE', (boolean)($_ENV['IMAGE_EDIT_OVERWRITE']?? true));

// Disable technical issues emails.
define('WP_DISABLE_FATAL_ERROR_HANDLER', (boolean)($_ENV['WP_DISABLE_FATAL_ERROR_HANDLER']?? false));

// Limit the number of post revisions.
define('WP_POST_REVISIONS', $_ENV['WP_POST_REVISIONS']?? 2);

// Set the absolute path to the WordPress directory.
if (!defined('ABSPATH')) {
    define('ABSPATH', sprintf('%s/', __DIR__, $_ENV['WP_DIR'] ?? 'wordpress'));
}

// Set the database table prefix.
$table_prefix = $_ENV['DB_TABLE_PREFIX']?? 'wp_';

require_once ABSPATH . 'wp-settings.php';

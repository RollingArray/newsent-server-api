<?php

// Should be set to 0 in production
error_reporting(E_ALL);

// Should be set to '0' in production
ini_set('display_errors', '1');

// Timezone
date_default_timezone_set('Europe/Berlin');

require_once '../environment/environment.php';


// Settings
$settings = [];

// Path settings
$settings['root'] = dirname(__DIR__);
$settings['temp'] = $settings['root'] . '/tmp';
$settings['public'] = $settings['root'] . '/public';

//echo "a ".$settings['environment'];
// Error Handling Middleware settings
$settings['error'] = [

    // Should be set to false in production
    'display_error_details' => true,

    // Parameter is passed to the default ErrorHandler
    // View in rendered output by enabling the "displayErrorDetails" setting.
    // For the console and unit tests we also disable it
    'log_errors' => true,

    // Display error details in error log
    'log_error_details' => true,
];

// Database settings
$settings['db'] = [
    'driver' => $environment['db']['driver'],
    'port' => $environment['db']['port'],
    'host' => $environment['db']['host'],
    'username' => $environment['db']['username'],
    'database' => $environment['db']['database'],
    'password' => $environment['db']['password'],
    'charset' => $environment['db']['charset'],
    'collation' => $environment['db']['collation'],
    'flags' => [
        // Turn off persistent connections
        PDO::ATTR_PERSISTENT => false,
        // Enable exceptions
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        // Emulate prepared statements
        PDO::ATTR_EMULATE_PREPARES => true,
        // Set default fetch mode to array
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        // Set character set
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci'
    ],
];

// feed settings
$settings['feed'] = [
    'url' => $environment['feed']['url'],
];

//tone analyzer
$settings['toneAnalyzer'] = [
    'key' => $environment['toneAnalyzer']['key'],
    'api' => $environment['toneAnalyzer']['api']
];

return $settings;
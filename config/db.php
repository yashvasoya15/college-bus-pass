<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../vendor/autoload.php';

$mongoUri = getenv('MONGODB_URI') ?: 'mongodb://127.0.0.1:27017';
$databaseName = getenv('MONGODB_DATABASE') ?: 'college_pass';

try {
    $mongoClient = new MongoDB\Client($mongoUri);
    $db = $mongoClient->selectDatabase($databaseName);
    $users = $db->users;
    $passes = $db->passes;
} catch (Throwable $e) {
    http_response_code(500);
    exit('Database connection failed. Check MongoDB and config/db.php.');
}

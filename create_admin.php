<?php
require_once __DIR__ . '/config/db.php';
$email = 'admin@gmail.com';
if ($users->findOne(['email' => $email])) {
    echo 'Admin already exists. Delete create_admin.php now.';
} else {
    $users->insertOne([
        'name' => 'Administrator', 'email' => $email,
        'password' => password_hash('admin123', PASSWORD_DEFAULT),
        'role' => 'admin', 'created_at' => new MongoDB\BSON\UTCDateTime()
    ]);
    echo 'Admin created. Email: admin@gmail.com | Password: admin123. Delete create_admin.php now.';
}

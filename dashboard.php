<?php
require_once __DIR__ . '/config/db.php';
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student') { header('Location: login.php'); exit; }
?>
<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Student Dashboard</title><link rel="stylesheet" href="style.css"></head>
<body><main class="container"><section class="panel"><h2>Student Dashboard</h2><p>Welcome, <?= htmlspecialchars($_SESSION['user_name']) ?>.</p>
<a class="btn" href="apply.php">Apply for Bus Pass</a> <a class="btn secondary" href="my_pass.php">My Applications</a> <a class="btn secondary" href="logout.php">Logout</a></section></main></body></html>

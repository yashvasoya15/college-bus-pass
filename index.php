<?php
require_once __DIR__ . '/config/db.php';
$isLoggedIn = isset($_SESSION['user_id']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1">
  <title>College Bus Pass</title><link rel="stylesheet" href="style.css">
</head>
<body>
<header><h1>College Bus Pass Management</h1></header>
<main class="container">
  <section class="hero">
    <h2>Welcome to College Bus Pass System</h2>
    <p>Register, apply for a bus pass, make demo payment and track your application.</p>
    <?php if ($isLoggedIn): ?>
      <p>Logged in as <strong><?= htmlspecialchars($_SESSION['user_name']) ?></strong></p>
      <a class="btn" href="<?= $_SESSION['role'] === 'admin' ? 'admin.php' : 'dashboard.php' ?>">Open Dashboard</a>
      <a class="btn secondary" href="logout.php">Logout</a>
    <?php else: ?>
      <a class="btn" href="register.php">Student Registration</a>
      <a class="btn secondary" href="login.php">Login</a>
    <?php endif; ?>
  </section>
</main>
</body></html>

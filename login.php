<?php
require_once __DIR__ . '/config/db.php';
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = strtolower(trim($_POST['email'] ?? ''));
    $password = $_POST['password'] ?? '';
    $user = $users->findOne(['email' => $email]);
    if ($user && password_verify($password, $user->password)) {
        session_regenerate_id(true);
        $_SESSION['user_id'] = (string)$user->_id;
        $_SESSION['user_name'] = $user->name;
        $_SESSION['role'] = $user->role;
        header('Location: ' . ($user->role === 'admin' ? 'admin.php' : 'dashboard.php'));
        exit;
    }
    $error = 'Invalid email or password.';
}
?>
<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Login</title><link rel="stylesheet" href="style.css"></head>
<body><main class="container"><section class="panel"><h2>Login</h2>
<?php if (isset($_GET['registered'])): ?><p class="success">Registration successful. Please log in.</p><?php endif; ?>
<?php if ($error): ?><p class="error"><?= htmlspecialchars($error) ?></p><?php endif; ?>
<form method="post"><label>Email</label><input type="email" name="email" required><label>Password</label><input type="password" name="password" required><button class="btn" type="submit">Login</button></form>
<p>New student? <a href="register.php">Register</a></p><a href="index.php">Home</a></section></main></body></html>

<?php
require_once __DIR__ . '/config/db.php';
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = strtolower(trim($_POST['email'] ?? ''));
    $password = $_POST['password'] ?? '';

    if ($name === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($password) < 6) {
        $error = 'Enter a name, valid email and password with at least 6 characters.';
    } elseif ($users->findOne(['email' => $email])) {
        $error = 'This email is already registered.';
    } else {
        $users->insertOne([
            'name' => $name, 'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'role' => 'student', 'created_at' => new MongoDB\BSON\UTCDateTime()
        ]);
        header('Location: login.php?registered=1'); exit;
    }
}
?>
<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Register</title><link rel="stylesheet" href="style.css"></head>
<body><main class="container"><section class="panel"><h2>Student Registration</h2>
<?php if ($error): ?><p class="error"><?= htmlspecialchars($error) ?></p><?php endif; ?>
<form method="post">
<label>Full name</label><input name="name" required>
<label>Email</label><input type="email" name="email" required>
<label>Password (minimum 6 characters)</label><input type="password" name="password" minlength="6" required>
<button class="btn" type="submit">Register</button>
</form><p>Already registered? <a href="login.php">Login</a></p><a href="index.php">Home</a></section></main></body></html>

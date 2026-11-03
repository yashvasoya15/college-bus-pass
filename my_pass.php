<?php
require_once __DIR__ . '/config/db.php';
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student') { header('Location: login.php'); exit; }
$items = $passes->find(['student_id' => $_SESSION['user_id']], ['sort' => ['created_at' => -1]]);
?>
<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>My Passes</title><link rel="stylesheet" href="style.css"></head>
<body><main class="container"><section class="panel"><h2>My Bus Pass Applications</h2>
<?php $found = false; foreach ($items as $p): $found = true; ?>
<div class="pass"><p><strong><?= htmlspecialchars($p->source) ?> → <?= htmlspecialchars($p->destination) ?></strong></p>
<p>Bus: <?= htmlspecialchars($p->bus_number) ?> | <?= htmlspecialchars($p->duration) ?> | ₹<?= number_format((float)$p->amount, 2) ?></p>
<p>Payment: <?= htmlspecialchars($p->payment_status) ?> | Admin status: <?= htmlspecialchars($p->status) ?></p></div>
<?php endforeach; if (!$found): ?><p>No applications yet.</p><?php endif; ?>
<a class="btn" href="apply.php">Apply another pass</a> <a class="btn secondary" href="dashboard.php">Dashboard</a></section></main></body></html>

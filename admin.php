<?php
require_once __DIR__ . '/config/db.php';
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') { header('Location: login.php'); exit; }
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? ''; $status = $_POST['status'] ?? '';
    if (in_array($status, ['Approved', 'Rejected'], true)) {
        try {
            $passes->updateOne(['_id' => new MongoDB\BSON\ObjectId($id), 'payment_status' => 'Paid'], ['$set' => ['status' => $status]]);
            $message = 'Application status updated.';
        } catch (Throwable $e) { $message = 'Could not update application.'; }
    }
}
$items = $passes->find([], ['sort' => ['created_at' => -1]]);
?>
<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Admin</title><link rel="stylesheet" href="style.css"></head>
<body><main class="container"><section class="panel"><h2>Admin Dashboard</h2><p>Welcome, <?= htmlspecialchars($_SESSION['user_name']) ?>.</p>
<?php if ($message): ?><p class="success"><?= htmlspecialchars($message) ?></p><?php endif; ?>
<?php $found = false; foreach ($items as $p): $found = true; ?>
<div class="pass"><p><strong><?= htmlspecialchars($p->student_name) ?></strong> (<?= htmlspecialchars($p->student_id) ?>)</p>
<p><?= htmlspecialchars($p->source) ?> → <?= htmlspecialchars($p->destination) ?> | Bus <?= htmlspecialchars($p->bus_number) ?></p>
<p><?= htmlspecialchars($p->duration) ?> | ₹<?= number_format((float)$p->amount, 2) ?> | Payment: <?= htmlspecialchars($p->payment_status) ?> | Status: <?= htmlspecialchars($p->status) ?></p>
<?php if ($p->payment_status === 'Paid' && $p->status === 'Pending'): ?>
<form method="post" class="inline"><input type="hidden" name="id" value="<?= htmlspecialchars((string)$p->_id) ?>"><button class="btn" name="status" value="Approved">Approve</button><button class="btn danger" name="status" value="Rejected">Reject</button></form>
<?php endif; ?></div>
<?php endforeach; if (!$found): ?><p>No applications found.</p><?php endif; ?>
<a class="btn secondary" href="logout.php">Logout</a></section></main></body></html>

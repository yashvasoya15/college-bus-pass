<?php
require_once __DIR__ . '/config/db.php';
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student') { header('Location: login.php'); exit; }
$id = $_GET['id'] ?? '';
try { $pass = $passes->findOne(['_id' => new MongoDB\BSON\ObjectId($id), 'student_id' => $_SESSION['user_id']]); }
catch (Throwable $e) { $pass = null; }
if (!$pass) { http_response_code(404); exit('Pass application not found.'); }
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $pass->payment_status !== 'Paid') {
    // Demo only: this marks payment as paid; it does not charge money.
    $passes->updateOne(['_id' => $pass->_id], ['$set' => ['payment_status' => 'Paid']]);
    header('Location: my_pass.php'); exit;
}
?>
<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Demo Payment</title><link rel="stylesheet" href="style.css"></head>
<body><main class="container"><section class="panel"><h2>Demo Payment</h2><p>Route: <?= htmlspecialchars($pass->source) ?> → <?= htmlspecialchars($pass->destination) ?></p><p>Duration: <?= htmlspecialchars($pass->duration) ?></p><p>Amount: ₹<?= number_format((float)$pass->amount, 2) ?></p>
<p class="hint">This is a demonstration only. No real payment will be collected.</p><form method="post"><button class="btn" type="submit">Confirm Demo Payment</button></form><a href="dashboard.php">Cancel</a></section></main></body></html>

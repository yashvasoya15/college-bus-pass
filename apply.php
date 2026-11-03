<?php
require_once __DIR__ . '/config/db.php';
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student') { header('Location: login.php'); exit; }
$error = '';
$prices = ['Monthly' => 500, 'Quarterly' => 1400, 'Yearly' => 5000];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $source = trim($_POST['source'] ?? '');
    $destination = trim($_POST['destination'] ?? '');
    $busNumber = trim($_POST['bus_number'] ?? '');
    $duration = $_POST['duration'] ?? '';
    if ($source === '' || $destination === '' || $busNumber === '' || !isset($prices[$duration])) {
        $error = 'Please fill all fields correctly.';
    } else {
        $result = $passes->insertOne([
            'student_id' => $_SESSION['user_id'],
            'student_name' => $_SESSION['user_name'],
            'source' => $source, 'destination' => $destination,
            'bus_number' => $busNumber, 'duration' => $duration,
            'amount' => $prices[$duration], 'payment_status' => 'Unpaid',
            'status' => 'Pending', 'created_at' => new MongoDB\BSON\UTCDateTime()
        ]);
        header('Location: payment.php?id=' . $result->getInsertedId()); exit;
    }
}
?>
<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Apply</title><link rel="stylesheet" href="style.css"></head>
<body><main class="container"><section class="panel"><h2>Apply for Bus Pass</h2>
<?php if ($error): ?><p class="error"><?= htmlspecialchars($error) ?></p><?php endif; ?>
<form method="post"><label>Starting point</label><input name="source" required><label>Destination</label><input name="destination" required><label>Bus number</label><input name="bus_number" required>
<label>Pass duration</label><select name="duration" required><option value="">Choose duration</option><option>Monthly</option><option>Quarterly</option><option>Yearly</option></select>
<p class="hint">Demo prices: Monthly ₹500, Quarterly ₹1,400, Yearly ₹5,000.</p><button class="btn" type="submit">Continue to Payment</button></form><a href="dashboard.php">Back</a></section></main></body></html>

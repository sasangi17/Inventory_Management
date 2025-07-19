<?php
include 'db.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
$low_stock_limit = 5;
$sql = "SELECT * FROM products WHERE quantity < $low_stock_limit";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Low Stock Alerts</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h2>Low Stock Alerts</h2>
    <?php if ($result->num_rows > 0) { ?>
        <ul class="list-group">
            <?php while ($row = $result->fetch_assoc()) { ?>
                <li class="list-group-item list-group-item-danger">
                    <?= $row['name'] ?> - Quantity: <?= $row['quantity'] ?>
                </li>
            <?php } ?>
        </ul>
    <?php } else { ?>
        <div class="alert alert-success">No low stock items.</div>
    <?php } ?>
</div>
</body>
</html>

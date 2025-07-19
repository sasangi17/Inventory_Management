<?php
include 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch products and their categories
$sql = "SELECT p.*, c.name AS category_name 
        FROM products p 
        LEFT JOIN categories c ON p.category_id = c.id 
        ORDER BY p.created_at DESC";
$result = $conn->query($sql);
?>
<?php include 'index.html'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Current Stock</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h2 class="mb-3">📦 Current Stock Levels</h2>

    <!-- Excel Download Button -->
    <a href="export_stock_excel.php" class="btn btn-success mb-3">Download Excel</a>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Product Title</th>
                <th>Category</th>
                <th>In Stock</th>
                <th>Buying Price</th>
                <th>Selling Price</th>
                <th>Added Date</th>
            </tr>
        </thead>
        <tbody>
        <?php if ($result && $result->num_rows > 0): ?>
            <?php $i = 1; while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $i++ ?></td>
                    <td><?= htmlspecialchars($row['name']) ?></td>
                    <td><?= htmlspecialchars($row['category_name']) ?></td>
                    <td><?= $row['quantity'] ?></td>
                    <td><?= number_format($row['price'], 2) ?></td>
                    <td><?= number_format($row['selling_price'], 2) ?></td>
                    <td><?= date('Y-m-d H:i A', strtotime($row['created_at'])) ?></td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="7" class="text-center">No products available</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>
</body>
</html>

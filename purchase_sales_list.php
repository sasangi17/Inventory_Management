<?php
include 'db.php';
session_start();

// Fetch purchase list
$purchases = $conn->query("SELECT p.id, pr.name AS product_name, p.quantity, p.purchase_price, p.purchase_date FROM purchases p JOIN products pr ON p.product_id = pr.id ORDER BY p.purchase_date DESC");

// Fetch sales list
$sales = $conn->query("SELECT s.id, pr.name AS product_name, s.quantity, s.sale_price, s.sale_date FROM sales s JOIN products pr ON s.product_id = pr.id ORDER BY s.sale_date DESC");

// Totals
$purchase_total = $conn->query("SELECT SUM(quantity * purchase_price) AS total FROM purchases")->fetch_assoc()['total'] ?? 0;
$sales_total = $conn->query("SELECT SUM(quantity * sale_price) AS total FROM sales")->fetch_assoc()['total'] ?? 0;
$revenue = $sales_total - $purchase_total;
?>
<?php include 'index.html'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Purchase and Sales Report</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h3 class="mb-4">Purchase Product List</h3>
    <table class="table table-bordered table-striped">
        <thead class="table-primary">
            <tr>
                <th>#</th>
                <th>Product Name</th>
                <th>Quantity</th>
                <th>Purchase Price</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $purchases->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= htmlspecialchars($row['product_name']) ?></td>
                    <td><?= $row['quantity'] ?></td>
                    <td><?= number_format($row['purchase_price'], 2) ?></td>
                    <td><?= $row['purchase_date'] ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <h3 class="mb-4 mt-5">Sales Product List</h3>
    <table class="table table-bordered table-striped">
        <thead class="table-success">
            <tr>
                <th>#</th>
                <th>Product Name</th>
                <th>Quantity</th>
                <th>Sale Price</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $sales->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= htmlspecialchars($row['product_name']) ?></td>
                    <td><?= $row['quantity'] ?></td>
                    <td><?= number_format($row['sale_price'], 2) ?></td>
                    <td><?= $row['sale_date'] ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <div class="mt-5">
        <h4>Summary</h4>
        <p><strong>Total Purchases:</strong> Rs. <?= number_format($purchase_total, 2) ?></p>
        <p><strong>Total Sales:</strong> Rs. <?= number_format($sales_total, 2) ?></p>
        <p><strong>Revenue (Sales - Purchases):</strong> <span class="text-success fw-bold">Rs. <?= number_format($revenue, 2) ?></span></p>
        <a href="export_sales_report_excel.php" class="btn btn-outline-success mt-3">Download Excel</a>
    </div>
</div>
</body>
</html>

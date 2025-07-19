<?php
include 'db.php';

// Set headers to prompt for Excel download
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=sales_purchase_report.xls");
header("Pragma: no-cache");
header("Expires: 0");

// Start the table
echo "<table border='1'>";
echo "<tr><th colspan='5'>Purchase Report</th></tr>";
echo "<tr><th>ID</th><th>Product</th><th>Quantity</th><th>Price</th><th>Date</th></tr>";

$purchases = $conn->query("SELECT p.id, pr.name AS product_name, p.quantity, p.purchase_price, p.purchase_date 
                           FROM purchases p JOIN products pr ON p.product_id = pr.id ORDER BY p.purchase_date DESC");

while ($row = $purchases->fetch_assoc()) {
    echo "<tr>
        <td>{$row['id']}</td>
        <td>{$row['product_name']}</td>
        <td>{$row['quantity']}</td>
        <td>{$row['purchase_price']}</td>
        <td>{$row['purchase_date']}</td>
    </tr>";
}

echo "<tr><td colspan='5'></td></tr>";
echo "<tr><th colspan='5'>Sales Report</th></tr>";
echo "<tr><th>ID</th><th>Product</th><th>Quantity</th><th>Price</th><th>Date</th></tr>";

$sales = $conn->query("SELECT s.id, pr.name AS product_name, s.quantity, s.sale_price, s.sale_date 
                       FROM sales s JOIN products pr ON s.product_id = pr.id ORDER BY s.sale_date DESC");

while ($row = $sales->fetch_assoc()) {
    echo "<tr>
        <td>{$row['id']}</td>
        <td>{$row['product_name']}</td>
        <td>{$row['quantity']}</td>
        <td>{$row['sale_price']}</td>
        <td>{$row['sale_date']}</td>
    </tr>";
}

// Revenue summary
$purchase_total = $conn->query("SELECT SUM(quantity * purchase_price) AS total FROM purchases")->fetch_assoc()['total'] ?? 0;
$sales_total = $conn->query("SELECT SUM(quantity * sale_price) AS total FROM sales")->fetch_assoc()['total'] ?? 0;
$revenue = $sales_total - $purchase_total;

echo "<tr><td colspan='5'></td></tr>";
echo "<tr><th colspan='5'>Summary</th></tr>";
echo "<tr><td colspan='2'>Total Purchases</td><td colspan='3'>Rs. " . number_format($purchase_total, 2) . "</td></tr>";
echo "<tr><td colspan='2'>Total Sales</td><td colspan='3'>Rs. " . number_format($sales_total, 2) . "</td></tr>";
echo "<tr><td colspan='2'>Revenue</td><td colspan='3'>Rs. " . number_format($revenue, 2) . "</td></tr>";

echo "</table>";
?>

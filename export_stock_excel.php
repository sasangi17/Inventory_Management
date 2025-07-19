<?php
include 'db.php';

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename="current_stock_report.xls"');
header('Pragma: no-cache');
header('Expires: 0');

echo "ID\tProduct Title\tCategory\tIn Stock\tBuying Price\tSelling Price\tDate Added\n";

$sql = "SELECT p.*, c.name AS category_name 
        FROM products p 
        LEFT JOIN categories c ON p.category_id = c.id 
        ORDER BY p.created_at DESC";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo $row['id'] . "\t" .
             $row['name'] . "\t" .
             $row['category_name'] . "\t" .
             $row['quantity'] . "\t" .
             number_format($row['price'], 2) . "\t" .
             number_format($row['selling_price'], 2) . "\t" .
             date("Y-m-d H:i A", strtotime($row['created_at'])) . "\n";
    }
} else {
    echo "No stock available\n";
}
?>

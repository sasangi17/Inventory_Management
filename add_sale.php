<?php
include 'db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];
    $sale_price = $_POST['sale_price'];

    // Insert into sales table
    $conn->query("INSERT INTO sales (product_id, quantity, sale_price) VALUES ($product_id, $quantity, $sale_price)");

    // Update product quantity
    $conn->query("UPDATE products SET quantity = quantity - $quantity WHERE id = $product_id");

    $success = "Sale recorded successfully!";
}

// Fetch all products for dropdown
$products = $conn->query("SELECT id, name FROM products");
?>
<?php include 'index.html'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Record Sale</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header fw-bold text-white bg-primary">
            <i class="bi bi-receipt-cutoff me-2"></i> Record Product Sale
        </div>
        <div class="card-body">
            <?php if (isset($success)): ?>
                <div class="alert alert-success"><?= $success ?></div>
            <?php endif; ?>

            <form method="post">
                <div class="mb-3">
                    <label for="product_id" class="form-label">Select Product</label>
                    <select name="product_id" class="form-control" required>
                        <option value="">-- Choose Product --</option>
                        <?php while ($row = $products->fetch_assoc()): ?>
                            <option value="<?= $row['id'] ?>"><?= htmlspecialchars($row['name']) ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Quantity Sold</label>
                    <input type="number" name="quantity" class="form-control" placeholder="Enter quantity sold" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Sale Price</label>
                    <input type="number" step="0.01" name="sale_price" class="form-control" placeholder="Enter sale price" required>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle-fill me-1"></i> Save Sale
                </button>
                <a href="index.php" class="btn btn-secondary">Back</a>
            </form>
        </div>
    </div>
</div>
</body>
</html>

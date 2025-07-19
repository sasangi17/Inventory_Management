<?php
include 'db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];
    $purchase_price = $_POST['purchase_price'];

    // Insert into purchases table
    $conn->query("INSERT INTO purchases (product_id, quantity, purchase_price) VALUES ($product_id, $quantity, $purchase_price)");

    // Update product quantity
    $conn->query("UPDATE products SET quantity = quantity + $quantity WHERE id = $product_id");

    $success = "Purchase added successfully!";
}

// Fetch all products for dropdown
$products = $conn->query("SELECT id, name FROM products");
?>
<?php include 'index.html'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Purchase</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header fw-bold text-white bg-primary">

            <i class="bi bi-cart-plus-fill me-2"></i> Add Product Purchase
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
                    <label class="form-label">Quantity</label>
                    <input type="number" name="quantity" class="form-control" placeholder="Enter quantity" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Purchase Price</label>
                    <input type="number" step="0.01" name="purchase_price" class="form-control" placeholder="Enter price per unit" required>
                </div>

                <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i> Save Purchase</button>
                <a href="index.php" class="btn btn-secondary">Back</a>
            </form>
        </div>
    </div>
</div>
</body>
</html>

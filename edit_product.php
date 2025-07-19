<?php
// edit_product.php
include 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch categories
$categories = $conn->query("SELECT id, name FROM categories");

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = intval($_POST['id']);
    $name = $_POST['name'];
    $category_id = $_POST['category_id'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];
    $selling_price = $_POST['selling_price'];

    $sql = "UPDATE products SET name='$name', category_id=$category_id, quantity=$quantity, price=$price, selling_price=$selling_price WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        header("Location: view_products.php");
    } else {
        echo "Error updating product: " . $conn->error;
    }
} elseif (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $result = $conn->query("SELECT * FROM products WHERE id = $id");
    $product = $result->fetch_assoc();
} else {
    echo "Invalid request.";
    exit();
}
?>
<?php include 'index.html'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <div class="card">
        <div class="card-header fw-bold">
            <i class="bi bi-pencil-square me-2"></i>Edit Product
        </div>
        <div class="card-body">
            <form method="post">
                <input type="hidden" name="id" value="<?= $product['id'] ?>">
                <div class="mb-3">
                    <label>Product Title</label>
                    <input type="text" name="name" class="form-control" value="<?= $product['name'] ?>" required>
                </div>
                <div class="mb-3">
                    <label>Category</label>
                    <select name="category_id" class="form-control" required>
                        <?php while ($row = $categories->fetch_assoc()) : ?>
                            <option value="<?= $row['id'] ?>" <?= $row['id'] == $product['category_id'] ? 'selected' : '' ?>>
                                <?= $row['name'] ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label>Quantity</label>
                    <input type="number" name="quantity" class="form-control" value="<?= $product['quantity'] ?>" required>
                </div>
                <div class="mb-3">
                    <label>Buying Price</label>
                    <input type="number" step="0.01" name="price" class="form-control" value="<?= $product['price'] ?>" required>
                </div>
                <div class="mb-3">
                    <label>Selling Price</label>
                    <input type="number" step="0.01" name="selling_price" class="form-control" value="<?= $product['selling_price'] ?>" required>
                </div>
                <button type="submit" class="btn btn-primary">Update Product</button>
                <a href="view_products.php" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
</body>
</html>

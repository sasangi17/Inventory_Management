<?php
include 'db.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $category_id = $_POST['category_id'];
    $quantity = $_POST['quantity'];
    $buying_price = $_POST['buying_price'];
    $selling_price = $_POST['selling_price'];

    $sql = "INSERT INTO products (name, category_id, quantity, price, selling_price) 
            VALUES ('$name', $category_id, $quantity, $buying_price, $selling_price)";
    if ($conn->query($sql) === TRUE) {
        header("Location: view_products.php"); // redirect to product list
    } else {
        echo "Error: " . $conn->error;
    }
}

// Fetch category options
$categories = $conn->query("SELECT id, name FROM categories");
?>
<?php include 'index.html'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background-color: #f7f9fc;
        }
        .form-icon {
            width: 40px;
            text-align: center;
        }
        .form-group {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }
        .form-group input,
        .form-group select {
            flex: 1;
        }
        .card {
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .btn-danger {
            width: 150px;
        }
    </style>
</head>
<body>
<div class="container mt-4">
    <div class="card">
        <div class="card-header fw-bold">
            <i class="bi bi-grid-fill me-2"></i>ADD NEW PRODUCT
        </div>
        <div class="card-body">
            <form method="post">
                <!-- Product Name -->
                <div class="form-group">
                    <span class="form-icon"><i class="bi bi-grid-3x3-gap-fill"></i></span>
                    <input type="text" name="name" class="form-control" placeholder="Product Title" required>
                </div>

                <!-- Category Dropdown -->
                <div class="form-group">
                    <span class="form-icon"><i class="bi bi-tags-fill"></i></span>
                    <select name="category_id" class="form-control" required>
                        <option value="">Select Product Category</option>
                        <?php while ($row = $categories->fetch_assoc()) : ?>
                            <option value="<?= $row['id'] ?>"><?= $row['name'] ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <!-- Quantity, Buying Price, Selling Price -->
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <span class="form-icon"><i class="bi bi-cart3"></i></span>
                            <input type="number" name="quantity" class="form-control" placeholder="Product Quantity" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <span class="form-icon"><i class="bi bi-currency-dollar"></i></span>
                            <input type="number" name="buying_price" class="form-control" step="0.01" placeholder="Buying Price" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <span class="form-icon"><i class="bi bi-currency-dollar"></i></span>
                            <input type="number" name="selling_price" class="form-control" step="0.01" placeholder="Selling Price" required>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="text-end mt-3">
                    <button type="submit" class="btn btn-danger"><i class="bi bi-plus-circle me-1"></i>Add product</button>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>

<?php
include 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch all products with category names
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
    <title>Product List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background-color: #f7f9fc;
        }
        .table th {
            background-color: #f0f2f5;
        }
        .btn-edit {
            background-color: #0d6efd;
            color: white;
        }
        .btn-delete {
            background-color: #dc3545;
            color: white;
        }
        .btn-edit:hover,
        .btn-delete:hover {
            opacity: 0.8;
        }
    </style>
</head>
<body>
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold">Product List</h4>
        <a href="add_product.php" class="btn btn-primary"><i class="bi bi-plus-circle me-1"></i> Add New</a>
    </div>
    
    <div class="table-responsive">
        <table class="table table-bordered table-hover text-center align-middle">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Product Title</th>
                    <th>Categories</th>
                    <th>In-Stock</th>
                    <th>Buying Price</th>
                    <th>Selling Price</th>
                    <th>Product Added</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php if ($result->num_rows > 0): 
                $count = 1;
                while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $count++ ?></td>
                    <td><?= htmlspecialchars($row['name']) ?></td>
                    <td><?= htmlspecialchars($row['category_name']) ?></td>
                    <td><?= $row['quantity'] ?></td>
                    <td><?= number_format($row['price'], 2) ?></td>
                    <td><?= number_format($row['selling_price'], 2) ?></td>
                    <td><?= date("F j, Y, g:i:s a", strtotime($row['created_at'])) ?></td>
                    <td>
                        <a href="edit_product.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-edit me-1"><i class="bi bi-pencil-square"></i></a>
                        <a href="delete_product.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-delete" onclick="return confirm('Are you sure to delete this product?')"><i class="bi bi-trash-fill"></i></a>
                    </td>
                </tr>
            <?php endwhile; else: ?>
                <tr><td colspan="8">No products found.</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>

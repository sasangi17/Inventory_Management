<?php
include 'db.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
$search = isset($_GET['search']) ? $_GET['search'] : '';
$sql = "SELECT * FROM products WHERE name LIKE '%$search%'";
$result = $conn->query($sql);
?>

<?php include 'index.html'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Search Products</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h2>Search Products</h2>
    <form method="get" class="mb-4">
        <input type="text" name="search" class="form-control" placeholder="Search products..." value="<?= htmlspecialchars($search) ?>">
        <button type="submit" class="btn btn-primary mt-2">Search</button>
    </form>
    <div class="table-responsive">
        <table class="table table-bordered">
            <tr><th>Name</th><th>Quantity</th><th>Price</th><th>Actions</th></tr>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?= $row['name'] ?></td>
                    <td><?= $row['quantity'] ?></td>
                    <td><?= $row['price'] ?></td>
                    <td>
                        <a href="update_product.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                        <a href="delete_product.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this item?')">Delete</a>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>
</div>
</body>
</html>

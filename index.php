<?php
// dashboard.php or index.php
include 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch data for dashboard stats
$total_products = $conn->query("SELECT COUNT(*) AS total FROM products")->fetch_assoc()['total'];
$total_purchases = $conn->query("SELECT COUNT(*) AS total FROM purchases")->fetch_assoc()['total'];
$total_sales = $conn->query("SELECT COUNT(*) AS total FROM sales")->fetch_assoc()['total'];
?>

<?php include 'index.html'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
    
<div class="container mt-5">
    <div class="d-flex justify-content-end mb-3">
    <a href="logout.php" class="btn btn-danger">
        <i class="bi bi-box-arrow-right"></i> Logout
    </a>
</div>

    <h2 class="mb-4">Dashboard Overview</h2>
    
    <div class="row">
        <div class="col-md-4">
            <div class="card text-bg-info mb-3">
                <div class="card-body">
                    <h5 class="card-title"><i class="bi bi-box-seam"></i> Total Products</h5>
                    <p class="card-text display-6 fw-bold"><?= $total_products ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-bg-primary mb-3">
                <div class="card-body">
                    <h5 class="card-title"><i class="bi bi-truck"></i> Purchases Made</h5>
                    <p class="card-text display-6 fw-bold"><?= $total_purchases ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-bg-success mb-3">
                <div class="card-body">
                    <h5 class="card-title"><i class="bi bi-currency-dollar"></i> Products Sold</h5>
                    <p class="card-text display-6 fw-bold"><?= $total_sales ?></p>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>

<?php
include 'db.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['category_name'])) {
    $name = trim($_POST['category_name']);
    if (!empty($name)) {
        $stmt = $conn->prepare("INSERT INTO categories (name) VALUES (?)");
        $stmt->bind_param("s", $name);
        $stmt->execute();
    }
}

// Handle delete
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM categories WHERE id = $id");
}

// Fetch categories
$result = $conn->query("SELECT * FROM categories ORDER BY id ASC");
?>
<?php include 'index.html'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Manage Categories</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container py-5">
    <div class="row">
      <!-- Add New Category -->
      <div class="col-md-4">
        <div class="card shadow-sm">
          <div class="card-header fw-bold">
            <i class="bi bi-grid-3x3-gap-fill me-2"></i> ADD NEW CATEGORY
          </div>
          <div class="card-body">
            <form method="post">
              <input type="text" name="category_name" class="form-control mb-3" placeholder="Category Name" required>
              <button type="submit" class="btn btn-primary w-100">Add Category</button>
            </form>
          </div>
        </div>
      </div>

      <!-- List Categories -->
      <div class="col-md-8">
        <div class="card shadow-sm">
          <div class="card-header fw-bold">
            <i class="bi bi-layout-text-window me-2"></i> ALL CATEGORIES
          </div>
          <div class="card-body">
            <table class="table table-bordered table-hover bg-white">
              <thead class="table-light">
                <tr>
                  <th>#</th>
                  <th>Categories</th>
                  <th style="width: 120px;">Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $i = 1;
                while ($row = $result->fetch_assoc()) {
                  echo "<tr>
                          <td>{$i}</td>
                          <td>{$row['name']}</td>
                          <td>
                            <a href='edit_category.php?id={$row['id']}' class='btn btn-warning btn-sm'><i class='bi bi-pencil-square'></i></a>
                            <a href='?delete={$row['id']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Delete this category?\")'><i class='bi bi-trash'></i></a>
                          </td>
                        </tr>";
                  $i++;
                }
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>

    </div>
  </div>
</body>
</html>

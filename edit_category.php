<?php
include 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Get category ID from URL
if (!isset($_GET['id'])) {
    echo "No category ID provided.";
    exit();
}

$cat_id = intval($_GET['id']);

// Handle update form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_name = trim($_POST['category_name']);

    if (!empty($new_name)) {
        $stmt = $conn->prepare("UPDATE categories SET name = ? WHERE id = ?");
        $stmt->bind_param("si", $new_name, $cat_id);

        if ($stmt->execute()) {
            header("Location: view_categories.php");
            exit();
        } else {
            echo "Error updating category.";
        }
    } else {
        echo "Category name cannot be empty.";
    }
}

// Fetch category details to show in form
$result = $conn->query("SELECT * FROM categories WHERE id = $cat_id");

if ($result->num_rows !== 1) {
    echo "Category not found.";
    exit();
}

$category = $result->fetch_assoc();
?>
<?php include 'index.html'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Category</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
    <div class="card shadow-sm col-md-6 mx-auto">
        <div class="card-header">
            <h4 class="mb-0">Edit Category</h4>
        </div>
        <div class="card-body">
            <form method="post">
                <div class="mb-3">
                    <label for="category_name" class="form-label">Category Name</label>
                    <input type="text" name="category_name" class="form-control" value="<?= htmlspecialchars($category['name']) ?>" required>
                </div>
                <button type="submit" class="btn btn-primary">Update Category</button>
                <a href="view_categories.php" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
</body>
</html>

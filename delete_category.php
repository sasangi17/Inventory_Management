<?php
include 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {
    $cat_id = intval($_GET['id']);
    $sql = "DELETE FROM categories WHERE id = $cat_id";

    if ($conn->query($sql) === TRUE) {
        header("Location: view_categories.php");
    } else {
        echo "Error deleting category: " . $conn->error;
    }
} else {
    echo "No category ID provided.";
}
?>

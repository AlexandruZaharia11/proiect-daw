<?php
require 'config.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['product_id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $category_id = $_POST['category_id'];
    $price = $_POST['price'];
    $imagePath = null;

    // Fetch the current image path if updating an existing product
    if ($id) {
        $stmt = $pdo->prepare("SELECT image_path FROM products WHERE id = ?");
        $stmt->execute([$id]);
        $currentImagePath = $stmt->fetchColumn();
    }

    // Handle image upload
    if (!empty($_FILES['image']['name'])) {
        $imageName = time() . "_" . basename($_FILES["image"]["name"]);
        $targetFile = "uploads/products/" . $imageName;

        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
            $imagePath = $targetFile;

            // Delete the old image if it exists
            if (!empty($currentImagePath) && file_exists($currentImagePath)) {
                unlink($currentImagePath);
            }
        }
    } else {
        // Keep the existing image if no new file is uploaded
        $imagePath = $currentImagePath;
    }

    // Update or insert the product
    if ($id) {
        $stmt = $pdo->prepare("UPDATE products SET title = ?, description = ?, price = ?, category_id = ?, image_path = ? WHERE id = ?");
        $stmt->execute([$title, $description, $price, $category_id, $imagePath, $id]);
    } else {
        // Insert new product
        $stmt = $pdo->prepare("INSERT INTO products (title, description, price, category_id, image_path) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$title, $description, $price, $category_id, $imagePath]);
    }

    // Handle delete action
    if (isset($_POST['delete']) && $id) {
        // Delete image file
        if (!empty($currentImagePath) && file_exists($currentImagePath)) {
            unlink($currentImagePath);
        }

        // Delete product from database
        $stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
        $stmt->execute([$id]);
    }

    header("Location: admin_products.php");
}
?>
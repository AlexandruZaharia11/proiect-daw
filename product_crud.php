<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['product_id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $category_id = $_POST['category_id'];
    $price = $_POST['price'];
    $imagePath = $_POST['image_path'] ?? null;

    if (!empty($_FILES['image']['name'])) {
        $imageName = time() . "_" . basename($_FILES["image"]["name"]);
        $targetFile = "uploads/products/" . $imageName;

        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
            $imagePath = $targetFile;
        }
    } else {
        $stmt = $pdo->prepare("SELECT image_path FROM products WHERE id = ?");
        $stmt->execute([$id]);
        $imagePath = $stmt->fetchColumn();
    }

    // Insert or update product
    if ($id) {
        $stmt = $pdo->prepare("UPDATE products SET title = ?, description = ?, price = ?, category_id = ?, image_path = ? WHERE id = ?");
        $stmt->execute([$title, $description, $price, $category_id, $imagePath, $id]);
    } else {
        // Insert new product
        $stmt = $pdo->prepare("INSERT INTO products (title, description, price, category_id, image_path) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$title, $description, $price, $category_id, $imagePath]);
    }

    // Delete product
    if (isset($_POST['delete']) && $id) {
        $stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
        $stmt->execute([$id]);
    }

    header("Location: admin_products.php");
}
?>
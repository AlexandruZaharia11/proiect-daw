<?php
require 'config.php';
require 'product_list.php';

session_start();

$isAdmin = isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'];

if (!$isAdmin) {
    header(header: "Location: login.php");
}

// Fetch all categories
$categoryStmt = $pdo->query("SELECT id, name FROM categories");
$categories = $categoryStmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch all products with category names
$productStmt = $pdo->query("SELECT p.*, c.name AS category_name FROM products p 
                            LEFT JOIN categories c ON p.category_id = c.id");
$products = $productStmt->fetchAll(PDO::FETCH_ASSOC);

if (isset($_POST['update'])) {
    $productId = $_POST['product_id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $category_id = $_POST['category_id'];

    // Check if a new image is uploaded
    if (!empty($_FILES['image']['name'])) {
        $uploadDir = 'uploads/products/';
        $uploadFile = $uploadDir . basename($_FILES['image']['name']);

        // Ensure the directory exists
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        // Move uploaded file
        if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
            $imagePath = $uploadFile;
        } else {
            $error = "Failed to upload image.";
        }
    } else {
        // Keep the existing image if no new one is uploaded
        $stmt = $pdo->prepare("SELECT image_path FROM products WHERE id = ?");
        $stmt->execute([$productId]);
        $imagePath = $stmt->fetchColumn();
    }

    // Update product
    $stmt = $pdo->prepare("UPDATE products SET title = ?, description = ?, category_id = ?, image_path = ? WHERE id = ?");
    $stmt->execute([$title, $description, $category_id, $imagePath, $productId]);

    header("Location: admin_products.php");
    exit;
}

if (isset($_POST['delete'])) {
    $productId = $_POST['product_id'];

    // Fetch the image path to delete the file
    $stmt = $pdo->prepare("SELECT image_path FROM products WHERE id = ?");
    $stmt->execute([$productId]);
    $imagePath = $stmt->fetchColumn();

    // Delete product from the database
    $stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
    if ($stmt->execute([$productId])) {
        // Remove the image file if it exists
        if ($imagePath && file_exists($imagePath)) {
            unlink($imagePath);
        }
    }

    header("Location: admin_products.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin - Products CRUD</title>
    <link rel="stylesheet" href="global.css">
</head>

<body>
    <?php include 'header.php'; ?>
    <div class="products-page">
        <h1 style="text-align: center;">Manage products</h1>

        <h2>Add product</h2>
        <form class="product-item" action="product_crud.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id">

            <label>Title:</label>
            <input type="text" name="title" required>

            <label>Description:</label>
            <input type="text" name="description" required></input>

            <label>Price:</label>
            <input type="text" name="price" required>

            <label>Category:</label>
            <select name="category_id" required>
                <option value="">Select a category</option>
                <?php foreach ($categories as $category): ?>
                    <option value="<?= $category['id'] ?>"><?= htmlspecialchars($category['name']) ?></option>
                <?php endforeach; ?>
            </select>

            <label>Image:</label>
            <input type="file" name="image" required>

            <button type="submit" name="submit">Add product</button>
        </form>

        <h2 style="margin-top: 70px;">Edit / Delete products</h2>
        <?php renderProductList($products, true) ?>
        <?php ?>
    </div>
</body>

</html>
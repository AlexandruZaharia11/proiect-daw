<?php
require 'config.php';
require 'product_list.php';

session_start();

$stmt = $pdo->query("SELECT p.id, p.category_id, p.title, p.description, p.image_path, p.price, c.name FROM products p JOIN categories c ON p.category_id = c.id");
$products = $stmt->fetchAll();
$isAdmin = isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="global.css">
</head>

<body>
    <?php include 'header.php'; ?>

    <main style="padding: 20px;">
        <h2>Products</h2>
        <div class="product-container">
            <?php renderProductList($products, false); ?>
        </div>
    </main>

</body>

</html>
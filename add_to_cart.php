<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['product_id'])) {
    $userId = $_SESSION['user_id'];
    $productId = $_POST['product_id'];

    try {
        // Check if the product is already in the cart
        $stmt = $pdo->prepare("SELECT * FROM cart WHERE user_id = :user_id AND product_id = :product_id");
        $stmt->execute(['user_id' => $userId, 'product_id' => $productId]);
        $existingItem = $stmt->fetch(PDO::FETCH_ASSOC);

        echo print_r($productId);

        if ($existingItem) {
            // If already in cart, increase quantity
            $stmt = $pdo->prepare("UPDATE cart SET quantity = quantity + 1 WHERE user_id = :user_id AND product_id = :product_id");
            $stmt->execute(['user_id' => $userId, 'product_id' => $productId]);
        } else {
            // Otherwise, insert a new row
            $stmt = $pdo->prepare("INSERT INTO cart (user_id, product_id, quantity) VALUES (:user_id, :product_id, 1)");
            $stmt->execute(['user_id' => $userId, 'product_id' => $productId]);
        }

        header("Location: index.php");
        exit();
    } catch (PDOException $e) {
        echo "Error adding to cart: " . $e->getMessage();
    }
} else {
    header("Location: index.php");
}
?>
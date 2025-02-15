<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['cart_id'])) {
    try {
        $stmt = $pdo->prepare("DELETE FROM cart WHERE id = :cart_id AND user_id = :user_id");
        $stmt->execute(['cart_id' => $_POST['cart_id'], 'user_id' => $_SESSION['user_id']]);
    } catch (PDOException $e) {
        die("Error removing item: " . $e->getMessage());
    }
}

header("Location: cart.php");
exit();
?>
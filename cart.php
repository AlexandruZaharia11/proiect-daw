<?php
include 'config.php';

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$userId = $_SESSION['user_id'];

try {
    $stmt = $pdo->prepare("
        SELECT cart.id, products.title, products.image_path, cart.quantity 
        FROM cart 
        JOIN products ON cart.product_id = products.id 
        WHERE cart.user_id = :user_id
    ");
    $stmt->execute(['user_id' => $userId]);
    $cartItems = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error fetching cart: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="global.css">
</head>

<body>
    <?php include 'header.php'; ?>
    <div style="padding: 20px;">
        <h2>Your Cart</h2>
        <div class="product-container">
            <?php foreach ($cartItems as $item): ?>
                <div class="product-cart">
                    <img src="<?= $item['image_path'] ?>" width="150" height="150" style="object-fit: cover;">
                    <p> <?= $item['title'] ?> </p>
                    <p> Quantity: <?= $item['quantity'] ?> </p>
                    <form method="POST" action="remove_from_cart.php" style="display:inline;">
                        <input type="hidden" name="cart_id" value="<?= $item['id'] ?>">
                        <button type="submit">Remove</button>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>

</html>
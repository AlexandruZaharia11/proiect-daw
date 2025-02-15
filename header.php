<?php
$isAdmin = isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'];
$isLoggedIn = isset($_SESSION['user_id']);
?>

<header>
    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="cart.php">Cart</a></li>
            <?php if ($isAdmin): ?>
                <li><a href="admin_products.php">Admin Panel</a></li>
            <?php endif; ?>
            <?php if ($isLoggedIn): ?>
                <li><a href="logout.php">Logout</a></li>
            <?php else: ?>
                <li><a href="login.php">Login</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>

<style>
    header {
        background: #1f1f1f;
        padding: 15px;
    }

    nav ul {
        list-style: none;
        padding: 0;
        text-align: end;
    }

    nav ul li {
        display: inline;
        margin: 0 15px;
    }

    nav ul li a {
        color: white;
        text-decoration: none;
    }

    nav ul li a:hover {
        text-decoration: underline;
    }
</style>
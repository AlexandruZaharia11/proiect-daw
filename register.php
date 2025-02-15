<?php
include 'config.php';

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);

    try {
        $hashedPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO `users` (email, password, isAdmin) VALUES (:email, :password, :isAdmin)");
        $stmt->execute([
            'email' => $_POST['email'],
            'password' => $hashedPassword,
            'isAdmin' => 0
        ]);

        header("Location: login.php");
        exit();
    } catch (PDOException $e) {
        $error = "Registration failed: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="global.css">
</head>

<body>

    <div class="page-container">
        <div class="container">
            <h2 style="margin-top: 0;">Register</h2>
            <form method="POST">
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit">Register</button>
            </form>
            <?php if ($error): ?>
                <p class="error"><?= $error ?></p><?php endif; ?>
        </div>
    </div>

</body>

</html>
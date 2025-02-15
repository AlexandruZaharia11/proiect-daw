<?php
$host = 'm60mxazb4g6sb4nn.chr7pe7iynqr.eu-west-1.rds.amazonaws.com';
$dbname = 'vd35h6vyhk821woi';
$username = 'fa890tx6b1gpx3k5';
$password = 'xlni66fvbu1tzxuf';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>
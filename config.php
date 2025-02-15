<?php

//local config
// $host = 'localhost';
// $username = 'alex';
// $password = '1234';
// $dbname = 'proiect';

//heroku config
$host = 'm60mxazb4g6sb4nn.chr7pe7iynqr.eu-west-1.rds.amazonaws.com';
$username = 'te8lov4gn7unchmo';
$password = 'cikvmz4nutkopf8c';
$dbname = 'gf5hvtcaepa1vs0q';

// $conn = new mysqli($host, $username, $password, $dbname, 3306);

// // Check connection
// if ($conn->connect_error) {
//   die("Connection failed: " . $conn->connect_error);
// }
// echo "Connected successfully";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password, [$port = 3306]);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
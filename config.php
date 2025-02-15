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
$port = 3306;

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password, [$port]);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
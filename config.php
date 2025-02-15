<?php

//local config
$host = 'localhost';
$username = 'alex';
$password = '1234';
$dbname = 'proiect';

//heroku config
$url = getenv('JAWSDB_URL');
$dbparts = parse_url($url);

$heroku_host = $dbparts['host'];
$heroku_user = $dbparts['user'];
$heroku_pass = $dbparts['pass'];
$heroku_database = ltrim($dbparts['path'], '/');

try {
    $conn = new PDO("mysql:host=$heroku_host;dbname=$heroku_database", $heroku_user, $heroku_database);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully";
} catch (PDOException $e) {
    // try {
    //     $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    //     $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // } catch (PDOException $e) {
    //     echo "Connection failed: " . $e->getMessage();
    // }
    echo "Connection failed: " . $e->getMessage();
}
?>
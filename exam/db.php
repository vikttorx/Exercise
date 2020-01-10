<?php
$dsn = 'mysql:host=localhost;dbname=exam';
$username = 'root';
$password = '';
$options = [];
try {
    $con = new PDO($dsn, $username, $password, $options);
} catch(PDOException $e) {
}
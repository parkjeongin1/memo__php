<?php
$host = "localhost";
$port = "3306";
$dbName = "db_paypleTest";
$user = "root";
$password = "root";

try {
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbName", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "데이터베이스 연결 성공!";
} catch (PDOException $e) {
    die("데이터베이스 연결 오류: " . $e->getMessage());
}

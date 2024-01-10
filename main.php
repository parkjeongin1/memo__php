<?php
// DB 연결 정보 설정
$host = "localhost";
$port = "3306";
$dbName = "db_paypleTest";
$user = "root";
$password = "root";

// PDO 객체 생성 및 예외 처리
$memojang = "mysql:host=$host;port=$port;dbname=$dbName";
try {
    $pdo = new PDO($memojang, $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PAYPLE 메모장</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #8a44a3, #653298);
            color: white;
            font-family: 'Malgun Gothic', sans-serif;
            text-align: center;
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        h1 {
            font-size: 4em;
            font-weight: bold;
            margin-bottom: 20px;
            font-family: 'cute-font', sans-serif;
        }

        .button-container {
            display: flex;
            justify-content: flex-end;
            margin: 10px;
        }

        button {
            background-color: transparent;
            color: white;
            padding: 10px 20px;
            border: 2px solid white;
            border-radius: 5px;
            margin: 5px;
            cursor: pointer;
            animation: animate__animated animate__fadeInUp;
        }

        button:hover {
            background-color: white;
            color: #8a44a3;
            animation: animate__animated animate__rubberBand;
        }
    </style>
</head>
<body>
<h1 class="animate__animated animate__fadeInUp">PAYPLE 메모장</h1>

<div class="button-container">
    <button id="loginButton" class="animate__animated animate__fadeInUp">로그인</button>
</div>

<script>
    document.getElementById('loginButton').addEventListener('click', function() {

        window.location.href = 'login.php';
    });
</script>
</body>
</html>

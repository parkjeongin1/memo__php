<?php
// 데이터베이스 연결 설정
$host = "localhost";
$port = "3306";
$dbName = "db_paypleTest";
$user = "root";
$password = "root";

// PDO 객체 생성
try {
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbName", $user, $password);
    // 에러 모드 설정: 예외 발생 시 예외를 던집니다.
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // 연결 실패 시 예외를 잡아서 에러 메시지를 출력하고 프로그램을 종료합니다.
    die("Connection failed: " . $e->getMessage());
}?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>가입 완료</title>

    <!-- 부트스트랩 CDN 추가 -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(to right, #8E2DE2, #4A00E0);
            color: white;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            max-width: 400px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>가입이 완료되었습니다.</h2>
    <a href="main.php" class="btn btn-primary">로그인하러 가기</a>
</div>

<!-- 부트스트랩 및 jQuery 및 Popper.js CDN 추가 -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>

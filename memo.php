<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$host = "localhost";
$port = "3306";
$dbName = "db_paypleTest";
$user = "root";
$password = "root";

try {
    $memojang = "mysql:host=$host;port=$port;dbname=$dbName";
    $pdo = new PDO($memojang, $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $action = isset($_POST['action']) ? $_POST['action'] : '';

        if ($action === 'insert') {
            $user_id = $_POST['user_id'];
            $title = $_POST['title'];
            $content = $_POST['content'];

            // memos 테이블에 데이터 삽입
            $stmt = $pdo->prepare("INSERT INTO memos (user_id, title, content, created_at) VALUES (?, ?, ?, NOW())");
            $result = $stmt->execute([$user_id, $title, $content]);

            if ($result) {
                // 삽입 성공 시 memo_board.php로 리디렉션
                header("Location: memo_board.php");
                exit();
            } else {
                echo "데이터 삽입 중 오류가 발생했습니다";
                // 쿼리 오류 메시지 출력
                var_dump($stmt->errorInfo());
            }
        }
    }
    // 사용자 아이디 가져오기
    $userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '';// 환영 메시지 생성
    $welcomeMessage = $userId ? "[$userId]님 환영합니다." : '';
} catch (PDOException $e) {
    // 추가한 로그: 오류 메시지 확인
    die("오류: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>메모장</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #c8a2c8;
        }
        .container {
            background-color: #e6ccff;
            border-radius: 40px;
            padding: 20px;
        }
        .btn-primary {
            background-color: #800080;
            border-color: #800080;
        }
        .text-welcome {
            color: black;
            font-weight: bold;
            margin-right: 20px;
        }
    </style>
</head>
<body>
<div class="d-flex justify-content-end">
    <p class="text-welcome"><?= $welcomeMessage ?></p>
</div>

<div class="container mt-5">
    <img src="payple.png" alt="Payple Logo" class="payple-logo">
    <form action="/memojang/memo.php" method="post">
        <div class="text-center">
            <table class="table table-bordered" style="width: 70%; margin: 0 auto; border: none;">
                <tr>
                    <h1 class="text-center">MEMO</h1>
                </tr>
                <tr>
                    <td style="border: none;">작성자</td>
                    <td style="text-align:left; border: none;">
                        <?php if ($userId) : ?>
                            <input type="text" name="user_id" class="form-control" value="<?= $userId ?>" readonly>
                        <?php else : ?>
                            <input type="text" name="user_id" class="form-control" value="" readonly>
                        <?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <td style="border: none;">제목</td>
                    <td style="text-align:left; border: none;"><input type="text" name="title" class="form-control" value=""></td>
                </tr>
                <tr>
                    <td style="border: none;">내용</td>
                    <td style="border: none;"><textarea name="content" class="form-control" style="width: 100%; height: 200px;"></textarea></td>
                </tr>
            </table>
            <button type="submit" name="action" value="insert" class="btn btn-primary">저장</button>
        </div>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>

<?php
session_start();
$host = "localhost";
$port = "3306";
$dbName = "db_paypleTest";
$user = "root";
$password = "root";

try {
    $memojang = "mysql:host=$host;port=$port;dbname=$dbName";
    $pdo = new PDO($memojang, $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $memoId = isset($_GET['memo_id']) ? $_GET['memo_id'] : null;

    if (!$memoId) {
        die("유효하지 않은 메모 ID");
    }

    $stmt = $pdo->prepare("SELECT * FROM memos WHERE id = :id");
    $stmt->bindParam(':id', $memoId, PDO::PARAM_INT);
    $stmt->execute();
    $memo = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$memo) {
        die("메모를 찾을 수 없습니다");
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // 메모 update sql문
        $title = isset($_POST['title']) ? $_POST['title'] : $memo['title'];
        $content = isset($_POST['content']) ? $_POST['content'] : $memo['content'];

        $stmt = $pdo->prepare("UPDATE memos SET title = :title, content = :content WHERE id = :id");
        $stmt->bindParam(':title', $title, PDO::PARAM_STR);
        $stmt->bindParam(':content', $content, PDO::PARAM_STR);
        $stmt->bindParam(':id', $memoId, PDO::PARAM_INT);
        $result = $stmt->execute();

        if ($result) {
            header("Location: memo_board.php");
            exit();
        } else {
            echo "데이터 수정 중 오류가 발생했습니다";
            var_dump($stmt->errorInfo());
        }
    }

} catch (PDOException $e) {
    die("오류: " . $e->getMessage());
}
$userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '';// 환영 메시지 생성
$welcomeMessage = $userId ? "[$userId]님 환영합니다." : '';
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>메모 수정</title>
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
    <form action="/memojang/memoupdate.php?memo_id=<?= $memo['id'] ?>" method="post">
        <div class="text-center">
            <table class="table table-bordered" style="width: 70%; margin: 0 auto; border: none;">
                <tr>
                    <h1 class="text-center">MEMO</h1>
                </tr>
                <tr>
                    <td style="border: none;">작성자</td>
                    <td style="text-align:left; border: none;">
                        <input type="text" name="user_id" class="form-control" value="<?= $memo['user_id'] ?>" readonly disabled>
                    </td>
                </tr>
                <tr>
                    <td style="border: none;">제목</td>
                    <td style="text-align:left; border: none;">
                        <input type="text" name="title" class="form-control" value="<?= $memo['title'] ?>" required>
                    </td>
                </tr>
                <tr>
                    <td style="border: none;">내용</td>
                    <td style="border: none;">
                        <textarea name="content" class="form-control" style="width: 100%; height: 200px;"><?= $memo['content'] ?></textarea>
                    </td>
                </tr>
            </table>
            <button type="submit" name="action" value="update" class="btn btn-primary">수정</button>
        </div>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>

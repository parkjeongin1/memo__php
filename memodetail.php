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

    $memoTitle = isset($_GET['title']) ? $_GET['title'] : null;

    if (!$memoTitle) {
        die("유효하지 않은 메모 제목");
    }

    if (isset($_POST['delete'])) {
        $stmtDelete = $pdo->prepare("DELETE FROM memos WHERE title = :title");
        $stmtDelete->bindParam(':title', $memoTitle, PDO::PARAM_STR);
        $stmtDelete->execute();

        header("Location: /memojang/memo_board.php");
        exit();
    }

    $stmt = $pdo->prepare("SELECT *, DATE_FORMAT(updated_at, '%Y-%m-%d %H:%i:%s') AS formatted_updated_at FROM memos WHERE title = :title");
    $stmt->bindParam(':title', $memoTitle, PDO::PARAM_STR);
    $stmt->execute();
    $memo = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$memo) {
        die("메모를 찾을 수 없습니다");
    }

    $userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '';// 환영 메시지 생성
    $welcomeMessage = $userId ? "[$userId]님 환영합니다." : '';

} catch (PDOException $e) {
    die("오류: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>메모 상세보기</title>
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
    <div class="text-center">
        <h1>MEMO 상세보기</h1>
    </div>

    <div class="form-group">
        <label for="name">작성자</label>
        <input type="text" name="name" id="name" class="form-control" value="<?= $memo['user_id'] ?>" readonly>
    </div>
    <div class="form-group">
        <label for="title">제목</label>
        <input type="text" name="title" id="title" class="form-control" value="<?= $memo['title'] ?>" readonly>
    </div>
    <div class="form-group">
        <label for="content">내용</label>
        <textarea name="content" id="content" class="form-control" readonly><?= $memo['content'] ?></textarea>
    </div>
    <form method="post">
        <?php if ($userId === $memo['user_id']) : ?>
            <div class="text-right">
                <a href="/memojang/memoupdate.php?memo_id=<?= $memo['id'] ?>" class="btn btn-primary">수정</a>
                <input type="submit" name="delete" class="btn btn-danger" value="삭제">
            </div>
        <?php endif; ?>
        <div class="form-group">
            <label for="updated_at">수정 일시</label>
            <input type="text" name="updated_at" id="updated_at" class="form-control" value="<?= $memo['formatted_updated_at'] ?>" readonly>
        </div>
    </form>
    <div class="text-right">
        <a href="/memojang/memo_board.php" class="btn btn-secondary">목록</a>
    </div>

</div>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>

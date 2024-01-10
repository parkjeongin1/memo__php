<?php
// 세션 시작
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

    $recordsPerPage = 10;

    $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;

    $offset = ($currentPage - 1) * $recordsPerPage;

    // 검색어
    $searchKeyword = isset($_GET['search']) ? $_GET['search'] : '';
    $searchCondition = !empty($searchKeyword) ? "WHERE title LIKE :search" : "";

    // 페이지별 메모 검색 및 검색어 처리
    $stmt = $pdo->prepare("SELECT * FROM memos $searchCondition ORDER BY created_at DESC LIMIT :offset, :recordsPerPage");
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    $stmt->bindParam(':recordsPerPage', $recordsPerPage, PDO::PARAM_INT);
    if (!empty($searchKeyword)) {
        $stmt->bindValue(':search', "%$searchKeyword%", PDO::PARAM_STR);
    }
    $stmt->execute();
    $memos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $totalMemosStmt = $pdo->prepare("SELECT COUNT(*) FROM memos $searchCondition");
    if (!empty($searchKeyword)) {
        $totalMemosStmt->bindValue(':search', "%$searchKeyword%", PDO::PARAM_STR);
    }
    $totalMemosStmt->execute();
    $totalMemos = $totalMemosStmt->fetchColumn();
    $totalPages = ceil($totalMemos / $recordsPerPage);

} catch (PDOException $e) {
    die("오류: " . $e->getMessage());
}

$userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '';

$welcomeMessage = $userId ? "[$userId]님 환영합니다." : '';

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
            position: relative;
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
        .btn-success {
            background-color: #993399;
            border-color: #993399;
        }
        .thead-dark th {
            background-color: #993399;
            color: white;
            text-align: center;
        }
        .payple-logo {
            position: absolute;
            top: 10px;
            right: 10px;
            max-width: 100px;
        }
        .register-button {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 1000;
        }

        input[name="user_id"],
        input[name="title"],
        textarea[name="memo"],
        .table-bordered input[type="text"],
        .table-bordered textarea {
            border: 2px solid #800080;
            border-radius: 5px;
            padding: 5px;
        }
        .table th, .table td {
            text-align: center;
        }
        .search-form {
            text-align: right;
            margin-bottom: 20px;
        }
        .total-memos {
            margin-bottom: 20px;
        }
        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }
        .pagination a {
            padding: 5px 10px;
            margin: 0 5px;
            border: 1px solid #800080;
            border-radius: 5px;
            color: #800080;
            text-decoration: none;
        }
        .pagination a.active {
            background-color: #800080;
            color: white;
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
    <?php if ($userId) : ?>
        <a href="/memojang/logout.php" class="btn btn-danger">로그아웃</a>
    <?php endif; ?>
</div>
<div class="mt-5">
    <div class="text-center mb-3">
        <h1 class="mb-0">MEMO</h1>
    </div>

    <div class="d-flex justify-content-between align-items-center">
        <div class="total-memos">
            <div class="total-memos">
                <p class="mb-0"><strong>[전체 게시글 수: <?= $totalMemos ?>]</strong></p>
            </div>
        </div>

        <div class="search-form">
            <form action="memo_board.php" method="get">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="제목으로 검색">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-primary">검색</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <table class="table table-bordered" style="margin: 0 auto;">
        <thead class="thead-dark">
        <tr>
            <th>구분</th>
            <th>작성자</th>
            <th>제목</th>
            <th>내용</th>
            <th>저장일시</th>
            <th>수정일시</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $sequenceNumber = $offset + 1; //시퀀스
        foreach ($memos as $memo): ?>
            <tr>
                <td><?= $sequenceNumber++ ?></td>
                <td><?= $memo['user_id'] ?></td>
                <td>
                    <a href="/memojang/memodetail.php?title=<?= $memo['title'] ?>" style="color: black; text-decoration: underline;">
                        <?= $memo['title'] ?>
                    </a>
                    </a>
                </td>
                <td><?= $memo['content'] ?></td>
                <td><?= $memo['created_at'] ?></td>
                <td><?= $memo['updated_at'] ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <div class="pagination">
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a href="memo_board.php?page=<?= $i ?>&search=<?= $searchKeyword ?>" class="<?= $i === $currentPage ? 'active' : '' ?>">
                <?= $i ?>
            </a>
        <?php endfor; ?>
    </div>
</div>

<a href="/memojang/memo.php" class="btn btn-primary register-button" style="position: fixed; bottom: 20px; right: 20px; z-index: 1000;">등록하기</a>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>

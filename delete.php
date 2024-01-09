<?php
$host = "localhost";
$port = "3306";
$dbName = "db_paypleTest";
$user = "root";
$password = "root";

try {
    $memojang = "mysql:host=$host;port=$port;dbname=$dbName";
    $pdo = new PDO($memojang, $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // URL에서 메모 title을 기반으로 메모 세부 정보를 가져옵니다.
    $memoTitle = isset($_GET['title']) ? $_GET['title'] : null;

    if (!$memoTitle) {
        die("유효하지 않은 메모 제목");
    }

    $stmtDelete = $pdo->prepare("DELETE FROM memos WHERE title = :title");
    $stmtDelete->bindParam(':title', $memoTitle, PDO::PARAM_STR);
    $stmtDelete->execute();

    // 삭제 후 메모 보드 페이지로 이동
    header("Location: /memojang/memo_board.php");
    exit();
} catch (PDOException $e) {
    die("오류: " . $e->getMessage() . "<br>삭제 대상 제목: " . $memoTitle);
}
?>

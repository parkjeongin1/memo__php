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


    $memoTitle = isset($_GET['title']) ? $_GET['title'] : null;

    if (!$memoTitle) {
        die("유효하지 않은 메모 제목");
    }

    $stmtDelete = $pdo->prepare("DELETE FROM memos WHERE title = :title");
    $stmtDelete->bindParam(':title', $memoTitle, PDO::PARAM_STR);
    $stmtDelete->execute();

    header("Location: /memojang/memo_board.php");
    exit();
} catch (PDOException $e) {
    die("오류: " . $e->getMessage() . "<br>삭제 대상 제목: " . $memoTitle);
}
?>

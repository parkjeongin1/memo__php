<?php
$host = "localhost";
$port = "3306";
$dbName = "db_paypleTest";
$user = "root";
$password = "root";

$conn = new mysqli($host, $user, $password, $dbName);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$userID = $_POST['User_Id'];
$userPassword = $_POST['User_Password'];

$stmt = $conn->prepare("SELECT * FROM user WHERE user_id = ?");
$stmt->bind_param("s", $userID);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $hashedPassword = $row['user_password'];

    if (password_verify($userPassword, $hashedPassword)) {
        // 로그인 성공 시 세션에 사용자 아이디 저장
        session_start();
        $_SESSION['user_id'] = $row['user_id'];

        header("Location: /memojang/memo_board.php");
        exit();
    }
}

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $hashedPassword = $row['user_password'];

    // 비밀번호 비교
    if (password_verify($userPassword, $hashedPassword)) {
        // 사용자 ID를 세션 변수에 저장
        session_start();
        $_SESSION['user_id'] = $row['user_id'];

        header("Location: /memojang/memo_board.php");
        exit();
    }
}

header("Location: /memojang/login.php");
exit();

$conn->close();
?>

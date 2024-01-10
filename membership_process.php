<?php
$host = "localhost";
$port = "3306";
$dbName = "db_paypleTest";
$user = "root";
$password = "root";

try {
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbName", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("데이터베이스 연결에 실패했습니다. 관리자에게 문의하세요.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_POST['User_Id'];
    $user_name = $_POST['User_Name'];
    $user_email = $_POST['User_Email'];
    $user_password = password_hash($_POST['User_Password'], PASSWORD_DEFAULT);
    $user_phone = $_POST['User_Phone'];
    $user_postcode = $_POST['User_Postcode'];
    $user_road_address = $_POST['User_RoadAddress'];
    $user_jibun_address = $_POST['User_JibunAddress'];
    $user_detail_address = $_POST['User_DetailAddress'];

    if (strlen($user_id) < 6 || !ctype_alpha($user_id)) {
        die("아이디는 6글자 이상이어야 하며 영문으로만 이루어져야 합니다.");
    }

    if (strlen($_POST['User_Password']) < 8) {
        die("비밀번호는 8글자 이상이어야 합니다.");
    }

    if (!filter_var($user_email, FILTER_VALIDATE_EMAIL) || strpos($user_email, '@') === false) {
        die("올바른 이메일 주소를 입력하세요.");
    }
    try {
        // 회원가입 insert
        $sql = "INSERT INTO user (user_id, user_name, user_email, user_password, user_phone, user_postcode, user_road_address, user_jibun_address, user_detail_address)
                VALUES (:user_id, :user_name, :user_email, :user_password, :user_phone, :user_postcode, :user_road_address, :user_jibun_address, :user_detail_address)";

        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':user_name', $user_name);
        $stmt->bindParam(':user_email', $user_email);
        $stmt->bindParam(':user_password', $user_password);
        $stmt->bindParam(':user_phone', $user_phone);
        $stmt->bindParam(':user_postcode', $user_postcode);
        $stmt->bindParam(':user_road_address', $user_road_address);
        $stmt->bindParam(':user_jibun_address', $user_jibun_address);
        $stmt->bindParam(':user_detail_address', $user_detail_address);

        // INSERT 문이 정상적으로 실행되었는지 확인
        if ($stmt->execute()) {
            echo "회원가입이 완료되었습니다.";

            header("Location: membership_com.php");
            exit();
        } else {
            $errorInfo = $stmt->errorInfo();
            $errorMessage = "회원가입 중 오류가 발생했습니다. 에러: " . $errorInfo[2];
            echo $errorMessage;
        }
    } catch (Exception $ex) {
        die("회원가입 중 오류가 발생했습니다. 에러: " . $ex->getMessage());
    } finally {
        $pdo = null;
    }
}
?>

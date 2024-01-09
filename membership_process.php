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

    // 추가적인 제약 조건 검사
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
        // SQL 쿼리 작성하여 사용자 정보 데이터베이스에 저장
        $sql = "INSERT INTO user (user_id, user_name, user_email, user_password, user_phone, user_postcode, user_road_address, user_jibun_address, user_detail_address)
                VALUES (:user_id, :user_name, :user_email, :user_password, :user_phone, :user_postcode, :user_road_address, :user_jibun_address, :user_detail_address)";

        // SQL 쿼리를 위한 준비 단계
        $stmt = $pdo->prepare($sql);

        // 바인딩 및 실행
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
            // 성공 메시지 출력
            echo "회원가입이 완료되었습니다.";

            // 가입이 완료되면 membership_com.php로 이동
            header("Location: membership_com.php");
            exit();
        } else {
            // 에러 처리 및 사용자에게 메시지 전달
            $errorInfo = $stmt->errorInfo();
            $errorMessage = "회원가입 중 오류가 발생했습니다. 에러: " . $errorInfo[2];
            echo $errorMessage;
        }
    } catch (Exception $ex) {
        // 예외 처리
        die("회원가입 중 오류가 발생했습니다. 에러: " . $ex->getMessage());
    } finally {
        // 사용한 리소스 반환
        $pdo = null;
    }
}
?>

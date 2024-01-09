<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>회원가입 페이지</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'Malgun Gothic', sans-serif;
            background: linear-gradient(135deg, #8a44a3, #653298);
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .container {
            max-width: 600px;
            width: 100%;
        }

        .cotn_principal {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0px 0px 10px 0px #000000;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .address-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 15px;
            margin-bottom: 15px;
        }

        #sample4_postcode {
            flex: 4;
            margin-right: 10px;
        }

        .btn-primary {
            flex: 1;
        }

        #sample4_postcode,
        #sample4_roadAddress,
        #sample4_jibunAddress,
        #sample4_detailAddress,
        #sample4_extraAddress {
            width: 100%;
            box-sizing: border-box;
        }

        .custom-button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .custom-button:hover {
            background-color: #45a049;
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
        }
    </style>
</head>

<body>
<div class="container">
    <div class="cotn_principal">
        <h2 class="font-weight-bold">회원 가입</h2>
        <?php include 'membership_process.php'; ?>
        <form action="membership.php" method="post" onsubmit="return validatePassword();">
            <div class="form-group">
                <input type="text" id="userid" class="form-control" name="User_Id" placeholder="아이디는 6글자 이상이어야 하며 영문으로만 이루어져야 합니다." required>
            </div>
            <div class="form-group">
                <input type="text" id="usernm" class="form-control" name="User_Name" placeholder="이름" required>
            </div>
            <div class="form-group">
                <input type="text" id="useremail" class="form-control" name="User_Email" placeholder="이메일 주소" required>
            </div>
            <div class="form-group">
                <input type="password" id="userpw" class="form-control" name="User_Password" placeholder="비밀번호" required>
            </div>
            <div class="form-group">
                <input type="password" id="userpw2" class="form-control" placeholder="비밀번호 확인" required>
                <div id="passwordMatchMessage"></div>
            </div>
            <div>
                <input type="text" id="userPhone" class="form-control" name="User_Phone" placeholder="전화번호" required>
            </div>
            <div class="form-group">
                <div class="address-container">
                    <input type="text" id="sample4_postcode" class="form-control" name="User_Postcode" placeholder="우편번호">
                    <input type="button" onclick="sample4_execDaumPostcode()" value="주소검색" class="btn btn-primary custom-button">
                </div>
                <input type="text" id="sample4_roadAddress" class="form-control" name="User_RoadAddress" placeholder="도로명주소">
                <input type="text" id="sample4_jibunAddress" class="form-control" name="User_JibunAddress" placeholder="지번주소">
                <input type="text" id="sample4_detailAddress" class="form-control" name="User_DetailAddress" placeholder="상세주소">
            </div>
            <button type="submit" class="btn btn-primary custom-button">가입하기</button>
        </form>
    </div>
</div>
<!-- Kakao 주소 API -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="//t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>
<script>
    var daum = window.daum || {};

    function sample4_execDaumPostcode() {
        new daum.Postcode({
            oncomplete: function (data) {
                var roadAddr = data.roadAddress;
                var extraRoadAddr = '';

                if (data.bname !== '' && /[동|로|가]$/g.test(data.bname)) {
                    extraRoadAddr += data.bname;
                }

                if (data.buildingName !== '' && data.apartment === 'Y') {
                    extraRoadAddr += (extraRoadAddr !== '' ? ', ' + data.buildingName : data.buildingName);
                }

                if (extraRoadAddr !== '') {
                    extraRoadAddr = ' (' + extraRoadAddr + ')';
                }

                document.getElementById('sample4_postcode').value = data.zonecode;
                document.getElementById("sample4_roadAddress").value = roadAddr;
                document.getElementById("sample4_jibunAddress").value = data.jibunAddress;

                if (roadAddr !== '') {
                    document.getElementById("sample4_extraAddress").value = extraRoadAddr;
                } else {
                    document.getElementById("sample4_extraAddress").value = '';
                }

                var guideTextBox = document.getElementById("guide");

                if (data.autoRoadAddress) {
                    var expRoadAddr = data.autoRoadAddress + extraRoadAddr;
                    guideTextBox.innerHTML = '(예상 도로명 주소 : ' + expRoadAddr + ')';
                    guideTextBox.style.display = 'block';

                } else if (data.autoJibunAddress) {
                    var expJibunAddr = data.autoJibunAddress;
                    guideTextBox.innerHTML = '(예상 지번 주소 : ' + expJibunAddr + ')';
                    guideTextBox.style.display = 'block';
                } else {
                    guideTextBox.innerHTML = '';
                    guideTextBox.style.display = 'none';
                }
            }
        }).open();
    }
</script>
<script>
    // 클라이언트 측에서 비밀번호 일치 여부 확인 및 메시지 표시
    function validatePassword() {
        var password = document.getElementById("userpw").value;
        var confirmPassword = document.getElementById("userpw2").value;
        var message = document.getElementById("passwordMatchMessage");

        // 만약 두 비밀번호 필드가 모두 입력되었고, 일치하면 메시지를 표시
        if (password !== "" && confirmPassword !== "" && password === confirmPassword) {
            message.innerHTML = '비밀번호가 일치합니다.';
            message.style.color = 'blue';
            return true;
        } else {
            message.innerHTML = '비밀번호가 일치하지 않습니다.';
            message.style.color = 'red';
            return false;
        }
    }

    // 비밀번호 입력 필드에 입력이 발생할 때마다 validatePassword 함수 호출
    document.getElementById("userpw").addEventListener("input", validatePassword);
    document.getElementById("userpw2").addEventListener("input", validatePassword);
</script>
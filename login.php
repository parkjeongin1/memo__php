<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>로그인 페이지</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'Malgun Gothic', sans-serif;
            background: linear-gradient(135deg, #8a44a3, #653298);
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }

        .cotn_principal {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 5px;
            padding: 20px;
            max-width: 400px;
            width: 100%;
        }

        .cont_form_login {
            text-align: center;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .btn-primary {
            background-color: #8a44a3;
            border-color: #8a44a3;
        }

        .btn-primary:hover {
            background-color: #653298;
            border-color: #653298;
        }

        .custom-link {
            color: black;
        }

        .custom-link:hover {
            color: #8a44a3;
        }
    </style>
</head>
<body>
<div class="cotn_principal">
    <div class="cont_centrar">
        <div class="cont_login">
            <div class="col-md-12">
                <form name="loginForm" method="post" action="login_process.php" autocomplete="off">
                    <div class="cont_form_login">
                        <div class="form-group">
                            <input type="text" name="User_Id" class="form-control" placeholder="User ID" required>
                        </div>
                        <div class="form-group">
                            <input type="password" name="User_Password" class="form-control" placeholder="Password" required>
                        </div>
                        <button class="btn btn-primary btn-block" type="submit">로그인</button>
                        <button class="btn btn-secondary btn-block" id="membershipButton">회원가입</button>
                        <div class="text-center mt-2">
                            <a href="#" class="custom-link" data-toggle="modal" data-target="#findIdModal">아이디 찾기</a>
                            <span class="mx-2 text-dark">|</span>
                            <a href="#" class="custom-link" data-toggle="modal" data-target="#findPasswordModal">비밀번호 찾기</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
    <!-- 아이디 찾기 모달 -->
    <div class="modal fade" id="findIdModal" tabindex="-1" role="dialog" aria-labelledby="findIdModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="findIdModalLabel">아이디 찾기</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="findIdForm">
                        <div class="form-group">
                            <label for="findIdName">이름</label>
                            <input type="text" class="form-control" id="findIdName" required>
                        </div>
                        <div class="form-group">
                            <label for="findIdPhone">전화번호</label>
                            <input type="tel" class="form-control" id="findIdPhone" required>
                        </div>
                        <div class="form-group">
                            <label for="findIdEmail">이메일</label>
                            <input type="email" class="form-control" id="findIdEmail" required>
                        </div>
                        <button type="button" class="btn btn-primary" onclick="findId()">아이디 찾기</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- 비밀번호 찾기 모달 -->
    <div class="modal fade" id="findPasswordModal" tabindex="-1" role="dialog" aria-labelledby="findPasswordModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="findPasswordModalLabel">비밀번호 찾기</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="findPasswordForm">
                        <div class="form-group">
                            <label for="findPasswordId">아이디</label>
                            <input type="text" class="form-control" id="findPasswordId" required>
                        </div>
                        <div class="form-group">
                            <label for="findPasswordPhone">전화번호</label>
                            <input type="tel" class="form-control" id="findPasswordPhone" required>
                        </div>
                        <div class="form-group">
                            <label for="findPasswordEmail">이메일</label>
                            <input type="email" class="form-control" id="findPasswordEmail" required>
                        </div>
                        <button type="button" class="btn btn-primary" onclick="findPassword()">비밀번호 찾기</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</body>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    document.getElementById('membershipButton').addEventListener('click', function () {
        window.location.href = 'membership.php';
    });
</script>
</body>

</html>
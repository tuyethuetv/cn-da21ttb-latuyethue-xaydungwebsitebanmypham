<?php
    session_start();

    require_once('../../Utils/utility.php');
    require_once('../../Database/dbhelper.php');
    require_once('process_form_register.php');

    $user = getUserToken();
    if ($user != null){
        header('Location: ../');
        die();
    }
 ?>
<!DOCTYPE html>
<html>
<head>
	<title>Trang Đăng ký</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">  
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">

	<!-- jQuery library -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

	<!-- Popper JS -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

	<!-- Latest compiled JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</head>
<body style = "background-image: url(../../Asset/Image/ecommerce.jpg);background-size: cover; height: 100vh;
  width: 100vw;background-repeat: no-repeat;background-position: center center;">
	<div class="container">
		<div class="panel panel-primary" style="width: 550px; margin : 0px auto; margin-top: 100px; background-color: white; padding: 10px; border-radius: 5px; box-shadow: 15px 15px #1b1456;" >
			<div class="panel-heading">
				<h2 class="text-center">Đăng ký tài khoản người dùng</h2>
                <h4 style="color: red;;class="class="text-center"><?=$msg?></h4>
			</div>
			<div class="panel-body">
				<form method="post" onsubmit="return validateForm();">
                <div class="form-group">
				  <label for="usr">Họ & Tên:</label>
				  <input required="true" type="text" class="form-control" id="usr" name= "fullname">
				</div>
				<div class="form-group">
				  <label for="email">Email:</label>
				  <input required="true" type="email" class="form-control" id="email" name="email">
				</div>
				<div class="form-group">
				  <label for="pwd">Mật khẩu:</label>
				  <input required="true" type="password" class="form-control" id="pwd" name="password" minlength="6">
				</div>
				<div class="form-group">
				  <label for="confirmation_pwd">Nhập Lại Mật Khẩu:</label>
				  <input required="true" type="password" class="form-control" id="confirmation_pwd" minlength="6">
				</div>
                <p>
                   <a href="login.php"> Tôi đã có tài khoản </a> 
                </p>
				<button class="btn btn-success">Đăng Ký</button>
                </form>
			</div>
		</div>
	</div>
    <script type="text/javascript">
    function validateForm() {
        const pwd = $('#pwd').val();
        const confirmPwd = $('#confirmation_pwd').val(); 
        if (pwd !== confirmPwd) {
            alert("Mật khẩu không khớp. Vui lòng kiểm tra lại.");
            return false;
        }
        return true;
    }
</script>
</body>
</html>
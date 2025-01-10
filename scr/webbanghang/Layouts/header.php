<?php
session_start();
require_once('utils/utility.php');
require_once('database/dbhelper.php');

// require_once($baseUrl.'./Utils/utility.php');
// require_once($baseUrl.'./Database/dbhelper.php');


$sql = "select * from category";
$menuItems = executeResult($sql);

$user = getUserToken();
if ($user == null) {
	header('Location: ' . $baseUrl . 'authen/login.php');
	die();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<title>Sammy Shop</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" href="https://theme.hstatic.net/200000551679/1001282356/14/logo.png?v=567">
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">

	<!-- jQuery library -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

	<!-- Popper JS -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

	<!-- Latest compiled JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>

	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.6.1/font/bootstrap-icons.css">

	<style type="text/css">
		.nav li {
			text-transform: uppercase;
			color: #ed87b8;
			margin-top: 20px;
		}

		.nav li a {
			color: #ed87b8;
			font-weight: bold;
		}

		.carousel-inner img {
			height: 420px;
			width: 100%;
		}

		.product-item:hover {
			background-color: #fff;
			cursor: pointer;
			margin-bottom: 10px;
		}

		footer {
			padding-top: 20px;
		}

		footer ul {
			list-style-type: none;
			padding: 0px;
			margin: 0px;
			padding-top: 10px;
			padding-bottom: 10px;
		}

		.cart_icon {
			position: fixed;
			z-index: 999999;
			right: 0px;
			top: 45%;
		}

		.cart_icon img {
			width: 45px;
		}

		.cart_icon .cart_count {
			background-color: red;
			color: white;
			font-size: 16px;
			padding-top: 2px;
			padding-bottom: 2px;
			padding-left: 10px;
			padding-right: 10px;
			font-weight: bold;
			border-radius: 12px;
			position: fixed;
			right: 40px;
		}

		.nav-item .form-inline input {
			border-radius: 4px;
			border: 1px solid #ced4da;
			padding: 5px 10px;
		}

		.nav-item .form-inline button {
			margin-left: 5px;
			border-radius: 4px;
			font-weight: bold;
		}

		.nav-item .btn-danger {
			font-weight: bold;
			display: inline-flex;
			align-items: center;
			justify-content: center;
			border-radius: 4px;
		}
	</style>
</head>

<body>
	<!-- Menu START -->
	<div class="container">
		<ul class="nav">
			<li class="nav-item" style="margin-top: 0px !important;">
				<a href="index.php"><img src="https://theme.hstatic.net/200000551679/1001282356/14/logo.png?v=567" style="max-width: 100%;height: auto;"></a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="index.php">Trang Chủ</a>
			</li>
			<?php
			foreach ($menuItems as $item) {
				echo '<li class="nav-item">
				    <a class="nav-link" href="category.php?id=' . $item['id'] . '">' . $item['name'] . '</a>
				  </li>';
			}
			?>

			<li class="nav-item">
				<a class="nav-link" href="contact.php">Liên Hệ</a>
			</li>
			<li class="nav-item ml-auto">
				<div style="display: flex; align-items: center; gap: 10px;">
					<form class="form-inline" method="GET" action="search.php" style="display: flex; align-items: center;">
						<input class="form-control" type="search" name="query" placeholder="Tìm kiếm sản phẩm..." aria-label="Search" style="height: 38px;">
						<button class="btn btn-outline-success" type="submit" style="height: 38px;">Tìm Kiếm</button>
					</form>
					<a class="btn btn-danger" href="./Admin/authen/logout.php" role="button" style="color: white; height: 38px;">Thoát</a>
				</div>
			</li>
		</ul>
	</div>
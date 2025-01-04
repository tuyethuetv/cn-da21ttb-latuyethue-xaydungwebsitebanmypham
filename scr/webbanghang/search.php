<?php
session_start();
require_once('utils/utility.php');
require_once('database/dbhelper.php');

$query = isset($_GET['query']) ? trim($_GET['query']) : '';

if ($query == '') {
    header('Location: index.php');
    die();
}

// Tìm kiếm sản phẩm
$sql = "SELECT * FROM product WHERE title LIKE '%" . $query . "%' OR description LIKE '%" . $query . "%'";
$searchResults = executeResult($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Kết Quả Tìm Kiếm</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
</head>
<body>
<div class="container">
	<h3>Kết Quả Tìm Kiếm Cho: <?= htmlspecialchars($query) ?></h3>
	<div class="row">
		<?php
		if (count($searchResults) > 0) {
			foreach ($searchResults as $product) {
				echo '<div class="col-md-3 col-6 product-item">
						<a href="detail.php?id=' . $product['id'] . '">
							<img src="' . $product['thumbnail'] . '" style="width: 100%; height: 220px;" alt="' . htmlspecialchars($product['title']) . '">
						</a>
						<a href="detail.php?id=' . $product['id'] . '">
							<p style="font-weight: bold;">' . htmlspecialchars($product['title']) . '</p>
						</a>
						<p style="color: red; font-weight: bold;">' . number_format($product['discount']) . ' VND</p>
						<p>
							<button class="btn" onclick="addCart(' . $product['id'] . ', 1)" 
									style="width: 100%; border-radius: 0px; background-color: #ff69b4; color: white; border: none;">
								<i class="bi bi-cart-plus-fill"></i> Thêm giỏ hàng
							</button>
						</p>
					</div>';
			}
		} else {
			echo '<p>Không tìm thấy sản phẩm nào phù hợp.</p>';
		}
		
		?>
	</div>
</div>
</body>
</html>

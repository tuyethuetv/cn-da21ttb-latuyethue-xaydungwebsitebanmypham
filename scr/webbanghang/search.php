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
				echo '<div class="col-md-3">
						<div class="card mb-4">
							<img src="' . $product['thumbnail'] . '" class="card-img-top" alt="' . htmlspecialchars($product['title']) . '">
							<div class="card-body">
								<h5 class="card-title">' . $product['title'] . '</h5>
								<p class="card-text">' . substr($product['description'], 0, 50) . '...</p>
								<a href="detail.php?id=' . $product['id'] . '" class="btn btn-primary">Xem Chi Tiết</a>
							</div>
						</div>
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

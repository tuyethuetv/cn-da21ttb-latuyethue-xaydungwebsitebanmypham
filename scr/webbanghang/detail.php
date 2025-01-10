<?php
require_once('layouts/header.php');

$productId = getGet('id');
$sql = "select product.*, category.name as category_name from product left join category on product.category_id = category.id where product.id = $productId";
$product = executeResult($sql, true);

$category_id = $product['category_id'];
$sql = "select product.*, category.name as category_name from product left join category on product.category_id = category.id where product.category_id = $category_id order by product.updated_at desc limit 0,4";

// Lấy đánh giá từ cơ sở dữ liệu
$sql = "SELECT r.*, u.fullname FROM reviews r JOIN user u ON r.user_id = u.id WHERE r.product_id = $productId ORDER BY r.created_at DESC";
$reviews = executeResult($sql);

$lastestItems = executeResult($sql);

// Lưu sản phẩm vừa xem vào session
if (!isset($_SESSION['viewed_products'])) {
	$_SESSION['viewed_products'] = [];
}

// Kiểm tra xem sản phẩm hiện tại đã có trong danh sách chưa
if (!in_array($productId, $_SESSION['viewed_products'])) {
	array_unshift($_SESSION['viewed_products'], $productId); // Thêm vào đầu danh sách
	if (count($_SESSION['viewed_products']) > 5) { // Giới hạn danh sách 5 sản phẩm
		array_pop($_SESSION['viewed_products']);
	}
}
$viewedProducts = [];
if (isset($_SESSION['viewed_products']) && count($_SESSION['viewed_products']) > 0) {
	$viewedIds = implode(',', $_SESSION['viewed_products']);
	$sql = "SELECT * FROM product WHERE id IN ($viewedIds)";
	$viewedProducts = executeResult($sql);
}
// Lấy danh sách sản phẩm tương tự
$sql = "SELECT * FROM product WHERE category_id = $category_id AND id != $productId ORDER BY updated_at DESC LIMIT 0, 4";
$similarProducts = executeResult($sql);

?>
<style type="text/css">
	.review-form {
		max-width: 700px;
		/* Tăng chiều rộng tối đa */
		margin: 30px auto;
		padding: 30px;
		background-color: #f9f9f9;
		border-radius: 10px;
		box-shadow: 0 6px 10px rgba(0, 0, 0, 0.15);
		font-family: Arial, sans-serif;
		transition: transform 0.3s ease, box-shadow 0.3s ease;
	}

	.review-form:hover {
		transform: translateY(-5px);
		box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
	}

	.review-form .form-group {
		margin-bottom: 20px;
	}

	.review-form label {
		font-weight: bold;
		display: block;
		margin-bottom: 8px;
		font-size: 16px;
		color: #333;
	}

	.review-form select,
	.review-form textarea {
		width: 100%;
		padding: 15px;
		/* Tăng padding để nội dung thoáng hơn */
		border: 1px solid #ccc;
		border-radius: 8px;
		font-size: 16px;
		background-color: #fff;
		transition: border-color 0.3s ease, box-shadow 0.3s ease;
	}

	.review-form select:focus,
	.review-form textarea:focus {
		border-color: rgb(255, 0, 170);
		box-shadow: 0 0 10px rgba(255, 0, 170, 0.7);
		outline: none;
	}

	.review-form .star-rating {
		display: flex;
		justify-content: center;
		gap: 15px;
		/* Tăng khoảng cách giữa các ngôi sao */
		margin-bottom: 20px;
	}

	.review-form .star {
		font-size: 30px;
		/* Tăng kích thước sao */
		cursor: pointer;
		color: #ccc;
		transition: color 0.3s ease, transform 0.3s ease;
	}

	.review-form .star.selected,
	.review-form .star:hover {
		color: rgb(255, 0, 170);
		transform: scale(1.3);
		/* Phóng to sao khi chọn hoặc hover */
	}

	.review-form button {
		width: 100%;
		padding: 15px;
		font-size: 18px;
		font-weight: bold;
		background-color: rgb(255, 0, 170);
		color: #fff;
		border: none;
		border-radius: 8px;
		cursor: pointer;
		transition: background-color 0.3s ease, transform 0.2s ease, box-shadow 0.2s ease;
	}

	.review-form button:hover {
		background-color: rgb(220, 0, 150);
		transform: translateY(-3px);
		box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
	}

	.review-form button:active {
		transform: translateY(0);
		box-shadow: none;
	}

	.card {
		border: 1px solid #ff69b4;
		/* Viền màu hồng */
		border-radius: 8px;
		overflow: hidden;
		background-color: #ffe6f2;
		/* Nền hồng nhạt */
		transition: transform 0.3s ease, box-shadow 0.3s ease;
	}

	.card:hover {
		transform: translateY(-5px);
		box-shadow: 0 8px 15px rgba(255, 105, 180, 0.3);
		/* Hiệu ứng hồng khi hover */
	}

	.card-img-top {
		border-bottom: 2px solid #ff69b4;
		/* Viền ảnh màu hồng */
		height: 150px;
		object-fit: cover;
	}

	.card-title {
		font-weight: bold;
		color: #ff69b4;
		/* Tiêu đề màu hồng đậm */
		text-overflow: ellipsis;
		overflow: hidden;
		white-space: nowrap;
	}

	.card-text {
		color: #d63384;
		/* Giá màu hồng đậm */
		font-size: 14px;
	}

	.btn-primary {
		background-color: #ff69b4;
		/* Nút màu hồng */
		border-color: #ff69b4;
		color: white;
		font-size: 14px;
		font-weight: bold;
	}

	.btn-primary:hover {
		background-color: #ff1493;
		/* Nút hồng đậm khi hover */
		border-color: #ff1493;
	}
</style>
<div class="container" style="margin-top: 20px; margin-bottom: 20px;">
	<div class="row">
		<div class="col-md-6">
			<img src="<?= $product['thumbnail'] ?>" style="width: 100%;">
		</div>
		<div class="col-md-6">
			<ul class="breadcrumb">
				<li><a href="index.php">Trang Chủ</a></li>
				<li><a href="category.php?id=<?= $product['category_id'] ?>"> / <?= $product['category_name'] ?></a></li>
				<li> / <?= $product['title'] ?></li>
			</ul>
			<h2><?= $product['title'] ?></h2>
			<?php
			// Tính tổng số sao và số lượt đánh giá
			$totalStars = 0;
			$totalReviews = count($reviews);

			foreach ($reviews as $review) {
				$totalStars += $review['rating'];
			}

			// Tính trung bình sao
			$averageRating = $totalReviews > 0 ? round($totalStars / $totalReviews, 1) : 0;

			// Hiển thị kết quả
			?>
			<div style="display: flex; align-items: center; margin-bottom: 20px;">
				<span style="font-size: 24px; font-weight: bold; color: orange; margin-right: 10px;"><?= $averageRating ?></span>
				<div>
					<?php for ($i = 1; $i <= 5; $i++): ?>
						<span style="color: <?= $i <= $averageRating ? 'orange' : '#ccc'; ?>;">★</span>
					<?php endfor; ?>
				</div>
				<span style="margin-left: 10px; font-size: 14px; color: #555;">
					(<?= $totalReviews ?> lượt đánh giá)
				</span>
			</div>
			<p style="font-size: 30px; color: red; margin-top: 15px; margin-bottom: 15px;">
				<?= number_format($product['discount']) ?> VND
			</p>
			<p style="font-size: 15px; color: grey; margin-top: 15px; margin-bottom: 15px;">
				<del><?= number_format($product['price']) ?> VND</del>
			</p>
			<div style="display: flex;">
				<button class="btn btn-light" style="border: solid #e0dede 1px; border-radius: 0px;" onclick="addMoreCart(-1)">-</button>
				<input type="number" name="num" class="form-control" step="1" value="1" style="max-width: 90px;border: solid #e0dede 1px; border-radius: 0px;" onchange="fixCartNum()">
				<button class="btn btn-light" style="border: solid #e0dede 1px; border-radius: 0px;" onclick="addMoreCart(1)">+</button>
			</div>
			<button class="btn" style="background-color: #ff69b4;color: white;margin-top: 20px; width: 100%; border-radius: 0px; font-size: 30px;" onclick="addCart(<?= $product['id'] ?>, $('[name=num]').val())">
				<i class="bi bi-cart-plus-fill"></i> THÊM VÀO GIỎ HÀNG
			</button>
			<button
				class="btn btn-secondary"
				style="margin-top: 20px; width: 100%; border-radius: 0px; font-size: 30px; background-color: #edebeb; border: solid #edebeb 1px; color: black;"
				onclick="addToFavorites(<?= $product['id'] ?>)">
				<i class="bi bi-bookmark-heart-fill"></i> THÊM MỤC YÊU THÍCH
			</button>

		</div>
		<div class="col-md-12" style="margin-top: 20px; margin-bottom: 30px;">
			<h2>Chi Tiết Sản Phẩm</h2>
			<a href="#productDetails" class="btn" style="width: 10%;border-radius: 0px;background-color: #ff69b4;color: white;border: none;" data-toggle="collapse">Xem thêm</a>
			<div id="productDetails" class="collapse">
				<?= $product['description'] ?>
			</div>
		</div>
		<div class="col-md-12">
			<h2>Đánh giá sản phẩm</h2>
			<?php foreach ($reviews as $review): ?>
				<div style="border-bottom: 1px solid #ddd; padding: 10px 0;">
					<strong><?= htmlspecialchars($review['fullname']) ?></strong>
					<div>
						<?php for ($i = 1; $i <= 5; $i++): ?>
							<span style="color: <?= $i <= $review['rating'] ? 'orange' : '#ccc'; ?>;">★</span>
						<?php endfor; ?>
					</div>
					<p><?= nl2br(htmlspecialchars($review['comment'])) ?></p>
					<small><?= date('d/m/Y H:i', strtotime($review['created_at'])) ?></small>
				</div>
			<?php endforeach; ?>
		</div>
		<form class="review-form" method="post" action="submit_review.php">
			<div class="form-group">
				<label for="rating">Đánh giá:</label>
				<div class="star-rating">
					<span class="star" data-value="1">&#9733;</span>
					<span class="star" data-value="2">&#9733;</span>
					<span class="star" data-value="3">&#9733;</span>
					<span class="star" data-value="4">&#9733;</span>
					<span class="star" data-value="5">&#9733;</span>
				</div>
				<input type="hidden" name="rating" id="rating" required>
			</div>
			<div class="form-group">
				<label for="comment">Bình luận:</label>
				<textarea name="comment" id="comment" class="form-control" rows="3" required placeholder="Nhập bình luận của bạn..."></textarea>
			</div>
			<input type="hidden" name="product_id" value="<?= $productId ?>">
			<button type="submit">Gửi đánh giá</button>
		</form>
		<?php if (count($viewedProducts) > 0): ?>
			<div class="col-md-12" style="margin-top: 20px;">
				<h2>Sản phẩm bạn vừa xem</h2>
				<div class="row">
					<?php foreach ($viewedProducts as $item): ?>
						<div class="col-md-3">
							<div class="card" style="margin-bottom: 20px;">
								<img src="<?= $item['thumbnail'] ?>" class="card-img-top" alt="<?= htmlspecialchars($item['title']) ?>">
								<div class="card-body">
									<h5 class="card-title"><?= htmlspecialchars($item['title']) ?></h5>
									<p class="card-text"><?= number_format($item['discount']) ?> VND</p>
									<a href="detail.php?id=<?= $item['id'] ?>" class="btn btn-primary btn-sm">Xem chi tiết</a>
								</div>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		<?php endif; ?>
		<?php if (count($similarProducts) > 0): ?>
			<div class="col-md-12" style="margin-top: 20px;">
				<h2>Sản phẩm tương tự</h2>
				<div class="row">
					<?php foreach ($similarProducts as $item): ?>
						<div class="col-md-3">
							<div class="card" style="margin-bottom: 20px;">
								<img src="<?= $item['thumbnail'] ?>" class="card-img-top" alt="<?= htmlspecialchars($item['title']) ?>">
								<div class="card-body">
									<h5 class="card-title"><?= htmlspecialchars($item['title']) ?></h5>
									<p class="card-text"><?= number_format($item['discount']) ?> VND</p>
									<a href="detail.php?id=<?= $item['id'] ?>" class="btn btn-primary btn-sm">Xem chi tiết</a>
								</div>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		<?php endif; ?>

		<script>
			const stars = document.querySelectorAll('.star');
			const ratingInput = document.getElementById('rating');

			stars.forEach(star => {
				star.addEventListener('click', () => {
					stars.forEach(s => s.classList.remove('selected'));
					star.classList.add('selected');
					ratingInput.value = star.getAttribute('data-value');
				});

				star.addEventListener('mouseover', () => {
					stars.forEach(s => s.classList.remove('selected'));
					star.classList.add('selected');
				});
			});
		</script>
	</div>
</div>
<script type="text/javascript">
	function addMoreCart(delta) {
		num = parseInt($('[name=num]').val())
		num += delta
		if (num < 1) num = 1;
		$('[name=num]').val(num)
	}

	function fixCartNum() {
		$('[name=num]').val(Math.abs($('[name=num]').val()))
	}
</script>
<script>
	function addToFavorites(productId) {
		fetch('add_to_favorites.php', {
				method: 'POST',
				headers: {
					'Content-Type': 'application/json'
				},
				body: JSON.stringify({
					product_id: productId
				})
			})
			.then(response => response.json())
			.then(data => {
				if (data.success) {
					alert("Đã thêm sản phẩm vào mục yêu thích!");
				} else {
					alert("Lỗi: " + data.message);
				}
			})
			.catch(error => {
				console.error('Error:', error);
				alert("Đã xảy ra lỗi, vui lòng thử lại!");
			});
	}
</script>

<?php
require_once('layouts/footer.php');
?>
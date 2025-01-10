<?php 
require_once('layouts/header.php');

$category_id = getGet('id');

// Nếu không có category_id, lấy tất cả sản phẩm có delete = 0
if($category_id == null || $category_id == '') {
	$sql = "SELECT product.*, category.name AS category_name 
	        FROM product 
	        LEFT JOIN category ON product.category_id = category.id 
	        WHERE product.deleted = 0 
	        ORDER BY product.updated_at DESC 
	        LIMIT 0, 12";
} else {
	// Nếu có category_id, lấy sản phẩm của danh mục đó và delete = 0
	$sql = "SELECT product.*, category.name AS category_name 
	        FROM product 
	        LEFT JOIN category ON product.category_id = category.id 
	        WHERE product.category_id = $category_id AND product.deleted = 0 
	        ORDER BY product.updated_at DESC 
	        LIMIT 0, 12";
}

$lastestItems = executeResult($sql);
?>
<div class="container" style="margin-top: 20px; margin-bottom: 20px;">
	<div class="row">
	<?php
		// Hiển thị sản phẩm
		foreach($lastestItems as $item) {
			echo '<div class="col-md-3 col-6 product-item">
					<a href="detail.php?id='.$item['id'].'"><img src="'.$item['thumbnail'].'" style="width: 100%; height: 220px;"></a>
					<p style="font-weight: bold;">'.$item['category_name'].'</p>
					<a href="detail.php?id='.$item['id'].'"><p style="font-weight: bold;">'.$item['title'].'</p></a>
					<p style="color: red; font-weight: bold;">'.number_format($item['discount']).' VND</p>
					<p><button class="btn" onclick="addCart('.$item['id'].', 1)" style="width: 100%; border-radius: 0px;background-color: #ff69b4;color: white;"><i class="bi bi-cart-plus-fill"></i> Thêm giỏ hàng</button></p>
				</div>';
		}
	?>
	</div>
</div>
<?php
require_once('layouts/footer.php');
?>

<!-- Menu Stop -->
<footer style="background-color: #ffaad4 !important;">
	<div class="container">
		<div class="row">
			<div class="col-md-4">
				<h4>GIỚI THIỆU</h4>
				<ul>
					<li>LIÊN HỆ SAMMYSHOP</li>
					<li><i class="bi bi-mailbox2"></i> tuyethuetv.com@gmail.com</li>
					<li><i class="bi bi-telephone-fill"></i> 0776825215</li>
					<li><i class="bi bi-map-fill"></i> Tra Vinh, Viet Nam</li>
					<li>Chúng tôi luôn tiên phong trong lĩnh vực xậy dựng website cho các doanh nghiệp và của hàng. Chúng tôi luôn nỗ lực để tạo ra sản phẩm có chất lượng tốt nhất cho khách hàng.</li>
				</ul>
			</div>
			<div class="col-md-4">
				<h4>SẢN PHẨM MỚI NHẤT</h4>
				<ul>
					<li>LIÊN HỆ SAMMYSHOP</li>
					<li>Email: tuyethuetv.com@gmail.com</li>
					<li>Phone: 0776825215</li>
					<li>Chúng tôi luôn tiên phong trong lĩnh vực xậy dựng website cho các doanh nghiệp và của hàng. Chúng tôi luôn nỗ lực để tạo ra sản phẩm có chất lượng tốt nhất cho khách hàng.</li>
				</ul>
			</div>
			<div class="col-md-4">
				<h4>TIN TỨC MỚI NHẤT</h4>
				<ul>
					<li>LIÊN HỆ SAMMYSHOP</li>
					<li>Email: tuyethuetv.com@gmail.com</li>
					<li>Phone: 0776825215</li>
					<li>Chúng tôi luôn tiên phong trong lĩnh vực xậy dựng website cho các doanh nghiệp và của hàng. Chúng tôi luôn nỗ lực để tạo ra sản phẩm có chất lượng tốt nhất cho khách hàng.</li>
				</ul>
			</div>
		</div>
	</div>
	<div style="background-color: #ed2f8b; width: 100%; text-align: center; padding: 20px;">
		© 2024 SammyShop . Được thiết kế bởi TuyetHue. All rights reserved.
	</div>
</footer>

<?php
if(!isset($_SESSION['cart'])) {
	$_SESSION['cart'] = [];
}
$count = 0;
// var_dump($_SESSION['cart']);
foreach($_SESSION['cart'] as $item) {
	$count += $item['num'];
}
?>
<script type="text/javascript">
	function addCart(productId, num) {
		$.post('api/ajax_request.php', {
			'action': 'cart',
			'id': productId,
			'num': num
		}, function(data) {
			location.reload()
		})
	}
</script>
<!-- Cart start -->
<span class="cart_icon">
	<span class="cart_count"><?=$count?></span>
	<a href="cart.php"><img src="https://theme.hstatic.net/200000551679/1001282356/14/cart-icon.png?v=567"></a>
</span>
<!-- Cart stop -->
</body>
</html>

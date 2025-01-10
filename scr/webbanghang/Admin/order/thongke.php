<?php 
   $title = 'Thống kê sản phẩm đã bán';
   $baseUrl = '../';
   require_once('../layout/header.php');

// Truy vấn lấy danh sách sản phẩm đã bán nhiều nhất
$sql = "SELECT 
            p.id AS product_id, 
            p.title AS product_name, 
            p.thumbnail, 
            p.discount, 
            Count(od.id) AS total_sold 
        FROM 
            order_details od 
        INNER JOIN 
            product p ON od.product_id = p.id 
        INNER JOIN 
            orders o ON od.order_id = o.id 
        WHERE 
            o.status = 1  -- Chỉ tính các đơn hàng đã được duyệt
        GROUP BY 
            p.id 
        ORDER BY 
            total_sold DESC";

$soldStatistics = executeResult($sql);
?>

<div class="container" style="margin-top: 20px; margin-bottom: 20px;">
    <h3 class="text-center text-primary">Thống Kê Sản Phẩm Đã Bán</h3>
    <div class="row">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Thumbnail</th>
                    <th>Tên Sản Phẩm</th>
                    <th>Giá</th>
                    <th>Số Lượt Đã Bán</th>
                </tr>
            </thead>
            <tbody>
            <?php
            if (count($soldStatistics) == 0) {
                echo '<tr><td colspan="5" style="text-align: center;">Chưa có thống kê!</td></tr>';
            } else {
                $index = 0;
                foreach ($soldStatistics as $item) {
                    echo '<tr>
                            <td>' . (++$index) . '</td>
                            <td><img src="'.fixUrl($item['thumbnail']).'" alt="Thumbnail" style="height: 100px; width: auto;"/></td>
                            <td>' . $item['product_name'] . '</td>
                            <td>' . number_format($item['discount']) . ' VND</td>
                            <td>' . $item['total_sold'] . '</td>
                        </tr>';
                }
            }
            ?>
            </tbody>
        </table>
    </div>
</div>

<?php
    require_once('../layout/footer.php');
?>

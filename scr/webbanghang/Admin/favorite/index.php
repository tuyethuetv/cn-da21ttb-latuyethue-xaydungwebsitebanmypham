<?php 
   $title = 'Thống kê lượt yêu thích';
   $baseUrl = '../';
   require_once('../layout/header.php');

// Truy vấn lấy danh sách sản phẩm yêu thích nhiều nhất
$sql = "SELECT 
            p.id AS product_id, 
            p.title AS product_name, 
            p.thumbnail, 
            p.discount, 
            COUNT(f.id) AS total_favorites 
        FROM 
            favorites f 
        INNER JOIN 
            product p ON f.product_id = p.id 
        GROUP BY 
            p.id 
        ORDER BY 
            total_favorites DESC";

$favoriteStatistics = executeResult($sql);
?>

<div class="container" style="margin-top: 20px; margin-bottom: 20px;">
    <h1 class="text-center text-primary">Thống Kê Sản Phẩm Yêu Thích</h1>

    
    <div class="row">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Thumbnail</th>
                    <th>Tên Sản Phẩm</th>
                    <th>Giá</th>
                    <th>Số Lượt Yêu Thích</th>
                </tr>
            </thead>
            <tbody>
            <?php
            if (count($favoriteStatistics) == 0) {
                echo '<tr><td colspan="5" style="text-align: center;">Chưa có thống kê!</td></tr>';
            } else {
                $index = 0;
                foreach ($favoriteStatistics as $item) {
                    echo '<tr>
                            <td>' . (++$index) . '</td>
                            <td><img src="'.fixUrl($item['thumbnail']).'" alt="Thumbnail" style="height: 100px; width: auto;"/></td>
                            <td>' . $item['product_name'] . '</td>
                            <td>' . number_format($item['discount']) . ' VND</td>
                            <td>' . $item['total_favorites'] . '</td>
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

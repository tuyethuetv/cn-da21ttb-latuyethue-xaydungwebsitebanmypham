<?php
$title = 'Dashboard Page';
$baseUrl = '';
require_once('layout/header.php');

// Lấy tổng số người dùng
$sql_count = "SELECT COUNT(*) AS total_users FROM user WHERE deleted = 0";
$result_count = executeResult($sql_count);
$total_users = $result_count[0]['total_users'] ?? 0; // Lấy số lượng người dùng từ câu truy vấn

// Lấy dữ liệu doanh thu theo ngày
$sql = "SELECT DATE(order_date) AS order_day, SUM(total_money) AS total_revenue 
        FROM orders 
        GROUP BY DATE(order_date) 
        ORDER BY order_day";
$results = executeResult($sql);

$days = [];
$revenues = [];
$totalRevenue = 0;

if (!empty($results)) {
    foreach ($results as $row) {
        $days[] = $row['order_day'];
        $revenues[] = $row['total_revenue'];
        $totalRevenue += $row['total_revenue'];
    }
}

// Lấy tổng số đơn hàng
$sqlOrders = "SELECT COUNT(*) AS total_orders FROM orders";
$orderResult = executeResult($sqlOrders, true);
$totalOrders = $orderResult['total_orders'] ?? 0;

// Tính tổng số ngày
$totalDays = count($days);

// Chuyển dữ liệu thành JSON để sử dụng trong JavaScript
$days = json_encode($days);
$revenues = json_encode($revenues);
?>

<div class="container-fluid mt-4">
    <!-- Tiêu đề -->
    <div class="row">
        <div class="col-md-12">
            <h1 class="text-center text-primary mb-4">Dashboard</h1>
        </div>
    </div>

    <!-- Các Card Thống Kê -->
    <div class="row text-center mb-5">
        <!-- Card Người Dùng -->
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <i class="fas fa-users"></i> Người Dùng
                </div>
                <div class="card-body">
                    <h3 class="text-dark"><?php echo $total_users; ?></h3>
                    <p>Số lượng người dùng hiện tại</p>
                </div>
            </div>
        </div>
        <!-- Card Đơn Hàng -->
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-header bg-warning text-white">
                    <i class="fas fa-cart-arrow-down"></i> Đơn Hàng
                </div>
                <div class="card-body">
                    <h3 class="text-dark"><?php echo $totalOrders; ?></h3>
                    <p>Tổng số đơn hàng đã đặt</p>
                </div>
            </div>
        </div>
        <!-- Card Tổng Doanh Thu -->
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <i class="fas fa-dollar-sign"></i> Tổng Doanh Thu
                </div>
                <div class="card-body">
                    <h3 class="text-dark"><?php echo number_format($totalRevenue); ?> VND</h3>
                    <p>Doanh thu từ tất cả các ngày</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Biểu đồ thống kê -->
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header bg-info text-white">
                    <i class="fas fa-chart-line"></i> Biểu đồ Thống Kê Doanh Thu
                </div>
                <div class="card-body">
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
require_once('layout/footer.php');
?>

<!-- Liên kết thư viện Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Biểu đồ doanh thu
    const days = <?php echo $days ?: '[]'; ?>;
    const revenues = <?php echo $revenues ?: '[]'; ?>;

    const ctx = document.getElementById('revenueChart').getContext('2d');
    new Chart(ctx, {
        type: 'line', // Đổi loại biểu đồ sang 'line'
        data: {
            labels: days,
            datasets: [{
                label: 'Doanh Thu (VND)',
                data: revenues,
                borderColor: 'rgba(54, 162, 235, 1)', // Màu đường kẻ
                backgroundColor: 'rgba(54, 162, 235, 0.2)', // Màu nền dưới đường
                borderWidth: 2, // Độ dày đường
                tension: 0.4 // Độ cong của đường
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top'
                },
                title: {
                    display: true,
                    text: 'Thống Kê Doanh Thu Theo Ngày',
                    font: {
                        size: 18,
                        weight: 'bold'
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return value.toLocaleString(); // Định dạng số kiểu VND
                        }
                    }
                }
            }
        }
    });
</script>

<?php
    require_once('layout/footer.php');
?>
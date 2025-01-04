<?php
    $title = 'Dashboard Page';
    $baseUrl = '';
    require_once('layout/header.php');
?>

<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-md-12">
            <h1 class="text-center">Dashboard</h1>
        </div>
    </div>

    <div class="row mt-4">
        <!-- Card Thống Kê Số Người Dùng -->
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <i class="fas fa-users"></i> Người Dùng
                </div>
                <div class="card-body text-center">
                    <h3>1,200</h3>
                    <p>Số lượng người dùng hiện tại</p>
                </div>
            </div>
        </div>

        <!-- Card Thống Kê Sản Phẩm -->
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <i class="fas fa-box"></i> Sản Phẩm
                </div>
                <div class="card-body text-center">
                    <h3>150</h3>
                    <p>Sản phẩm hiện có trong kho</p>
                </div>
            </div>
        </div>

        <!-- Card Thống Kê Đơn Hàng -->
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-header bg-warning text-white">
                    <i class="fas fa-cart-arrow-down"></i> Đơn Hàng
                </div>
                <div class="card-body text-center">
                    <h3>300</h3>
                    <p>Tổng số đơn hàng đã đặt</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Biểu đồ thống kê -->
    <div class="row mt-5">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <i class="fas fa-chart-line"></i> Biểu đồ Thống Kê
                </div>
                <div class="card-body">
                    <canvas id="myChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
    require_once('layout/footer.php');
?>

<!-- Liên kết với các thư viện cần thiết -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Biểu đồ thống kê
    var ctx = document.getElementById('myChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'line', // Chọn loại biểu đồ (line, bar, pie, ...)
        data: {
            labels: ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5'], // Các tháng
            datasets: [{
                label: 'Doanh Thu',
                data: [1200, 1900, 3000, 5000, 2500], // Dữ liệu
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>

<!-- Liên kết Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
   $title = 'Thống kê';
$baseUrl = '../';
require_once('../layout/header.php');

$ipAddress = $_SERVER['REMOTE_ADDR'];
$userAgent = $_SERVER['HTTP_USER_AGENT'];
$pageUrl = $_SERVER['REQUEST_URI'];

$sql = "INSERT INTO visitor_logs (ip_address, user_agent, page_url) 
        VALUES ('$ipAddress', '$userAgent', '$pageUrl')";
execute($sql);

// Lấy dữ liệu thống kê để hiển thị biểu đồ
$sql = "SELECT DATE(visit_time) AS visit_date, COUNT(*) AS visit_count 
        FROM visitor_logs 
        GROUP BY visit_date 
        ORDER BY visit_date ASC";
$result = executeResult($sql);

// Chuẩn bị dữ liệu cho biểu đồ
$chartData = [];
foreach ($result as $row) {
    $chartData[] = [
        'date' => $row['visit_date'],
        'count' => $row['visit_count']
    ];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Thống kê truy cập</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
</head>
<body>
<div class="container mt-5">
    <h1 class="text-center">Thống kê lượt truy cập</h1>
    <div id="visitChart"></div>
</div>

<script>
    // Dữ liệu biểu đồ từ PHP
    const chartData = <?php echo json_encode($chartData); ?>;
    const labels = chartData.map(item => item.date); // Ngày
    const counts = chartData.map(item => item.count); // Số lượt truy cập

    // Tạo biểu đồ với ApexCharts
    const options = {
        chart: {
            type: 'area', // Loại biểu đồ: Area (đường với vùng màu)
            height: 400,
            animations: {
                enabled: true,
                easing: 'easeinout',
                speed: 800,
            },
        },
        series: [{
            name: 'Lượt truy cập',
            data: counts // Dữ liệu trục Y
        }],
        xaxis: {
            categories: labels, // Dữ liệu trục X
            title: {
                text: 'Ngày',
            },
        },
        yaxis: {
            title: {
                text: 'Lượt truy cập',
            },
        },
        dataLabels: {
            enabled: true, // Hiển thị giá trị trên biểu đồ
        },
        colors: ['#00BAEC'], // Màu sắc đường
        fill: {
            type: 'gradient', // Hiệu ứng gradient
            gradient: {
                shade: 'light',
                type: 'vertical',
                shadeIntensity: 0.4,
                gradientToColors: ['#ABE5A1'],
                inverseColors: true,
                opacityFrom: 0.7,
                opacityTo: 0.3,
            },
        },
        grid: {
            show: true, // Hiển thị grid
            borderColor: '#e0e0e0', // Màu sắc đường kẻ
            strokeDashArray: 4, // Dạng nét đứt
            xaxis: {
                lines: {
                    show: true // Hiển thị đường kẻ dọc
                }
            },
            yaxis: {
                lines: {
                    show: true // Hiển thị đường kẻ ngang
                }
            }
        }
    };

    const chart = new ApexCharts(document.querySelector("#visitChart"), options);
    chart.render();
</script>
</body>
</html>
<?php
     require_once('../layout/footer.php');
?>

<?php 
   $title = 'Thống kê doanh thu';
   $baseUrl = '../';
   require_once('../layout/header.php');

   // Lấy dữ liệu doanh thu theo ngày
   $sql = "SELECT DATE(order_date) AS order_day, SUM(total_money) AS total_revenue 
           FROM orders 
           GROUP BY DATE(order_date) 
           ORDER BY order_day";
   $results = executeResult($sql);

   $days = [];
   $revenues = [];
   $totalRevenue = 0; // Tổng doanh thu

   if (!empty($results)) {
       foreach ($results as $row) {
           $days[] = $row['order_day'];
           $revenues[] = $row['total_revenue'];
           $totalRevenue += $row['total_revenue']; // Cộng dồn tổng doanh thu
       }
   }

   // Tính tổng số ngày
   $totalDays = count($days);

   // Chuyển dữ liệu thành JSON để sử dụng trong JavaScript
   $days = json_encode($days);
   $revenues = json_encode($revenues);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thống Kê Doanh Thu</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f4f4f4;
        }
        h1 {
            text-align: center;
            margin-bottom: 10px;
            color: #333;
        }
        .stats {
            text-align: center;
            margin-bottom: 20px;
        }
        .chart-container {
            width: 80%;
            margin: 0 auto;
            background: white;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
    </style>
</head>

<body>
    <h1 class="text-center text-primary mb-4">Biểu Đồ Thống Kê Doanh Thu</h1>
    <div class="stats">
        <p><strong>Tổng doanh thu:</strong> <?php echo number_format($totalRevenue); ?> VND</p>
        <p><strong>Tổng số ngày thống kê:</strong> <?php echo $totalDays; ?></p>
    </div>
    <div class="chart-container">
        <canvas id="revenueChart" width="400" height="200"></canvas>
    </div>

    <script>
        // Dữ liệu từ PHP
        const days = <?php echo $days ?: '[]'; ?>;
        const revenues = <?php echo $revenues ?: '[]'; ?>;

        if (days.length === 0 || revenues.length === 0) {
            alert('Không có dữ liệu doanh thu để hiển thị.');
        } else {
            // Cấu hình biểu đồ
            const ctx = document.getElementById('revenueChart').getContext('2d');
            const revenueChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: days,
                    datasets: [{
                        label: 'Doanh thu (VND)',
                        data: revenues,
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1,
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        title: {
                            display: true,
                            text: 'Thống Kê Doanh Thu Theo Ngày',
                            font: {
                                size: 20,
                                family: 'Arial, sans-serif',
                                weight: 'bold',
                            },
                            padding: { top: 10, bottom: 20 },
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
                        },
                        x: {
                            ticks: {
                                autoSkip: false,
                                maxRotation: 45,
                                minRotation: 0,
                            }
                        }
                    },
                    animation: {
                        duration: 1000,
                        easing: 'easeOutQuart'
                    }
                }
            });
        }
    </script>
</body>

</html>
<?php
    require_once('../layout/footer.php');
?>

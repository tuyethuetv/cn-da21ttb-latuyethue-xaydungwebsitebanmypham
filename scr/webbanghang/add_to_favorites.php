<?php
session_start();
require_once('Database/dbhelper.php');// Kết nối cơ sở dữ liệu

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $productId = $data['product_id'] ?? null;

    if (!$productId) {
        echo json_encode(['success' => false, 'message' => 'ID sản phẩm không hợp lệ!']);
        exit;
    }

    // Kiểm tra người dùng đã đăng nhập chưa
    if (!isset($_SESSION['user']['id'])) {
        echo json_encode(['success' => false, 'message' => 'Bạn cần đăng nhập để thêm yêu thích!']);
        exit;
    }

    $userId = $_SESSION['user']['id'];

    // Kiểm tra sản phẩm đã có trong danh sách yêu thích chưa
    $sql = "SELECT * FROM favorites WHERE user_id = $userId AND product_id = $productId";
    $result = executeResult($sql);
    if (!empty($result)) {
        echo json_encode(['success' => false, 'message' => 'Sản phẩm đã có trong mục yêu thích!']);
        exit;
    }

    // Thêm vào bảng favorites
    $sql = "INSERT INTO favorites (user_id, product_id) VALUES ($userId, $productId)";
    execute($sql);

    echo json_encode(['success' => true]);
    exit;
}

echo json_encode(['success' => false, 'message' => 'Phương thức không hợp lệ!']);
exit;
?>

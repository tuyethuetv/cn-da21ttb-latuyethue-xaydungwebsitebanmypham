<?php
require_once('Database/dbhelper.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_SESSION['user']['id'];
    $productId = $_POST['product_id'];
    $rating = intval($_POST['rating']);
    $comment = $_POST['comment'];

    if ($rating < 1 || $rating > 5) {
        die('Đánh giá không hợp lệ.');
    }

    $sql = "INSERT INTO reviews (product_id, user_id, rating, comment) VALUES ($productId, $userId, $rating, '$comment')";
    execute($sql);

    header("Location: detail.php?id=$productId");
    exit();
}
?>

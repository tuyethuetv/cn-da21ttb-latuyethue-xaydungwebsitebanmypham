<?php
require_once('config.php');
function execute($sql){
    $conn = mysqli_connect(HOST, USERNAME, PASSWORD, DATABASE);
    mysqli_set_charset($conn, 'utf8');

    mysqli_query($conn, $sql);

    mysqli_close($conn);
}

// SQL select -> lay du lieu dau ra (select danh sach ban ghi, lay 1 bang ghi)
function executeResult($sql, $isSingle = false) {
    $data = null;
    $conn = mysqli_connect(HOST, USERNAME, PASSWORD, DATABASE);
    mysqli_set_charset($conn, 'utf8');

    $resultset = mysqli_query($conn, $sql);

    if ($resultset == false) {
        // Thêm kiểm tra lỗi nếu truy vấn thất bại
        die("Lỗi truy vấn SQL: " . mysqli_error($conn));
    }

    if ($isSingle) {
        // Lấy một dòng kết quả
        $data = mysqli_fetch_array($resultset, MYSQLI_ASSOC);
    } else {
        // Lấy nhiều dòng kết quả
        $data = [];
        while (($row = mysqli_fetch_array($resultset, MYSQLI_ASSOC)) != null) {
            $data[] = $row; // Thêm từng dòng vào mảng `$data`
        }
    }

    mysqli_close($conn);
    return $data;
}
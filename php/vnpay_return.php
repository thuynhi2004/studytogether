<?php
session_start();
include "connect.php";

$id = $_GET['id'] ?? 0;
$vnp_ResponseCode = $_GET['vnp_ResponseCode'] ?? '';

if ($vnp_ResponseCode == "00") {
    // Thanh toán thành công → ghi session
    $_SESSION['paid_docs'][$id] = true;

    // Tăng lượt tải xuống
    $update = $conn->prepare("UPDATE tailieu SET luottaixuong = luottaixuong + 1 WHERE id=?");
    $update->bind_param("i", $id);
    $update->execute();

    // Redirect tới download
    header("Location: download_vnpay.php?id=$id");
    exit;
} else {
    echo "<h2 style='color:red;text-align:center;'>❌ Thanh toán thất bại hoặc bị hủy!</h2>";
    echo "<p style='text-align:center;'><a href='chitiet_tailieu.php?id=$id'>← Quay lại tài liệu</a></p>";
}

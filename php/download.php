<?php
session_start();
include 'connect.php';

$id = $_GET['id'] ?? 0;

// Kiểm tra đăng nhập
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php?redirect=download.php?id=$id");
    exit;
}

// Lấy thông tin tài liệu
$sql = "SELECT * FROM tailieu WHERE id = $id";
$res = mysqli_query($conn, $sql);
$file = mysqli_fetch_assoc($res);

// Kiểm tra thanh toán
$userId = $_SESSION['user_id'];
$check = mysqli_query($conn,
    "SELECT * FROM orders WHERE user_id = $userId AND tailieu_id = $id AND status = 'paid'"
);

if (mysqli_num_rows($check) == 0) {
    // Chưa thanh toán → chuyển đến trang thanh toán
    header("Location: thanhtoan.php?id=$id");
    exit;
}

// Nếu đã thanh toán → tải file
$path = "uploads/" . $file['duongdan'];

if (file_exists($path)) {
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="' . basename($path) . '"');
    header('Content-Length: ' . filesize($path));
    readfile($path);
    exit;
} else {
    echo "File không tồn tại.";
}
?>

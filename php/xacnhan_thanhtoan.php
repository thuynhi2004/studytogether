<?php
session_start();
include 'connect.php';

$id = $_GET['id'];
$userId = $_SESSION['user_id'];

// Cập nhật trạng thái paid
mysqli_query($conn,
    "UPDATE orders SET status='paid' 
     WHERE user_id=$userId AND tailieu_id=$id"
);

// Quay lại trang tải xuống
header("Location: download.php?id=$id");
exit;
?>

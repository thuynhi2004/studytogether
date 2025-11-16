<?php
session_start();
include "connect.php";

$id = $_GET['id'] ?? 0;

if (!isset($_SESSION['paid_docs'][$id])) {
    die("❌ Bạn chưa thanh toán để tải tài liệu này.");
}

$stmt = $conn->prepare("SELECT fileupload FROM tailieu WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$row = $stmt->get_result()->fetch_assoc();

$file = 'uploads/' . $row['fileupload'];
if (file_exists($file)) {
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="'.basename($file).'"');
    readfile($file);
    exit;
} else {
    die("File không tồn tại.");
}

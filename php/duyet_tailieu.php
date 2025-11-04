<?php
include 'connect.php';
session_start();
header('Content-Type: application/json');

if ($_SESSION['role'] !== 'admin') {
    echo json_encode(['success' => false, 'message' => 'Không có quyền duyệt tài liệu']);
    exit;
}

$id = $_POST['id'] ?? 0;
$action = $_POST['action'] ?? ''; // 'duyet' hoặc 'tu_choi'

if (!$id || !in_array($action, ['duyet', 'tuchoi'])) {
    echo json_encode(['success' => false, 'message' => 'Dữ liệu không hợp lệ']);
    exit;
}

$trangthai = $action === 'duyet' ? 'daduyet' : 'tuchoi';

$stmt = $conn->prepare("UPDATE tailieu SET trangthai = ? WHERE id = ?");
$stmt->bind_param("si", $trangthai, $id);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Cập nhật trạng thái thành công!']);
} else {
    echo json_encode(['success' => false, 'message' => 'Lỗi khi cập nhật']);
}

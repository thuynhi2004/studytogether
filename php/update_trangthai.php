<?php
include 'connect.php';
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);
$id = $data['id'] ?? 0;
$trangthai = $data['trangthai'] ?? '';

if (!$id || !$trangthai) {
    echo json_encode(['success' => false, 'message' => 'Thiếu dữ liệu']);
    exit;
}

$allowed = ['choduyet', 'daduyet', 'tuchoi'];
if (!in_array($trangthai, $allowed)) {
    echo json_encode(['success' => false, 'message' => 'Trạng thái không hợp lệ']);
    exit;
}

$stmt = $conn->prepare("UPDATE tailieu SET trangthai = ? WHERE id = ?");
$stmt->bind_param('si', $trangthai, $id);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Cập nhật trạng thái thành công!']);
} else {
    echo json_encode(['success' => false, 'message' => 'Lỗi khi cập nhật: ' . $stmt->error]);
}

$stmt->close();
$conn->close();
?>

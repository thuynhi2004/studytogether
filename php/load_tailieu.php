<?php
session_start();
include 'connect.php';
header('Content-Type: application/json');

// 🔐 Kiểm tra đăng nhập
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'error' => 'Chưa đăng nhập']);
    exit;
}

$userID = $_SESSION['user_id']; 
$role   = $_SESSION['role'] ?? 'user';

// 🧭 Nếu là admin thì load tất cả tài liệu
if ($role === 'admin') {
    $sql = "
        SELECT 
            t.id, 
            t.tentailieu, 
            t.fileupload, 
            t.phi, 
            t.ngayupload, 
            t.trangthai,
            d.tendanhmuc AS ten_danh_muc,
            u.hoten AS ten_nguoi_upload
        FROM tailieu t
        LEFT JOIN danhmuc d ON t.danhmucid = d.id
        LEFT JOIN users u ON t.nguoiupload = u.id
        ORDER BY t.id DESC
    ";
    $stmt = $conn->prepare($sql);

} else {
    // 🧍 Người đăng tải → chỉ thấy tài liệu của chính mình (mọi trạng thái)
    $sql = "
        SELECT 
            t.id, 
            t.tentailieu, 
            t.fileupload, 
            t.phi, 
            t.ngayupload, 
            t.trangthai,
            d.tendanhmuc AS ten_danh_muc,
            u.hoten AS ten_nguoi_upload
        FROM tailieu t
        LEFT JOIN danhmuc d ON t.danhmucid = d.id
        LEFT JOIN users u ON t.nguoiupload = u.id
        WHERE t.nguoiupload = ?
        ORDER BY t.id DESC
    ";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $userID);
}

$stmt->execute();
$result = $stmt->get_result();

$data = [];
while ($row = $result->fetch_assoc()) {
    // Format lại ngày upload
    $row['ngayupload'] = date('Y-m-d H:i:s', strtotime($row['ngayupload']));
    $data[] = $row;
}

echo json_encode(['success' => true, 'data' => $data]);

$stmt->close();
$conn->close();
?>

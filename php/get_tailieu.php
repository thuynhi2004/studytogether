<?php
include 'connect.php';

// Lấy id danh mục (nếu có)
$danhmuc_id = isset($_GET['danhmuc']) ? intval($_GET['danhmuc']) : 0;

// Câu truy vấn
if ($danhmuc_id > 0) {
    $sql = "SELECT t.id, t.tentailieu, t.trangbia, t.phi, t.luotxem, t.luottaixuong, t.danhgia, 
                   d.tendanhmuc, u.hoten AS nguoidang
            FROM tailieu t
            LEFT JOIN danhmuc d ON t.danhmucid = d.id
            LEFT JOIN users u ON t.nguoiupload = u.id
            WHERE t.danhmucid = ? AND t.trangthai = 'daduyet'
            ORDER BY t.ngayupload DESC";
    $stmt = $conn->prepare($sql);
    if (!$stmt) die("Lỗi prepare: " . $conn->error);
    $stmt->bind_param("i", $danhmuc_id);
} else {
    $sql = "SELECT t.id, t.tentailieu, t.trangbia, t.phi, t.luotxem, t.luottaixuong, t.danhgia, 
                   d.tendanhmuc, u.hoten AS nguoidang
            FROM tailieu t
            LEFT JOIN danhmuc d ON t.danhmucid = d.id
            LEFT JOIN users u ON t.nguoiupload = u.id
            WHERE t.trangthai = 'daduyet'
            ORDER BY t.ngayupload DESC";
    $stmt = $conn->prepare($sql);
    if (!$stmt) die("Lỗi prepare: " . $conn->error);
}

$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo '<div class="cards-container">';
    while ($row = $result->fetch_assoc()) {
        // ✅ Đường dẫn ảnh bìa
        $trangbiaPath = !empty($row['trangbia']) 
            ? 'uploads/' . htmlspecialchars($row['trangbia'])
            : 'uploads/no-image.png';

        $danhgia = $row['danhgia'] ?: 0;
        $id = $row['id']; // ✅ thêm biến $id để link hoạt động

        echo '
        <a href="chitiet_tailieu.php?id=' . $id . '" class="doc-card-link">
            <div class="doc-card">
                <div class="doc-thumb" style="background-image: url(\'' . $trangbiaPath . '\');"></div>
                <div class="doc-body">
                    <span class="category-tag">' . htmlspecialchars($row['tendanhmuc'] ?? "Khác") . '</span>
                    <h3 class="doc-title">' . htmlspecialchars($row['tentailieu']) . '</h3>
                    <p class="doc-author">👤 ' . htmlspecialchars($row['nguoidang'] ?? "Admin") . '</p>
                    <div class="doc-stats">
                        <span><i class="fa fa-eye"></i> ' . ($row['luotxem'] ?? 0) . '</span>
                        <span><i class="fa fa-download"></i> ' . ($row['luottaixuong'] ?? 0) . '</span>
                        <span>⭐ ' . number_format($danhgia, 1) . '</span>
                    </div>
                </div>
            </div>
        </a>';
    }
    echo '</div>';
} else {
    echo '<p style="text-align:center;color:#777;">Không có tài liệu nào.</p>';
}

$stmt->close();
$conn->close();
?>

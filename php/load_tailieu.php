<?php
include 'connect.php';

$danhmuc_id = $_GET['danhmuc'] ?? 0;

$sql = "SELECT id, tentailieu, trangbia, phi FROM tailieu 
        WHERE danhmucid = ? AND trangthai = 'daduyet' 
        ORDER BY ngayupload DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $danhmuc_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '<div class="card">';
        echo '  <img src="uploads/' . htmlspecialchars($row['trangbia']) . '" alt="' . htmlspecialchars($row['tentailieu']) . '">';
        echo '  <div class="card-body">';
        echo '    <h3>' . htmlspecialchars($row['tentailieu']) . '</h3>';
        echo '    <p>Phí: ' . number_format($row['phi'], 0, ',', '.') . 'đ</p>';
        echo '    <a href="chitiet.php?id=' . $row['id'] . '" class="btn">Xem chi tiết</a>';
        echo '  </div>';
        echo '</div>';
    }
} else {
    echo '<p>⚠️ Chưa có tài liệu trong danh mục này.</p>';
}
?>

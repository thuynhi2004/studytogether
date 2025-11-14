

<!-- file download -->
<?php
include 'connect.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id <= 0) {
    die("Thiếu ID file!");
}

$sql = "SELECT fileupload FROM tailieu WHERE id = $id";
$result = $conn->query($sql);

if (!$result || !$row = $result->fetch_assoc()) {
    die("Không tìm thấy file trong CSDL!");
}

$filename = basename($row['fileupload']);
$filePath = __DIR__ . '/../php/uploads/' . $filename;

// Kiểm tra file
if (!file_exists($filePath)) {
    die("File không tồn tại: $filePath");
}

// Cập nhật lượt tải trước khi gửi header
$conn->query("UPDATE tailieu SET luottaixuong = luottaixuong + 1 WHERE id = $id");

// Gửi file
header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="' . $filename . '"');
header('Content-Length: ' . filesize($filePath));

flush();
readfile($filePath);
exit;
?>

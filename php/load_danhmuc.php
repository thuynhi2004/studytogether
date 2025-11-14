<?php
include 'connect.php';
header('Content-Type: application/json; charset=utf-8');

// ✅ Bỏ dấu phẩy thừa trước FROM
$sql = "SELECT id, tendanhmuc, created_at FROM danhmuc";
$result = $conn->query($sql);

$danhmucs = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $danhmucs[] = [
            'id' => $row['id'],
            'tendanhmuc' => $row['tendanhmuc'],
            'created_at' => $row['created_at']
        ];
    }
}

echo json_encode($danhmucs, JSON_UNESCAPED_UNICODE);
?>

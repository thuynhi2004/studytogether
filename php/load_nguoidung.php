<?php
include 'connect.php'; 

$sql = "SELECT id, hoten, email, sdt, created_at FROM users WHERE role = 'khachhang'";
$result = $conn->query($sql);

$users = [];
while ($row = $result->fetch_assoc()) {
    $users[] = $row;
}

echo json_encode($users);
?>

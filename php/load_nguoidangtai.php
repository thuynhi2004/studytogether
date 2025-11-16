<?php
include "connect.php";

$sql = "SELECT id, hoten, email, sdt, created_at 
        FROM users 
        WHERE role = 'nguoitinhphi'";

$result = $conn->query($sql);

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode($data);
?>

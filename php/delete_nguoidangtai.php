<?php
include "connect.php";

if (!isset($_POST['id'])) {
    echo "error";
    exit;
}

$id = intval($_POST['id']);

// Xóa tài khoản khỏi database
$sql = "DELETE FROM users WHERE id = $id";

if ($conn->query($sql)) {
    echo "success";
} else {
    echo "error";
}
?>

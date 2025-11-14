<?php
include 'connect.php';

$id = $_POST['id'] ?? 0;

if ($id > 0) {
    $conn->query("UPDATE tailieu SET luotxem = luotxem + 1 WHERE id = $id");
    echo json_encode(["status" => "ok"]);
} else {
    echo json_encode(["status" => "error"]);
}
?>

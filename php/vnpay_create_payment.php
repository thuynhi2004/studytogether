<?php
session_start();
include "connect.php";

// Lấy ID tài liệu
$id = $_GET['id'] ?? 0;

// Lấy thông tin tài liệu
$stmt = $conn->prepare("SELECT tentailieu, phi FROM tailieu WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$row = $stmt->get_result()->fetch_assoc();

if (!$row) {
    die("Tài liệu không tồn tại.");
}

// Load cấu hình VNPAY
$vnp_TmnCode = "L0T06460"; // Mã website VNPAY (cung cấp bởi VNPAY)
$vnp_HashSecret = "I5IETICLMNY1VSS2E1ZV3SAENLRV5CRX"; // Chuỗi bí mật (do VNPAY cấp)
$vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html"; // Đường dẫn cổng test
$vnp_apiUrl = "http://sandbox.vnpayment.vn/merchant_webapi/merchant.html";
$vnp_Returnurl = "http://localhost:8088/studytogether/php/vnpay_return.php"; // URL sau khi thanh toán xong


$amount = $row['phi'] * 100; // VNPAY tính bằng đơn vị nhỏ (100 VND)
$transactionRef = rand(100000, 999999);
$orderInfo = "Thanh toán tài liệu: " . $row['tentailieu'];

$inputData = [
    "vnp_Version" => "2.1.0",
    "vnp_TmnCode" => $vnp_TmnCode,
    "vnp_Amount" => $amount,
    "vnp_Command" => "pay",
    "vnp_CreateDate" => date('YmdHis'),
    "vnp_CurrCode" => "VND",
    "vnp_IpAddr" => $_SERVER['REMOTE_ADDR'],
    "vnp_Locale" => "vn",
    "vnp_OrderInfo" => $orderInfo,
    "vnp_OrderType" => "other",
    "vnp_ReturnUrl" => $vnp_Returnurl,
    "vnp_TxnRef" => $transactionRef,
];

// Sắp xếp key để tạo hash
ksort($inputData);
$query = "";
$i = 0;
$hashData = "";
foreach ($inputData as $key => $value) {
    if ($i == 1) {
        $hashData .= '&' . $key . "=" . $value;
    } else {
        $hashData .= $key . "=" . $value;
        $i = 1;
    }
    $query .= urlencode($key) . '=' . urlencode($value) . '&';
}
$vnp_Url = $vnp_Url . "?" . $query . "vnp_SecureHash=" . hash_hmac('sha512', $hashData, $vnp_HashSecret);

// Redirect người dùng tới VNPAY
header("Location: $vnp_Url");
exit;

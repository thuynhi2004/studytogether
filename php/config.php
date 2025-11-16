<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');
  
// Load cấu hình VNPAY
$vnp_TmnCode = "L0T06460"; // Mã website VNPAY (cung cấp bởi VNPAY)
$vnp_HashSecret = "I5IETICLMNY1VSS2E1ZV3SAENLRV5CRX"; // Chuỗi bí mật (do VNPAY cấp)
$vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html"; // Đường dẫn cổng test
$vnp_apiUrl = "http://sandbox.vnpayment.vn/tryitnow/Home/CreateOrder";
$vnp_Returnurl = "http://localhost:8088/studytogether/php/vnpay_return.php"; // URL sau khi thanh toán xong

//Config input format
//Expire
$startTime = date("YmdHis");
$expire = date('YmdHis',strtotime('+15 minutes',strtotime($startTime)));

<?php
session_start();
include "connect.php";

$id = $_GET['id'] ?? 0;

// Kiểm tra login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php?redirect=thanhtoan.php?id=$id");
    exit;
}

$userId = $_SESSION['user_id'];

// Lấy thông tin user
$user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE id = $userId"));

// Lấy thông tin tài liệu + danh mục
$sql = "SELECT t.*, d.tendanhmuc 
        FROM tailieu t
        LEFT JOIN danhmuc d ON t.danhmucid = d.id
        WHERE t.id = $id";

$doc = mysqli_fetch_assoc(mysqli_query($conn, $sql));

if (!$doc) {
    die("<h2>❌ Không tìm thấy tài liệu</h2>");
}

// Lấy giá từ database
$phi = $doc['phi'];

// Tạo mã thanh toán
$motaThanhToan = "TTTaiLieu" . time() . $userId;
?>
<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Thanh toán tài liệu</title>
<style>
    body {
        background: #f5f6f8;
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 30px;
    }
    .container {
        display: flex;
        gap: 25px;
        max-width: 1200px;
        margin: auto;
    }
    .box {
        background: white;
        padding: 25px;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        flex: 1;
    }
    .title {
        font-size: 20px;
        font-weight: bold;
        margin-bottom: 15px;
    }
    .info p {
        margin: 3px 0;
    }
    .qr-box {
        text-align: center;
        padding: 20px;
        border: 1px solid #ddd;
        border-radius: 10px;
        margin-top: 10px;
    }
    .qr-box img {
        margin-bottom: 12px;
    }
    .doc-card {
        border: 1px solid #ddd;
        padding: 15px;
        border-radius: 10px;
        display: flex;
        gap: 15px;
    }
    .doc-cover {
        width: 90px;
        height: 120px;
        border-radius: 8px;
        background-size: cover;
        background-position: center;
        border: 1px solid #ddd;
    }
    .pay-btn {
        display: inline-block;
        margin-top: 20px;
        background: #1a73e8;
        color: white;
        padding: 12px 20px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: bold;
    }
    .price {
        text-align: right;
        font-size: 18px;
        font-weight: bold;
        margin-top: 20px;
    }

    .qr-wrapper {
        width: 260px;
        margin: 0 auto;
        position: relative;
    }
    .qr {
        width: 240px;
        height: 240px;
        object-fit: contain;
    }
</style>
</head>
<body>

<div class="container">

    <!-- BOX: THÔNG TIN KHÁCH HÀNG -->
    <div class="box">
        <div class="title">Thông tin khách hàng</div>
        <div class="info">
            <p><b>Email:</b> <?= $user['email'] ?></p>
            <p><b>Số điện thoại:</b> <?= $user['sdt'] ?></p>
            <p><b>Phương thức:</b> Vietcombank</p>
            <p><b>Trạng thái:</b> <span style="color:red;">Chưa thanh toán</span></p>
        </div>

        <h3 style="margin-top:20px;">Chuyển tiền bằng tài khoản ngân hàng</h3>

        <div class="qr-box">
            <p><b>Nội dung chuyển khoản:</b><br>
            <span style="color:red;font-size:18px;"><?= $motaThanhToan ?></span></p>

            <div class="qr-wrapper">
                <img 
                    src="https://img.vietqr.io/image/VCB-1031420085-compact.png?amount=<?= $phi ?>&addInfo=<?= urlencode($motaThanhToan) ?>" 
                    class="qr">
            </div>

            <p><b>Ngân hàng:</b> Vietcombank<br>
            <b>STK:</b> 1031420085<br>
            <b>Tên tài khoản:</b> HO NHU HUYNH<br>
            <b>Số tiền:</b> <?= number_format($phi) ?> VND
            </p>
        </div>

        <a href="xacnhan_thanhtoan.php?id=<?= $id ?>&code=<?= $motaThanhToan ?>" class="pay-btn">✔ Tôi đã chuyển khoản</a>
        <a href="chitiet_tailieu.php?id=<?= $id ?>" class="pay-btn">Quay lại</a>
    </div>


    <!-- BOX: THÔNG TIN TÀI LIỆU -->
    <div class="box">
        <div class="title">Thông tin tài liệu</div>

        <div class="doc-card">
            <div class="doc-cover" style="background-image:url('uploads/<?= $doc['trangbia'] ?>')"></div>

            <div>
                <h3 style="margin:0;"><?= $doc['tentailieu'] ?></h3>
                <p style="margin:3px 0;">Danh mục: <b><?= $doc['tendanhmuc'] ?></b></p>

                <p style="margin:5px 0; opacity:0.7;">
                    👁 <?= $doc['luotxem'] ?>  
                    ⬇ <?= $doc['luottaixuong'] ?>  
                    ⭐ <?= number_format($doc['danhgia'],1) ?>
                </p>
            </div>
        </div>

        <div class="price">
            Thanh toán: <?= number_format($phi) ?> VND
        </div>
    </div>

</div>

</body>
</html>

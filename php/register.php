<?php
// Kết nối database
$server = "localhost";
$user = "root";
$pass = ""; // nếu XAMPP không có mật khẩu
$db = "doan4"; // ⚠️ đổi tên theo database của Huỳnh

$conn = new mysqli($server, $user, $pass, $db);
$conn->set_charset("utf8");

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Nhận dữ liệu từ form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $hoten = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $sdt = trim($_POST["phone"]);
    $matkhau = trim($_POST["password"]);
    $xacnhan = trim($_POST["confirm_password"]);
    $role = isset($_POST["role"]) ? $_POST["role"] : "khachhang"; // ✅ đổi từ quyen → role

    // Kiểm tra mật khẩu trùng khớp
    if ($matkhau !== $xacnhan) {
        echo "<script>alert('Mật khẩu xác nhận không khớp!'); window.history.back();</script>";
        exit;
    }

    // Nếu email là admin@gmail.com thì role = 'admin'
    if ($email === 'studytogether@gmail.com') {
        $role = 'admin';
    }

    // Kiểm tra email đã tồn tại
    $checkEmail = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $checkEmail->bind_param("s", $email);
    $checkEmail->execute();
    $checkEmail->store_result();

    if ($checkEmail->num_rows > 0) {
        echo "<script>alert('Email đã tồn tại! Vui lòng dùng email khác.'); window.history.back();</script>";
        exit;
    }

    // Mã hóa mật khẩu
    $hashedPassword = password_hash($matkhau, PASSWORD_DEFAULT);

    // Thêm vào database (có cột role)
    $sql = "INSERT INTO users (hoten, email, sdt, matkhau, role, created_at) VALUES (?, ?, ?, ?, ?, NOW())";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Lỗi prepare: " . $conn->error); // in lỗi SQL nếu có
    }

    $stmt->bind_param("sssss", $hoten, $email, $sdt, $hashedPassword, $role);

    if ($stmt->execute()) {
        echo "<script>alert('Đăng ký thành công!'); window.location='dkdn.php';</script>";
    } else {
        echo "Lỗi khi đăng ký: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>

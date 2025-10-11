<?php
session_start();
include 'connect.php'; // Kết nối database

// Đặt múi giờ PHP và MySQL
date_default_timezone_set('Asia/Ho_Chi_Minh');
$conn->query("SET time_zone = '+07:00'");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);

    // Kiểm tra định dạng email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error_message'] = 'Vui lòng nhập địa chỉ email hợp lệ.';
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit();
    }

    // Kiểm tra email có tồn tại trong DB
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    if (!$stmt) {
        die("Lỗi prepare SQL: " . $conn->error);
    }

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
    // ✅ Tạo token ngẫu nhiên và lưu vào DB
    $token = bin2hex(random_bytes(32));
    $expire = date("Y-m-d H:i:s", strtotime("+15 minutes"));

    $update = $conn->prepare("UPDATE users SET reset_token = ?, token_expire = ? WHERE email = ?");
    $update->bind_param("sss", $token, $expire, $email);
    $update->execute();

    // ✅ Thoát ra HTML hiển thị loading
    ?>
    <div id="loading-screen" style="
        display:flex;
        justify-content:center;
        align-items:center;
        height:100vh;
        background:#f9f9f9;
        font-family:sans-serif;
        font-size:18px;
        color:#333;
        flex-direction:column;
    ">
        <img src="../img/loading.png" width="150" height="150" alt="Loading"><br>
         <p style="
        font-size:25px;
        font-weight:600;
        letter-spacing:0.5px;
    ">
        Đang kiểm tra email của bạn...
    </p>
    </div>

    <script>
        setTimeout(() => {
            window.location.href = "datlaimatkhau.php?token=<?= $token ?>";
        }, 2500);
    </script>
    <?php
    exit();
}

}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quên Mật Khẩu - StudyTogether</title>
    <link rel="stylesheet" href="../css/quenmatkhau.css">
</head>
<body>
    <div class="container">
        <div class="left-panel">
            <div class="logo">
                <div class="logo-icon">🎓</div>
                <div class="logo-text">StudyTogether</div>
            </div>

            <h1>Đừng lo lắng!</h1>
            <p>Chúng tôi sẽ giúp bạn khôi phục mật khẩu và quay lại học tập ngay lập tức.</p>

            <div class="features">
                <div class="feature-item">
                    <div class="feature-icon">🔒</div>
                    <div>Bảo mật tuyệt đối</div>
                </div>
                <div class="feature-item">
                    <div class="feature-icon">⚡</div>
                    <div>Khôi phục nhanh chóng</div>
                </div>
                <div class="feature-item">
                    <div class="feature-icon">📧</div>
                    <div>Gửi qua email</div>
                </div>
            </div>
        </div>

        <div class="right-panel">
            <div class="form-container">
                <h2>Quên mật khẩu?</h2>
                <p class="subtitle">Nhập email của bạn để nhận liên kết đặt lại mật khẩu</p>

                <?php
                if (isset($_SESSION['error_message'])) {
                    echo '<div class="alert alert-error">' . $_SESSION['error_message'] . '</div>';
                    unset($_SESSION['error_message']);
                }
                ?>

                <form method="POST" action="">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <div class="input-wrapper">
                            <span class="input-icon">📧</span>
                            <input type="email" id="email" name="email" placeholder="your@gmail.com" required>
                        </div>
                    </div>

                    <button type="submit" class="submit-btn">
                        Gửi liên kết đặt lại
                    </button>
                </form>
                
                

                <div class="back-to-login">
                    Nhớ mật khẩu? <a href="dkdn.php">Đăng nhập ngay</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

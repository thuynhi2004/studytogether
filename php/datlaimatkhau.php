<?php
session_start();
include "connect.php";

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Kiểm tra token hợp lệ và còn hạn
    $stmt = $conn->prepare("SELECT * FROM users WHERE reset_token = ? AND token_expire > NOW()");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        die("❌ Liên kết đặt lại mật khẩu không hợp lệ hoặc đã hết hạn!");
    }

    // Nếu người dùng gửi mật khẩu mới
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $new_password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];

        if ($new_password !== $confirm_password) {
            $_SESSION['error_message'] = "⚠️ Mật khẩu xác nhận không khớp!";
        } elseif (strlen($new_password) < 6) {
            $_SESSION['error_message'] = "⚠️ Mật khẩu phải có ít nhất 6 ký tự!";
        } else {
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

            // Cập nhật mật khẩu mới và xóa token
            $update = $conn->prepare("UPDATE users SET matkhau = ?, reset_token = NULL, token_expire = NULL WHERE reset_token = ?");
            $update->bind_param("ss", $hashed_password, $token);
            $update->execute();

            $_SESSION['success_message'] = "✅ Đặt lại mật khẩu thành công! Bạn có thể đăng nhập lại.";
            header("Location: dkdn.php");
            exit;
        }
    }
} else {
    die("❌ Không có token hợp lệ trong liên kết.");
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đặt Lại Mật Khẩu - StudyTogether</title>
    <style>
        /* --- GIỮ NGUYÊN TOÀN BỘ CSS BẠN ĐÃ GỬI --- */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .container { display: flex; max-width: 1000px; width: 100%; background: white; border-radius: 24px; overflow: hidden; box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3); }
        .left-panel { flex: 1; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 60px 40px; color: white; display: flex; flex-direction: column; }
        .logo { display: flex; align-items: center; gap: 12px; margin-bottom: 40px; }
        .logo-icon { width: 48px; height: 48px; background: white; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 24px; }
        .logo-text { font-size: 24px; font-weight: 700; }
        .left-panel h1 { font-size: 32px; font-weight: 700; margin-bottom: 16px; }
        .left-panel p { font-size: 16px; line-height: 1.6; opacity: 0.95; margin-bottom: 40px; }
        .feature { display: flex; align-items: center; gap: 16px; padding: 20px; background: rgba(255, 255, 255, 0.1); border-radius: 12px; margin-bottom: 16px; backdrop-filter: blur(10px); transition: all 0.3s ease; }
        .feature:hover { background: rgba(255, 255, 255, 0.15); transform: translateX(5px); }
        .feature-icon { width: 40px; height: 40px; background: rgba(255, 255, 255, 0.2); border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 20px; }
        .feature-text { font-size: 16px; font-weight: 500; }
        .right-panel { flex: 1; padding: 60px 50px; background: #faf8f6; }
        .right-panel h2 { font-size: 28px; font-weight: 700; color: #1a1a1a; margin-bottom: 12px; }
        .subtitle { font-size: 15px; color: #666; margin-bottom: 32px; line-height: 1.5; }
        .form-group { margin-bottom: 24px; }
        label { display: block; font-size: 14px; font-weight: 600; color: #333; margin-bottom: 8px; }
        .input-wrapper { position: relative; }
        .input-icon { position: absolute; left: 16px; top: 50%; transform: translateY(-50%); color: #667eea; font-size: 18px; }
        input { width: 100%; padding: 14px 16px 14px 45px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 15px; transition: all 0.3s ease; background: white; }
        input:focus { outline: none; border-color: #667eea; box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1); }
        .password-requirements { margin-top: 12px; padding: 12px; background: #f0f0f0; border-radius: 8px; font-size: 13px; color: #666; }
        .password-requirements ul { list-style: none; margin-top: 8px; }
        .password-requirements li { padding: 4px 0; padding-left: 20px; position: relative; }
        .password-requirements li:before { content: "•"; position: absolute; left: 8px; color: #667eea; }
        .submit-btn { width: 100%; padding: 16px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; border-radius: 10px; font-size: 16px; font-weight: 600; cursor: pointer; transition: all 0.3s ease; margin-top: 8px; }
        .submit-btn:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(102, 126, 234, 0.4); }
        .back-link { text-align: center; margin-top: 20px; font-size: 14px; color: #666; }
        .back-link a { color: #667eea; text-decoration: none; font-weight: 600; }
        .back-link a:hover { text-decoration: underline; }
        @media (max-width: 768px) { .container { flex-direction: column; } .left-panel { padding: 40px 30px; } .right-panel { padding: 40px 30px; } .left-panel h1, .right-panel h2 { font-size: 24px; } }
        .alert { padding: 12px; margin-bottom: 20px; border-radius: 10px; font-size: 14px; }
        .alert-success { background: #e6ffed; color: #0f5132; border: 1px solid #badbcc; }
        .alert-error { background: #fdecea; color: #842029; border: 1px solid #f5c2c7; }
    </style>
</head>
<body>
    <div class="container">
        <div class="left-panel">
            <div class="logo">
                <div class="logo-icon">🎓</div>
                <div class="logo-text">StudyTogether</div>
            </div>

            <h1>Đặt lại mật khẩu</h1>
            <p>Tạo mật khẩu mới để bảo mật tài khoản của bạn và tiếp tục học tập.</p>

            <div class="feature"><div class="feature-icon">🔒</div><div class="feature-text">Bảo mật tuyệt đối</div></div>
            <div class="feature"><div class="feature-icon">⚡</div><div class="feature-text">Khôi phục nhanh chóng</div></div>
            <div class="feature"><div class="feature-icon">✉️</div><div class="feature-text">Xác nhận qua email</div></div>
        </div>

        <div class="right-panel">
            <h2>Tạo mật khẩu mới</h2>
            <p class="subtitle">Mật khẩu mới của bạn phải khác với mật khẩu đã sử dụng trước đó</p>

            <?php
            if (isset($_SESSION['error_message'])) {
                echo '<div class="alert alert-error">' . $_SESSION['error_message'] . '</div>';
                unset($_SESSION['error_message']);
            }
            ?>

            <form method="POST">
                <div class="form-group">
                    <label>Mật khẩu mới</label>
                    <div class="input-wrapper">
                        <span class="input-icon">🔒</span>
                        <input type="password" name="password" placeholder="Nhập mật khẩu mới" required>
                    </div>
                </div>

                <div class="form-group">
                    <label>Xác nhận mật khẩu</label>
                    <div class="input-wrapper">
                        <span class="input-icon">🔒</span>
                        <input type="password" name="confirm_password" placeholder="Nhập lại mật khẩu mới" required>
                    </div>
                    <div class="password-requirements">
                        <strong>Yêu cầu mật khẩu:</strong>
                        <ul><li>Ít nhất 6 ký tự</li></ul>
                    </div>
                </div>

                <button type="submit" class="submit-btn">Đặt lại mật khẩu</button>

                <div class="back-link">
                    <a href="dkdn.php">← Quay lại đăng nhập</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>

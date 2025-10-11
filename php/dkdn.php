<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StudyTogether - Đăng nhập & Đăng ký</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
<style>

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            position: relative;
            overflow: hidden;
        }

        /* Animated background */
        .bg-animation {
            position: absolute;
            width: 100%;
            height: 100%;
            overflow: hidden;
        }

        .floating-shape {
            position: absolute;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            animation: float 20s infinite ease-in-out;
        }

        .shape1 {
            width: 300px;
            height: 300px;
            top: 10%;
            left: 10%;
            animation-delay: 0s;
        }

        .shape2 {
            width: 200px;
            height: 200px;
            bottom: 20%;
            right: 15%;
            animation-delay: 3s;
        }

        .shape3 {
            width: 150px;
            height: 150px;
            top: 50%;
            left: 70%;
            animation-delay: 6s;
        }

        @keyframes float {
            0%, 100% {
                transform: translate(0, 0) scale(1);
            }
            33% {
                transform: translate(30px, -30px) scale(1.1);
            }
            66% {
                transform: translate(-20px, 20px) scale(0.9);
            }
        }

        /* Container */
        .auth-container {
            position: relative;
            width: 100%;
            max-width: 1000px;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 30px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            display: flex;
            min-height: 600px;
        }

        /* Left Panel - Info */
        .info-panel {
            flex: 1;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 60px 40px;
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .info-panel::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            animation: rotate 30s linear infinite;
        }

        @keyframes rotate {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .logo {
            font-size: 2.5em;
            font-weight: bold;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 15px;
            position: relative;
            z-index: 1;
        }

        .logo i {
            background: white;
            color: #667eea;
            padding: 15px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }

        .info-content {
            position: relative;
            z-index: 1;
        }

        .info-content h2 {
            font-size: 2em;
            margin-bottom: 20px;
            line-height: 1.2;
        }

        .info-content p {
            font-size: 1.1em;
            line-height: 1.6;
            opacity: 0.9;
            margin-bottom: 30px;
        }

        .features {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .feature-item {
            display: flex;
            align-items: center;
            gap: 15px;
            background: rgba(255, 255, 255, 0.1);
            padding: 15px;
            border-radius: 15px;
            backdrop-filter: blur(5px);
            transition: transform 0.3s ease;
        }

        .feature-item:hover {
            transform: translateX(10px);
        }

        .feature-item i {
            font-size: 1.5em;
            width: 40px;
            text-align: center;
        }

        /* Right Panel - Form */
        .form-panel {
            flex: 1;
            padding: 60px 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .form-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .form-header h2 {
            color: #030409ff;
            font-size: 2em;
            margin-bottom: 10px;
        }

        .form-header p {
            color: #666;
            font-size: 0.95em;
        }

        .form-tabs {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-bottom: 30px;
        }

        .tab-btn {
            background: none;
            border: none;
            color: #999;
            font-size: 1.1em;
            padding: 10px 30px;
            cursor: pointer;
            position: relative;
            transition: all 0.3s ease;
            font-weight: 600;
        }

        .tab-btn.active {
            color: #667eea;
        }

        .tab-btn::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%) scaleX(0);
            width: 80%;
            height: 3px;
            background: linear-gradient(90deg, #667eea, #764ba2);
            border-radius: 2px;
            transition: transform 0.3s ease;
        }

        .tab-btn.active::after {
            transform: translateX(-50%) scaleX(1);
        }

        .form-content {
            display: none;
        }

        .form-content.active {
            display: block;
            animation: fadeIn 0.5s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .input-group {
            margin-bottom: 25px;
            position: relative;
        }

        .input-group label {
            display: block;
            color: #0c0101ff;
            font-weight: 600;
            margin-bottom: 8px;
            font-size: 0.9em;
        }

        .input-wrapper {
            position: relative;
        }

        .input-wrapper i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #999;
            font-size: 1.1em;
        }

        .input-group input {
            width: 100%;
            padding: 15px 15px 15px 45px;
            border: 2px solid #e0e0e0;
            border-radius: 12px;
            font-size: 1em;
            transition: all 0.3s ease;
            background: #f8f9fa;
        }

        .input-group input:focus {
            outline: none;
            border-color: #667eea;
            background: white;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
        }

        .toggle-password {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #999;
            transition: color 0.3s ease;
            z-index: 1;
        }

        .toggle-password:hover {
            color: #667eea;
        }
        
        .input-group input[type="password"],
        .input-group input[type="text"].password-input {
            padding-left: 45px;
            padding-right: 15px;
        }

        .forgot-password {
            text-align: right;
            margin-top: -15px;
            margin-bottom: 25px;
        }

        .forgot-password a {
            color: #0d38f9ff;
            text-decoration: none;
            font-size: 0.9em;
            transition: color 0.3s ease;
        }

        .forgot-password a:hover {
             text-decoration: underline;
        }

        .submit-btn {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 12px;
            color: white;
            font-size: 1.1em;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
        }

        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 7px 20px rgba(102, 126, 234, 0.4);
        }

        .submit-btn:active {
            transform: translateY(0);
        }

        .divider {
            text-align: center;
            margin: 30px 0;
            position: relative;
        }

        .divider::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            width: 100%;
            height: 1px;
            background: #e0e0e0;
        }

        .divider span {
            background: white;
            padding: 0 15px;
            color: #999;
            font-size: 0.9em;
            position: relative;
            z-index: 1;
        }

        .social-login {
            display: flex;
            gap: 15px;
            justify-content: center;
        }

        .social-btn {
            flex: 1;
            padding: 12px;
            border: 2px solid #e0e0e0;
            border-radius: 12px;
            background: white;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            font-weight: 600;
        }

        .social-btn:hover {
            border-color: #667eea;
            background: #f8f9fa;
            transform: translateY(-2px);
        }

        .social-btn i {
            font-size: 1.2em;
        }

        .google { color: #DB4437; }
        .facebook { color: #4267B2; }

        /* Responsive */
        @media (max-width: 768px) {
            .auth-container {
                flex-direction: column;
            }

            .info-panel {
                padding: 40px 30px;
                min-height: auto;
            }

            .form-panel {
                padding: 40px 30px;
            }

            .logo {
                font-size: 2em;
            }

            .info-content h2 {
                font-size: 1.5em;
            }
        }

        /* loai khách hàng */

        /* Khối chứa nhóm lựa chọn */
    .role-group {
  display: flex;
  justify-content: space-between; /* Cách đều hai bên */
  align-items: center;
  margin-top: 5px;
  margin-bottom: 20px;
  }

  /* Ẩn nút radio gốc */
 .role-option input[type="radio"] {
  display: none;
 }

 /* Nhãn hiển thị như nút */
 .role-label {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 5px;
  padding: 10px 16px;
  border: 2px solid #d0d0d0;
  border-radius: 8px;
  cursor: pointer;
  font-weight: 500;
  background-color: #fff;
  color: #333;
  transition: all 0.3s ease;
  min-width: 150px; /* Giúp nút cân đối hơn */
  text-align: center;
 }

  /* Khi rê chuột */
 .role-label:hover {
  border-color: #7b7ce6;
  background-color: #f3f4ff;
 }

 /* Khi được chọn */
 .role-option input[type="radio"]:checked + .role-label {
  background-color: #6574ff;
  color: #fff;
  border-color: #6574ff;
  box-shadow: 0 2px 6px rgba(101, 116, 255, 0.3);
 }

</style>


</head>
<body>
    <!-- Background Animation -->
    <div class="bg-animation">
        <div class="floating-shape shape1"></div>
        <div class="floating-shape shape2"></div>
        <div class="floating-shape shape3"></div>
    </div>

    <!-- Auth Container -->
    <div class="auth-container">
        <!-- Left Panel - Info -->
        <div class="info-panel">
            <div class="logo">
                <i class="fas fa-graduation-cap"></i>
                <span>StudyTogether</span>
            </div>
            
            <div class="info-content">
                <h2>Cùng nhau học tập hiệu quả hơn!</h2>
                <p>Tham gia cộng đồng học tập năng động, kết nối với bạn bè và đạt được mục tiêu học tập của bạn.</p>
                
                <div class="features">
                    <div class="feature-item">
                        <i class="fas fa-users"></i>
                        <span>Học nhóm trực tuyến</span>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-book"></i>
                        <span>Tài liệu chia sẻ</span>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-calendar-check"></i>
                        <span>Quản lý lịch học</span>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-trophy"></i>
                        <span>Theo dõi tiến độ</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Panel - Form -->
        <div class="form-panel">
            <div class="form-header">
                <h2>Chào mừng trở lại!</h2>
                <p>Tiếp tục hành trình học tập của bạn</p>
            </div>

            <!-- Form Tabs -->
            <div class="form-tabs">
                <button class="tab-btn active" onclick="switchTab('login')">Đăng nhập</button>
                <button class="tab-btn" onclick="switchTab('register')">Đăng ký</button>
            </div>

            <!-- Login Form -->
            <div id="login-form" class="form-content active">
                <form action="login.php" method="POST">
                    <div class="input-group">
                        <label for="login-email">Email</label>
                        <div class="input-wrapper">
                            <i class="fas fa-envelope"></i>
                            <input type="email" id="login-email" name="email" placeholder="your@email.com" required>
                        </div>
                    </div>

                    <div class="input-group">
                        <label for="login-password">Mật khẩu</label>
                        <div class="input-wrapper">
                            <i class="fas fa-eye toggle-password" onclick="togglePassword('login-password')"></i>
                            <input type="password" id="login-password" name="password" placeholder="Nhập mật khẩu" required>
                        </div>
                    </div>

                 <div class="forgot-password">
                    <a href="quenmatkhau.php">Quên mật khẩu?</a>
                 </div>


                    <button type="submit" class="submit-btn">
                        <i class="fas fa-sign-in-alt"></i> Đăng nhập
                    </button>
                </form>

                <div class="divider">
                    <span>hoặc đăng nhập với</span>
                </div>

                <div class="social-login">
                    <button class="social-btn">
                        <i class="fab fa-google google"></i>
                        <span>Google</span>
                    </button>
                    <button class="social-btn">
                        <i class="fab fa-facebook facebook"></i>
                        <span>Facebook</span>
                    </button>
                </div>
            </div>

            <!-- Register Form -->
          <div id="register-form" class="form-content">
    <form action="register.php" method="POST">
        <div class="input-group">
            <label for="register-name">Họ và tên</label>
            <div class="input-wrapper">
                <i class="fas fa-user"></i>
                <input type="text" id="register-name" name="name" placeholder="Nguyễn Văn A" required>
            </div>
        </div>

        <div class="input-group">
            <label for="register-email">Email</label>
            <div class="input-wrapper">
                <i class="fas fa-envelope"></i>
                <input type="email" id="register-email" name="email" placeholder="your@email.com" required>
            </div>
        </div>

        <div class="input-group">
            <label for="register-phone">Số điện thoại</label>
            <div class="input-wrapper">
                <i class="fas fa-phone"></i>
                <input type="tel" id="register-phone" name="phone" placeholder="0123456789" pattern="[0-9]{10}" required>
            </div>
        </div>

        <div class="input-group">
            <label for="register-password">Mật khẩu</label>
            <div class="input-wrapper">
                <i class="fas fa-eye toggle-password" onclick="togglePassword('register-password')"></i>
                <input type="password" id="register-password" name="password" placeholder="Tạo mật khẩu" required>
            </div>
        </div>

        <div class="input-group">
            <label for="register-confirm">Xác nhận mật khẩu</label>
            <div class="input-wrapper">
                <i class="fas fa-eye toggle-password" onclick="togglePassword('register-confirm')"></i>
                <input type="password" id="register-confirm" name="confirm_password" placeholder="Nhập lại mật khẩu" required>
            </div>
        </div>

        <div class="form-group">
    <label>Loại Tài Khoản *</label>
    <div class="role-group">
    <div class="role-option">
        <input type="radio" id="khach_hang" name="role" value="khachhang" required>
        <label for="khach_hang" class="role-label">
            👤 Khách Hàng
        </label>
    </div>
    <div class="role-option">
        <input type="radio" id="nguoi_tinh_phi" name="role" value="nguoitinhphi">
        <label for="nguoi_tinh_phi" class="role-label">
            💼 Người Tính Phí
        </label>
    </div>
</div>

</div>


        <button type="submit" class="submit-btn">
            <i class="fas fa-user-plus"></i> Đăng ký
        </button>
    </form>
</div>

        </div>
    </div>

    <script>
        function switchTab(tab) {
            const tabs = document.querySelectorAll('.tab-btn');
            const forms = document.querySelectorAll('.form-content');
            
            tabs.forEach(t => t.classList.remove('active'));
            forms.forEach(f => f.classList.remove('active'));
            
            if (tab === 'login') {
                tabs[0].classList.add('active');
                document.getElementById('login-form').classList.add('active');
            } else {
                tabs[1].classList.add('active');
                document.getElementById('register-form').classList.add('active');
            }
        }

        function togglePassword(inputId) {
            const input = document.getElementById(inputId);
            const icon = input.previousElementSibling;
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    </script>
</body>
</html>
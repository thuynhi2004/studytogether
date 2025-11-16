<?php 

include 'connect.php';
 
session_start(); 

// Lấy ID danh mục từ URL
$danhmuc_id = isset($_GET['danhmuc']) ? intval($_GET['danhmuc']) : 0;

// Lấy tên danh mục từ database
$tendanhmuc = "Không xác định";
if ($danhmuc_id > 0) {
    $sql_dm = "SELECT tendanhmuc FROM danhmuc WHERE id = ?";
    $stmt = $conn->prepare($sql_dm);
    $stmt->bind_param("i", $danhmuc_id);
    $stmt->execute();
    $stmt->bind_result($tendanhmuc);
    if (!$stmt->fetch()) $tendanhmuc = "Không xác định";
    $stmt->close();
}
?>


<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Danh mục tài liệu</title>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="../css/index.css">
</head>

<body>

<header>
  <div class="logo" id="logo" style="cursor: pointer;">🎓StudyTogether</div>
  <nav>
    <div class="menu-item">
      <a href="#">Danh mục ▾</a>

      <!-- 🔽 Mega Menu -->
      <div class="mega-menu">
        <div class="mega-column">
          <h4>Khoa học Nghiên cứu</h4>
         <li><a href="danhmuc.php?danhmuc=1" class="<?= ($_GET['danhmuc'] ?? '') == 1 ? 'active' : '' ?>">Toán học</a></li>
          <li><a href="danhmuc.php?danhmuc=2" class="<?= ($_GET['danhmuc'] ?? '') == 2 ? 'active' : '' ?>">Khoa học tự nhiên</a></li>
          <li><a href="danhmuc.php?danhmuc=3" class="<?= ($_GET['danhmuc'] ?? '') == 3 ? 'active' : '' ?>">Khoa học xã hội</a></li>
          <li><a href="danhmuc.php?danhmuc=6" class="<?= ($_GET['danhmuc'] ?? '') == 6 ? 'active' : '' ?>">Ngữ văn – Ngôn ngữ học</a></li>
          <li><a href="danhmuc.php?danhmuc=8" class="<?= ($_GET['danhmuc'] ?? '') == 8 ? 'active' : '' ?>">Tâm lý học – Xã hội học</a></li>
        </div>
        <div class="mega-column">
          <h4>Khoa học Ứng dụng </h4>
           <li><a href="danhmuc.php?danhmuc=4" class="<?= ($_GET['danhmuc'] ?? '') == 4 ? 'active' : '' ?>">Ngoại ngữ</a></li>
           <li><a href="danhmuc.php?danhmuc=5" class="<?= ($_GET['danhmuc'] ?? '') == 5 ? 'active' : '' ?>">Công nghệ thông tin / Lập trình</a></li>
           <li><a href="danhmuc.php?danhmuc=7" class="<?= ($_GET['danhmuc'] ?? '') == 7 ? 'active' : '' ?>">Kinh tế – Quản trị – Marketing</a></li>
          
        </div>
        <div class="mega-column">
          <h4>Chuyên mục khác</h4>
           <li><a href="danhmuc.php?danhmuc=11" class="<?= ($_GET['danhmuc'] ?? '') == 11 ? 'active' : '' ?>">Bài giảng & Slide giảng dạy</a></li>
         <li><a href="danhmuc.php?danhmuc=9" class="<?= ($_GET['danhmuc'] ?? '') == 9 ? 'active' : '' ?>">Tài liệu thi – Đề cương ôn tập</a></li>
         <li><a href="danhmuc.php?danhmuc=10" class="<?= ($_GET['danhmuc'] ?? '') == 10 ? 'active' : '' ?>">Tổng hợp kiến thức</a></li>
        </div>
      </div>
    </div>

    <a href="#">🔥 Tài liệu hot ▾</a>
    <a href="#">Về chúng tôi</a>
    <a href="#">Hỗ trợ</a>
    <?php if (isset($_SESSION['user_name'])): ?>

    <?php if ($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'nguoitinhphi'): ?>

        <!-- ADMIN hoặc NGƯỜI TÍNH PHÍ -->
        <div class="user-menu" style="
            display: flex; 
            align-items: center; 
            gap: 12px;
            background: #f3f3f3;
            padding: 6px 12px;
            border-radius: 8px;
        ">
            <span style="font-weight:600; color:black;">
                👤 <?= $_SESSION['user_name']; ?>
            </span>

            <!-- Nút quản trị -->
            <a href="<?=
                ($_SESSION['role'] == 'admin') 
                ? 'admin.php' 
                : 'nguoidangtai.php';
            ?>" 
                style="
                    background:#007bff;
                    color:white;
                    padding:6px 10px;
                    border-radius:6px;
                    text-decoration:none;
                ">
                Quản trị
            </a>

            <a href="logout.php" 
                style="
                    background:#dc3545;
                    color:white;
                    padding:6px 10px;
                    border-radius:6px;
                    text-decoration:none;
                ">
                Đăng xuất
            </a>
        </div>

    <?php else: ?>

        <!-- KHÁCH HÀNG: GIỮ NGUYÊN CODE CŨ -->
        <div class="user-menu" style="
            display: flex; 
            align-items: center; 
            gap: 12px;
            background: #f3f3f3;
            padding: 6px 12px;
            border-radius: 8px;
        ">
            <span style="font-weight:600; color:black;">
                👤 <?= $_SESSION['user_name']; ?>
            </span>

            <a href="logout.php" 
                style="
                    background:#dc3545;
                    color:white;
                    padding:6px 10px;
                    border-radius:6px;
                    text-decoration:none;
                ">
                Đăng xuất
            </a>
        </div>

    <?php endif; ?>

<?php else: ?>

    <!-- Chưa đăng nhập -->
    <a href="dkdn.php" class="btn-get-started">Đăng nhập</a>

<?php endif; ?>
  </nav>
</header>


<div class="container">
  <h1>🎓 Cùng nhau học tập hiệu quả hơn!</h1>
  <p class="subtitle">
    Nơi học sinh và giáo viên chia sẻ, tải về hàng nghìn tài liệu học tập chất lượng cao.
    Miễn phí, dễ dàng và thuận tiện.
  </p>

  <div class="content-wrapper">

    <!-- 🔹 Sidebar -->
    <div class="sidebar">
      <div class="search-container">
        <i class="fa-solid fa-magnifying-glass"></i>
        <input type="text" class="search-box" placeholder="Tìm kiếm...">
      </div>

      <h3>Danh mục chính</h3>
  <ul>
    <li><a href="danhmuc.php?danhmuc=1" class="<?= ($_GET['danhmuc'] ?? '') == 1 ? 'active' : '' ?>">Toán học</a></li>
    <li><a href="danhmuc.php?danhmuc=2" class="<?= ($_GET['danhmuc'] ?? '') == 2 ? 'active' : '' ?>">Khoa học tự nhiên</a></li>
    <li><a href="danhmuc.php?danhmuc=3" class="<?= ($_GET['danhmuc'] ?? '') == 3 ? 'active' : '' ?>">Khoa học xã hội</a></li>
    <li><a href="danhmuc.php?danhmuc=4" class="<?= ($_GET['danhmuc'] ?? '') == 4 ? 'active' : '' ?>">Ngoại ngữ</a></li>
    <li><a href="danhmuc.php?danhmuc=5" class="<?= ($_GET['danhmuc'] ?? '') == 5 ? 'active' : '' ?>">Công nghệ thông tin / Lập trình</a></li>
    <li><a href="danhmuc.php?danhmuc=6" class="<?= ($_GET['danhmuc'] ?? '') == 6 ? 'active' : '' ?>">Ngữ văn – Ngôn ngữ học</a></li>
    <li><a href="danhmuc.php?danhmuc=7" class="<?= ($_GET['danhmuc'] ?? '') == 7 ? 'active' : '' ?>">Kinh tế – Quản trị – Marketing</a></li>
    <li><a href="danhmuc.php?danhmuc=8" class="<?= ($_GET['danhmuc'] ?? '') == 8 ? 'active' : '' ?>">Tâm lý học – Xã hội học</a></li>
  </ul>

  <h3 style="margin-top: 30px;">Chuyên mục khác</h3>
  <ul>
    <li><a href="danhmuc.php?danhmuc=9" class="<?= ($_GET['danhmuc'] ?? '') == 9 ? 'active' : '' ?>">Tài liệu thi – Đề cương ôn tập</a></li>
    <li><a href="danhmuc.php?danhmuc=10" class="<?= ($_GET['danhmuc'] ?? '') == 10 ? 'active' : '' ?>">Tổng hợp kiến thức</a></li>
    <li><a href="danhmuc.php?danhmuc=11" class="<?= ($_GET['danhmuc'] ?? '') == 11 ? 'active' : '' ?>">Bài giảng & Slide giảng dạy</a></li>
  </ul>
    </div>

   <!-- load danh mục -->
<div class="main-content">

  <!-- 🧭 Breadcrumb -->
  <nav class="breadcrumb">
    <a href="index.php">Trang chủ</a>
    <span>›</span>
    <a href="#">Danh mục</a>
    <span>›</span>
    <span class="current"><?= htmlspecialchars($tendanhmuc) ?></span>
  </nav>

  <!-- 🔹 Tiêu đề danh mục -->
  <h2 class="category-title">
    
  </h2>

  <!-- 🔹 Danh sách tài liệu -->
  <div id="list-tailieu" class="cards-container">
    <?php include 'get_tailieu.php'; ?>
  </div>

</div>

    
  </div>
</div>


    <!-- Footer -->
    <footer class="footer">
        <div class="footer-content">
            <div class="footer-section">
                <h3>🎓 StudyTogether</h3>
                <p>Nền tảng chia sẻ tài liệu học tập hàng đầu Việt Nam. Cùng nhau học tập và phát triển!</p>
            </div>
            <div class="footer-section">
                <h3>Liên kết</h3>
                <a href="#" class="footer-link">Về chúng tôi</a>
                <a href="#" class="footer-link">Điều khoản</a>
                <a href="#" class="footer-link">Chính sách</a>
                <a href="#" class="footer-link">Liên hệ</a>
            </div>
            <div class="footer-section">
                <h3>Danh mục</h3>
                <a href="#" class="footer-link">Lập trình</a>
                <a href="#" class="footer-link">Toán học</a>
                <a href="#" class="footer-link">Ngoại ngữ</a>
                <a href="#" class="footer-link">Kinh tế</a>
            </div>
            <div class="footer-section">
                <h3>Theo dõi</h3>
                <a href="#" class="footer-link">Facebook</a>
                <a href="#" class="footer-link">Twitter</a>
                <a href="#" class="footer-link">Instagram</a>
                <a href="#" class="footer-link">YouTube</a>
            </div>
        </div>
        <div class="footer-bottom">
            © 2025 StudyTogether. All rights reserved.
        </div>
    </footer>

    
<script>
document.getElementById('logo').addEventListener('click', function() {
    window.location.href = 'index.php';
});
</script>


</body>
</html>























<?php 
session_start(); 
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StudyTogether</title>
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
    <!--<a href="dkdn.php" class="btn-get-started">Đăng nhập</a>-->
    
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

    <!-- 🔹 Main content -->
    <div class="main-content">
      <div class="category-tabs">
        <div class="category-tab active" data-target="latest">
          <div class="category-icon">📄</div>
          <div class="category-name">Tài liệu mới nhất</div>
        </div>
        <div class="category-tab" data-target="contributors">
          <div class="category-icon">🏆</div>
          <div class="category-name">Người đóng góp xuất sắc</div>
        </div>
        <div class="category-tab" data-target="admin-posts">
          <div class="category-icon">📝</div>
          <div class="category-name">Bài viết của Admin</div>
        </div>
        <div class="category-tab" data-target="chat-ai">
          <div class="category-icon">🤖</div>
          <div class="category-name">IChat - Hỏi đáp với AI</div>
        </div>
      </div>

      <!-- 🔹 Nội dung chính -->
      <div id="latest" class="tab-content active">
        <div class="featured-card">
          <div class="featured-content">
            <div class="handbook-label">StudyTogether</div>
            <h2 class="featured-title">Cập nhật những tài liệu hot nhất trong tuần</h2>
            <p class="featured-description">Nơi bạn tìm thấy giáo trình, bài hướng dẫn và tài liệu hữu ích được cập nhật liên tục.</p>
            <div class="author">
              <div class="author-avatar"></div>
              <span>Lane Shackleton</span>
            </div>
          </div>

          <div class="featured-image">
            <div class="device-mockup"></div>
          </div>

          <a href="#" class="btn-read">Read the handbook</a>
        </div>
        
         <a href="chitiet_tailieu.php?id=<?= $id ?>" 
   class="doc-card-link" 
   data-id="<?= $id ?>">



        <h2 class="section-title">🔥 Tài liệu phổ biến</h2>
        <section class="content">
          <div class="column" id="main-content">
            <div class="cards-container" id="cards-container">
              <?php include 'get_tailieu.php'; ?>
            </div>
          </div>
        </section>
      </div>

      <section id="contributors" class="tab-content">
         <h2>🏆 Danh sách những hành viên đóng góp xuất sắc</h2>
         
         <?php include 'dsnguoidangtai.php'; ?>
      </section>


      <section id="admin-posts" class="tab-content" style="padding:60px 5%; background:#f8f9fa;">
  <h2 style="font-size:36px; font-weight:700; text-align:center; margin-bottom:16px;">📝 Bài viết của Admin</h2>
  <p style="text-align:center; font-size:18px; color:#6b7280; margin-bottom:40px;">Tổng hợp các bài viết, hướng dẫn và cập nhật mới từ Admin để bạn luôn nắm bắt thông tin nhanh nhất.</p>

  <div class="admin-post-list" style="display:flex; flex-wrap:wrap; gap:30px; justify-content:center;">

    <!-- Bài viết 1 -->
    <div class="admin-post-card" style="background:white; border-radius:12px; overflow:hidden; width:350px; box-shadow:0 4px 12px rgba(0,0,0,0.08); transition:transform 0.3s;">
      <img src="images/toeic-vocab.jpg" alt="Vocabulary for TOEIC" style="width:100%; height:200px; object-fit:cover;">
      <div style="padding:20px;">
        <h3 style="font-size:20px; font-weight:600; margin-bottom:10px;">Vocabulary for TOEIC – Bí quyết tăng điểm nhanh</h3>
        <p style="font-size:14px; color:#6b7280; margin-bottom:12px;">15/11/2025</p>
        <p style="font-size:16px; color:#374151; margin-bottom:16px;">Học từ vựng thông minh, nâng điểm Reading & Listening chỉ trong vài tháng với bộ tài liệu TOEIC chất lượng.</p>
        <a href="baiviet1.php" style="display:inline-block; background:#6366f1; color:white; padding:10px 16px; border-radius:6px; font-weight:500; text-decoration:none; transition:background 0.2s;">Xem chi tiết</a>
      </div>
    </div>

    <!-- Bài viết 2 -->
    <div class="admin-post-card" style="background:white; border-radius:12px; overflow:hidden; width:350px; box-shadow:0 4px 12px rgba(0,0,0,0.08); transition:transform 0.3s;">
      <img src="images/admin-update.jpg" alt="Quy định và cập nhật hệ thống" style="width:100%; height:200px; object-fit:cover;">
      <div style="padding:20px;">
        <h3 style="font-size:20px; font-weight:600; margin-bottom:10px;">Quy định, thông báo và cập nhật hệ thống</h3>
        <p style="font-size:14px; color:#6b7280; margin-bottom:12px;">14/11/2025</p>
        <p style="font-size:16px; color:#374151; margin-bottom:16px;">Admin cập nhật các quy định và tính năng mới giúp cộng đồng sử dụng hệ thống hiệu quả và an toàn hơn.</p>
        <a href="baiviet2.php" style="display:inline-block; background:#6366f1; color:white; padding:10px 16px; border-radius:6px; font-weight:500; text-decoration:none; transition:background 0.2s;">Xem chi tiết</a>
      </div>
    </div>

  </div>

</section>

      <section id="chat-ai" class="tab-content">
        <h2>🤖 IChat - Hỏi đáp với AI</h2>
        <p>Trò chuyện với AI để được hỗ trợ và giải đáp thắc mắc nhanh nhất.</p>
      </section>
      
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
function hienThiChiTietTaiLieu(id) {
    // Gửi yêu cầu lấy chi tiết tài liệu
    fetch('chitiet_tailieu.php?id=' + id)
        .then(res => res.text())
        .then(html => {
            document.getElementById('main-content').innerHTML = html;
        })
        .catch(err => {
            console.error(err);
            document.getElementById('main-content').innerHTML = '<p>Lỗi tải chi tiết tài liệu.</p>';
        });

    // Gọi API tăng lượt xem
    fetch('update_luotxem.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: 'id=' + encodeURIComponent(id)
    })
    .then(res => res.json())
    .then(data => console.log('Lượt xem +1'))
    .catch(err => console.error(err));
}

function tangLuotTai(id, tenfile) {
    // Gọi API tăng lượt tải
    fetch('update_luottaixuong.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: 'id=' + encodeURIComponent(id)
    })
    .then(res => res.json())
    .then(data => {
        console.log('Lượt tải +1');
        alert('📥 Đang tải xuống...');
        // Sau này mở link tải file thật:
        if (tenfile) {
            window.location.href = 'uploads/' + tenfile;
        }
    })
    .catch(err => console.error(err));
}
</script>
<script>
document.addEventListener("DOMContentLoaded", () => {
  fetch("get_tailieu.php")
    .then(res => res.text()) // ✅ Đọc HTML, không phải JSON
    .then(html => {
      const container = document.getElementById("cards-container");
      container.innerHTML = html; // Gán luôn HTML trả về
    })
    .catch(err => {
      console.error("Lỗi tải tài liệu:", err);
    });
});

document.querySelectorAll('.category-tab').forEach(tab => {
  tab.addEventListener('click', () => {
    // Xóa active cũ
    document.querySelectorAll('.category-tab').forEach(t => t.classList.remove('active'));
    document.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));

    // Thêm active mới
    tab.classList.add('active');
    const target = tab.getAttribute('data-target');
    document.getElementById(target).classList.add('active');
  });
});
</script>
<!-- ///////////////////////// -->
 <script>
document.querySelectorAll('.sidebar ul li').forEach(li => {
  li.addEventListener('click', function() {
    const danhmucID = this.getAttribute('data-id');

    // Xóa class active cũ
    document.querySelectorAll('.sidebar ul li').forEach(item => item.classList.remove('active'));
    this.classList.add('active');

    // Gọi Ajax load tài liệu
    fetch(`get_tailieu.php?danhmuc=${danhmucID}`)
      .then(response => response.text())
      .then(data => {
        document.getElementById('list-tailieu').innerHTML = data;
      })
      .catch(error => console.error('Lỗi khi load tài liệu:', error));
  });
});
</script>
<!-- không cần load lại trang -->
  <script>
 document.querySelectorAll('.doc-card-link').forEach(card => {
    card.addEventListener('click', function (e) {
        let id = this.dataset.id;

        // Gửi request tăng view
        fetch("update_view.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: "id=" + id
        });

        // Tăng số mắt trên giao diện
        let viewSpan = this.querySelector(".doc-stats span i.fa-eye").parentElement;
        let currentViews = parseInt(viewSpan.innerText.trim().split(" ")[1]);
        viewSpan.innerHTML = `<i class="fa fa-eye"></i> ${currentViews + 1}`;
    });
});
</script>

</body>
</html>
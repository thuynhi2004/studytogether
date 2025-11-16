<?php
session_start(); 

include 'connect.php';

// Lấy ID tài liệu
$id = $_GET['id'] ?? 0;
if (!$id) {
    echo "<p>Không tìm thấy tài liệu.</p>";
    exit;
}

// ⭐ TĂNG LƯỢT XEM ⭐
$updateView = $conn->prepare("UPDATE tailieu SET luotxem = luotxem + 1 WHERE id = ?");
$updateView->bind_param("i", $id);
$updateView->execute();

// Lấy dữ liệu từ DB
$sql = "SELECT t.*, d.tendanhmuc, u.hoten 
        FROM tailieu t
        LEFT JOIN danhmuc d ON t.danhmucid = d.id
        LEFT JOIN users u ON t.nguoiupload = u.id
        WHERE t.id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if (!$row) {
    echo "<p>Không tìm thấy tài liệu.</p>";
    exit;
}

$filePath = 'uploads/' . $row['fileupload'];
$thumbPath = !empty($row['trangbia']) ? 'uploads/' . $row['trangbia'] : 'default-thumbnail.jpg';
$fileExt = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
$domain = "http://localhost/doan4/php/";
$shareURL = $domain . "chitiet_tailieu.php?id=" . $row['id'];

///////////////////////
$id = $_GET['id'] ?? 0;
$sql = "SELECT t.*, d.tendanhmuc 
        FROM tailieu t 
        LEFT JOIN danhmuc d ON t.danhmucid = d.id 
        WHERE t.id = $id";
$result = $conn->query($sql);
$data = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($row['tentailieu']); ?> - Chi tiết tài liệu</title>
   <link rel="stylesheet" href="../css/chitiet_tailieu.css">
   <link rel="stylesheet" href="../css/index.css">
    
    
</head>
<body>


    <!-- ===== HEADER ===== -->
    
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
        <p class="subtitle">Nơi học sinh và giáo viên chia sẻ, tải về hàng nghìn tài liệu học tập chất lượng cao. 
               Miễn phí, dễ dàng và thuận tiện.</p>

        <div class="content-wrapper">
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

            <div class="main-content">
               
            
          <!-- breadcrumb -->
           <div class="breadcrumb">
    <a href="index.php">Trang chủ</a>
    <span>›</span>
    <a href="danhmuc.php?id=<?php echo $data['danhmucid']; ?>">
        <?php echo htmlspecialchars($data['tendanhmuc']); ?>
    </a>
    <span>›</span>
    <span class="current"><?php echo htmlspecialchars($data['tentailieu']); ?></span>
</div>

            <!-- ===== NỘI DUNG CHI TIẾT ===== -->
<div class="doc-wrapper">
    <div class="doc-header">
        <img src="<?php echo htmlspecialchars($thumbPath); ?>" alt="Ảnh bìa tài liệu">
        <div class="doc-info">
            <h1><?php echo htmlspecialchars($row['tentailieu']); ?></h1>
            <div class="category">📚 <?php echo htmlspecialchars($row['tendanhmuc'] ?? 'Không có danh mục'); ?></div>
            <div class="rating">⭐⭐⭐⭐☆</div>
            <div class="date-upload">📅 Ngày đăng: <?php echo date("d/m/Y H:i", strtotime($row['ngayupload'] ?? 'now')); ?></div>
        </div>
    </div>

    <div class="doc-content">
        <div class="info-grid">
            <div class="info-item"><strong>👤 Người upload:</strong><br><?php echo htmlspecialchars($row['hoten'] ?? 'Không rõ'); ?></div>
            <div class="info-item"><strong>👁️ Lượt xem:</strong><br><?php echo ($row['luotxem'] ?? 0); ?></div>
            <div class="info-item"><strong>⬇️ Lượt tải:</strong><br><?php echo ($row['luottaixuong'] ?? 0); ?></div>
            <div class="info-item"><strong>💰 Phí tải:</strong><br><?php echo number_format($row['phi'], 0, ',', '.'); ?> VND</div>
        </div>

        <div class="preview-box" style="width: 100%; text-align:center;">
<?php
$officeExts = ['doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx'];

if ($fileExt == 'pdf') {
    echo '<div id="viewer" style="width: 100%; margin:auto; max-height: 80vh; overflow-y:auto;"></div>';
} 
elseif (in_array($fileExt, ['jpg','jpeg','png','gif'])) {
    echo '<img src="'. htmlspecialchars($filePath) .'" style="max-width:100%; border-radius:10px;">';
}
elseif (in_array($fileExt, $officeExts)) {
    $fileURL = urlencode("http://localhost/doan4/php/" . $filePath);
    $viewerURL = "https://docs.google.com/gview?url=" . $fileURL . "&embedded=true";
    echo '<iframe src="'.$viewerURL.'" style="width:100%; height:80vh;" frameborder="0"></iframe>';
}
else {
    echo '<div style="padding:20px;color:#666;">Không xem trước được file này.</div>';
}
?>
</div>

<?php if ($fileExt == 'pdf'): ?>
<script type="module">
    import * as pdfjsLib from '../pdfjs/pdf.mjs';

    pdfjsLib.GlobalWorkerOptions.workerSrc = '../pdfjs/pdf.worker.mjs';

    const url = "<?php echo $filePath; ?>";
    const limitPage = 10;

    pdfjsLib.getDocument(url).promise.then(pdf => {
        const viewer = document.getElementById("viewer");
        const total = pdf.numPages;
        const max = Math.min(total, limitPage);

        for (let p = 1; p <= max; p++) {
            pdf.getPage(p).then(page => {
                const canvas = document.createElement("canvas");
                canvas.style.marginBottom = "20px";
                viewer.appendChild(canvas);

                const context = canvas.getContext("2d");
                const viewport = page.getViewport({ scale: 1.1 });

                canvas.height = viewport.height;
                canvas.width = viewport.width;

                page.render({ canvasContext: context, viewport: viewport });
            });
        }

        if (total > limitPage) {
            const lockBox = document.createElement("div");
            lockBox.style = `
                margin-top: 15px;
                padding: 20px;
                background: #ffe5e5;
                border: 1px solid #ff8585;
                font-weight: bold;
                border-radius: 10px;
                font-size: 18px;
            `;
            lockBox.innerHTML = `
                🔒 Bạn chỉ được xem ${limitPage}/${total} trang.<br>
                Mua tài liệu để mở khóa toàn bộ nội dung.
            `;
            viewer.appendChild(lockBox);
        }
    });
</script>
<?php endif; ?>


    <a href="#" 
   class="download-btn"
   onclick="openPayment(<?php echo $id; ?>)"
   style="
     display:inline-block;
     background:#ff3b3b;
     padding:10px 18px;
     color:white;
     border-radius:8px;
     font-weight:bold;
     text-decoration:none;
     margin-top:15px;
   ">
   🔽 Tải xuống toàn bộ tài liệu
</a>



        <div class="share-buttons">
            <a class="facebook" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode($shareURL); ?>">📘 Chia sẻ Facebook</a>
            <a class="zalo" target="_blank" href="https://zalo.me/share/?url=<?php echo urlencode($shareURL); ?>">💬 Chia sẻ Zalo</a>
        </div>
    </div>
</div>                         
            </div>
        </div>
    </div>

<div id="paymentPopup" 
     style="
        position:fixed;
        top:0; left:0;
        width:100%; height:100%;
        background:rgba(0,0,0,0.6);
        display:none;
        justify-content:center;
        align-items:center;
        z-index:9999;
     ">
  
  <div style="
    width:420px;
    background:white;
    padding:28px;
    border-radius:18px;
    box-shadow:0 8px 25px rgba(0,0,0,0.12);
    animation:popupShow 0.28s ease;
    font-family:'Segoe UI', sans-serif;
">

    <h2 style="
        margin-bottom:12px;
        font-size:22px;
        font-weight:600;
        color:#333;
        text-align:center;
    ">
      Thanh toán tài liệu
    </h2>

    <p style="
        font-size:16px;
        text-align:center;
        margin-bottom:20px;
        color:#444;
    ">
        Giá: <b style="color:#28a745; font-size:18px;">10.000đ</b>
    </p>

    <!-- Nút QR -->
    <button onclick="confirmPayment()" 
      style="
        width:100%;
        padding:14px;
        background:linear-gradient(135deg, #28a745, #1e8d38);
        border:none;
        border-radius:10px;
        font-size:16px;
        color:white;
        font-weight:600;
        cursor:pointer;
        transition:0.25s;
        box-shadow:0 4px 12px rgba(40,167,69,0.45);
        margin-bottom:12px;
      "
      onmouseover="this.style.opacity='0.9'"
      onmouseout="this.style.opacity='1'"
    >
      💚 Thanh toán bằng mã QR
    </button>

    <!-- Nút VNPAY -->
    <button onclick="vnpay()" 
      style="
        width:100%;
        padding:14px;
        background:linear-gradient(135deg, #007bff, #0056d2);
        border:none;
        border-radius:10px;
        font-size:16px;
        color:white;
        font-weight:600;
        cursor:pointer;
        transition:0.25s;
        box-shadow:0 4px 12px rgba(0,123,255,0.45);
        margin-bottom:12px;
      "
      onmouseover="this.style.opacity='0.9'"
      onmouseout="this.style.opacity='1'"
    >
      🔵 Thanh toán Online (VNPAY)
    </button>
    <script>
function vnpay() {
    window.location.href = "vnpay_create_payment.php?id=<?php echo $id; ?>";
}
</script>

    <!-- Nút Hủy -->
    <button onclick="closePopup()"
      style="
        width:100%;
        padding:12px;
        background:#f1f1f1;
        border:none;
        border-radius:10px;
        font-size:15px;
        color:#333;
        cursor:pointer;
        transition:0.25s;
      "
      onmouseover="this.style.background='#e2e2e2'"
      onmouseout="this.style.background='#f1f1f1'"
    >
      ❌ Hủy
    </button>

</div>

</div>

<style>
@keyframes popupShow {
  from { transform:scale(0.7); opacity:0; }
  to   { transform:scale(1); opacity:1; }
}
</style>


   

    <!-- ===== FOOTER ===== -->
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


<script>
let downloadID = 0;

function openPayment(id) {
    downloadID = id;
    document.getElementById("paymentPopup").style.display = "flex";
}

function closePopup() {
    document.getElementById("paymentPopup").style.display = "none";
}

function confirmPayment() {
    // Sau khi thanh toán thành công → tải file
    window.location.href = "download.php?id=" + downloadID;
}
</script>



</body>
</html>

<?php
session_start();

// Giả lập dữ liệu người dùng đã đăng nhập
$isLoggedIn = true; // Thay đổi thành false để xem giao diện chưa đăng nhập
$user = [
    'name' => 'Nguyễn Văn A',
    'avatar' => '👤'
];

// Danh mục tài liệu
$categories = [
    ['name' => 'Lập trình', 'icon' => '💻', 'count' => 1234, 'color' => '#667eea'],
    ['name' => 'Toán học', 'icon' => '📐', 'count' => 892, 'color' => '#f093fb'],
    ['name' => 'Ngoại ngữ', 'icon' => '🌍', 'count' => 756, 'color' => '#4facfe'],
    ['name' => 'Kinh tế', 'icon' => '💰', 'count' => 645, 'color' => '#43e97b'],
    ['name' => 'Khoa học', 'icon' => '🔬', 'count' => 523, 'color' => '#fa709a'],
    ['name' => 'Văn học', 'icon' => '📚', 'count' => 478, 'color' => '#feca57'],
    ['name' => 'Lịch sử', 'icon' => '🏛️', 'count' => 389, 'color' => '#ff6348'],
    ['name' => 'Nghệ thuật', 'icon' => '🎨', 'count' => 267, 'color' => '#a29bfe']
];

// Tài liệu phổ biến
$popular_documents = [
    [
        'title' => 'Lập trình PHP từ cơ bản đến nâng cao',
        'author' => 'Trần Văn B',
        'category' => 'Lập trình',
        'views' => 5420,
        'downloads' => 892,
        'rating' => 4.8,
        'date' => '05/10/2025',
        'thumbnail' => '💻'
    ],
    [
        'title' => 'Toán cao cấp A1 - Đại học Bách Khoa',
        'author' => 'TS. Lê Thị C',
        'category' => 'Toán học',
        'views' => 4523,
        'downloads' => 756,
        'rating' => 4.9,
        'date' => '03/10/2025',
        'thumbnail' => '📐'
    ],
    [
        'title' => 'IELTS Speaking - Chiến lược đạt 8.0+',
        'author' => 'Phạm Văn D',
        'category' => 'Ngoại ngữ',
        'views' => 3892,
        'downloads' => 645,
        'rating' => 4.7,
        'date' => '02/10/2025',
        'thumbnail' => '🌍'
    ],
    [
        'title' => 'Kinh tế vi mô - Nguyên lý cơ bản',
        'author' => 'GS. Hoàng Văn E',
        'category' => 'Kinh tế',
        'views' => 3456,
        'downloads' => 523,
        'rating' => 4.6,
        'date' => '01/10/2025',
        'thumbnail' => '💰'
    ],
    [
        'title' => 'Hóa học hữu cơ - Tổng hợp bài tập',
        'author' => 'Nguyễn Thị F',
        'category' => 'Khoa học',
        'views' => 2987,
        'downloads' => 478,
        'rating' => 4.5,
        'date' => '30/09/2025',
        'thumbnail' => '🔬'
    ],
    [
        'title' => 'JavaScript Modern - ES6+ và React',
        'author' => 'Vũ Văn G',
        'category' => 'Lập trình',
        'views' => 2745,
        'downloads' => 412,
        'rating' => 4.8,
        'date' => '28/09/2025',
        'thumbnail' => '💻'
    ]
];

// Tài liệu mới nhất
$latest_documents = [
    ['title' => 'Python Machine Learning 2025', 'author' => 'AI Team', 'time' => '2 giờ trước', 'category' => 'Lập trình'],
    ['title' => 'Đề thi Toán A1 học kỳ 1', 'author' => 'Admin', 'time' => '5 giờ trước', 'category' => 'Toán học'],
    ['title' => 'TOEIC Listening Practice', 'author' => 'English Center', 'time' => '8 giờ trước', 'category' => 'Ngoại ngữ'],
    ['title' => 'Marketing căn bản', 'author' => 'Business School', 'time' => '1 ngày trước', 'category' => 'Kinh tế']
];


?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StudyTogether - Nền tảng chia sẻ tài liệu học tập</title>
    <link rel="stylesheet" href="../css/index.css">
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="header-content">
            <div class="logo-section">
                <div class="logo-icon">🎓</div>
                <div class="logo-text">StudyTogether</div>
            </div>
            
            <nav class="header-nav">
                <a href="#" class="nav-link">Trang chủ</a>
                <a href="#" class="nav-link">Danh mục</a>
                <a href="#" class="nav-link hot-link">🔥Tài liệu hot</a>

                <a href="#" class="nav-link">Về chúng tôi</a>
            </nav>
             <div class="header-actions">
    <button class="btn-upload" onclick="window.location.href='dkdn.php'">Đăng kí tài khoản</button>

    <?php if ($isLoggedIn): ?>
        <div class="user-avatar"><?php echo $user['avatar']; ?></div>
    <?php else: ?>
        <button class="btn-upload" 
            style="background: white; color: #667eea; border: 2px solid #667eea;"
            onclick="window.location.href='dkdn.php'">
            Đăng nhập
        </button>
    <?php endif; ?>
</div>

          
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <h1>🎓 Cùng nhau học tập hiệu quả hơn!</h1>
            <p>Nền tảng chia sẻ tài liệu học tập miễn phí cho sinh viên Việt Nam</p>
            
            <div class="search-bar">
                <input type="text" class="search-input" placeholder="Tìm kiếm tài liệu, môn học, giáo trình...">
                <button class="search-btn">🔍 Tìm kiếm</button>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
   

    <!-- Main Content -->
    <div class="container">
        <!-- Categories -->
        <h2 class="section-title">📂 Danh mục phổ biến</h2>
        <div class="categories-grid">
            <?php foreach ($categories as $category): ?>
            <div class="category-card">
                <div class="category-icon"><?php echo $category['icon']; ?></div>
                <div class="category-name"><?php echo $category['name']; ?></div>
                <div class="category-count"><?php echo number_format($category['count']); ?> tài liệu</div>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- Content Layout -->
        <div class="content-layout">
            <!-- Popular Documents -->
            <div>
                <h2 class="section-title">🔥 Tài liệu phổ biến</h2>
                <div class="documents-grid">
                    <?php foreach ($popular_documents as $doc): ?>
                    <div class="document-card">
                        <div class="doc-thumbnail"><?php echo $doc['thumbnail']; ?></div>
                        <div class="doc-content">
                            <span class="doc-category"><?php echo $doc['category']; ?></span>
                            <h3 class="doc-title"><?php echo $doc['title']; ?></h3>
                            <div class="doc-author">👤 <?php echo $doc['author']; ?></div>
                            <div class="doc-stats">
                                <div class="doc-stat-item">
                                    <span>👁️</span>
                                    <span><?php echo number_format($doc['views']); ?></span>
                                </div>
                                <div class="doc-stat-item">
                                    <span>⬇️</span>
                                    <span><?php echo number_format($doc['downloads']); ?></span>
                                </div>
                                <div class="doc-rating">
                                    <span>⭐</span>
                                    <span><?php echo $doc['rating']; ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Sidebar -->
            <aside class="sidebar">
                <!-- Latest Documents -->
                <div class="sidebar-card">
                    <h3 class="sidebar-title">🆕 Tài liệu mới nhất</h3>
                    <?php foreach ($latest_documents as $latest): ?>
                    <div class="latest-item">
                        <div class="latest-title"><?php echo $latest['title']; ?></div>
                        <div class="latest-meta">
                            <span>👤 <?php echo $latest['author']; ?></span>
                            <span>⏰ <?php echo $latest['time']; ?></span>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>

                <!-- Top Contributors -->
                <div class="sidebar-card">
                    <h3 class="sidebar-title">🏆 Người đóng góp xuất sắc</h3>
                    <div class="latest-item">
                        <div class="latest-title">🥇 Nguyễn Văn A</div>
                        <div class="latest-meta">
                            <span>245 tài liệu</span>
                        </div>
                    </div>
                    <div class="latest-item">
                        <div class="latest-title">🥈 Trần Thị B</div>
                        <div class="latest-meta">
                            <span>189 tài liệu</span>
                        </div>
                    </div>
                    <div class="latest-item">
                        <div class="latest-title">🥉 Lê Văn C</div>
                        <div class="latest-meta">
                            <span>156 tài liệu</span>
                        </div>
                    </div>
                </div>
            </aside>
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
        // Search functionality
        document.querySelector('.search-input').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                const query = this.value;
                alert('Đang tìm kiếm: ' + query);
            }
        });

        // Animation on scroll
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        document.querySelectorAll('.category-card, .document-card, .stat-card').forEach(el => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(20px)';
            el.style.transition = 'all 0.6s ease';
            observer.observe(el);
        });
    </script>
</body>
</html>
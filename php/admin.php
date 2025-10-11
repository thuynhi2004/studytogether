```php
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .sidebar {
            height: 100vh;
            background: linear-gradient(180deg, #343a40 0%, #495057 100%);
            position: fixed;
            width: 250px;
            top: 0;
            left: 0;
            z-index: 1000;
            padding-top: 20px;
        }
        .sidebar .nav-link {
            color: #adb5bd;
            padding: 12px 20px;
            border-radius: 0 15px 15px 0;
            margin: 5px 0;
            transition: all 0.3s ease;
        }
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            color: #fff;
            background-color: #007bff;
            transform: translateX(5px);
        }
        .sidebar .nav-link i {
            width: 20px;
            margin-right: 10px;
        }
        .main-content {
            margin-left: 250px;
            padding: 20px;
        }
        .header {
            background: #fff;
            padding: 15px 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .header h2 {
            margin: 0;
        }
        .logout-btn {
            background-color: #dc3545;
            border: none;
            color: white;
            padding: 8px 15px;
            border-radius: 5px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            transition: background-color 0.3s ease;
        }
        .logout-btn:hover {
            background-color: #c82333;
            color: white;
            text-decoration: none;
        }
        .logout-btn i {
            margin-right: 5px;
        }
        .table-container {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 20px;
            overflow-x: auto;
        }
        .table {
            margin-bottom: 0;
        }
        .table th {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 15px;
        }
        .table td {
            padding: 15px;
            border-color: #dee2e6;
        }
        .empty-state {
            text-align: center;
            padding: 40px;
            color: #6c757d;
        }
        .empty-state i {
            font-size: 48px;
            margin-bottom: 10px;
            opacity: 0.5;
        }
        .table-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }
        .search-container {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .search-input {
            max-width: 300px;
            height: 38px;
        }
        .add-btn {
            background-color: #28a745;
            border: none;
            color: white;
            padding: 8px 20px;
            border-radius: 5px;
            display: inline-flex;
            align-items: center;
            height: 38px;
            line-height: 1.5;
            white-space: nowrap;
            transition: background-color 0.3s ease;
        }
        .add-btn:hover {
            background-color: #218838;
            color: white;
        }
        .add-btn i {
            margin-right: 5px;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h4 class="text-white text-center mb-4">Admin Dashboard</h4>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link active" href="index.php" data-section="trangchu">
                    <i class="fas fa-home"></i> Trang chủ
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#" data-section="users">
                    <i class="fas fa-users"></i> Quản lý người dùng
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#" data-section="uploaders">
                    <i class="fas fa-upload"></i> Quản lý người đăng tải
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#" data-section="transactions">
                    <i class="fas fa-exchange-alt"></i> Quản lý giao dịch tài liệu
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#" data-section="documents">
                    <i class="fas fa-file-alt"></i> Quản lý tài liệu
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#" data-section="danhmuc">
                    <i class="fas fa-file-alt"></i> Quản lý danh mục
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#" data-section="danhgia">
                    <i class="fas fa-star"></i> Quản lý đánh giá
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#" data-section="lienhe">
                    <i class="fas fa-address-book"></i> Quản lý liên hệ
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#" data-section="thongke">
                    <i class="fas fa-chart-bar"></i> Thống kê
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#" data-section="chatbox">
                    <i class="fas fa-comments"></i> Chat
                </a>
            </li>
        </ul>
    </div>
    <div class="main-content">
        <div class="header">
            <div>
                <h2>Chào mừng đến với Admin Dashboard</h2>
                <p class="text-muted mb-0">Chọn một phần quản lý từ menu bên trái để xem chi tiết.</p>
            </div>
            <a href="#" class="logout-btn" title="Đăng xuất">
                <i class="fas fa-sign-out-alt"></i> Đăng xuất
            </a>
        </div>
        <div class="table-container">
            <div id="content-area">
                <div class="empty-state">
                    <i class="fas fa-table"></i>
                    <h5>Chào mừng đến với Admin Dashboard</h5>
                    <p>Chọn một phần quản lý từ menu bên trái để xem chi tiết.</p>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal cho form thêm tài liệu -->
    <div class="modal fade" id="addDocumentModal" tabindex="-1" aria-labelledby="addDocumentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addDocumentModalLabel">Thêm Tài Liệu Mới</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addDocumentForm">
                        <div class="mb-3">
                            <label for="documentName" class="form-label">Tên tài liệu</label>
                            <input type="text" class="form-control" id="documentName" placeholder="Nhập tên tài liệu" required>
                        </div>
                        <div class="mb-3">
                            <label for="documentCategory" class="form-label">Danh mục</label>
                            <select class="form-select" id="documentCategory" required>
                                <option value="">Chọn danh mục</option>
                                <option value="1">Danh mục 1</option>
                                <option value="2">Danh mục 2</option>
                                <option value="3">Danh mục 3</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="documentFee" class="form-label">Phí (VND)</label>
                            <input type="number" class="form-control" id="documentFee" placeholder="Nhập phí" min="0" required>
                        </div>
                        <div class="mb-3">
                            <label for="documentFile" class="form-label">Chọn file</label>
                            <input type="file" class="form-control" id="documentFile" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="button" class="btn btn-primary" onclick="submitForm()">Thêm</button>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const navLinks = document.querySelectorAll('.nav-link');
            const contentArea = document.getElementById('content-area');
            const addDocumentModal = new bootstrap.Modal(document.getElementById('addDocumentModal'));

            function showTable(section) {
                let title = '';
                let headers = [];
                let sectionName = '';
                let showAddButton = false;

                switch(section) {
                    case 'transactions':
                        title = 'Quản lý giao dịch tài liệu';
                        headers = ['ID','Họ Tên','Ngày giao dịch','Phí' ,'Xem chi tiết'];
                        sectionName = 'Giao dịch';
                        break;
                    case 'users':
                        title = 'Quản lý người dùng';
                        headers = ['ID', 'Họ tên', 'Email', 'Số điện thoại', 'Ngày đăng ký', 'Thao tác'];
                        sectionName = 'Người dùng';
                        break;
                    case 'uploaders':
                        title = 'Quản lý người đăng tải';
                        headers = ['ID', 'Họ tên', 'Email', 'Số điện thoại', 'Ngày đăng ký', 'Thao tác'];
                        sectionName = 'Người đăng tải';
                        break;
                    case 'documents':
                        title = 'Quản lý tài liệu';
                        headers = ['ID', 'Tên tài liệu','Danh mục', 'Phí', 'Người upload', 'Ngày upload', 'Thao tác'];
                        sectionName = 'Tài liệu';
                        showAddButton = true;
                        break;
                    case 'danhmuc':
                        title = 'Quản lý danh mục';
                        headers = ['ID', 'Tên danh mục', 'Người upload', 'Ngày','Thao tác'];
                        sectionName = 'Tài liệu';
                        break;
                    case 'danhgia':
                        title = 'Quản lý đánh giá';
                        headers = ['ID', 'Họ tên', 'Nội dung đánh giá', 'Số sao', 'Ngày đánh giá','Thao tác'];
                        sectionName = 'Tài liệu';
                        break;
                    case 'lienhe':
                        title = 'Quản lý liên hệ';
                        headers = ['ID', 'Họ tên', 'Email','Nội dung liên hệ', 'Ngày liên hệ','Thao tác'];
                        sectionName = 'Tài liệu';
                        break;
                }

                let headerRow = '<tr>' + headers.map(h => `<th>${h}</th>`).join('') + '</tr>';
                let tableHeader = `
                    <div class="table-header">
                        <h4 class="mb-0">${title}</h4>
                        <div class="search-container">
                            <input type="text" class="form-control search-input d-inline-block" placeholder="Tìm kiếm...">
                            ${showAddButton ? `<button class="add-btn" data-bs-toggle="modal" data-bs-target="#addDocumentModal"><i class="fas fa-plus"></i> Thêm tài liệu</button>` : ''}
                        </div>
                    </div>
                `;
                const tableHTML = `
                    ${tableHeader}
                    <table class="table table-striped mt-3">
                        <thead>
                            ${headerRow}
                        </thead>
                        <tbody>
                            <!-- Bảng trống, không có dữ liệu -->
                        </tbody>
                    </table>
                    <div class="empty-state mt-3">
                        <i class="fas fa-inbox"></i>
                        <p>Chưa có dữ liệu ${sectionName.toLowerCase()} nào.</p>
                    </div>
                `;
                contentArea.innerHTML = tableHTML;
            }

            navLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    const section = this.getAttribute('data-section');
                    if (section === 'trangchu') {
                        // Allow default navigation to index.php for customer page
                        window.location.href = this.getAttribute('href');
                    } else {
                        // Prevent default for other links and handle dynamically
                        e.preventDefault();
                        navLinks.forEach(l => l.classList.remove('active'));
                        this.classList.add('active');
                        showTable(section);
                    }
                });
            });

            // Hiển thị mặc định cho trang admin
            showTable('users');

            window.submitForm = function() {
                const form = document.getElementById('addDocumentForm');
                if (form.checkValidity()) {
                    alert('Tài liệu đã được thêm thành công!');
                    addDocumentModal.hide();
                    form.reset();
                } else {
                    form.reportValidity();
                }
            };
        });
    </script>
</body>
</html>
```
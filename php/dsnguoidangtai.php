<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
.contributor-list {
    width: 100%;
    max-width: 950px;
    margin: 25px auto;
    display: flex;
    flex-direction: column;
    gap: 18px;
}

/* ITEM WRAPPER */
.contributor-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 22px 28px;
    background: #ffffff;
    border-radius: 14px;
    transition: 0.25s ease;
    border: 1px solid #f1f1f1;
    box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    position: relative;
}

/* Hover nổi lên */
.contributor-item:hover {
    transform: translateY(-4px);
    box-shadow: 0 10px 22px rgba(0,0,0,0.12);
}

/* RANK BOX */
.rank-box {
    width: 46px;
    height: 46px;
    flex-shrink: 0;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    font-weight: 700;
    margin-right: 18px;
    color: #555;
    background: #eef0f5;
}

/* Top 1 – Gradient vàng */
.rank-box.top-1 {
    background: linear-gradient(135deg, #ffda6b, #ffb703);
    color: #5a4a00;
}

/* Top 2 – Gradient bạc */
.rank-box.top-2 {
    background: linear-gradient(135deg, #e1e1e1, #c8c8c8);
    color: #444;
}

/* Top 3 – Gradient đồng */
.rank-box.top-3 {
    background: linear-gradient(135deg, #e6b089, #c97437);
    color: #fff;
}

/* AVATAR */
.avatar {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid #f1f1f1;
    margin-right: 18px;
    transition: 0.2s;
}

.contributor-item:hover .avatar {
    border-color: #4d6bff;
}

/* INFO */
.info h3 {
    margin: 0;
    font-size: 18px;
    font-weight: 700;
    color: #222;
}

.info p {
    margin: 0;
    color: #777;
    font-size: 14px;
}

.stats {
    margin-left: auto;
    display: flex;
    align-items: center;
    gap: 25px;
}

/* STAT ITEM */
.stat-item {
    background: #eef3ff;
    padding: 8px 16px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 14px;
    font-weight: 500;
}

.stat-item i {
    color: #4d6bff;
    font-size: 16px;
}

/* STAR BOX */
.stat-item.star {
    background: #fff4d6;
}

.stat-item.star i {
    color: #ffb400;
}

.stat-item strong {
    font-weight: 700;
}

/* Responsive */
@media (max-width: 700px) {
    .contributor-item {
        flex-direction: column;
        align-items: flex-start;
        gap: 12px;
    }

    .stats {
        width: 100%;
        justify-content: space-between;
    }
}

.auto-avatar {
    width: 55px;
    height: 55px;
    border-radius: 50%;
    display: flex;
    justify-content: center;
    align-items: center;

    font-size: 20px;
    font-weight: 700;
    color: #fff;

    margin-right: 15px;
    flex-shrink: 0;

    background: #6970ff;
    user-select: none;
    text-transform: uppercase;

    transition: 0.25s ease;
}

/* Hover giống avatar ảnh */
.contributor-item:hover .auto-avatar {
    transform: scale(1.15) rotate(5deg);
    box-shadow: 0 4px 12px rgba(100,100,255,0.3);
}


</style>



<?php
include 'connect.php';

// Lấy danh sách người đóng góp theo số tài liệu upload
$sql = "
    SELECT 
        u.id,
        u.hoten AS name,
        u.email,
        COUNT(t.id) AS total_files,
        AVG(t.danhgia) AS avg_rating
    FROM users u
    LEFT JOIN tailieu t ON u.id = t.nguoiupload
    GROUP BY u.id
    HAVING total_files > 0
    ORDER BY total_files DESC
    LIMIT 10
";

$data = $conn->query($sql);
?>

<div class="contributor-list">
<?php 
$rank = 1;
while($row = $data->fetch_assoc()): 
?>
    <div class="contributor-item">

    <!-- Ranking -->
    <div class="rank-box <?php echo $rank <= 3 ? 'top-'.$rank : ''; ?>">
        <?php echo $rank; ?>
    </div>

    <!-- Avatar tự động bằng chữ cái từ tên -->
    <div class="avatar auto-avatar" data-name="<?php echo $row['name']; ?>"></div>

    <!-- Info -->
    <div class="info">
        <h3><?php echo $row['name']; ?></h3>
        <p>Thành viên đóng góp</p>
    </div>

    <!-- Stats -->
    <div class="stats">
        <div class="stat-item">
            <i class="fas fa-file-alt"></i>
            <span>Tài liệu</span>
            <strong><?php echo $row['total_files']; ?></strong>
        </div>

        <div class="stat-item star">
            <i class="fas fa-star"></i>
            <span>Đánh giá</span>
            <strong>
                <?php 
                echo $row['avg_rating'] ? number_format($row['avg_rating'], 1) : "0.0";
                ?> / 5.0
            </strong>
        </div>
    </div>

</div>

<?php 
$rank++;
endwhile;
?>
</div>
<script>
document.querySelectorAll(".auto-avatar").forEach(box => {
    let name = box.dataset.name || "";

    // Lấy chữ cái đầu tiên của tên
    let initial = name.trim().charAt(0).toUpperCase();

    box.innerText = initial;

    // Màu nền random đẹp
    const colors = ["#6a5af9", "#ff6b6b", "#ffa502", "#1e90ff", "#2ed573", "#ff4757"];
    box.style.background = colors[Math.floor(Math.random() * colors.length)];
});
</script>

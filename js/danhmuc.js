document.addEventListener("DOMContentLoaded", function () {
  fetch("load_danhmuc.php") // ✅ đường dẫn PHP phải đúng
    .then((response) => {
      if (!response.ok) throw new Error("Không thể tải dữ liệu danh mục");
      return response.json();
    })
    .then((data) => {
      const select = document.getElementById("danhMucSelect");
      if (!select) {
        console.error("Không tìm thấy phần tử #danhMucSelect");
        return;
      }

      // reset và thêm option mặc định
      select.innerHTML = '<option value="">Chọn danh mục</option>';

      if (!data || data.length === 0) {
        const option = document.createElement("option");
        option.textContent = "Chưa có danh mục";
        select.appendChild(option);
        return;
      }

      data.forEach((dm) => {
        const option = document.createElement("option");
        option.value = dm.id;
        option.textContent = dm.tendanhmuc; // bạn có thể thêm icon nếu có cột 'icon'
        select.appendChild(option);
      });
    })
    .catch((error) => console.error("Lỗi load danh mục:", error));
});

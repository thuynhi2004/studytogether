document.addEventListener("DOMContentLoaded", () => {
  const navLinks = document.querySelectorAll(".nav-link");
  const contentArea = document.getElementById("content-area");

  navLinks.forEach((link) => {
    link.addEventListener("click", (e) => {
      e.preventDefault();
      navLinks.forEach((l) => l.classList.remove("active"));
      link.classList.add("active");
      showTable(link.dataset.section);
    });
  });

  function showTable(section) {
    if (section !== "documents") {
      contentArea.innerHTML = `<p class="text-center text-muted mt-5">Đang phát triển...</p>`;
      return;
    }

    contentArea.innerHTML = `
      <div class="table-header d-flex justify-content-between">
        <h4>Quản lý tài liệu</h4>
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addDocumentModal"><i class="fas fa-plus"></i> Thêm tài liệu</button>
      </div>
      <table class="table table-striped">
        <thead>
          <tr><th>ID</th><th>Tên tài liệu</th><th>Danh mục</th><th>Người upload</th><th>Phí</th><th>Ngày</th><th>Trạng thái</th><th>Thao tác</th></tr>
        </thead>
        <tbody></tbody>
      </table>
    `;

    const tbody = contentArea.querySelector("tbody");

    fetch("load_tailieu.php")
      .then((res) => res.json())
      .then((data) => {
        if (!data.success || data.data.length === 0) {
          tbody.innerHTML = `<tr><td colspan="8" class="text-center text-muted">Chưa có tài liệu</td></tr>`;
          return;
        }

        data.data.forEach((item) => {
          const disabled =
            item.trangthai === "daduyet" || item.trangthai === "tuchoi"
              ? "disabled"
              : "";
          tbody.innerHTML += `
            <tr data-id="${item.id}">
              <td>${item.id}</td>
              <td>${item.tentailieu}</td>
              <td>${item.ten_danh_muc || "-"}</td>
              <td>${item.ten_nguoi_upload || "-"}</td>
              <td>${item.phi}</td>
              <td>${item.ngayupload}</td>
              <td>
                <select class="form-select form-select-sm trangthai-select" data-id="${
                  item.id
                }" ${disabled}>
                  <option value="choduyet" ${
                    item.trangthai === "choduyet" ? "selected" : ""
                  }>⏳ Chờ duyệt</option>
                  <option value="daduyet" ${
                    item.trangthai === "daduyet" ? "selected" : ""
                  }>✅ Đã duyệt</option>
                  <option value="tuchoi" ${
                    item.trangthai === "tuchoi" ? "selected" : ""
                  }>❌ Từ chối</option>
                </select>
              </td>
              <td><button class="btn btn-sm btn-danger btn-delete">Xóa</button></td>
            </tr>`;
        });

        document.querySelectorAll(".trangthai-select").forEach((sel) => {
          sel.addEventListener("change", () => updateStatus(sel));
        });

        document.querySelectorAll(".btn-delete").forEach((btn) => {
          btn.addEventListener("click", () => deleteDoc(btn));
        });
      });
  }

  function updateStatus(select) {
    const id = select.dataset.id;
    const newStatus = select.value;
    if (!confirm(`Xác nhận thay đổi trạng thái tài liệu #${id}?`)) return;

    fetch("update_trangthai.php", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ id, trangthai: newStatus }),
    })
      .then((res) => res.json())
      .then((r) => {
        alert(r.message);
        if (r.success && (newStatus === "daduyet" || newStatus === "tuchoi"))
          select.disabled = true;
      });
  }

  function deleteDoc(btn) {
    const id = btn.closest("tr").dataset.id;
    if (!confirm("Xác nhận xóa?")) return;

    fetch(`delete_tailieu.php?id=${id}`)
      .then((res) => res.json())
      .then((r) => {
        alert(r.message);
        if (r.success) btn.closest("tr").remove();
      });
  }

  // Load danh mục khi mở modal thêm
  document
    .getElementById("addDocumentModal")
    .addEventListener("show.bs.modal", () => {
      fetch("load_danhmuc.php")
        .then((res) => res.json())
        .then((data) => {
          const sel = document.getElementById("danh_muc");
          sel.innerHTML = '<option value="">Chọn danh mục</option>';
          data.forEach(
            (dm) =>
              (sel.innerHTML += `<option value="${dm.id}">${dm.tendanhmuc}</option>`)
          );
        });
    });

  // Thêm tài liệu
  document.getElementById("addDocumentForm").addEventListener("submit", (e) => {
    e.preventDefault();
    const fd = new FormData(e.target);

    fetch("add_document.php", { method: "POST", body: fd })
      .then((res) => res.json())
      .then((r) => {
        alert(r.message);
        if (r.success) {
          e.target.reset();
          bootstrap.Modal.getInstance(
            document.getElementById("addDocumentModal")
          ).hide();
          showTable("documents");
        }
      });
  });

  showTable("documents"); // mặc định mở trang tài liệu
});

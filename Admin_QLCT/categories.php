<?php
$availableIcons = [
  'home', 'car', 'soup', 'gift',
  'fuel', 'baby', 'piggy-bank', 'graduation-cap',
  'clapperboard', 'shopping-bag', 'heart-pulse', 'more-horizontal'
];

$availableColors = [
  '#2196F3', '#FF5252', '#EC407A', '#FFD54F', '#8D6E63', '#A5D6A7',
  '#FF9800', '#B39DDB', '#78909C', '#66BB6A', '#4DD0E1', '#E0E0E0'
];

$categoriesData = [
  ['id' => 1, 'name' => 'Ăn uống', 'type' => 'Chi', 'icon' => 'soup', 'color' => '#2196F3', 'active' => true],
  ['id' => 2, 'name' => 'Di chuyển', 'type' => 'Chi', 'icon' => 'car', 'color' => '#FF9800', 'active' => true],
  ['id' => 3, 'name' => 'Nhà cửa', 'type' => 'Chi', 'icon' => 'home', 'color' => '#66BB6A', 'active' => true],
  ['id' => 4, 'name' => 'Mua sắm', 'type' => 'Chi', 'icon' => 'shopping-bag', 'color' => '#EC407A', 'active' => true],
  ['id' => 5, 'name' => 'Giải trí', 'type' => 'Chi', 'icon' => 'clapperboard', 'color' => '#B39DDB', 'active' => true],
  ['id' => 6, 'name' => 'Sức khoẻ', 'type' => 'Chi', 'icon' => 'heart-pulse', 'color' => '#FF5252', 'active' => false],
  ['id' => 7, 'name' => 'Tiền lương', 'type' => 'Thu', 'icon' => 'piggy-bank', 'color' => '#4DD0E1', 'active' => true],
  ['id' => 8, 'name' => 'Thưởng & Quà tặng', 'type' => 'Thu', 'icon' => 'gift', 'color' => '#FFD54F', 'active' => true],
];

$currentType = ($_GET['type'] ?? 'Chi') === 'Thu' ? 'Thu' : 'Chi';
$keyword = trim($_GET['q'] ?? '');

$filteredCategories = array_filter($categoriesData, function ($c) use ($currentType, $keyword) {
  return $c['type'] === $currentType && ($keyword === '' || stripos($c['name'], $keyword) !== false);
});
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Quản lý Danh mục hệ thống mặc định</title>
  <link rel="stylesheet" href="categories.css" />
  <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body>
  <div class="app-container">
    <aside class="sidebar">
      <div class="brand-title">Quản lý chi tiêu<br />cá nhân</div>
      <nav class="nav-menu">
        <a href="dashboard.php" class="nav-item">
          <i data-lucide="layout-panel-top"></i>
          <span>Bảng điều khiển<br />Quản trị</span>
        </a>
        <a href="users.php" class="nav-item">
          <i data-lucide="user"></i>
          <span>Quản lý tài khoản<br />user</span>
        </a>
        <a href="categories.php" class="nav-item active">
          <i data-lucide="folder"></i>
          <span>Quản lý danh mục<br />mẫu</span>
        </a>
      </nav>
    </aside>

    <main class="main-content">
      <header class="page-header">
        <h1>Quản lý Danh mục hệ thống mặc định</h1>
        <p class="subtitle">Quản lý bộ danh mục mẫu (Master Categories) tự động nhân bản cho người dùng mới đăng ký</p>
      </header>

      <div class="category-workspace">
        <div class="category-left">
          <div class="category-toolbar">
            <div class="cat-tabs">
              <a href="?type=Chi" class="cat-tab <?= $currentType === 'Chi' ? 'active' : '' ?>">Danh mục chi</a>
              <a href="?type=Thu" class="cat-tab <?= $currentType === 'Thu' ? 'active' : '' ?>">Danh mục thu</a>
            </div>

            <form method="GET" class="cat-actions">
              <input type="hidden" name="type" value="<?= $currentType ?>" />
              <div class="cat-search-box">
                <i data-lucide="search"></i>
                <input type="text" name="q" value="<?= htmlspecialchars($keyword) ?>" placeholder="Tìm kiếm danh mục" />
              </div>
              <button type="button" class="btn-dark" onclick="focusAddForm()">+ Thêm danh mục mẫu</button>
            </form>
          </div>

          <div class="table-card">
            <table class="cat-table">
              <thead>
                <tr>
                  <th>Biểu & Tên danh mục</th>
                  <th>Loại</th>
                  <th>Trạng thái</th>
                  <th>Thao tác</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($filteredCategories as $cat): ?>
                  <tr>
                    <td>
                      <div class="cat-icon-name">
                        <span class="cat-icon-box" style="border-color: <?= $cat['color'] ?>; color: <?= $cat['color'] ?>;">
                          <i data-lucide="<?= $cat['icon'] ?>"></i>
                        </span>
                        <span><?= htmlspecialchars($cat['name']) ?></span>
                      </div>
                    </td>
                    <td><?= $cat['type'] ?></td>
                    <td>
                      <?php if ($cat['active']): ?>
                        <span class="badge-teal">Đang hoạt động</span>
                      <?php else: ?>
                        <span class="badge-hidden-pink">Đang ẩn<br />(Vô hiệu hoá)</span>
                      <?php endif; ?>
                    </td>
                    <td>
                      <div class="cat-action-btns">
                        <button type="button" class="btn-mini-gray"
                                onclick="fillEditForm('<?= htmlspecialchars($cat['name'], ENT_QUOTES) ?>', '<?= $cat['type'] ?>')">Sửa</button>
                        <button type="button" class="btn-mini-gray"
                                onclick="openCatModal('<?= htmlspecialchars($cat['name'], ENT_QUOTES) ?>', '<?= $cat['type'] ?>', <?= $cat['active'] ? 'true' : 'false' ?>)">
                          <?= $cat['active'] ? 'Ẩn/Xoá' : 'Khôi phục' ?>
                        </button>
                      </div>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>

        <aside class="category-right-panel">
          <form method="POST" onsubmit="event.preventDefault(); showToast('Đã lưu danh mục mẫu!');">
            <h3 class="form-panel-title">Thêm mới/ Chỉnh sửa danh mục mẫu</h3>

            <div class="type-selector">
              <label class="type-option">
                <input type="radio" name="catType" value="Chi" <?= $currentType === 'Chi' ? 'checked' : '' ?> />
                <span class="type-circle blue"></span>
                <span>Chi</span>
              </label>
              <label class="type-option">
                <input type="radio" name="catType" value="Thu" <?= $currentType === 'Thu' ? 'checked' : '' ?> />
                <span class="type-circle red"></span>
                <span>Thu</span>
              </label>
            </div>

            <div class="form-group">
              <label for="cat-name-input">Tên danh mục mẫu<span class="req">*</span></label>
              <input type="text" id="cat-name-input" name="catName" value="Ăn uống" placeholder="Nhập tên danh mục..." />
              <small class="hint-text">Ví dụ: Lương, Ăn uống</small>
            </div>

            <div class="form-group">
              <label>Chọn biểu tượng (icon)</label>
              <div class="icon-picker-grid">
                <?php foreach ($availableIcons as $icon): ?>
                  <button type="button" class="icon-choice <?= $icon === 'soup' ? 'selected' : '' ?>" onclick="selectIcon(this)">
                    <i data-lucide="<?= $icon ?>"></i>
                  </button>
                <?php endforeach; ?>
              </div>
            </div>

            <div class="form-group">
              <label>Chọn màu sắc</label>
              <div class="color-picker-grid">
                <?php foreach ($availableColors as $hex): ?>
                  <button type="button" class="color-choice <?= $hex === '#2196F3' ? 'selected' : '' ?>" style="background-color: <?= $hex ?>;" onclick="selectColor(this)"></button>
                <?php endforeach; ?>
              </div>
            </div>

            <div class="constraint-note">
              <strong>Ràng buộc SR-4.5</strong><br />
              *Lưu ý: Thay đổi chỉ áp dụng cho người mới đăng ký mới từ thời điểm này, không ảnh hưởng tới cấu hình người dùng cũ.
            </div>

            <div class="form-footer-btns">
              <button type="reset" class="btn-cancel-blue" onclick="showToast('Đã huỷ thao tác')">Huỷ bỏ</button>
              <button type="submit" class="btn-save-dark">Lưu danh mục mẫu</button>
            </div>
          </form>
        </aside>
      </div>
    </main>
  </div>

  <!-- POP-UP XÁC NHẬN ẨN / KHÔI PHỤC DANH MỤC -->
  <div id="cat-modal" class="modal-overlay" onclick="if(event.target === this) closeCatModal()">
    <div class="modal-box">
      <div class="modal-header">
        <h3 id="modal-cat-title">Xác nhận thay đổi</h3>
        <button class="modal-close" onclick="closeCatModal()">×</button>
      </div>
      <div class="modal-body">
        <p id="modal-cat-desc"></p>
        <div class="modal-sr-warning">
          <strong>Ràng buộc SR-4.5:</strong> Thay đổi chỉ áp dụng cho người dùng đăng ký mới, không làm mất dữ liệu danh mục của người dùng cũ.
        </div>
      </div>
      <div class="modal-footer">
        <button class="modal-btn-cancel" onclick="closeCatModal()">Huỷ bỏ</button>
        <button id="modal-cat-confirm" class="modal-btn-confirm" onclick="confirmCatAction()">Xác nhận</button>
      </div>
    </div>
  </div>

  <div id="toast" class="toast"></div>

  <script>
    lucide.createIcons();
    let currentCatName = '';
    let currentCatActive = true;

    function showToast(msg) {
      const t = document.getElementById('toast');
      t.textContent = msg;
      t.classList.add('show');
      setTimeout(() => t.classList.remove('show'), 2500);
    }

    function focusAddForm() {
      const input = document.getElementById('cat-name-input');
      input.value = '';
      input.focus();
      showToast('Nhập thông tin bên phải để thêm danh mục mới');
    }

    function fillEditForm(name, type) {
      document.getElementById('cat-name-input').value = name;
      const radio = document.querySelector(`input[name="catType"][value="${type}"]`);
      if (radio) radio.checked = true;
      showToast(`Đang chỉnh sửa "${name}"`);
    }

    function selectIcon(btn) {
      document.querySelectorAll('.icon-choice').forEach(b => b.classList.remove('selected'));
      btn.classList.add('selected');
    }

    function selectColor(btn) {
      document.querySelectorAll('.color-choice').forEach(b => b.classList.remove('selected'));
      btn.classList.add('selected');
    }

    function openCatModal(name, type, isActive) {
      currentCatName = name;
      currentCatActive = isActive;
      const title = document.getElementById('modal-cat-title');
      const desc = document.getElementById('modal-cat-desc');
      const confirmBtn = document.getElementById('modal-cat-confirm');

      if (isActive) {
        title.textContent = 'Ẩn / Vô hiệu hoá danh mục mẫu';
        desc.innerHTML = `Bạn muốn ẩn danh mục <strong>"${name}"</strong> (${type}) khỏi bộ danh mục mặc định?`;
        confirmBtn.textContent = 'Xác nhận ẩn';
        confirmBtn.className = 'modal-btn-confirm pink';
      } else {
        title.textContent = 'Khôi phục danh mục mẫu';
        desc.innerHTML = `Kích hoạt lại danh mục <strong>"${name}"</strong> (${type}) cho người dùng mới?`;
        confirmBtn.textContent = 'Khôi phục';
        confirmBtn.className = 'modal-btn-confirm teal';
      }
      document.getElementById('cat-modal').classList.add('show');
    }

    function closeCatModal() {
      document.getElementById('cat-modal').classList.remove('show');
    }

    function confirmCatAction() {
      showToast(currentCatActive ? `Đã ẩn "${currentCatName}"` : `Đã khôi phục "${currentCatName}"`);
      closeCatModal();
    }
  </script>
</body>
</html>
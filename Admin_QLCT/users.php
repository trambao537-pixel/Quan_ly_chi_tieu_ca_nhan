<?php
$usersData = [
  ['id' => 1, 'name' => 'Nguyễn Văn A', 'phone' => '0474****123', 'email' => 'nguyenvana@gmail.com', 'regDate' => '12/10/2026', 'timestamp' => 20261012, 'status' => 'active'],
  ['id' => 2, 'name' => 'Trần Thị B', 'phone' => '0326****589', 'email' => 'tranthib@gmail.com', 'regDate' => '01/10/2026', 'timestamp' => 20261001, 'status' => 'locked'],
  ['id' => 3, 'name' => 'Lê Văn C', 'phone' => '024****478', 'email' => 'levanb@gmail.com', 'regDate' => '08/10/2026', 'timestamp' => 20261008, 'status' => 'active'],
  ['id' => 4, 'name' => 'Phạm Thị D', 'phone' => '054****524', 'email' => 'phamthid@gmail.com', 'regDate' => '12/11/2026', 'timestamp' => 20261112, 'status' => 'active'],
  ['id' => 5, 'name' => 'Hoàng Văn E', 'phone' => '084****562', 'email' => 'hoangvane@gmail.com', 'regDate' => '18/09/2026', 'timestamp' => 20260918, 'status' => 'locked'],
];

$keyword = trim($_GET['q'] ?? '');
$statusFilter = $_GET['status'] ?? 'all';
$sortFilter = $_GET['sort'] ?? 'default';

$filteredUsers = array_filter($usersData, function ($u) use ($keyword, $statusFilter) {
  $matchText = $keyword === '' ||
    stripos($u['name'], $keyword) !== false ||
    stripos($u['email'], $keyword) !== false ||
    stripos($u['phone'], $keyword) !== false;
  $matchStatus = $statusFilter === 'all' || $u['status'] === $statusFilter;
  return $matchText && $matchStatus;
});

if ($sortFilter === 'newest') {
  usort($filteredUsers, fn($a, $b) => $b['timestamp'] <=> $a['timestamp']);
} elseif ($sortFilter === 'oldest') {
  usort($filteredUsers, fn($a, $b) => $a['timestamp'] <=> $b['timestamp']);
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Quản lý Tài Khoản User</title>
  <link rel="stylesheet" href="users.css" />
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
        <a href="users.php" class="nav-item active">
          <i data-lucide="user"></i>
          <span>Quản lý tài khoản<br />user</span>
        </a>
        <a href="categories.php" class="nav-item">
          <i data-lucide="folder"></i>
          <span>Quản lý danh mục<br />mẫu</span>
        </a>
      </nav>
    </aside>

    <main class="main-content">
      <header class="page-header">
        <h1>Quản lý Tài Khoản User</h1>
        <p class="subtitle">Danh sách người dùng hệ thống và các thao tác vận hành (Khoá / Mở khoá tài khoản).</p>
      </header>

      <div class="stats-grid-3">
        <div class="stat-card">
          <div class="stat-label-lg">Tổng người dùng</div>
          <div class="stat-value-lg">12.450</div>
        </div>
        <div class="stat-card">
          <div class="stat-header-inline">
            <span class="status-dot green"></span>
            <span class="stat-label-lg">Đang hoạt động</span>
            <span class="mini-pill green">12.110</span>
          </div>
          <div class="stat-value-lg">12.110</div>
        </div>
        <div class="stat-card">
          <div class="stat-header-inline">
            <span class="status-dot red"></span>
            <span class="stat-label-lg">Đã khoá</span>
            <span class="mini-pill red">340</span>
          </div>
        </div>
      </div>

      <form method="GET" class="filter-bar">
        <div class="search-input-box">
          <i data-lucide="search"></i>
          <input type="text" name="q" value="<?= htmlspecialchars($keyword) ?>" placeholder="Tìm kiếm theo Tên, Email, Số điện thoại...." />
        </div>

        <select name="status" class="filter-select">
          <option value="all" <?= $statusFilter === 'all' ? 'selected' : '' ?>>Trạng thái: Tất cả</option>
          <option value="active" <?= $statusFilter === 'active' ? 'selected' : '' ?>>Trạng thái: Đang hoạt động</option>
          <option value="locked" <?= $statusFilter === 'locked' ? 'selected' : '' ?>>Trạng thái: Bị khoá</option>
        </select>

        <select name="sort" class="filter-select">
          <option value="default" <?= $sortFilter === 'default' ? 'selected' : '' ?>>Lọc theo: Ngày đăng ký</option>
          <option value="newest" <?= $sortFilter === 'newest' ? 'selected' : '' ?>>Mới nhất trước</option>
          <option value="oldest" <?= $sortFilter === 'oldest' ? 'selected' : '' ?>>Cũ nhất trước</option>
        </select>

        <button type="submit" class="btn-cyan">Tìm kiếm</button>
      </form>

      <div class="table-card">
        <table class="data-table">
          <thead>
            <tr>
              <th>STT</th>
              <th>Họ & tên/SĐT</th>
              <th>Email</th>
              <th>Ngày đăng ký</th>
              <th>Trạng thái</th>
              <th>Thao tác</th>
            </tr>
          </thead>
          <tbody>
            <?php $stt = 1; foreach ($filteredUsers as $user): 
              $isLocked = $user['status'] === 'locked';
            ?>
              <tr>
                <td><?= str_pad($stt++, 2, '0', STR_PAD_LEFT) ?></td>
                <td class="user-name-cell">
                  <div><?= htmlspecialchars($user['name']) ?></div>
                  <div><?= htmlspecialchars($user['phone']) ?></div>
                </td>
                <td><?= htmlspecialchars($user['email']) ?></td>
                <td><?= htmlspecialchars($user['regDate']) ?></td>
                <td>
                  <?php if ($isLocked): ?>
                    <span class="badge-pill badge-locked-red">Bị khoá</span>
                  <?php else: ?>
                    <span class="badge-pill badge-active-green">Đang hoạt động</span>
                  <?php endif; ?>
                </td>
                <td>
                  <button type="button"
                          class="action-btn <?= $isLocked ? 'btn-unlock' : 'btn-lock' ?>"
                          onclick="openUserModal('<?= htmlspecialchars($user['name'], ENT_QUOTES) ?>', '<?= htmlspecialchars($user['email'], ENT_QUOTES) ?>', '<?= $user['status'] ?>')">
                    <?= $isLocked ? 'Mở khoá' : 'Khoá tài khoản' ?>
                  </button>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>

      <div class="pagination-bar">
        <span>Trang 1/50</span>
        <button type="button" class="page-btn"><i data-lucide="chevron-left"></i></button>
        <button type="button" class="page-btn"><i data-lucide="chevron-right"></i></button>
      </div>
    </main>
  </div>

  <!-- POP-UP XÁC NHẬN KHOÁ / MỞ KHOÁ USER -->
  <div id="user-modal" class="modal-overlay" onclick="if(event.target === this) closeUserModal()">
    <div class="modal-box">
      <div class="modal-header">
        <h3 id="modal-user-title">Xác nhận thao tác</h3>
        <button class="modal-close" onclick="closeUserModal()">×</button>
      </div>
      <div class="modal-body">
        <p id="modal-user-desc"></p>
        <div id="lock-reason-box" class="reason-box">
          <label for="lock-reason-select">Lý do khoá tài khoản:</label>
          <select id="lock-reason-select">
            <option value="Vi phạm điều khoản sử dụng">Vi phạm điều khoản sử dụng</option>
            <option value="Phát hiện hành vi spam / bất thường">Phát hiện hành vi spam / bất thường</option>
            <option value="Theo yêu cầu tạm khoá của người dùng">Theo yêu cầu tạm khoá của người dùng</option>
          </select>
        </div>
      </div>
      <div class="modal-footer">
        <button class="modal-btn-cancel" onclick="closeUserModal()">Huỷ bỏ</button>
        <button id="modal-user-confirm" class="modal-btn-confirm" onclick="confirmUserAction()">Xác nhận</button>
      </div>
    </div>
  </div>

  <div id="toast" class="toast"></div>

  <script>
    lucide.createIcons();
    let currentUserName = '';
    let currentUserStatus = '';

    function showToast(msg) {
      const t = document.getElementById('toast');
      t.textContent = msg;
      t.classList.add('show');
      setTimeout(() => t.classList.remove('show'), 2500);
    }

    function openUserModal(name, email, status) {
      currentUserName = name;
      currentUserStatus = status;
      const title = document.getElementById('modal-user-title');
      const desc = document.getElementById('modal-user-desc');
      const reasonBox = document.getElementById('lock-reason-box');
      const confirmBtn = document.getElementById('modal-user-confirm');

      if (status === 'active') {
        title.textContent = 'Xác nhận khoá tài khoản';
        desc.innerHTML = `Bạn có chắc muốn khoá tài khoản <strong>${name}</strong> (${email})? Người dùng sẽ không thể đăng nhập cho đến khi được mở khoá.`;
        reasonBox.style.display = 'block';
        confirmBtn.textContent = 'Khoá ngay';
        confirmBtn.className = 'modal-btn-confirm red';
      } else {
        title.textContent = 'Xác nhận mở khoá tài khoản';
        desc.innerHTML = `Khôi phục quyền truy cập cho tài khoản <strong>${name}</strong> (${email})?`;
        reasonBox.style.display = 'none';
        confirmBtn.textContent = 'Mở khoá';
        confirmBtn.className = 'modal-btn-confirm green';
      }
      document.getElementById('user-modal').classList.add('show');
    }

    function closeUserModal() {
      document.getElementById('user-modal').classList.remove('show');
    }

    function confirmUserAction() {
      if (currentUserStatus === 'active') {
        const reason = document.getElementById('lock-reason-select').value;
        showToast(`Đã khoá tài khoản ${currentUserName} (${reason})`);
      } else {
        showToast(`Đã mở khoá tài khoản ${currentUserName}`);
      }
      closeUserModal();
    }
  </script>
</body>
</html>
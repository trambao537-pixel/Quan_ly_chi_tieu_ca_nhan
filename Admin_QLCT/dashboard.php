<?php
$growthData = [
  ['label' => 'Tháng 6', 'value' => 72],
  ['label' => '7', 'value' => 125],
  ['label' => '8', 'value' => 160],
  ['label' => '9', 'value' => 118],
  ['label' => 'Tháng 10/2026', 'value' => 215],
];

$activityLogs = [
  ['line1' => '15:24:20-Tài khoản mới', 'line2' => '"nguyenvan***@gmail.com" đã kích hoạt'],
  ['line1' => '14:15:10_Admin đã khoá tài khoản', 'line2' => '"spam_account_01"'],
  ['line1' => '11:05:45_Danh mục mặc định "Hoá đơn điện"', 'line2' => 'Được cập nhật'],
  ['line1' => '09:30:00_Hệ thống hoàn tất sao lưu dữ liệu tự động', 'line2' => 'hàng ngày'],
];

$maxVal = 250;
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Bảng điều khiển Quản trị</title>
  <link rel="stylesheet" href="dashboard.css" />
  <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body>
  <div class="app-container">
    <aside class="sidebar">
      <div class="brand-title">Quản lý chi tiêu<br />cá nhân</div>
      <nav class="nav-menu">
        <a href="dashboard.php" class="nav-item active">
          <i data-lucide="layout-panel-top"></i>
          <span>Bảng điều khiển<br />Quản trị</span>
        </a>
        <a href="users.php" class="nav-item">
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
        <h1>Bảng điều khiển Quản trị</h1>
        <p class="subtitle">Xin chào, Quản trị viên | Phiên làm việc bảo mật</p>
      </header>

      <div class="security-banner">
        <i data-lucide="alert-triangle"></i>
        <span>Lưu ý bảo mật: Hệ thống tuyệt đối chặn truy cập vào dữ liệu thu/chi chi tiết người dùng cá nhân</span>
      </div>

      <h2 class="section-heading">Thống kê nền tảng (Các tuyệt đối không có tiền thu/chi)</h2>

      <div class="stats-grid-4">
        <div class="stat-card">
          <div class="stat-label">Tổng số người dùng</div>
          <div class="stat-value">12,450</div>
          <div class="stat-note">+120 trong tuần này</div>
        </div>
        <div class="stat-card">
          <div class="stat-label">Tài khoản đang hoạt động</div>
          <div class="stat-value">8,920</div>
          <div class="stat-note">71,6% tỉ lệ hoạt động</div>
        </div>
        <div class="stat-card">
          <div class="stat-label">Tài khoản bị khoá</div>
          <div class="stat-value">24</div>
          <div class="stat-note">Tạm ngưng do vi phạm</div>
        </div>
        <div class="stat-card">
          <div class="stat-label">Bộ danh mục mặc định</div>
          <div class="stat-value">32</div>
          <div class="stat-note">Áp dụng cho user mới</div>
        </div>
      </div>

      <div class="dashboard-bottom-grid">
        <div class="panel-box chart-panel">
          <h3 class="panel-title">Biểu đồ tăng trưởng người dùng mới</h3>
          <div class="chart-wrapper">
            <div class="y-axis">
              <span>250</span><span>200</span><span>150</span><span>100</span><span>50</span><span>0</span>
            </div>
            <div class="chart-area">
              <div class="grid-lines">
                <div class="line"></div><div class="line"></div><div class="line"></div>
                <div class="line"></div><div class="line"></div><div class="line"></div>
              </div>
              <div class="bars-container">
                <?php foreach ($growthData as $item): 
                  $percent = round(($item['value'] / $maxVal) * 100);
                ?>
                  <div class="bar-group">
                    <div class="bar" style="height: <?= $percent ?>%" title="<?= htmlspecialchars($item['label']) ?>: <?= $item['value'] ?> người dùng mới"></div>
                    <span class="x-label"><?= htmlspecialchars($item['label']) ?></span>
                  </div>
                <?php endforeach; ?>
              </div>
            </div>
          </div>
        </div>

        <div class="panel-box log-panel">
          <h3 class="panel-title">Nhật ký hoạt động gần đây</h3>
          <ul class="timeline-list">
            <?php foreach ($activityLogs as $log): ?>
              <li class="timeline-item"
                  onclick="openLogModal(this)"
                  data-line1="<?= htmlspecialchars($log['line1'], ENT_QUOTES) ?>"
                  data-line2="<?= htmlspecialchars($log['line2'], ENT_QUOTES) ?>"
                  title="Bấm để xem chi tiết">
                <span class="timeline-dot"></span>
                <div class="timeline-content">
                  <div class="log-line-1"><?= htmlspecialchars($log['line1']) ?></div>
                  <div class="log-line-2"><?= htmlspecialchars($log['line2']) ?></div>
                </div>
              </li>
            <?php endforeach; ?>
          </ul>
        </div>
      </div>
    </main>
  </div>

  <!-- POP-UP CHI TIẾT NHẬT KÝ -->
  <div id="log-modal" class="modal-overlay" onclick="if(event.target === this) closeLogModal()">
    <div class="modal-box">
      <div class="modal-header">
        <h3>Chi tiết nhật ký hệ thống</h3>
        <button class="modal-close" onclick="closeLogModal()">×</button>
      </div>
      <div class="modal-body" id="log-modal-content"></div>
      <div class="modal-footer">
        <button class="modal-btn-cancel" onclick="closeLogModal()">Đóng</button>
      </div>
    </div>
  </div>

  <script>
    lucide.createIcons();

    function openLogModal(el) {
      const line1 = el.getAttribute('data-line1');
      const line2 = el.getAttribute('data-line2');
      document.getElementById('log-modal-content').innerHTML = `
        <p><strong>Sự kiện:</strong> ${line1}</p>
        <p><strong>Nội dung:</strong> ${line2}</p>
        <p><strong>Trạng thái bảo mật:</strong> Đã mã hoá, không chứa dữ liệu thu/chi cá nhân.</p>
      `;
      document.getElementById('log-modal').classList.add('show');
    }

    function closeLogModal() {
      document.getElementById('log-modal').classList.remove('show');
    }
  </script>
</body>
</html>
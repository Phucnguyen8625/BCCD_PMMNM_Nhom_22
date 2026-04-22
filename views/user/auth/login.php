<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập – MangaStore</title>
    <link rel="stylesheet" href="public/assets/css/authStyle.css">
</head>
<body>
<div class="auth-page">
    <div class="auth-box">
        <!-- LEFT PANEL -->
        <div class="auth-box__left">
            <a href="index.php" class="auth-back">
                ← Về trang chủ
            </a>
            <div class="brand">MangaStore</div>
            <span class="auth-badge">Chào mừng trở lại</span>
            <h1>Đăng nhập tài khoản</h1>
            <p>Đăng nhập để mua truyện, theo dõi đơn hàng và quản lý hồ sơ cá nhân của bạn.</p>

            <div class="auth-features">
                <div class="auth-feature-item">
                    <div class="icon">📦</div>
                    <span>Theo dõi đơn hàng dễ dàng</span>
                </div>
                <div class="auth-feature-item">
                    <div class="icon">❤️</div>
                    <span>Lưu danh sách truyện yêu thích</span>
                </div>
                <div class="auth-feature-item">
                    <div class="icon">🔔</div>
                    <span>Nhận thông báo sách mới về</span>
                </div>
            </div>
        </div>

        <!-- RIGHT PANEL -->
        <div class="auth-box__right">
            <form method="POST" action="index.php?controller=auth&action=processLogin" class="auth-form" autocomplete="off">
                <h2>Đăng nhập</h2>
                <p class="subtitle">Nhập thông tin tài khoản của bạn bên dưới.</p>

                <?php if (!empty($message)): ?>
                    <div class="auth-alert auth-alert--<?php echo $messageType === 'error' ? 'error' : 'success'; ?>">
                        <?php echo htmlspecialchars($message); ?>
                    </div>
                <?php endif; ?>

                <div class="auth-form__group">
                    <label for="login_value">Email hoặc Tên đăng nhập</label>
                    <input type="text" id="login_value" name="login_value" required
                           placeholder="Nhập email hoặc username..."
                           autocomplete="off"
                           readonly
                           onfocus="this.removeAttribute('readonly');"
                           value="<?php echo htmlspecialchars($_POST['login_value'] ?? ''); ?>">
                </div>

                <div class="auth-form__group">
                    <label for="password">Mật khẩu</label>
                    <div style="position:relative;">
                        <input type="password" id="password" name="password" required
                               placeholder="Nhập mật khẩu..." style="padding-right: 48px;"
                               autocomplete="new-password"
                               readonly
                               onfocus="this.removeAttribute('readonly');">
                        <button type="button" class="toggle-password"
                                style="position:absolute;right:14px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:#6b7280;display:flex;align-items:center;">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="18" height="18">
                                <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7-10-7-10-7z"/>
                                <circle cx="12" cy="12" r="3"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="auth-form__row">
                    <a href="#" class="auth-link">Quên mật khẩu?</a>
                </div>

                <button type="submit" class="auth-btn auth-btn--primary">Đăng nhập</button>

                <p class="auth-form__footer">
                    Chưa có tài khoản?
                    <a href="index.php?controller=auth&action=register">Đăng ký ngay</a>
                </p>
            </form>
        </div>
    </div>
</div>
<script src="public/assets/js/auth.js"></script>
</body>
</html>

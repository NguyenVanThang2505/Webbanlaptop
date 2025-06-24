<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/app/helpers/SessionHelper.php';

// Nếu chưa đăng nhập
if (!SessionHelper::isLoggedIn()) {
    die("👀 Không có gì đâu, đừng vào!");
}

// Nếu không phải admin
if (!SessionHelper::isAdmin()) {
    die("🚫 Đây là khu vực của admin, bạn không được phép truy cập!");
}
?>

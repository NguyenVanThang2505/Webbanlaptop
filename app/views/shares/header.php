<?php
// header.php (hoặc tên file chứa phần header của bạn)

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$cartCount = 0;
$user = $_SESSION['username'] ?? null;

if ($user && isset($_SESSION['cart_by_user'][$user]) && is_array($_SESSION['cart_by_user'][$user])) {
    foreach ($_SESSION['cart_by_user'][$user] as $item) {
        $cartCount += $item['quantity'];
    }
}

require_once 'app/helpers/SessionHelper.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>ThangTech+ - Gaming Gear</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&family=Roboto:wght@400;700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        /* ĐỔI CÁC BIẾN MÀU CHÍNH ĐỂ CÓ TÔNG SÁNG */
        :root {
            --gaming-dark: #f8f9fa; /* Nền sáng, gần như trắng (cho navbar, dropdown) */
            --gaming-accent: #007bff; /* Xanh dương nổi bật, hiện đại */
            --gaming-secondary: #e2e6ea; /* Xám nhạt cho các thành phần phụ, nền hover */
            --gaming-light: #343a40; /* Chữ tối trên nền sáng (màu chữ chính) */
            --gaming-green: #28a745; /* Xanh lá cây tươi sáng cho thành công/nút */
            --gaming-red: #dc3545; /* Màu đỏ cho lỗi/danger */
        }

        /* GLOBAL BODY STYLES (áp dụng cho toàn bộ trang web theo mặc định) */
        body {
            padding-top: 85px; /* Giữ nguyên padding cho navbar cố định */
            background-color: #f0f2f5; /* Nền body sáng hơn một chút so với header */
            color: var(--gaming-light); /* Màu chữ mặc định là tối */
            font-family: 'Inter', sans-serif; /* Sử dụng Inter làm font chính cho body */
        }

        /* NAVBAR STYLES */
        .navbar-custom {
            background-color: var(--gaming-dark); /* Nền navbar sáng */
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1030;
            padding-top: 15px;
            padding-bottom: 15px;
            white-space: nowrap; /* Ngăn không cho navbar item bị xuống dòng quá sớm */
            border-bottom: 3px solid var(--gaming-accent); /* Border màu accent */
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1); /* Đổ bóng nhẹ hơn cho nền sáng */
        }

        .navbar-custom .nav-link,
        .navbar-custom .navbar-brand {
            color: var(--gaming-light); /* Chữ tối trên nền sáng */
            font-family: 'Orbitron', sans-serif; /* Font đặc trưng cho brand */
            font-weight: 700;
            text-shadow: 0 0 2px rgba(0, 123, 255, 0.3); /* Hiệu ứng glow nhẹ hơn với màu xanh accent */
            transition: color 0.3s ease, text-shadow 0.3s ease;
        }

        .navbar-custom .nav-link {
            font-family: 'Roboto', sans-serif; /* Font cho các link điều hướng */
            font-weight: 500; /* Làm chữ menu đậm hơn một chút */
        }

        .navbar-custom .nav-link:hover,
        .navbar-custom .navbar-brand:hover {
            color: var(--gaming-accent); /* Màu accent khi hover */
            text-shadow: 0 0 8px var(--gaming-accent); /* Glow mạnh hơn khi hover */
        }

        /* SEARCH BAR STYLES */
        .search-wrapper {
            max-width: 500px;
            min-width: 300px;
            margin: 0 20px;
            flex-grow: 1;
        }

        .search-input .form-control {
            height: 42px;
            border-radius: 50px 0 0 50px;
            border: 1px solid var(--gaming-secondary);
            background-color: #ffffff; /* Nền trắng cho input */
            color: var(--gaming-light);
            box-shadow: none;
            padding-left: 20px;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        .search-input .form-control::placeholder {
            color: rgba(52, 58, 64, 0.7); /* Placeholder màu tối */
        }

        .search-input .form-control:focus {
            border-color: var(--gaming-accent);
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25); /* Glow màu accent khi focus */
        }

        .input-group-append .btn {
            border-radius: 0 50px 50px 0;
            background-color: var(--gaming-green); /* Nút tìm kiếm màu xanh lá */
            color: white;
            border: none;
            padding: 0 16px;
            transition: background-color 0.3s ease;
        }

        .input-group-append .btn:hover {
            background-color: #218838; /* Xanh lá đậm hơn khi hover */
        }

        /* CART BADGE */
        .badge-cart {
            font-size: 0.7rem;
            padding: 4px 7px;
            border-radius: 10px;
            background-color: var(--gaming-accent); /* Badge vẫn giữ màu accent */
            color: white;
            font-weight: bold;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.7);
        }

        .navbar-nav .nav-link {
            white-space: nowrap; /* Đảm bảo các link không bị ngắt dòng */
        }

        /* PROFILE/USER DROPDOWN STYLES */
        .profile-btn {
            background-color: var(--gaming-secondary);
            color: var(--gaming-light);
            border: 1px solid var(--gaming-accent);
            border-radius: 50px;
            padding: 8px 15px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            transition: all 0.2s ease-in-out;
            font-family: 'Roboto', sans-serif;
            font-weight: 700;
        }

        .profile-btn:hover {
            background-color: var(--gaming-accent);
            color: white;
            text-decoration: none;
            box-shadow: 0 0 10px var(--gaming-accent);
            transform: translateY(-2px);
        }

        .profile-btn .bi {
            font-size: 1.1rem;
        }

        /* CUSTOM DROPDOWN CSS (for user/admin profile) */
        .custom-dropdown {
            position: relative;
            display: inline-block;
        }

        .custom-dropdown-toggle {
            background: none;
            border: none;
            font-weight: 500;
            padding: 6px 12px;
            display: flex;
            align-items: center;
            gap: 5px;
            cursor: pointer;
            color: var(--gaming-light); /* Chữ tối */
            font-family: 'Roboto', sans-serif;
            text-shadow: 0 0 2px rgba(0, 123, 255, 0.3); /* Glow nhẹ */
            transition: color 0.3s ease, text-shadow 0.3s ease;
        }

        .custom-dropdown-toggle:hover {
            color: var(--gaming-accent);
            text-shadow: 0 0 8px var(--gaming-accent);
        }

        .custom-dropdown-content {
            /* THAY ĐỔI: Ban đầu ẩn bằng display: none */
            display: none;
            position: absolute;
            top: 100%;
            background-color: var(--gaming-dark); /* Nền dropdown sáng */
            border: 1px solid var(--gaming-accent);
            border-radius: 6px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15); /* Đổ bóng nhẹ hơn */
            min-width: 220px;
            z-index: 1000;
            padding: 10px 0;
            right: 0; /* Mặc định căn phải */
            left: auto;
        }

        /* Specific for Admin dropdown - overrides default right:0 to left:0 */
        .admin-dropdown .custom-dropdown-content {
            right: auto;
            left: 0;
        }

        .custom-dropdown-content a {
            display: block;
            padding: 10px 16px;
            color: var(--gaming-light); /* Chữ tối */
            text-decoration: none;
            font-family: 'Roboto', sans-serif;
            transition: background-color 0.2s ease, color 0.2s ease;
        }

        .custom-dropdown-content a:hover {
            background-color: var(--gaming-secondary); /* Nền hover xám nhạt */
            color: var(--gaming-accent); /* Chữ accent khi hover */
        }

        .custom-dropdown-divider {
            border-top: 1px solid #d8d8d8; /* Đường kẻ chia màu xám */
            margin: 5px 0;
        }

        .custom-dropdown-content a.text-danger {
            color: var(--gaming-red) !important; /* Màu đỏ tiêu chuẩn cho logout */
        }

        .custom-dropdown-content a.text-danger:hover {
            background-color: var(--gaming-red);
            color: white !important;
        }

        /* THAY ĐỔI: Bỏ quy tắc này, jQuery sẽ tự thêm display: block khi cần */
        /* .custom-dropdown.show .custom-dropdown-content {
            display: block;
        } */

        /* Adjustments for avatar in dropdown toggle */
        .navbar-custom .nav-link img {
            border: 2px solid var(--gaming-green); /* Border xanh lá quanh avatar */
            margin-right: 8px;
        }

        .navbar-custom .nav-link span {
            color: var(--gaming-light);
        }

        /*
          * CÁC QUY TẮC CSS DƯỚI ĐÂY DÙNG ĐỂ "ĐẢM BẢO KHÔNG ẢNH HƯỞNG ĐẾN CÁC VIEW KHÁC"
          * CỤ THỂ LÀ CÁC TRANG CÓ CÁC STYLE RIÊNG (NHƯ TRANG LOGIN)
          * Chúng ta sẽ nhắm mục tiêu vào body khi nó có một lớp (class) cụ thể
          * hoặc khi một div wrapper cụ thể tồn tại.
          * Đây là một cách giải quyết KHÔNG SẠCH SẼ NHƯ DÙNG FILE CSS RIÊNG
          * nhưng nó hoạt động khi bạn không muốn tạo file mới.
          */

        /* Khi body có class 'login-page-body', hãy reset các style global của body */
        /* Bạn sẽ cần THÊM class 'login-page-body' vào thẻ <body> của trang login. */
        body.login-page-body {
            padding-top: 0 !important; /* Bỏ padding của navbar cố định */
            background-color: #e9ecef !important; /* Đặt lại nền cho trang login */
            color: #333 !important; /* Đặt lại màu chữ cho trang login */
            font-family: 'Inter', sans-serif !important; /* Đặt lại font cho trang login */
            display: flex !important; /* Bật flexbox để căn giữa nội dung trang login */
            justify-content: center !important;
            align-items: center !important;
            min-height: 100vh !important;
            margin: 0 !important;
            overflow: hidden !important;
        }

        /* Thẻ nav trong trang login nếu có (có thể ẩn nó đi hoặc đặt display: none) */
        body.login-page-body .navbar-custom {
            display: none !important; /* Ẩn navbar trên trang login */
        }

        /* Điều chỉnh div.container nếu nó ảnh hưởng đến bố cục trang login */
        body.login-page-body .container.mt-4 {
            /* Bạn có thể reset hoặc điều chỉnh các thuộc tính của nó nếu cần */
            margin-top: 0 !important;
            padding-left: 0 !important;
            padding-right: 0 !important;
            max-width: none !important;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-custom shadow-sm">
    <div class="container d-flex align-items-center justify-content-between flex-nowrap">
        <a class="navbar-brand fw-bold me-4" href="/webbanhang/Product/">ThangTech+</a>

        <ul class="navbar-nav flex-row align-items-center">
            <?php if (SessionHelper::isAdmin()): ?>
                <li class="nav-item custom-dropdown mx-2 admin-dropdown">
                    <a class="nav-link custom-dropdown-toggle d-flex align-items-center" href="#" id="adminDropdown">
                        <i class="bi bi-tools mr-1"></i> Quản trị
                    </a>
                    <div class="custom-dropdown-content" aria-labelledby="adminDropdown">
                        <a class="dropdown-item" href="/webbanhang/Product/add">
                            <i class="bi bi-plus-circle"></i> Thêm sản phẩm
                        </a>
                        <a class="dropdown-item" href="/webbanhang/Product/manage">
                            <i class="bi bi-gear-fill"></i> Quản lý sản phẩm
                        </a>
                        <a class="dropdown-item" href="/webbanhang/account/statistic">
                            <i class="bi bi-people-fill"></i> Thống kê tài khoản
                        </a>
                        <a class="dropdown-item" href="/webbanhang/Category/list">
                            <i class="bi bi-tags-fill"></i> Quản lý danh mục
                        </a>
                    </div>
                </li>
            <?php endif; ?>
        </ul>

        <div class="search-wrapper">
            <form class="w-100" action="/webbanhang/Product/search" method="get">
                <div class="input-group search-input">
                    <input class="form-control" type="search" name="query" placeholder="Bạn cần tìm gì?" aria-label="Search">
                    <div class="input-group-append">
                        <button class="btn btn-outline-dark" type="submit"><i class="bi bi-search"></i></button>
                    </div>
                </div>
            </form>
        </div>

        <ul class="navbar-nav flex-row align-items-center">
            <li class="nav-item position-relative mx-2">
                <a class="nav-link" href="/webbanhang/Product/cart">
                    <i class="bi bi-cart4"></i> Giỏ hàng
                    <?php if ($cartCount > 0): ?>
                        <span class="badge badge-danger badge-cart position-absolute" style="top: 2px; right: -10px;">
                            <?= $cartCount ?>
                        </span>
                    <?php endif; ?>
                </a>
            </li>
            <?php if (SessionHelper::isLoggedIn()) : ?>
                <li class="nav-item custom-dropdown mx-2">
                    <a class="nav-link custom-dropdown-toggle d-flex align-items-center" href="#" id="userDropdown">
                        <img src="/webbanhang/<?= htmlspecialchars($_SESSION['avatar'] ?? 'uploads/default_avatar.png'); ?>"
                            alt="avatar"
                            class="rounded-circle"
                            style="width: 30px; height: 30px; object-fit: cover;">
                        <span><?= htmlspecialchars($_SESSION['username'] ?? '', ENT_QUOTES, 'UTF-8'); ?></span>
                    </a>
                    <div class="custom-dropdown-content" aria-labelledby="userDropdown">
                        <a class="dropdown-item" href="/webbanhang/account/profile">
                            <i class="bi bi-person-circle"></i> Trang cá nhân
                        </a>
                        <a class="dropdown-item" href="/webbanhang/account/showPurchaseHistory">
                            <i class="bi bi-receipt"></i> Lịch sử mua hàng
                        </a>
                        <div class="custom-dropdown-divider"></div>
                        <a class="dropdown-item text-danger" href="/webbanhang/account/logout">
                            <i class="bi bi-box-arrow-right"></i> Đăng xuất
                        </a>
                    </div>
                </li>
            <?php else : ?>
                <li class="nav-item mx-2">
                    <a class="nav-link" href="/webbanhang/account/login">Đăng nhập</a>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</nav>

<div class="container mt-4">
    </div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Custom Dropdown Logic for Header Nav
        $('.custom-dropdown-toggle').on('click', function(event) {
            event.preventDefault(); // Ngăn hành vi mặc định của thẻ <a>
            event.stopPropagation(); // Ngăn sự kiện click lan truyền ra document

            const $thisDropdownToggle = $(this);
            const $thisDropdownMenu = $thisDropdownToggle.next('.custom-dropdown-content');

            // Đóng tất cả các dropdown khác đang mở
            $('.custom-dropdown-content').not($thisDropdownMenu).slideUp(200);

            // Mở/đóng dropdown hiện tại
            $thisDropdownMenu.slideToggle(200);
        });

        // Đóng dropdown khi click bên ngoài
        $(document).on('click', function(event) {
            // Kiểm tra xem click có nằm trong bất kỳ custom-dropdown nào không
            if (!$(event.target).closest('.custom-dropdown').length) {
                $('.custom-dropdown-content').slideUp(200);
            }
        });
    });
</script>
</body>
</html>
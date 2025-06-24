<?php require_once 'app/helpers/SessionHelper.php'; ?>
<?php include 'app/views/shares/header.php'; ?>

<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css"/>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<style>
    body {
        background-color: #f0f2f5; /* Giữ màu nền sáng */
    }
    .col-5th { width: 20%; max-width: 20%; padding: 8px; }
    @media (max-width: 1200px) { .col-5th { width: 25%; } }
    @media (max-width: 992px) { .col-5th { width: 33.33%; } }
    @media (max-width: 768px) { .col-5th { width: 50%; } }
    @media (max-width: 576px) { .col-5th { width: 100%; } }

    .card.product-card {
        height: 100%;
        display: flex;
        flex-direction: column;
        border-radius: 12px;
        overflow: hidden;
        transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
        background-color: #ffffff;
        border: none;
    }
    .card.product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
    }
    .card-body { flex-grow: 1; display: flex; flex-direction: column; padding: 15px; }
    .card-title {
        min-height: 40px;
        overflow: hidden;
        text-overflow: ellipsis;
        font-size: 1rem;
        line-height: 1.3;
        margin-bottom: 8px;
    }
    .card-body p.text-muted:last-of-type { min-height: 50px; overflow: hidden; text-overflow: ellipsis; }

    .card-img-top {
        width: 100%;
        height: 180px;
        object-fit: contain;
        background-color: #e9ecef;
        padding: 10px;
        border-bottom: 1px solid #dee2e6;
        transition: transform 0.3s ease-in-out;
        border-radius: 12px 12px 0 0;
    }
    .card:hover .card-img-top { transform: scale(1.05); }

    .product-badge { font-size: 0.75rem; padding: 4px 8px; font-weight: bold; border-radius: 3px; }
    .discount-badge { background-color: #dc3545; color: white; }
    .installment-badge { background-color: #007bff; color: white; }
    .card-title a { color: #333; }
    .card-title a:hover { color: #ff5722; text-decoration: underline; }
    .product-card { font-size: 0.95rem; }

    .action-btn {
        width: 34px; height: 34px; padding: 0; display: inline-flex;
        align-items: center; justify-content: center; border-radius: 50%;
        font-size: 0.9rem; transition: all 0.2s ease-in-out;
    }
    .action-btn i { margin: 0; }
    /* Animation for action buttons */
    .action-btn:hover {
        transform: scale(1.1);
        box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    }

    .btn-buy {
        border-radius: 20px; padding: 8px 16px; font-size: 0.9rem;
        display: inline-flex; align-items: center; gap: 5px;
        font-weight: bold;
        transition: all 0.3s ease-in-out; /* Add transition */
    }
    .btn-buy:hover {
        transform: translateY(-2px); /* Slight lift on hover */
        box-shadow: 0 4px 10px rgba(220,53,69,0.4); /* Shadow on hover */
    }

    /* CUSTOM STYLES FOR DROPDOWNS */
    .custom-dropdown {
        position: relative;
        display: inline-block;
    }

    .custom-dropdown-toggle {
        background-color: #ffffff;
        color: #333;
        padding: 8px 15px;
        border: 1px solid #ced4da;
        border-radius: 18px;
        cursor: pointer;
        font-size: 0.875rem;
        transition: all 0.2s ease-in-out;
        display: flex;
        align-items: center;
        gap: 5px;
        user-select: none; /* Prevent text selection on click */
    }

    .custom-dropdown-toggle:hover {
        background-color: #e9ecef;
        transform: translateY(-1px);
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }

    .custom-dropdown-menu {
        display: none; /* Hidden by default */
        position: absolute;
        background-color: #f9f9f9;
        min-width: 160px;
        box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
        z-index: 1;
        border-radius: 8px;
        overflow: hidden;
        margin-top: 5px;
        left: 0;
    }

    .custom-dropdown-menu a {
        color: black;
        padding: 12px 16px;
        text-decoration: none;
        display: block;
        font-size: 0.875rem;
        transition: background-color 0.2s ease;
    }

    .custom-dropdown-menu a:hover {
        background-color: #ddd;
    }

    .custom-dropdown-menu a.active {
        background-color: #d90429;
        color: white;
    }
    /* END CUSTOM STYLES */

    /* Slick Carousel Customization */
    .slick-prev, .slick-next {
        display: none !important; /* Hide arrows */
    }
    .slick-dots li button:before {
        font-size: 12px; /* Smaller dots */
        color: rgba(0, 0, 0, 0.5) !important; /* Change dot color for light background */
        transition: color 0.2s ease, transform 0.2s ease;
    }
    .slick-dots li.slick-active button:before {
        color: #d90429 !important; /* Active dot color, matching the red */
        transform: scale(1.2);
    }

    .carousel-slide img {
        height: 500px;
        object-fit: cover;
        border-radius: 15px;
        transition: transform 0.5s ease; /* Smooth transition for zoom */
    }
    /* Add a subtle zoom on hover for carousel images */
    .carousel-slide:hover img {
        transform: scale(1.01);
    }

    .slick-banner {
        margin-bottom: 20px;
        position: relative;
    }

    /* Fade effect for the banner */
    .slick-banner:before,
    .slick-banner:after {
        content: '';
        position: absolute;
        top: 0;
        height: 100%;
        width: 15%;
        z-index: 1;
        pointer-events: none;
    }

    .slick-banner:before {
        left: 0;
        background: linear-gradient(to right, rgba(240, 242, 245, 1), rgba(240, 242, 245, 0));
    }

    .slick-banner:after {
        right: 0;
        background: linear-gradient(to left, rgba(240, 242, 245, 1), rgba(240, 242, 245, 0));
    }

    .promo-item {
        display: block;
        background-color: #ffffff;
        padding: 12px 8px;
        border-radius: 12px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.12);
        color: #000;
        transition: all 0.3s ease-in-out;
        font-size: 0.85rem;
        text-decoration: none;
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        text-align: center;
    }
    .promo-item:hover {
        transform: translateY(-3px); /* Lighter lift for promo items */
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        color: #d90429 !important;
        background-color: #f8f9fa;
    }
    .promo-item small {
        font-size: 0.75rem;
        display: block;
        margin-top: 5px;
    }

    .promo-item img {
        height: 24px;
    }

    .brand-logos {
        gap: 24px;
        background-color: #ffffff;
        padding: 20px;
        border-radius: 15px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    }

    .brand-logo {
        width: 70px;
        height: 70px;
        border-radius: 50%;
        background-color: #f8f9fa;
        box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease, border-color 0.3s ease; /* Add border-color transition */
        border: 1px solid #e9ecef;
    }

    .brand-logo:hover {
        transform: scale(1.15);
        box-shadow: 0 6px 15px rgba(0,0,0,0.25);
        border-color: #d90429; /* Highlight border on hover */
    }

    .brand-logo img {
        max-height: 38px;
        max-width: 80%;
        object-fit: contain;
        filter: drop-shadow(0 0 2px rgba(0,0,0,0.15));
    }

    h2.text-danger {
        color: #d90429 !important;
        letter-spacing: 1px;
        margin-top: 40px !important;
        margin-bottom: 30px !important;
    }

    .product-sort-section {
        background-color: #ffffff;
        padding: 15px 20px;
        border-radius: 12px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        margin-bottom: 25px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .product-sort-section .btn {
        padding: 6px 15px;
        font-size: 0.875rem;
        border-radius: 18px;
        transition: all 0.2s ease-in-out; /* Add transition for buttons */
    }
    .product-sort-section .btn:hover {
        transform: translateY(-1px); /* Slight lift on hover */
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }

    /* Retained original product-grid-container background color */
    .product-grid-container {
        background-color: #343a40; /* Darker background for the product grid */
        padding: 20px;
        border-radius: 15px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    }

    .pagination .page-item .page-link {
        border-radius: 8px !important;
        margin: 0 3px;
        transition: all 0.2s ease-in-out;
    }
    .pagination .page-item.active .page-link,
    .pagination .page-item .page-link:hover {
        background-color: #d90429;
        border-color: #d90429;
        color: white;
    }
    .pagination .page-item .page-link {
        color: #333;
    }
    /* Add a subtle animation for pagination links */
    .pagination .page-item .page-link:hover {
        transform: translateY(-1px);
        box-shadow: 0 2px 5px rgba(217, 4, 41, 0.2);
    }
</style>

<div class="container mt-4">
    <div class="slick-banner">
        <div class="carousel-slide">
            <a href="/webbanhang/Product/show/02">
                <img src="/webbanhang/image/banner/banner1.jpg" class="w-100 rounded shadow" alt="Acer Predator Helios 18 AI">
            </a>
        </div>
        <div class="carousel-slide">
            <a href="/webbanhang/Product/show/07">
                <img src="/webbanhang/image/banner/banner2.jpg" class="w-100 rounded shadow" alt="Asus ROG Strix G15/17">
            </a>
        </div>
        <div class="carousel-slide">
            <a href="/webbanhang/Product/show/34">
                <img src="/webbanhang/image/banner/banner3.jpg" class="w-100 rounded shadow" alt="Gigabyte Aorus">
            </a>
        </div>
        <div class="carousel-slide">
            <a href="/webbanhang/Product/show/31">
                <img src="/webbanhang/image/banner/banner4.jpg" class="w-100 rounded shadow" alt="MSI ">
            </a>
        </div>
        <div class="carousel-slide">
            <a href="/webbanhang/Product/show/01">
                <img src="/webbanhang/image/banner/banner5.jpg" class="w-100 rounded shadow" alt="HP Victus">
            </a>
        </div>
        <div class="carousel-slide">
            <a href="/webbanhang/Product/show/14">
                <img src="/webbanhang/image/banner/banner6.jpg" class="w-100 rounded shadow" alt="DELL G15">
            </a>
        </div>
        <div class="carousel-slide">
            <a href="/webbanhang/Product/show/105">
                <img src="/webbanhang/image/banner/banner7.jpg" class="w-100 rounded shadow" alt="Lenovo Ideapad">
            </a>
        </div>
    </div>

    <div class="row mt-4 text-center text-uppercase fw-bold small g-3">
        <div class="col-md">
            <a href="/webbanhang/Product/show/2" class="promo-item">
                Acer Predator Helios 18 AI<br><small class="fw-normal text-muted">Mua ngay</small>
            </a>
        </div>
        <div class="col-md">
            <a href="/webbanhang/Product/show/62" class="promo-item">
                Lenovo Gaming Legion 5<br><small class="fw-normal text-muted">Giá tốt chốt ngay</small>
            </a>
        </div>
        <div class="col-md">
            <a href="/webbanhang/Product/show/66" class="promo-item">
                MSI G6 KF<br><small class="fw-normal text-muted">Chỉ có tại CPS</small>
            </a>
        </div>
        <div class="col-md">
            <a href="/webbanhang/account/register" class="promo-item text-danger">
                Đăng ký<br><small class="fw-bold">Nhận ngay gói AI Hay</small>
            </a>
        </div>
    </div>

    <?php
    $brands = [
        ['name' => 'Dell', 'logo' => 'https://upload.wikimedia.org/wikipedia/commons/4/48/Dell_Logo.svg'],
        ['name' => 'HP', 'logo' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/a/ad/HP_logo_2012.svg/150px-HP_logo_2012.svg.png'],
        ['name' => 'Asus', 'logo' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/2/2e/ASUS_Logo.svg/750px-ASUS_Logo.svg.png'],
        ['name' => 'Acer', 'logo' => 'https://images.acer.com/is/content/acer/acer-4'],
        ['name' => 'Lenovo', 'logo' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/b/b8/Lenovo_logo_2015.svg/750px-Lenovo_logo_2015.svg.png'],
        ['name' => 'Apple', 'logo' => 'https://upload.wikimedia.org/wikipedia/commons/f/fa/Apple_logo_black.svg'],
        ['name' => 'MSI', 'logo' => 'https://upload.wikimedia.org/wikipedia/vi/6/6c/Msi_logo.png?20201107090254'],
        ['name' => 'Gigabyte', 'logo' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/c/c3/Gigabyte_Technology_logo_20080107.svg/470px-Gigabyte_Technology_logo_20080107.svg.png']
    ];
    ?>

    <div class="brand-logos d-flex justify-content-center flex-wrap gap-4 mt-5">
        <?php foreach ($brands as $brand): ?>
            <form action="/webbanhang/Product/search_results" method="get" class="brand-logo-form">
                <input type="hidden" name="keyword" value="<?= htmlspecialchars($brand['name']) ?>">
                <button type="submit" class="brand-logo d-flex align-items-center justify-content-center" title="Tìm <?= $brand['name'] ?>">
                    <img src="<?= $brand['logo'] ?>" alt="<?= $brand['name'] ?>">
                </button>
            </form>
        <?php endforeach; ?>
    </div>

    <h2 class="text-center my-4 text-uppercase fw-bold text-danger">Deal Sốc Mỗi Ngày</h2>

    <div class="product-sort-section">
        <div class="d-flex align-items-center gap-5"> <label class="fw-bold mb-0 text-dark">Sắp xếp theo:</label>
            <?php
            // Get current sort and filter parameters
            $currentSort = $_GET['sort'] ?? '';
            $currentPriceRange = $_GET['price_range'] ?? '';
            $currentPageParam = isset($_GET['page']) ? '&page=' . $_GET['page'] : '';

            // Function to generate URL with current parameters
            function generateUrl($sort = '', $priceRange = '', $page = 1) {
                $params = [];
                if ($sort) {
                    $params[] = 'sort=' . $sort;
                }
                if ($priceRange) {
                    $params[] = 'price_range=' . $priceRange;
                }
                if ($page > 1) { // Only add page if it's not the first page
                    $params[] = 'page=' . $page;
                }
                return '/webbanhang/Product/index' . (!empty($params) ? '?' . implode('&', $params) : '');
            }
            ?>

            <div class="custom-dropdown">
                <div class="custom-dropdown-toggle">
                    <i class="bi bi-funnel"></i> Sắp xếp giá <i class="bi bi-chevron-down"></i>
                </div>
                <div class="custom-dropdown-menu">
                    <a href="<?php echo generateUrl('asc', $currentPriceRange, 1); // Reset to page 1 on sort change ?>"
                       class="<?php echo ($currentSort === 'asc') ? 'active' : ''; ?>">
                        <i class="bi bi-sort-up"></i> Giá Thấp - Cao
                    </a>
                    <a href="<?php echo generateUrl('desc', $currentPriceRange, 1); // Reset to page 1 on sort change ?>"
                       class="<?php echo ($currentSort === 'desc') ? 'active' : ''; ?>">
                        <i class="bi bi-sort-down-alt"></i> Giá Cao - Thấp
                    </a>
                    <a href="<?php echo generateUrl('', $currentPriceRange, 1); // Reset to page 1 on sort change ?>"
                       class="<?php echo ($currentSort === '') ? 'active' : ''; ?>">
                        <i class="bi bi-arrow-clockwise"></i> Mặc định
                    </a>
                </div>
            </div>

            <label class="fw-bold mb-0 text-dark">Lọc giá:</label>
            <div class="custom-dropdown">
                <div class="custom-dropdown-toggle">
                    <i class="bi bi-currency-dollar"></i> Khoảng giá <i class="bi bi-chevron-down"></i>
                </div>
                <div class="custom-dropdown-menu">
                    <a href="<?php echo generateUrl($currentSort, '0-20000000', 1); // Reset to page 1 on filter change ?>"
                       class="<?php echo ($currentPriceRange === '0-20000000') ? 'active' : ''; ?>">
                        0 - 20 Triệu
                    </a>
                    <a href="<?php echo generateUrl($currentSort, '20000000-40000000', 1); // Reset to page 1 on filter change ?>"
                       class="<?php echo ($currentPriceRange === '20000000-40000000') ? 'active' : ''; ?>">
                        20 - 40 Triệu
                    </a>
                    <a href="<?php echo generateUrl($currentSort, '40000000-60000000', 1); // Reset to page 1 on filter change ?>"
                       class="<?php echo ($currentPriceRange === '40000000-60000000') ? 'active' : ''; ?>">
                        40 - 60 Triệu
                    </a>
                    <a href="<?php echo generateUrl($currentSort, '60000000-max', 1); // Reset to page 1 on filter change ?>"
                       class="<?php echo ($currentPriceRange === '60000000-max') ? 'active' : ''; ?>">
                        60 Triệu Trở Lên
                    </a>
                    <a href="<?php echo generateUrl($currentSort, '', 1); // Reset to page 1 on filter change ?>"
                       class="<?php echo ($currentPriceRange === '') ? 'active' : ''; ?>">
                        <i class="bi bi-arrow-clockwise"></i> Tất cả
                    </a>
                </div>
            </div>
        </div>

        <div>
            <img src="https://media3.giphy.com/media/2vkUyaJW3gVQtSfs2I/200w.webp"
                 alt="Ảnh gif"
                 style="width: 100px; height: auto; margin-right: 10px; border-radius: 8px;">
            <img src="https://media0.giphy.com/media/eu9t1uWl452jGY7hFb/200w.webp"
                 alt="Ảnh gif"
                 style="width: 100px; height: auto; border-radius: 8px;">
        </div>
    </div>

    <?php
    if (isset($products)) { // Ensure $products array is defined
        // Filter by price range first
        if (!empty($_GET['price_range'])) {
            $range = $_GET['price_range'];
            list($min, $max) = explode('-', $range);
            $min = (float)$min; // Use float for currency
            $max = ($max === 'max') ? PHP_FLOAT_MAX : (float)$max; // Use float max

            $filteredProducts = array_filter($products, function($product) use ($min, $max) {
                return $product->price >= $min && $product->price <= $max;
            });
            $products = array_values($filteredProducts); // Re-index the array
        }

        // Then sort the filtered products
        if (!empty($_GET['sort'])) {
            if ($_GET['sort'] === 'asc') {
                usort($products, fn($a, $b) => $a->price <=> $b->price);
            } elseif ($_GET['sort'] === 'desc') {
                usort($products, fn($a, $b) => $b->price <=> $a->price);
            }
        }

        // Pagination variables
        $productsPerPage = 20; // Số sản phẩm trên mỗi trang
        $totalProducts = count($products); // Tổng số sản phẩm
        $totalPages = ($totalProducts > 0) ? ceil($totalProducts / $productsPerPage) : 1; // Tổng số trang, ít nhất là 1
        $currentPage = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1; // Trang hiện tại, mặc định là 1

        // Đảm bảo trang hiện tại không vượt quá tổng số trang
        if ($currentPage > $totalPages) {
            $currentPage = $totalPages;
        }

        $offset = ($currentPage - 1) * $productsPerPage; // Vị trí bắt đầu của sản phẩm trên trang hiện tại

        // Lấy danh sách sản phẩm cho trang hiện tại
        $paginatedProducts = array_slice($products, $offset, $productsPerPage);
    } else {
        $paginatedProducts = []; // Initialize as empty if $products is not set
        $totalPages = 0;
        $currentPage = 1;
    }
    ?>

    <div class="product-grid-container">
        <div class="row">
            <?php if (!empty($paginatedProducts)): ?>
                <?php foreach ($paginatedProducts as $product): ?>
                    <div class="col-5th d-flex align-items-stretch">
                        <div class="card border shadow-sm w-100 product-card position-relative d-flex flex-column h-100">
                            <a href="/webbanhang/Product/show/<?php echo $product->id; ?>">
                                <img src="/webbanhang/<?php echo htmlspecialchars($product->image ?? 'public/images/default-laptop.png', ENT_QUOTES, 'UTF-8'); ?>"
                                     class="card-img-top img-fluid"
                                     alt="<?php echo htmlspecialchars($product->name); ?>">
                            </a>

                            <div class="card-body d-flex flex-column p-3">
                                <h6 class="card-title fw-bold mb-2">
                                    <a href="/webbanhang/Product/show/<?php echo $product->id; ?>" class="text-decoration-none">
                                        <?php echo htmlspecialchars($product->name); ?>
                                    </a>
                                </h6>
                                <div class="mb-2 text-danger fw-bold fs-5">
                                    <?php echo number_format($product->price, 0, ',', '.'); ?> VND
                                </div>
                                <p class="text-muted mb-1 small"><strong>Thương hiệu:</strong> <?php echo htmlspecialchars($product->category_name); ?></p>

                                <div class="mt-auto pt-2">
                                    <div class="d-flex justify-content-between align-items-center gap-2">
                                        <?php if (SessionHelper::isAdmin()): ?>
                                            <a href="/webbanhang/Product/edit/<?php echo $product->id; ?>"
                                               class="btn btn-outline-warning action-btn" title="Sửa">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <a href="/webbanhang/Product/delete/<?php echo $product->id; ?>"
                                               class="btn btn-outline-danger action-btn" title="Xóa"
                                               onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?');">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        <?php endif; ?>
                                        <a href="/webbanhang/Product/addToCart/<?php echo $product->id; ?>"
                                           class="btn btn-danger btn-buy ms-auto" title="Thêm vào giỏ">
                                            <i class="bi bi-cart-plus"></i> Mua
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center text-white-50 py-5">
                    Không tìm thấy sản phẩm nào.
                </div>
            <?php endif; ?>
        </div>
    </div>

    <nav aria-label="Page navigation" class="mt-4">
        <ul class="pagination justify-content-center">
            <?php
            // Regenerate URL parameters for pagination, ensuring existing sort/filter are kept
            $currentSortParam = isset($_GET['sort']) ? '&sort=' . $_GET['sort'] : '';
            $currentPriceRangeParam = isset($_GET['price_range']) ? '&price_range=' . $_GET['price_range'] : '';
            ?>
            <?php if ($currentPage > 1): ?>
                <li class="page-item">
                    <a class="page-link" href="?page=<?php echo $currentPage - 1; ?><?php echo $currentSortParam; ?><?php echo $currentPriceRangeParam; ?>" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <li class="page-item <?php echo ($i == $currentPage) ? 'active' : ''; ?>">
                    <a class="page-link" href="?page=<?php echo $i; ?><?php echo $currentSortParam; ?><?php echo $currentPriceRangeParam; ?>"><?php echo $i; ?></a>
                </li>
            <?php endfor; ?>

            <?php if ($currentPage < $totalPages): ?>
                <li class="page-item">
                    <a class="page-link" href="?page=<?php echo $currentPage + 1; ?><?php echo $currentSortParam; ?><?php echo $currentPriceRangeParam; ?>" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </nav>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
<script>
    $(document).ready(function(){
        // Banner Slider
        $('.slick-banner').slick({
            dots: true,
            arrows: false,
            infinite: true,
            speed: 500,
            autoplay: true,
            autoplaySpeed: 3000,
            slidesToShow: 1,
            slidesToScroll: 1
        });

        // Custom Dropdown Logic
        $('.custom-dropdown-toggle').on('click', function(event) {
            event.stopPropagation(); // Prevent document click from closing it immediately
            $(this).next('.custom-dropdown-menu').slideToggle(200); // Toggle with a slide effect
            // Close other dropdowns when one is opened
            $('.custom-dropdown-menu').not($(this).next('.custom-dropdown-menu')).slideUp(200);
        });

        // Close dropdowns when clicking anywhere else on the document
        $(document).on('click', function(event) {
            if (!$(event.target).closest('.custom-dropdown').length) {
                $('.custom-dropdown-menu').slideUp(200);
            }
        });
    });
</script>
<?php include 'app/views/shares/footer.php'; ?>
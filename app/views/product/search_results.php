<?php include 'app/views/shares/header.php'; ?>

<style>
    /* Base styles */
    body {
        background-color: #f0f2f5; /* Consistent gaming theme background */
        color: #333; /* Standard text color */
    }

    .container.search-results {
        padding-top: 40px;
        padding-bottom: 40px;
    }

    /* Carousel Specific Styles */
    .carousel-container {
        margin-bottom: 40px; /* Space between carousel and search results */
        border-radius: 15px; /* Rounded corners for the carousel container */
        overflow: hidden; /* Ensures images respect border-radius */
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1); /* Subtle shadow for the carousel */
    }

    .carousel-item img {
        width: 100%;
        height: 350px; /* Fixed height for consistency, adjust as needed */
        object-fit: cover; /* Cover ensures image fills the area, cropping if necessary */
        border-radius: 15px; /* Match container border-radius */
    }

    /* Optional: Style for carousel controls/indicators if default Bootstrap isn't enough */
    .carousel-control-prev-icon,
    .carousel-control-next-icon {
        background-color: rgba(0, 0, 0, 0.5); /* Semi-transparent background for better visibility */
        border-radius: 50%; /* Make them round */
        padding: 10px;
    }
    .carousel-indicators [data-bs-target] {
        background-color: #d90429; /* Active indicator color */
    }


    /* Search Results Heading */
    .search-results h3 {
        font-weight: bold;
        color: #212529;
        margin-bottom: 30px;
        font-size: 2.2rem;
        border-bottom: 2px solid #d90429;
        padding-bottom: 10px;
        text-align: center;
    }

    .search-results h3 strong {
        color: #d90429;
    }

    /* Product Card Styles */
    .product-card {
        border-radius: 15px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
        text-decoration: none;
        color: inherit;
        background-color: #ffffff;
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .product-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        text-decoration: none;
    }

    .product-img {
        height: 220px;
        object-fit: contain;
        background-color: #f8f9fa;
        border-bottom: 1px solid #e0e0e0;
        padding: 15px;
        border-radius: 15px 15px 0 0;
    }

    .product-title {
        font-size: 1.25rem;
        font-weight: bold;
        color: #333;
        min-height: 60px;
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        line-clamp: 2;
        -webkit-box-orient: vertical;
    }

    .product-price {
        font-size: 1.3rem;
        font-weight: bold;
        color: #d90429;
        margin-top: auto;
        padding-top: 10px;
        border-top: 1px dashed #eee;
    }

    .product-link {
        text-decoration: none;
        color: inherit;
        display: block;
        height: 100%;
    }

    .product-card .card-body {
        padding: 20px;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }

    .alert-warning {
        background-color: #fff3cd;
        border-color: #ffeeba;
        color: #856404;
        border-radius: 10px;
        padding: 20px;
        font-size: 1.1rem;
        font-weight: 500;
        margin-top: 30px;
    }

    /* Responsive adjustments for carousel */
    @media (max-width: 768px) {
        .carousel-item img {
            height: 200px; /* Smaller height on mobile */
        }
    }
</style>

<div class="container mt-5">
    <div class="carousel-container">
        <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
            </div>
            <div class="carousel-inner">
                <div class="carousel-item active" data-bs-interval="5000"> <img src="/webbanhang/image/banner/banner8.jpg" class="d-block w-100" alt="Gaming Laptop Banner 1">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Trải nghiệm gaming đỉnh cao</h5>
                        <p>Sức mạnh vượt trội, đồ họa chân thực.</p>
                    </div>
                </div>
                <div class="carousel-item" data-bs-interval="5000"> <img src="/webbanhang/image/banner/banner9.jpg" class="d-block w-100" alt="New Arrival Banner">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Sản phẩm mới về</h5>
                        <p>Nhiều lựa chọn hấp dẫn đang chờ đón.</p>
                    </div>
                </div>
                <div class="carousel-item" data-bs-interval="5000"> <img src="/webbanhang/image/banner/banner10.jpg" class="d-block w-100" alt="Discount Offer Banner">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Ưu đãi lớn trong tháng</h5>
                        <p>Đừng bỏ lỡ cơ hội sở hữu.</p>
                    </div>
                </div>
            </div>
            </div>
    </div>
    <div class="search-results">
        <!-- <h3 class="mb-4">Kết quả tìm kiếm cho:
            <strong class="text-primary"><?php echo htmlspecialchars($_GET['keyword'] ?? ''); ?></strong>
        </h3> -->

        <?php if (!empty($results)) : ?>
            <div class="row">
                <?php foreach ($results as $product): ?>
                    <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                        <a href="/webbanhang/Product/show/<?php echo $product->id; ?>" class="product-link">
                            <div class="card product-card h-100">
                                <?php if (!empty($product->image)) : ?>
                                    <img src="/webbanhang/<?php echo htmlspecialchars($product->image); ?>" 
                                            alt="Ảnh sản phẩm <?php echo htmlspecialchars($product->name); ?>" 
                                            class="card-img-top product-img">
                                <?php else : ?>
                                    <img src="/webbanhang/public/images/default-laptop.png" 
                                            alt="Không có ảnh sản phẩm" 
                                            class="card-img-top product-img">
                                <?php endif; ?>

                                <div class="card-body d-flex flex-column p-3">
                                    <h5 class="product-title mb-2">
                                        <?php echo htmlspecialchars($product->name); ?>
                                    </h5>

                                    <p class="product-price mb-0">
                                        <?php echo number_format($product->price, 0, ',', '.'); ?> VND
                                    </p>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else : ?>
            <div class="alert alert-warning text-center" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i> Mình không tìm thấy thứ bạn cần.
            <br>
            <img src="https://i.pinimg.com/originals/d1/22/cb/d122cbf31e6601bf19f0673b2b751b5f.gif" 
                alt="Tonton thắc mắc" class="mx-auto d-block"
                style="width:200px; margin-top:10px;">
            </div>


        <?php endif; ?>
    </div>
</div>

<?php include 'app/views/shares/footer.php'; ?>
<?php include 'app/views/shares/header.php'; ?>

<style>
    /* Base styles */
    body {
        background-color: #f0f2f5;
        color: #333;
    }

    .container {
        padding-top: 30px;
        padding-bottom: 30px;
    }

    /* Card-like sections */
    .product-image-section,
    .info-box,
    .description-section {
        background: #ffffff;
        padding: 20px;
        border-radius: 15px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    /* Product Image Gallery */
    .product-image-section {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .main-product-img {
        width: 100%;
        padding-top: 100%; /* 1:1 aspect ratio */
        position: relative;
        overflow: hidden;
        background-color: #e9ecef;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .main-product-img img {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: contain;
        border-radius: 10px;
        cursor: zoom-in;
        transition: opacity 0.3s ease-in-out, transform 0.3s ease-in-out;
        will-change: opacity, transform;
    }

    /* Animation states for main image */
    .main-product-img img.fade-out {
        opacity: 0;
        transform: translateX(-20px);
    }

    .main-product-img img.fade-in {
        opacity: 1;
        transform: translateX(0);
    }

    .thumbnail-gallery {
        display: flex;
        justify-content: center;
        gap: 12px;
        margin-top: 20px;
        overflow-x: hidden; /* Hide scrollbar */
        padding-bottom: 10px;
        width: 100%;
    }

    .thumbnail-gallery img {
        width: 90px;
        height: 90px;
        object-fit: cover;
        border: 3px solid #ddd;
        border-radius: 8px;
        cursor: pointer;
        transition: border-color 0.2s ease, transform 0.2s ease, box-shadow 0.2s ease;
    }

    .thumbnail-gallery img:hover {
        border-color: #ff5722;
        transform: scale(1.08);
        box-shadow: 0 0 8px rgba(255, 87, 34, 0.5);
    }

    .thumbnail-gallery img.active {
        border-color: #d90429;
        box-shadow: 0 0 10px rgba(217, 4, 41, 0.6);
        transform: scale(1.05);
    }

    /* Product Info Box */
    .info-box {
        padding: 30px;
    }

    .info-box h2 {
        font-size: 2.2rem;
        font-weight: bold;
        color: #212529;
        margin-bottom: 15px;
    }

    .product-price {
        font-size: 2.5rem;
        color: #d90429;
        font-weight: bold;
        margin-bottom: 25px;
        letter-spacing: 0.5px;
    }

    .specs-table {
        margin-top: 20px;
        border-collapse: separate;
        border-spacing: 0;
        background-color: #f8f9fa;
        border-radius: 10px;
        overflow: hidden;
        margin-bottom: 30px;
    }

    .specs-table th, .specs-table td {
        padding: 12px 15px;
        border-bottom: 1px solid #e0e0e0;
        text-align: left;
        font-size: 0.95rem;
    }

    .specs-table th {
        background-color: #e9ecef;
        font-weight: bold;
        color: #495057;
    }

    .specs-table tr:last-child th,
    .specs-table tr:last-child td {
        border-bottom: none;
    }

    /* Description Section */
    .description-section {
        margin-top: 30px;
        margin-bottom: 30px;
        display: flex;
        flex-wrap: wrap;
        align-items: flex-start;
        gap: 30px;
    }

    .description-section h3 {
        font-size: 1.8rem;
        font-weight: bold;
        color: #212529;
        margin-bottom: 20px;
        border-bottom: 2px solid #d90429;
        padding-bottom: 10px;
        width: 100%;
    }

    .description-content {
        flex: 1;
        min-width: 45%;
        max-width: calc(50% - 15px);
    }

    .description-image-wrapper {
        flex: 1;
        min-width: 45%;
        max-width: calc(50% - 15px);
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .description-image {
        width: 100%;
        max-height: 400px;
        object-fit: contain;
        border-radius: 10px;
        background-color: #f8f9fa;
        padding: 10px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    /* Add to Cart Button */
    .btn-danger {
        background-color: #d90429;
        border-color: #d90429;
        font-size: 1.1rem;
        padding: 12px 25px;
        border-radius: 30px;
        font-weight: bold;
        transition: background-color 0.2s ease, transform 0.2s ease, box-shadow 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-danger:hover {
        background-color: #ef233c;
        border-color: #ef233c;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(217, 4, 41, 0.4);
    }

    /* Related Products Section */
    h4.related-products-heading {
        font-size: 1.8rem;
        font-weight: bold;
        color: #212529;
        margin-bottom: 25px;
        padding-top: 15px;
        border-bottom: 2px solid #d90429;
        padding-bottom: 10px;
    }

    .related-product-card {
        border: none;
        border-radius: 12px;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        background: #ffffff;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        display: flex;
        flex-direction: column;
        height: 100%;
        overflow: hidden;
    }

    .related-product-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.15);
    }

    .related-product-card img {
        width: 100%;
        height: 180px;
        object-fit: contain;
        background-color: #f8f9fa;
        border-bottom: 1px solid #eee;
        border-radius: 12px 12px 0 0;
    }

    .related-product-card .card-body { /* Renamed p-2 to card-body for semantic clarity */
        flex-grow: 1;
        padding: 15px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .related-product-card h6 {
        min-height: 45px;
        overflow: hidden;
        text-overflow: ellipsis;
        font-size: 1rem;
        line-height: 1.3;
        margin-bottom: 10px;
    }

    .related-product-card h6 a {
        color: #333;
        text-decoration: none;
        transition: color 0.2s ease;
    }

    .related-product-card h6 a:hover {
        color: #d90429;
        text-decoration: underline;
    }

    /* Image Modal (Zoom) */
    .image-modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.9);
        align-items: center;
        justify-content: center;
    }

    .image-modal-content {
        margin: auto;
        display: block;
        max-width: 95%;
        max-height: 95%;
        object-fit: contain;
        border-radius: 8px;
    }

    .close-modal {
        position: absolute;
        top: 20px;
        right: 35px;
        color: #f1f1f1;
        font-size: 40px;
        font-weight: bold;
        transition: 0.3s;
        cursor: pointer;
    }

    .close-modal:hover,
    .close-modal:focus {
        color: #bbb;
        text-decoration: none;
        cursor: pointer;
    }

    /* Responsive adjustments */
    @media (max-width: 992px) {
        .description-content,
        .description-image-wrapper {
            max-width: 100%;
            margin-top: 20px;
        }
    }

    @media (max-width: 768px) {
        .product-image-section, .info-box, .description-section {
            padding: 15px;
        }
        .main-product-img {
            padding-top: 80%;
        }
        .thumbnail-gallery img {
            width: 70px;
            height: 70px;
        }
        .info-box h2 {
            font-size: 1.8rem;
        }
        .product-price {
            font-size: 2rem;
        }
        .btn-danger {
            width: 100%;
            text-align: center;
            justify-content: center;
        }
        h3.description-heading, h4.related-products-heading {
            font-size: 1.5rem;
        }
    }
</style>

<div class="container my-5" style="max-width: 1100px;">
    <div class="row gx-4">
        <div class="col-md-6 mb-4 mb-md-0">
            <div class="product-image-section">
                <?php
                // PHP Logic for image paths
                $mainImage = '/webbanhang/' . ($product->image ?? 'public/images/default-laptop.png');
                $productImages = [];
                $folderPath = $_SERVER['DOCUMENT_ROOT'] . "/webbanhang/image/product_" . $product->id . "/";

                if (is_dir($folderPath)) {
                    $files = scandir($folderPath);
                    $imageFiles = array_filter($files, function($file) {
                        return !in_array($file, ['.', '..']) && in_array(pathinfo($file, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                    });
                    foreach ($imageFiles as $file) {
                        $productImages[] = "/webbanhang/image/product_" . $product->id . "/" . $file;
                    }
                    sort($productImages);

                    // Prioritize product->image if it exists in the folder
                    $initialMainImageFound = false;
                    if ($product->image) {
                        $productImageBasename = basename($product->image);
                        foreach ($productImages as $img) {
                            if (basename($img) === $productImageBasename) {
                                $mainImage = $img;
                                $initialMainImageFound = true;
                                break;
                            }
                        }
                    }
                    // Fallback to first image in folder if no specific product->image, or product->image not in folder
                    if (!$initialMainImageFound && !empty($productImages)) {
                        $mainImage = $productImages[0];
                    }
                }
                $randomDescriptionImage = !empty($productImages) ? $productImages[array_rand($productImages)] : null;
                ?>

                <div class="main-product-img">
                    <img src="<?= htmlspecialchars($mainImage) ?>" alt="<?= htmlspecialchars($product->name) ?>" id="mainProductImage" class="img-fluid">
                </div>

                <?php if (!empty($productImages)): ?>
                    <div class="thumbnail-gallery" id="thumbnailGallery">
                        <?php foreach ($productImages as $thumb): ?>
                            <img src="<?= htmlspecialchars($thumb) ?>" class="<?= $thumb === $mainImage ? 'active' : '' ?>" onclick="changeMainImage(this)">
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="col-md-6">
            <div class="info-box">
                <h2><?= htmlspecialchars($product->name) ?></h2>
                <p class="mb-2">Hãng: <strong><?= htmlspecialchars($product->category_name) ?></strong></p>
                <div class="product-price"><?= number_format($product->price, 0, ',', '.') ?> VND</div>

                <hr class="my-4">

                <p class="fw-bold mb-3">Thông số kỹ thuật:</p>
                <table class="specs-table w-100">
                    <tr><th>CPU</th><td><?= htmlspecialchars($product->cpu ?? 'Đang cập nhật') ?></td></tr>
                    <tr><th>RAM</th><td><?= htmlspecialchars($product->ram ?? 'Đang cập nhật') ?></td></tr>
                    <tr><th>Ổ cứng</th><td><?= htmlspecialchars($product->ssd ?? 'Đang cập nhật') ?></td></tr>
                    <tr><th>Card đồ họa</th><td><?= htmlspecialchars($product->card ?? 'Đang cập nhật') ?></td></tr>
                </table>

                <form action="/webbanhang/Product/addToCart/<?= $product->id ?>" method="post">
                    <button type="submit" class="btn btn-danger mt-4">
                        <i class="bi bi-cart-plus"></i> Thêm vào giỏ hàng
                    </button>
                </form>
            </div>
        </div>
    </div>

    <?php if (!empty($product->description) || $randomDescriptionImage): ?>
        <div class="description-section">
            <h3>Mô tả sản phẩm</h3>
            
            <?php if (!empty($product->description)): ?>
                <div class="description-content">
                    <p style="white-space: pre-line" class="text-secondary"><?= nl2br(htmlspecialchars($product->description)) ?></p>
                </div>
            <?php endif; ?>

            <?php if ($randomDescriptionImage): ?>
                <div class="description-image-wrapper">
                    <img src="<?= htmlspecialchars($randomDescriptionImage) ?>" alt="Ảnh ngẫu nhiên sản phẩm" class="img-fluid description-image">
                </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($relatedProducts)): ?>
        <div class="mt-5">
            <h4 class="related-products-heading">Sản phẩm cùng danh mục</h4>
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
                <?php foreach ($relatedProducts as $related): ?>
                    <div class="col d-flex align-items-stretch">
                        <div class="related-product-card">
                            <a href="/webbanhang/Product/show/<?= $related->id ?>">
                                <img src="/webbanhang/<?= htmlspecialchars($related->image ?? 'public/images/default-laptop.png', ENT_QUOTES, 'UTF-8') ?>" class="w-100" alt="<?= htmlspecialchars($related->name) ?>">
                            </a>
                            <div class="card-body">
                                <h6 class="mb-1">
                                    <a href="/webbanhang/Product/show/<?= $related->id ?>" class="text-dark text-decoration-none">
                                        <?= htmlspecialchars($related->name) ?>
                                    </a>
                                </h6>
                                <div class="text-danger fw-bold"><?= number_format($related->price, 0, ',', '.') ?> VND</div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>
</div>

<div id="imageModal" class="image-modal">
    <span class="close-modal">&times;</span>
    <img class="image-modal-content" id="modalProductImg">
</div>

<?php include 'app/views/shares/footer.php'; ?>

<script>
    const mainProductImage = document.getElementById('mainProductImage');
    const thumbnailGallery = document.getElementById('thumbnailGallery');
    const imageModal = document.getElementById('imageModal');
    const modalProductImg = document.getElementById('modalProductImg');
    const closeModal = document.getElementsByClassName('close-modal')[0];

    function changeMainImage(thumbnail) {
        // Deactivate all thumbnails
        document.querySelectorAll('#thumbnailGallery img').forEach(img => img.classList.remove('active'));
        // Activate clicked thumbnail
        thumbnail.classList.add('active');

        // Apply fade-out animation
        mainProductImage.classList.add('fade-out');

        // After animation, update source and apply fade-in
        setTimeout(() => {
            mainProductImage.src = thumbnail.src;
            mainProductImage.classList.remove('fade-out');
            mainProductImage.classList.add('fade-in');

            // Remove fade-in class after a very short delay to re-trigger transition next time
            setTimeout(() => mainProductImage.classList.remove('fade-in'), 10);
        }, 300); // Matches CSS transition duration
    }

    // Initialize active thumbnail on page load
    document.addEventListener('DOMContentLoaded', () => {
        const currentMainImageSrc = mainProductImage.src;
        let initialActiveThumbnail = null;

        const thumbnails = thumbnailGallery.querySelectorAll('img');
        for (const img of thumbnails) { // Use for...of for cleaner iteration
            if (img.src === currentMainImageSrc) {
                initialActiveThumbnail = img;
                break; // Found it, no need to continue
            }
        }

        if (initialActiveThumbnail) {
            initialActiveThumbnail.classList.add('active');
        } else if (thumbnails.length > 0) { // If no match, activate the first one
            thumbnails[0].classList.add('active');
        }
    });

    // Modal functionality
    mainProductImage.addEventListener('click', () => {
        imageModal.style.display = 'flex';
        modalProductImg.src = mainProductImage.src;
    });

    closeModal.addEventListener('click', () => {
        imageModal.style.display = 'none';
    });

    imageModal.addEventListener('click', (event) => {
        if (event.target === imageModal) {
            imageModal.style.display = 'none';
        }
    });
</script>
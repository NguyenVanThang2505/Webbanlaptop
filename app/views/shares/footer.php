<footer class="gaming-footer mt-5 pt-4 pb-3 shadow-lg">
    <div class="container">
        <div class="row">
            <div class="col-md-4 mb-4">
                <h5 class="footer-brand">ThangTech+</h5>
                <p class="footer-description">Chuyên cung cấp các dòng laptop và gaming gear chất lượng, hỗ trợ trả góp 0%. Đảm bảo uy tín - chất lượng - phục vụ tận tâm.</p>
                <div class="social-icons mt-3">
                    <a href="#" class="social-icon"><i class="bi bi-facebook"></i></a>
                    <a href="#" class="social-icon"><i class="bi bi-instagram"></i></a>
                    <a href="#" class="social-icon"><i class="bi bi-youtube"></i></a>
                    <a href="#" class="social-icon"><i class="bi bi-twitter"></i></a>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <h6 class="footer-heading">Liên kết nhanh</h6>
                <ul class="list-unstyled footer-links">
                    <li><a href="/webbanhang/Product/">Sản phẩm</a></li>
                    <li><a href="/webbanhang/Product/cart">Giỏ hàng</a></li>
                    <li><a href="/webbanhang/Product/checkout">Thanh toán</a></li>
                    <li><a href="/webbanhang/account/login">Đăng nhập</a></li>
                    <li><a href="/webbanhang/ad/aboutme">Về chúng tôi</a></li>                </ul>
            </div>

            <div class="col-md-4 mb-4">
                <h6 class="footer-heading">Liên hệ</h6>
                <p class="contact-info"><i class="bi bi-telephone me-2 gaming-accent-icon"></i> 0353 124 275</p>
                <p class="contact-info"><i class="bi bi-envelope me-2 gaming-accent-icon"></i> nguyenvanthang2505200425@gmail.com</p>
                <p class="contact-info"><i class="bi bi-geo-alt me-2 gaming-accent-icon"></i> Ấp Phú Sớn, xã Bắc Sơn, huyện Trảng Bom, Tỉnh Đồng Nai, Việt Nam</p>
                <p class="contact-info"><i class="bi bi-clock me-2 gaming-accent-icon"></i> Thứ 2 - Thứ 7: 9:00 AM - 6:00 PM</p>
            </div>
        </div>

        <div class="footer-bottom-bar text-center pt-3 mt-3">
            &copy; <?php echo date('Y'); ?> ThangTech+. All rights reserved.
        </div>
    </div>
</footer>

</div> <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css"/>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>

<script>
    // Ensure the document is ready before initializing Slick
    $(document).ready(function(){
        // Check if the element exists to avoid errors on pages without it
        if ($('.slick-slider-row').length) {
            $('.slick-slider-row').slick({
                slidesToShow: 5,
                slidesToScroll: 1,
                arrows: true,
                infinite: false, // Set to true if you want infinite looping
                responsive: [
                    { breakpoint: 1200, settings: { slidesToShow: 4 }},
                    { breakpoint: 992,  settings: { slidesToShow: 3 }},
                    { breakpoint: 768,  settings: { slidesToShow: 2 }},
                    { breakpoint: 576,  settings: { slidesToShow: 1 }}
                ]
            });
        }
    });
</script>

</body>
</html>
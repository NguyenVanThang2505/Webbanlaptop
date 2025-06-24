<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giới thiệu về Laptop Store - Nơi công nghệ hội tụ</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            font-family: 'Open Sans', sans-serif;
            line-height: 1.7;
            color: #343a40;
            background-color: #f0f2f5; /* Light grey background */
            overflow-x: hidden; /* Prevent horizontal scroll */
        }
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            color: #212529;
        }

        /* Header Section */
        .header-bg {
            background: linear-gradient(to right, #007bff, #0056b3);
            color: white;
            padding: 100px 0;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        .header-bg::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('https://source.unsplash.com/random/1920x600/?technology,laptop,circuit') no-repeat center center/cover;
            opacity: 0.2;
            z-index: 0;
        }
        .header-bg .container {
            position: relative;
            z-index: 1;
        }
        .header-bg h1 {
            font-size: 4.5rem;
            font-weight: 800;
            margin-bottom: 25px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
            animation: fadeInDown 1s ease-out;
        }
        .header-bg p {
            font-size: 1.4rem;
            max-width: 900px;
            margin: 0 auto;
            animation: fadeInUp 1s ease-out 0.3s forwards;
            opacity: 0; /* Hidden initially for animation */
        }

        /* General Section Styling */
        .section-padding {
            padding: 80px 0;
        }
        .bg-light-custom {
            background-color: #e9ecef;
        }

        /* Product Card */
        .product-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0,0,0,.08);
            transition: transform 0.4s ease, box-shadow 0.4s ease;
            background-color: #ffffff;
            height: 100%;
            display: flex;
            flex-direction: column;
            overflow: hidden; /* For image border-radius */
        }
        .product-card:hover {
            transform: translateY(-10px) scale(1.02);
            box-shadow: 0 15px 30px rgba(0,0,0,.15);
        }
        .product-card img {
            width: 100%;
            height: 220px; /* Fixed height for consistency */
            object-fit: cover; /* Cover the area, crop if needed */
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
            transition: transform 0.3s ease;
        }
        .product-card:hover img {
            transform: scale(1.05); /* Zoom effect on hover */
        }
        .product-card .card-body {
            flex-grow: 1;
            padding: 25px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .product-card .card-title {
            font-weight: 700;
            color: #007bff;
            font-size: 1.4rem;
            margin-bottom: 10px;
        }
        .product-card .card-text {
            color: #555;
            font-size: 1rem;
            margin-bottom: 15px;
        }
        .product-card .price {
            font-size: 1.8rem;
            font-weight: 800;
            color: #dc3545;
            margin-bottom: 20px;
        }
        .btn-primary-custom {
            background-color: #007bff;
            border-color: #007bff;
            padding: 12px 25px;
            font-size: 1.1rem;
            border-radius: 8px;
            transition: all 0.3s ease;
        }
        .btn-primary-custom:hover {
            background-color: #0056b3;
            border-color: #004085;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        /* Call to Action */
        .btn-call-to-action {
            background-color: #28a745;
            border-color: #28a745;
            color: white;
            padding: 15px 40px;
            font-size: 1.3rem;
            border-radius: 50px;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(40, 167, 69, 0.4);
            font-weight: 600;
        }
        .btn-call-to-action:hover {
            background-color: #218838;
            border-color: #1e7e34;
            transform: scale(1.05);
            box-shadow: 0 8px 20px rgba(40, 167, 69, 0.6);
        }

        /* Feature Box */
        .feature-box {
            text-align: center;
            padding: 30px;
            border-radius: 15px;
            background-color: #ffffff;
            box-shadow: 0 5px 15px rgba(0,0,0,.05);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            height: 100%; /* Ensure consistent height */
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .feature-box:hover {
            transform: translateY(-8px);
            box-shadow: 0 10px 25px rgba(0,0,0,.1);
        }
        .feature-icon {
            font-size: 4rem;
            color: #17a2b8; /* Info color */
            margin-bottom: 20px;
            transition: color 0.3s ease;
        }
        .feature-box:hover .feature-icon {
            color: #007bff; /* Primary color on hover */
        }
        .feature-box h3 {
            font-weight: 700;
            margin-bottom: 15px;
            color: #343a40;
        }
        .feature-box p {
            font-size: 1rem;
            color: #6c757d;
        }

        /* Contact Section */
        .contact-info li {
            font-size: 1.1rem;
            padding: 10px 0;
        }
        .contact-info li strong {
            color: #007bff;
            min-width: 100px; /* Align labels */
            display: inline-block;
        }
        .contact-info a {
            color: #007bff;
            text-decoration: none;
            transition: color 0.2s ease;
        }
        .contact-info a:hover {
            color: #0056b3;
            text-decoration: underline;
        }

        /* Footer */
        .footer {
            background-color: #212529; /* Darker footer */
            color: #adb5bd;
            padding: 40px 0;
            text-align: center;
            font-size: 0.95rem;
        }
        .footer p {
            margin-bottom: 0;
        }

        /* Animations */
        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>

    <header class="header-bg">
        <div class="container">
            <h1>Chào mừng đến với Laptop Store!</h1>
            <p>Nơi công nghệ bùng nổ, mang đến cho bạn những chiếc laptop mạnh mẽ, thời thượng, và phù hợp với mọi nhu cầu với giá cả không thể tốt hơn cùng dịch vụ hậu mãi đẳng cấp.</p>
        </div>
    </header>

    <section class="section-padding bg-light-custom">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 mb-4 mb-md-0 animate__animated animate__fadeInLeft">
                    <img src="https://voz.vn/attachments/299679143_822534165412649_1870802211820361760_n-jpg.1524518/" class="img-fluid rounded shadow-lg" alt="Về chúng tôi">
                </div>
                <div class="col-md-6 animate__animated animate__fadeInRight">
                    <h2 class="mb-4">Về chúng tôi</h2>
                    <p>ThangTech+ tự hào là **người bạn đồng hành công nghệ** của hàng ngàn khách hàng tại Việt Nam. Với hơn **một thập kỷ kinh nghiệm** trong lĩnh vực bán lẻ laptop, chúng tôi không ngừng nỗ lực mang đến những sản phẩm chất lượng vượt trội từ các thương hiệu hàng đầu thế giới như **Dell, HP, Lenovo, Asus, Acer, Apple, MSI, Razer**, và nhiều hơn nữa.</p>
                    <p>Mỗi chiếc laptop tại cửa hàng đều được tuyển chọn kỹ lưỡng, đảm bảo hiệu suất ổn định và độ bền bỉ. Chúng tôi không chỉ bán sản phẩm, chúng tôi bán **trải nghiệm và sự hài lòng**.</p>
                    <a href="/webbanhang/product" class="btn btn-primary-custom mt-3 btn-lg">Khám phá toàn bộ sản phẩm <i class="fas fa-arrow-right ml-2"></i></a>
                </div>
            </div>
        </div>
    </section>

    <section class="section-padding">
        <div class="container">
            <h2 class="text-center mb-5">Tại sao ThangTech+ là lựa chọn số 1 của bạn?</h2>
            <div class="row">
                <div class="col-md-4 mb-4 animate__animated animate__zoomIn animate__delay-1s">
                    <div class="feature-box">
                        <i class="feature-icon fas fa-gem"></i>
                        <h3>Sản phẩm chính hãng</h3>
                        <p>100% laptop nhập khẩu chính ngạch, có tem kiểm định và bảo hành từ nhà sản xuất uy tín.</p>
                    </div>
                </div>
                <div class="col-md-4 mb-4 animate__animated animate__zoomIn animate__delay-2s">
                    <div class="feature-box">
                        <i class="feature-icon fas fa-headset"></i>
                        <h3>Hỗ trợ chuyên nghiệp</h3>
                        <p>Đội ngũ kỹ thuật viên giàu kinh nghiệm, tư vấn tận tình, hỗ trợ nhanh chóng mọi vấn đề.</p>
                    </div>
                </div>
                <div class="col-md-4 mb-4 animate__animated animate__zoomIn animate__delay-3s">
                    <div class="feature-box">
                        <i class="feature-icon fas fa-tags"></i>
                        <h3>Giá tốt, ưu đãi khủng</h3>
                        <p>Luôn cập nhật giá cạnh tranh, cùng nhiều chương trình khuyến mãi và quà tặng hấp dẫn.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section-padding bg-info text-white text-center">
        <div class="container animate__animated animate__zoomIn">
            <h2>Đừng bỏ lỡ những "deal" cực hot!</h2>
            <p class="lead mb-5">Đăng ký nhận bản tin của chúng tôi để là người đầu tiên biết về các chương trình khuyến mãi độc quyền, sản phẩm mới và tin tức công nghệ.</p>
            <a href="/webbanhang/account/register" class="btn btn-call-to-action btn-lg">Đăng ký ngay <i class="fas fa-envelope-open-text ml-2"></i></a>
        </div>
    </section>

    <section class="section-padding">
        <div class="container">
            <h2 class="text-center mb-5">Gặp gỡ chúng tôi tại</h2>
            <div class="row">
                <div class="col-md-8 mx-auto animate__animated animate__fadeInUp">
                    <ul class="list-group list-group-flush mb-4 contact-info">
                        <li class="list-group-item"><strong><i class="fas fa-map-marker-alt mr-2"></i> Địa chỉ:</strong> Ấp Phú Sơn, Xã Bắc Sơn, Huyện Trảng Bom, Tỉnh Đồng Nai</li>
                        <li class="list-group-item"><strong><i class="fas fa-phone-alt mr-2"></i> Điện thoại:</strong> <a href="tel:0901234567">090-1234-567</a> (Hotline tư vấn 24/7)</li>
                        <li class="list-group-item"><strong><i class="fas fa-envelope mr-2"></i> Email:</strong> <a href="mailto:contact@laptopstore.com.vn">contact@laptopstore.com.vn</a></li>
                        <li class="list-group-item"><strong><i class="fas fa-clock mr-2"></i> Giờ làm việc:</strong> 8:00 AM - 9:00 PM (Thứ 2 - Thứ 7) | 9:00 AM - 6:00 PM (Chủ Nhật)</li>
                    </ul>
                    <div class="embed-responsive embed-responsive-16by9 rounded shadow-lg">
                        <iframe class="embed-responsive-item" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15664.120023605658!2d107.0378036!3d10.97022285!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3174dfcd99709d73%3A0x8f3c4c9d74e2d31!2zVHJhbmcgQm9tIERpc3RyaWN0LCBEb25nIE5haSwgVmlldG5hbQ!5e0!3m2!1sen!2sus!4v1718641977717!5m2!1sen!2sus" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="footer">
        <div class="container">
            <p>Laptop Store Việt Nam - Công nghệ trong tầm tay bạn.</p>
            <p>© 2025 Laptop Store. All rights reserved. Phát triển bởi <a href="#" class="text-white-50">Tên của bạn/Công ty của bạn</a>.</p>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <script>
        // Simple Intersection Observer for animations on scroll
        document.addEventListener("DOMContentLoaded", function() {
            const observerOptions = {
                root: null,
                rootMargin: "0px",
                threshold: 0.2 // Trigger when 20% of the element is visible
            };

            const observer = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('animate__animated'); // Add the base class
                        // Check for specific animations and add them
                        if (entry.target.classList.contains('animate__fadeInLeft')) {
                            entry.target.classList.add('animate__fadeInLeft');
                        } else if (entry.target.classList.contains('animate__fadeInRight')) {
                            entry.target.classList.add('animate__fadeInRight');
                        } else if (entry.target.classList.contains('animate__zoomIn')) {
                            entry.target.classList.add('animate__zoomIn');
                        } else if (entry.target.classList.contains('animate__fadeInUp')) {
                            entry.target.classList.add('animate__fadeInUp');
                        }
                        observer.unobserve(entry.target); // Stop observing once animated
                    }
                });
            }, observerOptions);

            // Observe elements that should animate
            document.querySelectorAll('.animate__animated').forEach(el => {
                observer.observe(el);
            });

            // Specific animation for header text
            document.querySelector('.header-bg h1').classList.add('animate__fadeInDown');
            document.querySelector('.header-bg p').classList.add('animate__fadeInUp');
        });
    </script>
</body>
</html>
<?php include 'app/views/shares/header.php'; ?>

<style>
    body {
        background-color: #f0f2f5; /* Consistent gaming theme background */
        color: #333; /* Standard text color */
    }

    .checkout-wrapper {
        background-color: #ffffff; /* White background for the checkout form */
        padding: 40px;
        border-radius: 18px; /* More rounded corners */
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1); /* Stronger, more modern shadow */
        border: none; /* Remove default border, rely on shadow */
        max-width: 850px; /* Slightly wider for better layout */
        margin: 50px auto; /* More margin top/bottom */
    }

    .checkout-wrapper h2 {
        font-weight: bold;
        color: #d90429; /* Consistent red gaming color */
        margin-bottom: 35px; /* More space below heading */
        text-align: center;
        font-size: 2.5rem; /* Larger heading for impact */
        padding-bottom: 15px; /* Padding for border-bottom */
        border-bottom: 2px solid #d90429; /* Red underline */
    }

    .form-label {
        font-weight: 700; /* Bolder labels */
        margin-bottom: 8px; /* More space below label */
        color: #212529; /* Darker label color */
        font-size: 1.1rem; /* Slightly larger label font */
    }

    .form-control, .form-check-input {
        border-radius: 10px; /* Rounded corners for inputs */
        padding: 16px 18px; /* Larger padding for inputs */
        font-size: 1rem;
        border: 1px solid #ced4da; /* Default border color */
        box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.05); /* Subtle inner shadow */
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }

    .form-control:focus {
        border-color: #d90429; /* Red border on focus */
        box-shadow: 0 0 0 0.25rem rgba(217, 4, 41, 0.25); /* Red glow on focus */
    }

    .form-check-label {
        margin-left: 10px; /* More space for checkbox label */
        font-size: 1rem;
        color: #495057;
    }

    /* Primary button style (Submit button) */
    .btn-primary-custom {
        background-color: #d90429; /* Primary red gaming color */
        color: white;
        border: none;
        padding: 15px 30px; /* Larger padding for main button */
        font-weight: 700; /* Bolder font */
        font-size: 1.2rem; /* Larger font size */
        border-radius: 12px; /* More rounded corners */
        transition: background-color 0.3s ease, transform 0.2s ease;
        box-shadow: 0 4px 10px rgba(217, 4, 41, 0.3); /* Red shadow for buttons */
    }

    .btn-primary-custom:hover {
        background-color: #a80321; /* Darker red on hover */
        color: white; /* Keep text white on hover */
        transform: translateY(-3px); /* Slight lift on hover */
        box-shadow: 0 6px 15px rgba(217, 4, 41, 0.4); /* Stronger shadow on hover */
    }

    /* Secondary button style (Back to cart) */
    .btn-secondary-custom {
        background-color: #6c757d; /* Standard grey */
        color: white;
        border: none;
        padding: 15px 30px;
        font-weight: 600;
        font-size: 1.2rem;
        border-radius: 12px;
        transition: background-color 0.3s ease, transform 0.2s ease;
        text-decoration: none; /* Ensure no underline */
        display: inline-block; /* For proper padding and margin */
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .btn-secondary-custom:hover {
        background-color: #5a6268; /* Darker grey on hover */
        color: white;
        transform: translateY(-3px);
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15);
    }

    #qr-section .bg-light {
        background-color: #f8f9fa !important; /* Lighter background for QR section */
        border-radius: 15px; /* Rounded corners for QR section */
        padding: 30px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08); /* Shadow for QR section */
    }

    #qr-section p.fw-semibold {
        font-size: 1.2rem;
        color: #333;
    }

    #qr-section img {
        border-radius: 10px; /* More rounded QR images */
        border: 2px solid #d90429; /* Red border for QR codes */
        box-shadow: 0 4px 10px rgba(0,0,0,0.15); /* Stronger shadow for QR codes */
        width: 100%; /* Ensure images fill col width */
        max-width: 180px; /* Limit max width for better appearance */
        height: auto;
        margin: auto; /* Center images */
    }
    
    #qr-section .col-6 {
        display: flex;
        flex-direction: column;
        align-items: center; /* Center content within col */
        text-align: center; /* Center text below QR */
    }

    #qr-section .col-6 p.fw-bold {
        font-size: 1rem;
        margin-bottom: 10px; /* Space between title and QR */
        color: #333;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .checkout-wrapper {
            padding: 25px;
            margin: 30px auto;
        }
        .checkout-wrapper h2 {
            font-size: 2rem;
            margin-bottom: 25px;
        }
        .form-label {
            font-size: 1rem;
        }
        .form-control, .form-check-input {
            padding: 12px 14px;
            font-size: 0.95rem;
        }
        .btn-primary-custom, .btn-secondary-custom {
            padding: 12px 20px;
            font-size: 1rem;
        }
        #qr-section .bg-light {
            padding: 20px;
        }
        #qr-section p.fw-semibold {
            font-size: 1.1rem;
        }
        #qr-section img {
            max-width: 150px; /* Adjust max width for mobile */
        }
    }

    /* Remove unused .col-5th if not relevant to this file */
    /* .col-5th {
        width: 20%;
        max-width: 20%;
        padding: 8px;
    } */
</style>

<div class="container my-5">
    <div class="checkout-wrapper">
        <h2>Thanh toán</h2>

        <form method="POST" action="/webbanhang/Product/processCheckout">
            <div class="mb-4">
                <label for="name" class="form-label">Họ tên:</label>
                <input type="text" id="name" name="name" class="form-control" required value="<?= htmlspecialchars($_SESSION['user_info']['name'] ?? '') ?>">
            </div>

            <div class="mb-4">
                <label for="phone" class="form-label">Số điện thoại:</label>
                <input type="text" id="phone" name="phone" class="form-control" required value="<?= htmlspecialchars($_SESSION['user_info']['phone'] ?? '') ?>">
            </div>

            <div class="mb-4">
                <label for="address" class="form-label">Địa chỉ:</label>
                <textarea id="address" name="address" class="form-control" rows="3" required><?= htmlspecialchars($_SESSION['user_info']['address'] ?? '') ?></textarea>
            </div>

            <div class="mb-4">
                <label class="form-label">Phương thức thanh toán:</label>
                <div class="form-check mb-2">
                    <input class="form-check-input" type="radio" name="payment_method" id="cod" value="COD" checked>
                    <label class="form-check-label" for="cod">Thanh toán khi nhận hàng (COD)</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="payment_method" id="banking" value="BANK">
                    <label class="form-check-label" for="banking">Chuyển khoản qua ngân hàng / MoMo</label>
                </div>
            </div>

            <div id="qr-section" class="mb-4 d-none">
                <div class="bg-light rounded p-4 text-center">
                    <p class="fw-semibold mb-4">Vui lòng quét mã QR bên dưới để thanh toán:</p>
                    <div class="row justify-content-center g-3"> <div class="col-6 col-md-4">
                            <p class="mb-2 fw-bold">QR Ngân hàng</p>
                            <img src="/webbanhang/image/checkout/vcbbank.jpg" alt="QR Ngân hàng" class="img-fluid">
                        </div>
                        <div class="col-6 col-md-4">
                            <p class="mb-2 fw-bold">QR MoMo</p>
                            <img src="/webbanhang/image/checkout/momo.jpg" alt="QR MoMo" class="img-fluid">
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-grid gap-3 mt-4"> <button type="submit" class="btn btn-primary-custom">Xác nhận thanh toán</button>
                <a href="/webbanhang/Product/cart" class="btn btn-secondary-custom">Quay lại giỏ hàng</a>
            </div>
        </form>
    </div>
</div>

<script>
    const codRadio = document.getElementById('cod');
    const bankingRadio = document.getElementById('banking');
    const qrSection = document.getElementById('qr-section');

    function toggleQR() {
        if (bankingRadio.checked) {
            qrSection.classList.remove('d-none');
        } else {
            qrSection.classList.add('d-none');
        }
    }

    // Initial check on page load
    toggleQR(); 

    codRadio.addEventListener('change', toggleQR);
    bankingRadio.addEventListener('change', toggleQR);
</script>

<?php include 'app/views/shares/footer.php'; ?>
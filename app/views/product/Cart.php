<?php include 'app/views/shares/header.php'; ?>

<?php
// Lấy thông tin user hiện tại
$user = $_SESSION['username'] ?? null;
$cart = [];

if ($user && isset($_SESSION['cart_by_user'][$user])) {
    $cart = $_SESSION['cart_by_user'][$user];
}
?>

<style>
    body {
        background-color: #f0f2f5; /* Consistent gaming theme background */
        color: #333; /* Standard text color */
    }

    .cart-wrapper {
        background-color: #ffffff; /* White background for the main cart area */
        border-radius: 18px; /* More rounded corners for modern look */
        padding: 40px; /* Increased padding */
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1); /* Stronger, more modern shadow */
        max-width: 1000px; /* Slightly wider for better content distribution */
        margin: 50px auto; /* More margin top/bottom */
    }

    .cart-item {
        border: none; /* Remove default border */
        border-radius: 15px; /* Rounded corners for each item */
        padding: 20px 25px; /* Increased padding */
        margin-bottom: 25px; /* More space between items */
        background-color: #fefefe; /* Slightly off-white background for items */
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.07); /* Subtle shadow for items */
        transition: transform 0.2s ease-in-out; /* Smooth transition on hover */
    }

    .cart-item:hover {
        transform: translateY(-5px); /* Lift effect on hover */
    }

    .cart-item img {
        border-radius: 12px; /* More rounded image corners */
        width: 100px; /* Slightly larger image */
        height: 100px; /* Slightly larger image */
        object-fit: cover;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1); /* Small shadow for image */
    }

    .cart-item h5 {
        font-size: 1.3rem; /* Larger item name */
        font-weight: bold;
        color: #333; /* Darker text */
    }

    .cart-item .text-muted {
        font-size: 1rem; /* Adjust price label size */
    }

    .cart-item .text-danger {
        color: #d90429 !important; /* Consistent red for prices */
        font-weight: bold;
    }

    .cart-item .text-secondary {
        color: #6c757d !important; /* Standard text color */
    }

    .cart-total {
        font-size: 1.6rem; /* Larger total font */
        font-weight: bold;
        color: #212529; /* Darker for emphasis */
    }

    .cart-total .text-danger {
        color: #d90429 !important; /* Consistent red for total price */
        font-size: 1.8rem; /* Even larger total price */
    }

    .btn-sm {
        padding: 6px 12px; /* Slightly larger small buttons */
        border-radius: 8px; /* Rounded corners for small buttons */
    }

    /* Primary button style (for increase/decrease quantity) */
    .btn-outline-primary {
        border-color: #d90429; /* Red border */
        color: #d90429; /* Red text */
        transition: all 0.2s ease;
    }

    .btn-outline-primary:hover {
        background-color: #d90429; /* Red background on hover */
        color: white; /* White text on hover */
        border-color: #d90429;
    }

    /* Danger button style (for remove) */
    .btn-danger {
        background-color: #e63946; /* Slightly brighter red for danger */
        border-color: #e63946;
        border-radius: 8px;
        transition: all 0.2s ease;
    }

    .btn-danger:hover {
        background-color: #c02d39; /* Darker red on hover */
        border-color: #c02d39;
    }

    /* Main action buttons (continue shopping, checkout) */
    .btn-main {
        background-color: #d90429; /* Primary red gaming color */
        color: white;
        border: none;
        padding: 12px 28px; /* Larger padding */
        font-weight: 700; /* Bolder font */
        font-size: 1.1rem; /* Larger font size */
        border-radius: 12px; /* More rounded corners */
        transition: background-color 0.3s ease, transform 0.2s ease;
        text-decoration: none;
        box-shadow: 0 4px 10px rgba(217, 4, 41, 0.3); /* Red shadow for buttons */
    }

    .btn-main:hover {
        background-color: #a80321; /* Darker red on hover */
        color: white;
        transform: translateY(-3px); /* Slight lift on hover */
        box-shadow: 0 6px 15px rgba(217, 4, 41, 0.4); /* Stronger shadow on hover */
    }

    /* Alert styles for empty cart/not logged in */
    .alert {
        border-radius: 12px;
        padding: 30px;
        font-size: 1.1rem;
        margin-top: 30px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
    }

    .alert-heading {
        font-size: 1.8rem;
        font-weight: bold;
        margin-bottom: 15px;
    }

    .alert-warning {
        background-color: #ffe0b2; /* Lighter orange for warning */
        color: #c56700;
        border-color: #ffc107;
    }

    .alert-info {
        background-color: #bbdefb; /* Lighter blue for info */
        color: #1a237e;
        border-color: #2196f3;
    }

    .alert img {
        max-width: 150px;
        margin: 20px auto;
        display: block;
        border-radius: 10px;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .cart-wrapper {
            padding: 25px;
            margin: 30px auto;
        }
        .cart-item {
            flex-direction: column;
            align-items: flex-start !important;
            padding: 15px;
        }
        .cart-item .d-flex:first-child { /* Product info section */
            flex-direction: row;
            align-items: center;
            width: 100%;
            margin-bottom: 15px;
            min-width: unset !important; /* Override min-width for mobile */
        }
        .cart-item .d-flex:last-child { /* Quantity and delete buttons */
            margin-top: 15px;
            width: 100%;
            justify-content: center; /* Center buttons on mobile */
            flex-wrap: wrap; /* Allow buttons to wrap */
            gap: 10px; /* Gap between buttons */
        }
        .cart-item img {
            width: 80px;
            height: 80px;
            margin-right: 10px !important;
        }
        .cart-item h5 {
            font-size: 1.1rem;
        }
        .cart-item p {
            font-size: 0.9rem;
        }
        .cart-total {
            font-size: 1.4rem;
        }
        .cart-total .text-danger {
            font-size: 1.6rem;
        }
        .btn-main {
            padding: 10px 20px;
            font-size: 1rem;
        }
    }

    /* Remove unused .col-5th if not needed in this file */
    /* .col-5th {
        width: 20%;
        max-width: 20%;
        padding: 8px;
    } */
</style>

<div class="container my-5">
    <div class="cart-wrapper">
        <h2 class="text-center mb-4 fw-bold" style="color: #d90429;">Giỏ hàng của bạn</h2>

        <?php if (!empty($cart)): ?>
            <?php 
            $total = 0;
            foreach ($cart as $id => $item): 
                $subtotal = $item['price'] * $item['quantity'];
                $total += $subtotal;
            ?>
                <div class="cart-item d-flex flex-column flex-md-row justify-content-between align-items-center">
                    <div class="d-flex align-items-center mb-3 mb-md-0"> <?php if (!empty($item['image'])): ?>
                            <img src="/webbanhang/<?php echo htmlspecialchars($item['image'], ENT_QUOTES, 'UTF-8'); ?>" 
                                 alt="<?= htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8') ?>" 
                                 class="img-thumbnail me-3">
                        <?php endif; ?>
                        <div>
                            <h5 class="mb-1"><?= htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8') ?></h5>
                            <p class="mb-1 text-muted">Giá: <strong class="text-danger"><?= number_format($item['price'], 0, ',', '.') ?> VND</strong></p>
                            <p class="mb-0 small text-secondary">Thành tiền: <strong><?= number_format($subtotal, 0, ',', '.') ?> VND</strong></p>
                        </div>
                    </div>

                    <div class="d-flex align-items-center flex-wrap">
                        <form action="/webbanhang/Product/updateQuantity" method="post" class="me-2">
                            <input type="hidden" name="id" value="<?= $id ?>">
                            <input type="hidden" name="action" value="decrease">
                            <button type="submit" class="btn btn-outline-primary btn-sm px-2">&minus;</button>
                        </form>

                        <span class="mx-2 fw-bold"><?= (int)$item['quantity'] ?></span>

                        <form action="/webbanhang/Product/updateQuantity" method="post" class="ms-2">
                            <input type="hidden" name="id" value="<?= $id ?>">
                            <input type="hidden" name="action" value="increase">
                            <button type="submit" class="btn btn-outline-primary btn-sm px-2">&plus;</button>
                        </form>

                        <form action="/webbanhang/Product/removeFromCart" method="post" class="ms-3 mt-2 mt-md-0">
                            <input type="hidden" name="id" value="<?= $id ?>">
                            <button type="submit" class="btn btn-danger btn-sm">
                                <i class="bi bi-trash"></i> Xóa
                            </button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>

            <div class="d-flex justify-content-between align-items-center cart-total mt-4 border-top pt-3">
                <strong>Tổng tiền:</strong>
                <span class="text-danger fw-bold"><?= number_format($total, 0, ',', '.') ?> VND</span>
            </div>

            <div class="d-flex justify-content-center gap-3 flex-wrap mt-4">
                <a href="/webbanhang/Product/" class="btn-main">Tiếp tục mua sắm</a>
                <a href="/webbanhang/Product/checkout" class="btn-main">Thanh toán</a>
            </div>

        <?php elseif (!$user): ?>
            <div class="alert alert-warning text-center" role="alert">
                <h4 class="alert-heading">Bạn chưa đăng nhập!</h4>
                <p>Vui lòng đăng nhập để xem giỏ hàng của bạn.</p>
                <a href="/webbanhang/account/login" class="btn btn-warning mt-3">Đăng nhập</a>
            </div>
        <?php else: ?>
            <div class="alert alert-info text-center" role="alert">
                <h4 class="alert-heading">Giỏ hàng trống!</h4>
                <img src="https://media3.giphy.com/media/XHFzB9t4wDlKqrfQ58/200.webp" alt="Giỏ hàng trống" class="img-fluid" />
                <p>Hiện tại bạn chưa có sản phẩm nào trong giỏ hàng.</p>
                <a href="/webbanhang/Product" class="btn btn-main mt-3">Quay lại mua hàng</a>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include 'app/views/shares/footer.php'; ?>
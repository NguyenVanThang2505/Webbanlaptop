<?php include 'app/views/shares/header.php'; ?>

<style>
    body {
        background-color: white;
        }


        .col-5th {
            width: 20%;
            max-width: 20%;
            padding: 8px;
        }

    .confirmation-wrapper {
        background: #ffffff;
        border-radius: 16px;
        padding: 40px 30px;
        max-width: 600px;
        margin: 60px auto;
        box-shadow: 0 10px 24px rgba(0, 0, 0, 0.08);
        text-align: center;
    }

    .confirmation-wrapper h1 {
        font-size: 2rem;
        color: #ff6b6b;
        font-weight: bold;
        margin-top: 20px;
    }

    .confirmation-wrapper p {
        font-size: 1.1rem;
        color: #555;
        margin: 15px 0 30px;
    }

    .confirmation-wrapper img {
        max-width: 160px;
        margin-bottom: 20px;
        border-radius: 12px;
    }

    .btn-continue {
        padding: 12px 24px;
        font-size: 1rem;
        border-radius: 10px;
        font-weight: 600;
        background-color: #ff6b6b;
        border: none;
    }

    .btn-continue:hover {
        background-color: #e64949;
    }
</style>

<div class="confirmation-wrapper">
    <img src="https://media0.giphy.com/media/20BgaKm1pDakU39byD/200.webp" alt="Cảm ơn" />

    <h1>Đặt hàng thành công!</h1>
    <p>Cảm ơn bạn đã đặt hàng tại ThangTech+. Chúng tôi sẽ liên hệ và giao hàng sớm nhất.</p>

    <a href="/webbanhang/Product/" class="btn btn-continue">Tiếp tục mua sắm</a>
    </div>

<?php include 'app/views/shares/footer.php'; ?>

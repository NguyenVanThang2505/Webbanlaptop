<?php include 'app/views/shares/header.php'; ?>

<style>
    body {
        background-color: #f0f2f5;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .login-wrapper {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 40px 15px;
    }

    .login-card {
        background-color: #f9f9f9;
        border-radius: 12px;
        padding: 40px 30px;
        color: #333;
        width: 100%;
        max-width: 400px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    }

    .login-card h3 {
        margin-bottom: 10px;
        font-weight: 600;
        color: #007bff;
    }

    .login-card p {
        margin-bottom: 30px;
        color: #555;
        font-size: 0.95rem;
    }

    .login-card input.form-control {
        border-radius: 8px;
        height: 44px;
        font-size: 1rem;
        padding-left: 12px;
        border: 1px solid #ccc;
    }

    input:invalid,
    input:required:invalid {
        box-shadow: none !important;
        border-color: #ccc !important;
    }

    .login-card .btn-primary {
        background-color: #007bff;
        color: white;
        font-weight: 500;
        border-radius: 8px;
        height: 44px;
        border: none;
        transition: 0.3s ease;
    }

    .login-card .btn-primary:hover {
        background-color: #0056b3;
    }

    .back-link {
        margin-top: 20px;
        display: block;
        font-size: 0.9rem;
        color: #007bff;
        text-decoration: none;
    }

    .back-link:hover {
        text-decoration: underline;
    }

    .alert-light {
        background-color: #fff5f5;
        border-left: 5px solid #dc3545;
        padding: 10px 15px;
        color: #dc3545;
        font-size: 0.95rem;
    }
</style>

<div class="login-wrapper">
    <div class="login-card text-center">
        <h3>ThangTech+</h3>
        <p>Đăng nhập vào hệ thống</p>

        <?php if (isset($error)): ?>
            <div class="alert alert-light">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <form action="/webbanhang/account/checklogin" method="post">
            <div class="form-group mb-3 text-start">
                <input type="text" name="username" class="form-control" placeholder="Tên đăng nhập" required>
            </div>
            <div class="form-group mb-4 text-start">
                <input type="password" name="password" class="form-control" placeholder="Mật khẩu" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Đăng nhập</button>
        </form>

        <a href="/webbanhang/account/register" class="back-link">Chưa có tài khoản? Đăng ký</a>
    </div>
</div>

<?php include 'app/views/shares/footer.php'; ?>

<?php include_once __DIR__ . '/../../../check_admin.php'; ?>
<?php include 'app/views/shares/header.php'; ?>

<section class="vh-100" style="background: linear-gradient(to right, #74ebd5, #ACB6E5);">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                <div class="card bg-primary text-white shadow-lg" style="border-radius: 1rem; min-height: 500px;">
                    <div class="card-body px-5 py-5 text-center d-flex flex-column justify-content-between">

                        <!-- Thương hiệu -->
                        <div>
                            <h2 class="fw-bold text-white mb-3">ThangTech+</h2>
                            <p class="text-white-50 mb-4">Đăng nhập tài khoản quản trị</p>

                            <!-- Thông báo lỗi -->
                            <?php if (isset($error)): ?>
                                <div class="alert alert-danger bg-light text-danger" role="alert">
                                    <?= htmlspecialchars($error) ?>
                                </div>
                            <?php endif; ?>

                            <form action="/webbanhang/account/checkLoginAdmin" method="post">
                                <div class="form-outline form-white mb-4">
                                    <input type="text" name="username" class="form-control form-control-lg" placeholder="Tên đăng nhập" required>
                                </div>

                                <div class="form-outline form-white mb-4">
                                    <input type="password" name="password" class="form-control form-control-lg" placeholder="Mật khẩu" required>
                                </div>

                                <button type="submit" class="btn btn-light btn-lg px-5 mt-2 fw-bold text-primary">
                                    Đăng nhập
                                </button>
                            </form>
                        </div>

                        <div class="mt-4">
                            <p class="mb-0">
                                Trở về <a href="/webbanhang/product" class="text-white fw-bold">Trang chủ</a>
                            </p>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'app/views/shares/footer.php'; ?>

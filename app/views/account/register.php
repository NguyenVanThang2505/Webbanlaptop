<?php include 'app/views/shares/header.php'; ?>

<style>
    body {
        background-color: #f8f9fa;
    }

    .form-section {
        padding: 60px 15px;
    }

    .form-container {
        max-width: 800px;
        background-color: #fff;
        border-radius: 10px;
        padding: 40px;
        box-shadow: 0 0 20px rgba(0,0,0,0.1);
    }

    .form-title {
        font-size: 24px;
        font-weight: 600;
        margin-bottom: 30px;
        text-align: center;
    }

    .btn-register {
        background-color: #d70018;
        color: white;
        font-weight: bold;
        border-radius: 8px;
        padding: 10px 20px;
        width: 100%;
    }

    .btn-register:hover {
        background-color: #b40015;
    }

    .btn-back {
        border: 1px solid #ccc;
        border-radius: 8px;
        background: white;
        font-weight: bold;
        width: 100%;
        padding: 10px 20px;
    }

    .text-note {
        font-size: 0.85rem;
        color: #6c757d;
    }

    .form-check-input {
        margin-top: 7px;
    }
</style>

<section class="form-section">
    <div class="container">
        <div class="form-container mx-auto">
            <div class="form-title">Tạo tài khoản</div>

            <form method="post" action="/webbanhang/account/save" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Họ và tên</label>
                        <input type="text" name="fullname" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Số điện thoại</label>
                        <input type="text" name="phone" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tên đăng nhập</label>
                        <input type="text" name="username" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Email (tuỳ chọn)</label>
                        <input type="email" name="email" class="form-control">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Mật khẩu</label>
                        <input type="password" name="password" class="form-control" required>
                        <small class="text-success">Mật khẩu tối thiểu 6 ký tự, có ít nhất 1 chữ và 1 số</small>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nhập lại mật khẩu</label>
                        <input type="password" name="confirmpassword" class="form-control" required>
                    </div>
                    <div class="col-12 mb-3">
                        <label class="form-label">Địa chỉ</label>
                        <input type="text" name="address" class="form-control" required>
                    </div>
                    <div class="col-12 mb-4">
                        <label class="form-label">Ảnh đại diện</label>
                        <input type="file" name="avatar" class="form-control" accept="image/*">
                    </div>
                </div>

                <!-- Button group -->
                <div class="row">
                    <div class="col-md-6 mb-2">
                        <a href="/webbanhang/account/login" class="btn btn-back">← Quay lại đăng nhập</a>
                    </div>
                    <div class="col-md-6 mb-2">
                        <button type="submit" class="btn btn-register">Hoàn tất đăng ký</button>
                    </div>
                </div>
            </form>

            <div class="text-note mt-3">
                Bằng việc đăng ký, bạn đã đồng ý với <a href="#">Chính sách</a> & <a href="#">Điều khoản</a> sử dụng.
            </div>
        </div>
    </div>
</section>

<?php include 'app/views/shares/footer.php'; ?>

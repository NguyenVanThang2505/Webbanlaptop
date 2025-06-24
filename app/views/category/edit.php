<?php include_once __DIR__ . '/../../../check_admin.php'; ?>
<?php include __DIR__ . '/../shares/header.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm danh mục mới</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* CSS cho body */
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f4f7f6; /* Nền màu xám nhạt đồng nhất */
        }

        /* Styles copied and adapted from the product edit form for consistency */
        .form-wrapper {
            background-color: #ffffff;
            padding: 40px 30px;
            border-radius: 12px;
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.08);
            border: 1px solid #f1f1f1;
        }

        .form-wrapper h2 {
            font-weight: bold;
            color: #ff6b6b; /* Màu đỏ nổi bật */
            font-size: 1.75rem; /* Tăng kích thước tiêu đề */
            margin-bottom: 30px;
        }

        .form-label {
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
            display: block; /* Ensure label is a block element */
        }

        .form-control, .form-select {
            height: 52px; /* Chiều cao cố định */
            font-size: 1rem;
            padding: 14px 16px;
            border-radius: 10px;
            border: 1px solid #ced4da;
            transition: border 0.3s ease;
            width: 100%; /* Full width */
        }

        textarea.form-control {
            height: auto;
            padding: 14px 16px;
            resize: vertical; /* Cho phép thay đổi kích thước theo chiều dọc */
        }

        .form-control:focus, .form-select:focus {
            border-color: #ff6b6b; /* Màu viền đỏ khi focus */
            box-shadow: 0 0 0 0.2rem rgba(255, 107, 107, 0.2); /* Đổ bóng khi focus */
            outline: none; /* Remove default outline */
        }

        .btn-primary {
            background-color: #ff6b6b;
            border: none;
            color: white;
            font-weight: 600;
            padding: 12px 28px;
            font-size: 1rem;
            border-radius: 10px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #ff4d4d;
        }

        .btn-secondary {
            background-color: #f8f9fa;
            color: #333;
            border: 1px solid #e2e6ea; /* Added border for secondary button */
            font-weight: 500;
            padding: 12px 28px;
            font-size: 1rem;
            border-radius: 10px;
            cursor: pointer;
            transition: background-color 0.3s ease, border-color 0.3s ease;
        }

        .btn-secondary:hover {
            background-color: #e2e6ea;
            border-color: #d1d5db;
        }

        /* Utility classes for spacing from Bootstrap, mapped to Tailwind equivalent for clarity */
        .my-5 { margin-top: 3rem; margin-bottom: 3rem; } /* Equivalent to Tailwind my-12 */
        .mb-4 { margin-bottom: 1rem; } /* Equivalent to Tailwind mb-4 */
        .mb-6 { margin-bottom: 1.5rem; } /* Equivalent to Tailwind mb-6 */
        .mt-4 { margin-top: 1rem; } /* Equivalent to Tailwind mt-4 */
        .d-flex { display: flex; } /* Equivalent to Tailwind flex */
        .justify-content-center { justify-content: center; } /* Equivalent to Tailwind justify-center */
        .justify-content-between { justify-content: space-between; } /* Equivalent to Tailwind justify-between */
        .text-center { text-align: center; } /* Equivalent to Tailwind text-center */
        
        /* Chỉnh sửa để form ngắn hơn */
        .col-lg-8 { max-width: 50%; flex: 0 0 50%; } /* Giảm từ 66.66% xuống 50% cho màn hình lớn */
        .col-md-10 { max-width: 66.666667%; flex: 0 0 66.666667%; } /* Giảm từ 83.33% xuống 66.66% cho màn hình trung bình */
    </style>
</head>
<body>
    <div class="container my-5">
        <div class="d-flex justify-content-center">
            <div class="col-lg-8 col-md-10">
                <div class="form-wrapper">

                    <h2 class="text-center">Thêm danh mục mới</h2>

                    <?php if (!empty($errors)): ?>
                        <div class="alert alert-danger mb-4">
                            <ul>
                                <?php foreach ($errors as $error): ?>
                                    <li><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <!-- Form sẽ gửi dữ liệu về phương thức create() trong CategoryController -->
                    <form action="/webbanhang/Category/create" method="POST">
                        <div class="mb-4">
                            <label for="name" class="form-label">Tên danh mục</label>
                            <input type="text" id="name" name="name" class="form-control" required placeholder="Nhập tên danh mục"
                                   value="<?= htmlspecialchars($_POST['name'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                        </div>

                        <div class="mb-6">
                            <label for="description" class="form-label">Mô tả</label>
                            <textarea id="description" name="description" rows="4" class="form-control" placeholder="Nhập mô tả danh mục"><?= htmlspecialchars($_POST['description'] ?? '', ENT_QUOTES, 'UTF-8') ?></textarea>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <a href="/webbanhang/Category/list" class="btn-secondary">
                                Quay lại
                            </a>
                            <button type="submit" class="btn-primary">
                                Thêm danh mục
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</body>
</html>

<?php include __DIR__ . '/../shares/footer.php'; ?>

<?php include_once __DIR__ . '/../../../check_admin.php'; ?>
<?php include 'app/views/shares/header.php'; ?>

<style>
    .form-wrapper {
        background-color: #ffffff;
        padding: 40px 30px;
        border-radius: 12px;
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.08);
        border: 1px solid #f1f1f1;
    }

    .form-wrapper h2 {
        font-weight: bold;
        color: #ff6b6b;
        font-size: 1.75rem;
        margin-bottom: 30px;
    }

    .form-label {
        font-weight: 600;
        color: #333;
        margin-bottom: 8px;
    }

    .form-control, .form-select {
        height: 52px;
        font-size: 1rem;
        padding: 14px 16px;
        border-radius: 10px;
        border: 1px solid #ced4da;
        transition: border 0.3s ease;
    }

    textarea.form-control {
        height: auto;
        padding: 14px 16px;
        resize: vertical;
    }

    .form-control:focus, .form-select:focus {
        border-color: #ff6b6b;
        box-shadow: 0 0 0 0.2rem rgba(255, 107, 107, 0.2);
    }

    .btn-primary {
        background-color: #ff6b6b;
        border: none;
        font-weight: 600;
        padding: 12px 28px;
        font-size: 1rem;
        border-radius: 10px;
    }

    .btn-primary:hover {
        background-color: #ff4d4d;
    }

    .btn-secondary {
        background-color: #f8f9fa;
        color: #333;
        font-weight: 500;
        padding: 12px 28px;
        font-size: 1rem;
        border-radius: 10px;
    }

    .btn-secondary:hover {
        background-color: #e2e6ea;
    }

    /* Đổi tên từ .img-preview thành .current-image-preview để rõ ràng hơn */
    .current-image-preview {
        max-width: 160px;
        border-radius: 8px;
        margin-top: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        display: block; /* Mặc định hiển thị nếu có ảnh */
    }

    .alert ul {
        margin: 0;
        padding-left: 20px;
    }

    body {
        background-color: white;
    }

    .col-5th {
        width: 20%;
        max-width: 20%;
        padding: 8px;
    }

    /* CSS cho phần hiển thị ảnh preview mới */
    .image-upload-preview-container {
        margin-top: 15px;
        border: 1px dashed #ced4da;
        border-radius: 10px;
        min-height: 150px; /* Chiều cao tối thiểu cho vùng preview */
        display: flex;
        justify-content: center;
        align-items: center;
        overflow: hidden;
        position: relative;
        background-color: #f8f9fa;
    }

    .new-image-preview {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
        display: none; /* Ban đầu ẩn đi */
    }

    .image-preview-placeholder {
        color: #6c757d;
        font-style: italic;
        text-align: center;
        padding: 20px;
    }
</style>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            <div class="form-wrapper">

                <h2 class="text-center">Sửa sản phẩm</h2>

                <?php if (!empty($errors)): ?>
                    <div class="alert alert-danger">
                        <ul>
                            <?php foreach ($errors as $error): ?>
                                <li><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <form method="POST" action="/webbanhang/Product/update" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($product->id, ENT_QUOTES, 'UTF-8'); ?>">

                    <div class="mb-4">
                        <label for="name" class="form-label">Tên sản phẩm</label>
                        <input type="text" id="name" name="name" class="form-control"
                            value="<?php echo htmlspecialchars($product->name ?? '', ENT_QUOTES, 'UTF-8'); ?>" required>
                    </div>

                    <div class="mb-4">
                        <label for="description" class="form-label">Mô tả</label>
                        <textarea id="description" name="description" class="form-control" rows="4" required><?php
                            echo htmlspecialchars($product->description ?? '', ENT_QUOTES, 'UTF-8');
                        ?></textarea>
                    </div>

                    <div class="mb-4">
                        <label for="price" class="form-label">Giá</label>
                        <input type="number" id="price" name="price" class="form-control" step="0.01"
                            value="<?php echo htmlspecialchars($product->price ?? '', ENT_QUOTES, 'UTF-8'); ?>" required>
                    </div>

                    <div class="mb-4">
                        <label for="category_id" class="form-label">Danh mục</label>
                        <select id="category_id" name="category_id" class="form-select" required>
                            <?php foreach ($categories as $category): ?>
                                <option value="<?php echo $category->id; ?>"
                                    <?php echo (isset($product->category_id) && $category->id == $product->category_id) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($category->name, ENT_QUOTES, 'UTF-8'); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="cpu" class="form-label">CPU</label>
                        <input type="text" id="cpu" name="cpu" class="form-control" placeholder="Ví dụ: Intel Core i5-12400H"
                            value="<?php echo htmlspecialchars($product->cpu ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                    </div>

                    <div class="mb-4">
                        <label for="card" class="form-label">Card đồ họa</label>
                        <input type="text" id="card" name="card" class="form-control" placeholder="Ví dụ: NVIDIA GeForce RTX 3050"
                            value="<?php echo htmlspecialchars($product->card ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                    </div>

                    <div class="mb-4">
                        <label for="ram" class="form-label">RAM</label>
                        <input type="text" id="ram" name="ram" class="form-control" placeholder="Ví dụ: 8GB DDR4 3200MHz"
                            value="<?php echo htmlspecialchars($product->ram ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                    </div>

                    <div class="mb-4">
                        <label for="ssd" class="form-label">Ổ cứng (SSD)</label>
                        <input type="text" id="ssd" name="ssd" class="form-control" placeholder="Ví dụ: 512GB PCIe Gen4 NVMe SSD"
                            value="<?php echo htmlspecialchars($product->ssd ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                    </div>


                    <div class="mb-4">
                        <label for="image" class="form-label">Hình ảnh</label>
                        <input type="file" id="image" name="image" class="form-control" accept="image/*">
                        <input type="hidden" name="existing_image" value="<?php echo htmlspecialchars($product->image ?? '', ENT_QUOTES, 'UTF-8'); ?>">

                        <div class="image-upload-preview-container mt-3">
                            <?php if (!empty($product->image)): ?>
                                <img id="currentImagePreview" src="/webbanhang/<?php echo htmlspecialchars($product->image, ENT_QUOTES, 'UTF-8'); ?>"
                                     alt="Ảnh hiện tại" class="current-image-preview">
                            <?php endif; ?>
                            <img id="newImagePreview" src="#" alt="Xem trước ảnh mới" class="new-image-preview">
                            <span id="imagePlaceholder" class="image-preview-placeholder"
                                  style="<?php echo empty($product->image) ? 'display: block;' : 'display: none;'; ?>">
                                Chọn ảnh mới hoặc ảnh hiện tại sẽ được giữ
                            </span>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="/webbanhang/Product/" class="btn btn-secondary">
                            Quay lại
                        </a>
                        <button type="submit" class="btn btn-primary">
                            Lưu thay đổi
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>

<?php include 'app/views/shares/footer.php'; ?>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const imageInput = document.getElementById('image');
        const currentImagePreview = document.getElementById('currentImagePreview');
        const newImagePreview = document.getElementById('newImagePreview');
        const imagePlaceholder = document.getElementById('imagePlaceholder');

        imageInput.addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    newImagePreview.src = e.target.result;
                    newImagePreview.style.display = 'block';
                    if (currentImagePreview) { // Ẩn ảnh cũ nếu có
                        currentImagePreview.style.display = 'none';
                    }
                    imagePlaceholder.style.display = 'none'; // Ẩn placeholder
                };
                reader.readAsDataURL(file);
            } else {
                // Nếu người dùng xóa file đã chọn, hiển thị lại ảnh cũ (nếu có)
                // Hoặc placeholder nếu không có ảnh cũ
                newImagePreview.src = '#';
                newImagePreview.style.display = 'none';
                if (currentImagePreview) {
                    currentImagePreview.style.display = 'block';
                } else {
                    imagePlaceholder.style.display = 'block';
                }
            }
        });
    });
</script>
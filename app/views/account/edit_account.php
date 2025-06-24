<?php include 'app/views/shares/header.php'; ?>

<style>
    body {
        background-color: #f0f2f5; /* Consistent gaming theme background */
        color: #333; /* Standard text color */
    }

    .form-wrapper {
        background-color: #ffffff;
        padding: 40px 35px; /* Slightly more padding */
        border-radius: 18px; /* More rounded corners */
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12); /* Stronger, more modern shadow */
        border: none; /* Remove default border, rely on shadow */
        margin-top: 50px; /* More top margin */
        margin-bottom: 60px; /* More bottom margin */
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .form-wrapper:hover {
        transform: translateY(-5px); /* More pronounced lift on hover */
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.18); /* Stronger shadow on hover */
    }

    .form-wrapper h2 {
        font-weight: bold;
        color: #d90429; /* Consistent red gaming color */
        font-size: 2.2rem; /* Larger heading for impact */
        margin-bottom: 35px; /* More space below heading */
        text-align: center;
        position: relative;
        padding-bottom: 15px; /* More padding for underline */
    }

    .form-wrapper h2::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 80px; /* Longer underline */
        height: 4px; /* Thickness */
        background-color: #d90429; /* Red underline */
        border-radius: 2px;
    }

    .form-label {
        font-weight: 700; /* Bolder labels */
        color: #212529; /* Darker label color */
        margin-bottom: 8px;
        display: block;
        font-size: 1.05rem; /* Slightly larger label font */
    }

    .form-control, .form-select {
        height: 52px;
        font-size: 1rem;
        padding: 14px 18px; /* Slightly more padding */
        border-radius: 10px;
        border: 1px solid #ced4da;
        background-color: #fcfcfc; /* Slightly off-white background for inputs */
        box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.05); /* Subtle inner shadow */
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }

    textarea.form-control {
        height: auto;
        min-height: 120px; /* Increased min-height for textarea */
        resize: vertical;
    }

    .form-control:focus, .form-select:focus {
        border-color: #d90429; /* Red border on focus */
        box-shadow: 0 0 0 0.25rem rgba(217, 4, 41, 0.25); /* Red glow on focus */
        outline: none;
    }

    /* Custom button styles, consistent with other pages */
    .btn-main {
        background-color: #d90429; /* Primary red gaming color */
        color: white;
        border: none;
        padding: 14px 30px; /* Larger padding */
        font-weight: 700; /* Bolder font */
        font-size: 1.1rem; /* Larger font size */
        border-radius: 12px; /* More rounded corners */
        transition: background-color 0.3s ease, transform 0.2s ease, box-shadow 0.3s ease;
        text-decoration: none; /* Ensure no underline for anchors */
        display: inline-block; /* For anchor to behave like a button */
        box-shadow: 0 4px 10px rgba(217, 4, 41, 0.3); /* Red shadow for buttons */
    }

    .btn-main:hover {
        background-color: #a80321; /* Darker red on hover */
        color: white;
        transform: translateY(-3px); /* Slight lift on hover */
        box-shadow: 0 6px 15px rgba(217, 4, 41, 0.4); /* Stronger shadow on hover */
    }

    .btn-main:active {
        transform: translateY(0);
        box-shadow: none;
    }

    .btn-secondary-custom { /* Using a custom name to avoid conflict and align with .btn-main */
        background-color: #6c757d; /* Standard grey */
        color: white;
        border: none;
        padding: 14px 30px;
        font-weight: 600;
        font-size: 1.1rem;
        border-radius: 12px;
        transition: background-color 0.3s ease, transform 0.2s ease, box-shadow 0.3s ease;
        text-decoration: none;
        display: inline-block;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .btn-secondary-custom:hover {
        background-color: #5a6268; /* Darker grey on hover */
        color: white;
        transform: translateY(-3px);
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15);
    }
    .btn-secondary-custom:active {
        transform: translateY(0);
        box-shadow: none;
    }

    .image-upload-preview-container {
        margin-top: 20px; /* More space */
        border: 2px dashed #b0b0b0; /* Softer dashed border */
        border-radius: 15px; /* More rounded */
        min-height: 200px; /* Taller min-height */
        display: flex;
        justify-content: center;
        align-items: center;
        overflow: hidden;
        position: relative;
        background-color: #fefefe; /* Very light background for container */
        transition: border-color 0.3s ease, background-color 0.3s ease;
    }

    .image-upload-preview-container:hover {
        border-color: #d90429; /* Red border on hover */
        background-color: #fff9f9; /* Slight red tint on hover */
    }

    .current-image-preview, .new-image-preview {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
        border-radius: 12px; /* More rounded images */
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1); /* Subtle shadow for images */
        transition: opacity 0.3s ease;
    }
    
    .new-image-preview {
        display: none;
    }

    .image-preview-placeholder {
        color: #888;
        font-style: italic;
        text-align: center;
        padding: 20px;
        font-size: 1rem; /* Slightly larger placeholder text */
    }

    .alert ul {
        margin: 0;
        padding-left: 20px;
        list-style-type: disc;
    }

    .alert-danger {
        background-color: #ffe0e0; /* Lighter red background */
        color: #cc0000; /* Darker red text */
        border-color: #ffcccc;
        border-radius: 10px;
        padding: 15px 20px;
        margin-bottom: 25px;
    }

    .form-text {
        font-size: 0.9em; /* Slightly larger helper text */
        color: #777; /* Darker gray for better contrast */
        margin-top: 8px; /* More space below input */
        display: block; /* Ensure it takes its own line */
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .form-wrapper {
            padding: 25px;
            margin: 30px auto;
        }
        .form-wrapper h2 {
            font-size: 1.8rem;
            margin-bottom: 25px;
        }
        .form-label {
            font-size: 0.95rem;
        }
        .form-control, .form-select {
            padding: 12px 14px;
            font-size: 0.95rem;
        }
        textarea.form-control {
            min-height: 100px;
        }
        .btn-main, .btn-secondary-custom {
            padding: 12px 20px;
            font-size: 1rem;
        }
        .image-upload-preview-container {
            min-height: 160px;
        }
    }
</style>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            <div class="form-wrapper">

                <h2>Chỉnh sửa thông tin tài khoản</h2>

                <?php
                // Lấy thông tin tài khoản và lỗi từ biến $data được truyền từ controller
                // $data['account'] là object chứa thông tin tài khoản
                // $data['errors'] là mảng chứa các lỗi
                $account = $data['account'] ?? (object)[
                    'id' => '', 'username' => '', 'fullname' => '', 'email' => '',
                    'phone' => '', 'address' => '', 'avatar' => ''
                ];
                $errors = $data['errors'] ?? [];
                
                // Hiển thị lỗi nếu có
                if (!empty($errors)): ?>
                    <div class="alert alert-danger">
                        <ul>
                            <?php foreach ($errors as $error): ?>
                                <li><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <form method="POST" action="/webbanhang/account/updateProfile" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?= htmlspecialchars($account->id ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                    <input type="hidden" name="existing_avatar" value="<?= htmlspecialchars($account->avatar ?? '', ENT_QUOTES, 'UTF-8'); ?>">

                    <div class="mb-4">
                        <label for="username" class="form-label">Tên đăng nhập</label>
                        <input type="text" id="username" name="username" class="form-control"
                            value="<?= htmlspecialchars($account->username ?? '', ENT_QUOTES, 'UTF-8'); ?>" readonly disabled>
                        <small class="form-text text-muted">Tên đăng nhập không thể thay đổi.</small>
                    </div>

                    <div class="mb-4">
                        <label for="fullname" class="form-label">Họ và Tên</label>
                        <input type="text" id="fullname" name="fullname" class="form-control"
                            value="<?= htmlspecialchars($account->fullname ?? '', ENT_QUOTES, 'UTF-8'); ?>" required>
                    </div>

                    <div class="mb-4">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" id="email" name="email" class="form-control"
                            value="<?= htmlspecialchars($account->email ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                    </div>

                    <div class="mb-4">
                        <label for="phone" class="form-label">Số điện thoại</label>
                        <input type="tel" id="phone" name="phone" class="form-control"
                            value="<?= htmlspecialchars($account->phone ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                    </div>

                    <div class="mb-4">
                        <label for="address" class="form-label">Địa chỉ</label>
                        <textarea id="address" name="address" class="form-control" rows="3"><?= 
                            htmlspecialchars($account->address ?? '', ENT_QUOTES, 'UTF-8'); 
                        ?></textarea>
                    </div>

                    <div class="mb-4">
                        <label for="password" class="form-label">Mật khẩu mới (để trống nếu không thay đổi)</label>
                        <input type="password" id="password" name="password" class="form-control">
                    </div>

                    <div class="mb-4">
                        <label for="confirmpassword" class="form-label">Xác nhận mật khẩu mới</label>
                        <input type="password" id="confirmpassword" name="confirmpassword" class="form-control">
                    </div>

                    <div class="mb-4">
                        <label for="avatar" class="form-label">Ảnh đại diện</label>
                        <input type="file" id="avatar" name="avatar" class="form-control" accept="image/*">
                        
                        <div class="image-upload-preview-container mt-3">
                            <?php
                            // Kiểm tra nếu có avatar và file tồn tại, nếu không dùng ảnh mặc định
                            // Đảm bảo đường dẫn '/webbanhang/' là chính xác với base URL của bạn
                            $currentAvatarPath = (!empty($account->avatar) && file_exists(str_replace('/webbanhang/', '', $account->avatar))) 
                                                            ? htmlspecialchars($account->avatar, ENT_QUOTES, 'UTF-8') 
                                                            : '/webbanhang/public/images/default-avatar.png';
                            ?>
                            <img id="currentImagePreview" 
                                        src="<?= $currentAvatarPath ?>" 
                                        alt="Ảnh đại diện hiện tại" 
                                        class="current-image-preview" 
                                        style="<?= (empty($account->avatar) || strpos($currentAvatarPath, 'default-avatar.png') !== false) ? 'display: none;' : 'display: block;' ?>">
                            <img id="newImagePreview" src="#" alt="Xem trước ảnh mới" class="new-image-preview">
                            <span id="imagePlaceholder" class="image-preview-placeholder"
                                        style="<?= (empty($account->avatar) || strpos($currentAvatarPath, 'default-avatar.png') !== false) ? 'display: block;' : 'display: none;' ?>">
                                            Tải ảnh mới hoặc ảnh hiện tại sẽ được giữ
                            </span>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mt-5"> <a href="/webbanhang/account/profile" class="btn-secondary-custom">Quay lại Profile</a>
                        <button type="submit" class="btn-main">Lưu thay đổi</button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>

<?php include 'app/views/shares/footer.php'; ?>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const avatarInput = document.getElementById('avatar');
        const currentImagePreview = document.getElementById('currentImagePreview');
        const newImagePreview = document.getElementById('newImagePreview');
        const imagePlaceholder = document.getElementById('imagePlaceholder');

        // Logic ban đầu để hiển thị ảnh hiện tại hoặc placeholder
        function updatePreviewVisibility() {
            // Lấy src của ảnh hiện tại và kiểm tra nếu đó là ảnh mặc định hoặc rỗng
            const currentSrc = currentImagePreview.getAttribute('src');
            // Kiểm tra nếu src rỗng hoặc chứa default-avatar.png
            const isDefaultAvatar = currentSrc.includes('default-avatar.png') || currentSrc.trim() === '/webbanhang/' || currentSrc.trim() === '';

            // Ẩn tất cả trước khi quyết định hiển thị cái nào
            currentImagePreview.style.display = 'none';
            newImagePreview.style.display = 'none';
            imagePlaceholder.style.display = 'none';

            if (newImagePreview.src && newImagePreview.src !== window.location.href + '#') {
                // Nếu có ảnh mới đã được chọn và hiển thị
                newImagePreview.style.display = 'block';
            } else if (currentSrc && !isDefaultAvatar) {
                // Nếu có ảnh cũ không phải default, hiển thị ảnh cũ
                currentImagePreview.style.display = 'block';
            } else {
                // Nếu không có ảnh nào (hoặc chỉ có default), hiển thị placeholder
                imagePlaceholder.style.display = 'block';
            }
        }

        // Gọi lần đầu khi DOM đã load
        updatePreviewVisibility();

        avatarInput.addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    newImagePreview.src = e.target.result;
                    newImagePreview.style.display = 'block';
                    currentImagePreview.style.display = 'none'; // Ẩn ảnh cũ khi có ảnh mới
                    imagePlaceholder.style.display = 'none';
                };
                reader.readAsDataURL(file);
            } else {
                // Nếu người dùng xóa file đã chọn, trở lại trạng thái ban đầu
                newImagePreview.src = '#'; // Đặt lại src để không hiển thị ảnh cũ trong newImagePreview
                updatePreviewVisibility(); // Cập nhật lại trạng thái hiển thị
            }
        });
    });
</script>
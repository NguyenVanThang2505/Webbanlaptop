<?php include 'app/views/shares/header.php'; ?>

<style>
    body {
        /* Nền gradient nhẹ nhàng, chuyên nghiệp, bao phủ toàn bộ chiều cao */
        background: linear-gradient(135deg, #f0f4f8, #d9e2ec);
        min-height: 100vh;
        display: flex;
        flex-direction: column;
    }

    .container {
        flex-grow: 1; /* Cho phép container chiếm hết không gian còn lại */
        display: flex;
        align-items: center; /* Căn giữa card theo chiều dọc */
        justify-content: center; /* Căn giữa card theo chiều ngang */
        padding: 20px; /* Thêm padding cho container */
    }

    .profile-card {
        background-color: #ffffff;
        padding: 40px; /* Padding tổng thể của card */
        padding-top: 0; /* Đặt padding-top về 0 để dải màu không bị đẩy xuống */
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        text-align: center;
        max-width: 600px;
        width: 100%;
        border: none;
        position: relative;
        overflow: hidden; /* Đảm bảo không có gì tràn ra ngoài */
        /* --- New: Appearance Effect --- */
        opacity: 0; /* Initially hide the card */
        animation: fadeInUp 0.8s ease-out forwards; /* Apply the animation */
        /* animation-delay: 0.2s; Optional: Add a slight delay */
    }

    /* --- New: Keyframes for Appearance Effect --- */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px); /* Start slightly below its final position */
        }
        to {
            opacity: 1;
            transform: translateY(0); /* End at its final position */
        }
    }

    .profile-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100px; /* Chiều cao lớn hơn để avatar có thể nổi lên */
        background: linear-gradient(to right, #6a11cb, #2575fc); /* Gradient tím-xanh */
        border-radius: 15px 15px 0 0;
        z-index: 0; /* Đảm bảo dải màu nằm dưới các phần tử khác của card */
    }

    .profile-avatar {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        object-fit: cover;
        border: 6px solid #ffffff; /* Viền trắng dày để tách avatar khỏi dải màu */
        box-shadow: 0 0 0 3px #2575fc; /* Viền accent bên ngoài */
        margin-top: 30px; /* Đẩy avatar xuống một chút từ top của card để nằm trong dải màu */
        margin-bottom: 25px;
        transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
        z-index: 1; /* Đảm bảo avatar nằm trên dải màu accent */
        position: relative; /* Quan trọng để z-index hoạt động */
        cursor: pointer; /* Thêm con trỏ báo hiệu có thể click */
    }

    /* Bỏ hiệu ứng hover phóng to */
    /* .profile-avatar:hover {
        transform: scale(1.08);
        box-shadow: 0 0 0 5px #ff6b6b;
    } */

    .profile-name {
        font-size: 2.5rem;
        font-weight: 700;
        color: #2c3e50;
        margin-bottom: 10px;
        letter-spacing: -0.5px;
        position: relative; /* Để tên nằm trên dải màu nếu dải màu quá lớn */
        z-index: 1;
    }

    .profile-role {
        font-size: 1.2rem;
        color: #7f8c8d;
        margin-bottom: 30px;
        text-transform: capitalize;
        font-weight: 500;
        position: relative;
        z-index: 1;
    }

    .profile-info {
        text-align: left;
        margin-top: 20px;
        padding: 0 20px;
        position: relative;
        z-index: 1;
    }

    .profile-info p {
        font-size: 1.1rem;
        color: #34495e;
        margin-bottom: 15px;
        padding-bottom: 10px;
        border-bottom: 1px solid #ebf2f7;
        display: flex;
        align-items: baseline;
    }

    .profile-info p:last-child {
        border-bottom: none;
    }

    .profile-info p strong {
        color: #4a69bd;
        display: inline-block;
        min-width: 130px;
        flex-shrink: 0;
        margin-right: 15px;
        font-weight: 600;
    }

    .profile-info p span {
        flex-grow: 1;
        word-wrap: break-word;
    }

    .btn-edit-profile {
        background: linear-gradient(45deg, #28a745, #218838);
        border: none;
        padding: 14px 30px;
        font-size: 1.1rem;
        font-weight: bold;
        border-radius: 50px;
        margin-top: 30px;
        color: white;
        text-decoration: none;
        transition: all 0.3s ease-in-out;
        box-shadow: 0 5px 15px rgba(40, 167, 69, 0.3);
        position: relative;
        z-index: 1;
    }

    .btn-edit-profile:hover {
        background: linear-gradient(45deg, #218838, #1e7e34);
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(40, 167, 69, 0.4);
    }

    /* CSS cho Modal hiển thị ảnh lớn */
    .image-modal {
        display: none; /* Ẩn mặc định */
        position: fixed; /* Giữ vị trí khi cuộn */
        z-index: 1000; /* Đặt cao hơn các nội dung khác */
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto; /* Cho phép cuộn nếu ảnh quá lớn */
        background-color: rgba(0, 0, 0, 0.9); /* Nền tối mờ */
        align-items: center;
        justify-content: center;
    }

    .image-modal-content {
        margin: auto;
        display: block;
        max-width: 90%;
        max-height: 90%;
        object-fit: contain; /* Đảm bảo ảnh vừa với khung */
        border-radius: 8px; /* Bo góc ảnh trong modal */
    }

    .close-modal {
        position: absolute;
        top: 20px;
        right: 35px;
        color: #f1f1f1;
        font-size: 40px;
        font-weight: bold;
        transition: 0.3s;
        cursor: pointer;
    }

    .close-modal:hover,
    .close-modal:focus {
        color: #bbb;
        text-decoration: none;
        cursor: pointer;
    }
</style>

<div class="container">
    <div class="profile-card">
        <?php
        // Đảm bảo $data['account'] được truyền từ controller
        if (isset($_SESSION['username'])) { // Kiểm tra session username để đảm bảo người dùng đã đăng nhập
            // Trong trường hợp này, vì bạn đang include header, có lẽ account data đã có sẵn hoặc cần lấy lại.
            // Để đơn giản hóa, tôi giả định $account đã được gán giá trị từ controller.
            // Nếu không, bạn sẽ cần lấy thông tin account từ database hoặc session ở đây.

            // Dữ liệu giả định nếu không có $data['account'] từ controller
            if (!isset($data['account'])) {
                // Đây chỉ là dữ liệu mẫu, bạn cần thay thế bằng dữ liệu thực từ database
                $account = (object)[
                    'id' => $_SESSION['user_id'] ?? null,
                    'username' => $_SESSION['username'],
                    'fullname' => $_SESSION['fullname'] ?? 'Người dùng',
                    'role' => $_SESSION['role'] ?? 'Người dùng',
                    'avatar' => $_SESSION['avatar'] ?? 'public/images/UserAvatar/default.png',
                    'email' => 'user@example.com', // Thay bằng dữ liệu thực
                    'phone' => '0123456789', // Thay bằng dữ liệu thực
                    'address' => '123 Đường ABC, Quận XYZ, TP.HCM' // Thay bằng dữ liệu thực
                ];
            } else {
                $account = $data['account'];
            }

            // Xử lý đường dẫn avatar cho đúng
            // Kiểm tra xem avatar có tồn tại và đường dẫn hợp lệ không, nếu không thì dùng ảnh mặc định
            $avatarPath = !empty($account->avatar) && file_exists($account->avatar)
                                    ? '/webbanhang/' . htmlspecialchars($account->avatar, ENT_QUOTES, 'UTF-8')
                                    : '/webbanhang/public/images/UserAvatar/default.png'; // Đặt tên ảnh mặc định rõ ràng
        ?>
            <img src="<?= $avatarPath ?>" alt="Avatar" class="profile-avatar" id="profileAvatar">
            <h3 class="profile-name"><?= htmlspecialchars($account->fullname ?? $account->username, ENT_QUOTES, 'UTF-8'); ?></h3>
            <p class="profile-role">Vai trò: <?= htmlspecialchars($account->role, ENT_QUOTES, 'UTF-8'); ?></p>

            <div class="profile-info">
                <p><strong>Username:</strong> <span><?= htmlspecialchars($account->username, ENT_QUOTES, 'UTF-8'); ?></span></p>
                <p><strong>Email:</strong> <span><?= htmlspecialchars($account->email ?? 'Chưa cập nhật', ENT_QUOTES, 'UTF-8'); ?></span></p>
                <p><strong>Số điện thoại:</strong> <span><?= htmlspecialchars($account->phone ?? 'Chưa cập nhật', ENT_QUOTES, 'UTF-8'); ?></span></p>
                <p><strong>Địa chỉ:</strong> <span><?= htmlspecialchars($account->address ?? 'Chưa cập nhật', ENT_QUOTES, 'UTF-8'); ?></span></p>
            </div>

            <a href="/webbanhang/account/edit_profile/<?= htmlspecialchars($account->id ?? '', ENT_QUOTES, 'UTF-8'); ?>" class="btn btn-primary btn-edit-profile">Sửa thông tin</a>

        <?php
        } else {
            echo '<p class="text-danger">Không thể tải thông tin tài khoản. Vui lòng đăng nhập.</p>';
            // Có thể thêm link đăng nhập ở đây
            // echo '<a href="/webbanhang/account/login" class="btn btn-primary mt-3">Đăng nhập</a>';
        }
        ?>
    </div>
</div>

<div id="imageModal" class="image-modal">
    <span class="close-modal">&times;</span>
    <img class="image-modal-content" id="img01">
</div>

<script>
    // Lấy các phần tử DOM cần thiết
    const profileAvatar = document.getElementById('profileAvatar');
    const imageModal = document.getElementById('imageModal');
    const modalImg = document.getElementById('img01');
    const closeModal = document.getElementsByClassName('close-modal')[0];

    // Khi click vào ảnh đại diện, hiển thị modal
    profileAvatar.onclick = function() {
        imageModal.style.display = 'flex'; // Sử dụng flex để căn giữa ảnh
        modalImg.src = this.src; // Đặt nguồn ảnh của modal bằng nguồn ảnh đại diện
    }

    // Khi click vào nút đóng (x) hoặc ngoài ảnh, đóng modal
    closeModal.onclick = function() {
        imageModal.style.display = 'none';
    }

    imageModal.onclick = function(event) {
        if (event.target === imageModal) { // Chỉ đóng khi click trực tiếp vào nền modal, không phải ảnh
            imageModal.style.display = 'none';
        }
    }
</script>

<?php include 'app/views/shares/footer.php'; ?>
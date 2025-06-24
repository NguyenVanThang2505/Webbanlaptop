<?php
require_once('app/config/database.php');
require_once('app/models/AccountModel.php');
require_once('app/helpers/SessionHelper.php');

class AccountController
{
    private $accountModel;
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->getConnection();
        $this->accountModel = new AccountModel($this->db);
    }

    // Phương thức hiển thị form đăng ký tài khoản người dùng
    public function register()
    {
        // Khởi tạo các biến rỗng khi hiển thị form lần đầu
        $errors = [];
        $data = [
            'username' => '',
            'fullname' => '',
            'email' => '',
            'phone' => '',
            'address' => '',
            'avatar' => ''
        ];
        include_once 'app/views/account/register.php';
    }

    // Phương thức lưu thông tin tài khoản người dùng mới
    public function save()
    {
        // Kiểm tra nếu là POST request
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Lấy dữ liệu từ POST request
            $username = $_POST['username'] ?? '';
            $fullName = $_POST['fullname'] ?? '';
            $password = $_POST['password'] ?? '';
            $confirmPassword = $_POST['confirmpassword'] ?? '';
            $email = $_POST['email'] ?? '';
            $phone = $_POST['phone'] ?? '';
            $address = $_POST['address'] ?? '';
            $avatar = ''; // Khởi tạo avatar rỗng
            $errors = []; // Mảng chứa các lỗi validation

            // Các quy tắc validation cơ bản
            if (empty($username)) $errors['username'] = "Vui lòng nhập tên đăng nhập.";
            if (empty($fullName)) $errors['fullname'] = "Vui lòng nhập họ và tên.";
            if (empty($password)) $errors['password'] = "Vui lòng nhập mật khẩu.";
            if ($password !== $confirmPassword) $errors['confirm'] = "Mật khẩu xác nhận không khớp.";
            if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors['email'] = "Email không hợp lệ.";

            // Kiểm tra tên đăng nhập đã tồn tại chưa
            if ($this->accountModel->getAccountByUsername($username)) {
                $errors['account'] = "Tên đăng nhập đã tồn tại.";
            }

            // Xử lý upload ảnh đại diện
            if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] == UPLOAD_ERR_OK) {
                try {
                    $avatar = $this->uploadAvatar($_FILES['avatar']);
                } catch (Exception $e) {
                    $errors['avatar'] = $e->getMessage();
                }
            } elseif (isset($_FILES['avatar']) && $_FILES['avatar']['error'] !== UPLOAD_ERR_NO_FILE) {
                // Xử lý các lỗi upload khác ngoài UPLOAD_ERR_OK và UPLOAD_ERR_NO_FILE
                $errors['avatar'] = "Lỗi khi upload ảnh đại diện: " . $_FILES['avatar']['error'];
            }

            // Nếu có lỗi validation, hiển thị lại form với lỗi và dữ liệu đã nhập
            if (count($errors) > 0) {
                $data = [ // Gói dữ liệu đã nhập vào mảng $data để truyền về view
                    'username' => $username,
                    'fullname' => $fullName,
                    'email' => $email,
                    'phone' => $phone,
                    'address' => $address,
                    'avatar' => $avatar, // Đường dẫn avatar (nếu đã upload thành công nhưng có lỗi khác)
                    'errors' => $errors
                ];
                include_once 'app/views/account/register.php';
                return; // Dừng thực thi sau khi include view
            }

            // Hash mật khẩu trước khi lưu vào DB
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
            $result = $this->accountModel->save($username, $fullName, $hashedPassword, $email, $phone, $address, $avatar, 'user');

            // Kiểm tra kết quả lưu vào DB
            if ($result) {
                header('Location: /webbanhang/account/login');
                exit;
            } else {
                $errors['db'] = "Đăng ký thất bại! Vui lòng thử lại sau.";
                $data = [ // Gói dữ liệu đã nhập vào mảng $data để truyền về view
                    'username' => $username,
                    'fullname' => $fullName,
                    'email' => $email,
                    'phone' => $phone,
                    'address' => $address,
                    'avatar' => $avatar,
                    'errors' => $errors
                ];
                include_once 'app/views/account/register.php';
                return; // Dừng thực thi
            }
        }
    }

    // Phương thức hiển thị form đăng nhập
    public function login()
    {
        include 'app/views/account/login.php';
    }

    // Phương thức kiểm tra thông tin đăng nhập
    public function checkLogin()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';
        $account = $this->accountModel->getAccountByUsername($username);

        if ($account && password_verify($password, $account->password)) {
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }

            $_SESSION['username'] = $account->username;
            $_SESSION['role'] = $account->role;
            $_SESSION['user_id'] = $account->id;
            $_SESSION['avatar'] = $account->avatar ?? 'uploads/default_avatar.png'; // ✅ Dòng thêm mới

            header("Location: /webbanhang/product");
            exit;
        } else {
            $error = "Sai thông tin đăng nhập.";
            include 'app/views/account/login.php';
        }
    }
}


    // Phương thức đăng xuất
    public function logout()
{
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    $username = $_SESSION['username'] ?? null;
    $cartBackup = [];

    if ($username && isset($_SESSION['cart_by_user'][$username])) {
        $cartBackup[$username] = $_SESSION['cart_by_user'][$username];
    }

    // Xóa thông tin đăng nhập
    unset($_SESSION['user']);
    unset($_SESSION['username']);
    unset($_SESSION['avatar']);
    unset($_SESSION['role']); // ✅ Thêm dòng này để isAdmin() = false sau khi logout

    // Giữ lại giỏ hàng nếu có
    if (!empty($cartBackup)) {
        $_SESSION['cart_by_user'] = $cartBackup;
    }

    header('Location: /webbanhang/account/login');
    exit;
}





    // Phương thức hiển thị form đăng nhập admin
    public function loginAdmin()
    {
        $error = ''; // Khởi tạo biến lỗi rỗng
        include 'app/views/account/login_admin.php';
    }

    // Phương thức kiểm tra đăng nhập admin
    public function checkLoginAdmin()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';
            $account = $this->accountModel->getAccountByUsername($username);

            // Kiểm tra tài khoản, vai trò và mật khẩu
            if ($account && $account->role === 'admin' && password_verify($password, $account->password)) {
                if (session_status() == PHP_SESSION_NONE) { session_start(); } // Đảm bảo session bắt đầu
                $_SESSION['username'] = $account->username;
                $_SESSION['role'] = $account->role;
                $_SESSION['user_id'] = $account->id; // Lưu ID người dùng vào session
                header("Location: /webbanhang/product"); // Chuyển hướng về trang sản phẩm
                exit;
            } else {
                $error = "Sai thông tin hoặc bạn không phải quản trị viên."; // Thông báo lỗi
                include 'app/views/account/login_admin.php'; // Hiển thị lại form đăng nhập admin với lỗi
            }
        }
    }

    // Phương thức hiển thị form đăng ký tài khoản admin
    public function createAdmin()
    {
        // Khởi tạo biến lỗi và dữ liệu rỗng
        $errors = [];
        $data = [
            'username' => '',
            'fullname' => '',
            'email' => '',
            'phone' => '',
            'address' => '',
            'avatar' => ''
        ];
        include 'app/views/account/register_admin.php';
    }

    // Phương thức lưu thông tin tài khoản admin mới
    public function storeAdmin()
    {
        // Kiểm tra xem đã có admin nào chưa và người dùng hiện tại có phải admin không
        $anyAdmin = $this->accountModel->hasAdmin();
        if ($anyAdmin && !SessionHelper::isAdmin()) {
            header("Location: /webbanhang/account/loginAdmin");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $fullname = $_POST['fullname'] ?? '';
            $password = $_POST['password'] ?? '';
            $confirm = $_POST['confirmpassword'] ?? '';
            $email = $_POST['email'] ?? '';
            $phone = $_POST['phone'] ?? '';
            $address = $_POST['address'] ?? '';
            $avatar = '';
            $errors = [];

            // Các quy tắc validation
            if (empty($username)) $errors['username'] = "Vui lòng nhập tên đăng nhập.";
            if (empty($fullname)) $errors['fullname'] = "Vui lòng nhập họ và tên.";
            if (empty($password)) $errors['password'] = "Vui lòng nhập mật khẩu.";
            if ($password !== $confirm) {
                $errors['confirm'] = "Mật khẩu xác nhận không khớp.";
            }
            if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors['email'] = "Email không hợp lệ.";

            // Kiểm tra tên đăng nhập đã tồn tại
            if ($this->accountModel->getAccountByUsername($username)) {
                $errors['account'] = "Tên đăng nhập đã tồn tại.";
            }

            // Xử lý upload ảnh đại diện
            if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] == UPLOAD_ERR_OK) {
                try {
                    $avatar = $this->uploadAvatar($_FILES['avatar']);
                } catch (Exception $e) {
                    $errors['avatar'] = $e->getMessage();
                }
            } elseif (isset($_FILES['avatar']) && $_FILES['avatar']['error'] !== UPLOAD_ERR_NO_FILE) {
                $errors['avatar'] = "Lỗi khi upload ảnh đại diện: " . $_FILES['avatar']['error'];
            }

            // Nếu có lỗi validation, hiển thị lại form
            if (!empty($errors)) {
                $data = [ // Gói dữ liệu đã nhập
                    'username' => $username,
                    'fullname' => $fullname,
                    'email' => $email,
                    'phone' => $phone,
                    'address' => $address,
                    'avatar' => $avatar,
                    'errors' => $errors
                ];
                include 'app/views/account/register_admin.php';
                return;
            }

            // Hash mật khẩu và lưu vào DB với vai trò admin
            $hash = password_hash($password, PASSWORD_BCRYPT);
            $result = $this->accountModel->save($username, $fullname, $hash, $email, $phone, $address, $avatar, 'admin');

            if ($result) {
                header("Location: /webbanhang/account/loginAdmin");
                exit;
            } else {
                $errors['db'] = "Đăng ký admin thất bại! Vui lòng thử lại sau.";
                $data = [ // Gói dữ liệu đã nhập
                    'username' => $username,
                    'fullname' => $fullname,
                    'email' => $email,
                    'phone' => $phone,
                    'address' => $address,
                    'avatar' => $avatar,
                    'errors' => $errors
                ];
                include 'app/views/account/register_admin.php';
                return;
            }
        }
    }

    // Phương thức hiển thị thống kê và danh sách tài khoản (chỉ admin)
    public function statistic()
    {
        if (session_status() == PHP_SESSION_NONE) { session_start(); } // Đảm bảo session bắt đầu
        // Kiểm tra quyền admin
        if (!SessionHelper::isAdmin()) {
            header("Location: /webbanhang/account/loginAdmin");
            exit;
        }

        $search = $_GET['search'] ?? '';
        $roleFilter = $_GET['role'] ?? '';

        $stats = $this->accountModel->getAccountStatistics();
        $accounts = $this->accountModel->getFilteredAccounts($search, $roleFilter);

        $userCount = $this->accountModel->countByRole('user');
        $adminCount = $this->accountModel->countByRole('admin');

        include 'app/views/account/statistic.php';
    }

    // Phương thức xóa tài khoản (chỉ admin)
    public function delete($id)
    {
        if (session_status() == PHP_SESSION_NONE) { session_start(); } // Đảm bảo session bắt đầu
        // Kiểm tra quyền admin
        if (!SessionHelper::isAdmin()) {
            header("Location: /webbanhang/account/loginAdmin");
            exit;
        }

        $account = $this->accountModel->getAccountById($id);

        // Không cho phép admin tự xóa tài khoản của mình
        if ($account && isset($_SESSION['username']) && $account->username !== $_SESSION['username']) {
            // Xóa ảnh đại diện vật lý nếu có
            if (!empty($account->avatar) && file_exists($account->avatar)) {
                unlink($account->avatar);
            }
            $this->accountModel->deleteById($id);
        }

        header("Location: /webbanhang/account/statistic");
        exit;
    }

    // --- PHƯƠNG THỨC HIỂN THỊ TRANG PROFILE CÁ NHÂN ---
    public function profile()
    {
        if (session_status() == PHP_SESSION_NONE) { session_start(); } // Đảm bảo session bắt đầu

        // Kiểm tra xem người dùng đã đăng nhập chưa
        if (!isset($_SESSION['username'])) {
            header("Location: /webbanhang/account/login"); // Chuyển hướng về trang đăng nhập
            exit;
        }

        $username = $_SESSION['username'];
        $account = $this->accountModel->getAccountByUsername($username);

        // Kiểm tra xem tài khoản có tồn tại không (phòng trường hợp bị xóa khi session còn)
        if (!$account) {
            session_destroy(); // Hủy session
            header("Location: /webbanhang/account/login");
            exit;
        }

        // Kiểm tra và hiển thị thông báo thành công (nếu có từ updateProfile)
        $successMessage = null;
        if (isset($_SESSION['success_message'])) {
            $successMessage = $_SESSION['success_message'];
            unset($_SESSION['success_message']); // Xóa thông báo sau khi dùng
        }

        // Truyền dữ liệu tài khoản và thông báo thành công đến view
        $data = ['account' => $account, 'success_message' => $successMessage];
        include 'app/views/account/profile.php'; // Đảm bảo bạn có file profile.php
    }

    // --- PHƯƠNG THỨC HIỂN THỊ FORM CHỈNH SỬA PROFILE ---
    public function edit_profile($id = null)
    {
        if (session_status() == PHP_SESSION_NONE) { session_start(); } // Đảm bảo session bắt đầu

        // Kiểm tra xem người dùng đã đăng nhập chưa
        if (!isset($_SESSION['user_id'])) {
            header("Location: /webbanhang/account/login");
            exit;
        }

        $accountIdToEdit = $id; // ID tài khoản từ URL (nếu có, dùng cho admin chỉnh sửa người khác)
        $loggedInUserId = $_SESSION['user_id']; // ID của người dùng đang đăng nhập

        // Nếu không có ID được cung cấp trong URL, chỉnh sửa profile của chính người dùng đó
        if (is_null($accountIdToEdit)) {
            $accountIdToEdit = $loggedInUserId;
        }

        // Kiểm tra quyền: Admin có thể chỉnh sửa mọi tài khoản, User chỉ được chỉnh sửa tài khoản của mình
        if (!SessionHelper::isAdmin() && $accountIdToEdit != $loggedInUserId) {
            // Chuyển hướng về profile nếu không có quyền
            header("Location: /webbanhang/account/profile");
            exit;
        }

        $account = $this->accountModel->getAccountById($accountIdToEdit);

        // Kiểm tra nếu tài khoản không tồn tại
        if (!$account) {
            header("Location: /webbanhang/account/profile"); // Có thể chuyển hướng đến trang lỗi 404
            exit;
        }

        // Khi hiển thị form lần đầu (hoặc sau khi cập nhật thành công), không có lỗi
        $errors = [];
        // Gói dữ liệu tài khoản và lỗi vào mảng $data để truyền cho view
        $data = ['account' => $account, 'errors' => $errors];

        include 'app/views/account/edit_account.php'; // Sử dụng view edit_profile.php
    }

    // --- PHƯƠNG THỨC XỬ LÝ CẬP NHẬT PROFILE ---
    public function updateProfile()
    {
        if (session_status() == PHP_SESSION_NONE) { session_start(); } // Đảm bảo session bắt đầu

        // Kiểm tra xem người dùng đã đăng nhập chưa
        if (!isset($_SESSION['user_id'])) {
            header("Location: /webbanhang/account/login");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
            $fullname = $_POST['fullname'] ?? '';
            $email = $_POST['email'] ?? '';
            $phone = $_POST['phone'] ?? '';
            $address = $_POST['address'] ?? '';
            $password = $_POST['password'] ?? ''; // Mật khẩu mới
            $confirmPassword = $_POST['confirmpassword'] ?? ''; // Xác nhận mật khẩu mới
            $existingAvatar = $_POST['existing_avatar'] ?? ''; // Đường dẫn avatar hiện tại từ hidden field

            $errors = [];

            // Validation ID
            if (!filter_var($id, FILTER_VALIDATE_INT) || $id <= 0) {
                $errors['id'] = "ID tài khoản không hợp lệ.";
            }

            // Lấy thông tin tài khoản hiện tại từ DB để kiểm tra quyền và avatar cũ
            $currentAccount = $this->accountModel->getAccountById($id);
            if (!$currentAccount) {
                $errors['account'] = "Tài khoản không tồn tại.";
            }

            // Kiểm tra quyền: Admin có thể chỉnh sửa mọi tài khoản, User chỉ được chỉnh sửa tài khoản của mình
            if (!SessionHelper::isAdmin() && $id != $_SESSION['user_id']) {
                 $errors['permission'] = "Bạn không có quyền chỉnh sửa tài khoản này.";
            }

            // Validation các trường bắt buộc/quan trọng
            if (empty($fullname)) $errors['fullname'] = "Họ và tên không được để trống.";
            if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors['email'] = "Email không hợp lệ.";

            // Xử lý mật khẩu mới (nếu người dùng nhập)
            if (!empty($password)) {
                if (strlen($password) < 6) { // Ví dụ: mật khẩu tối thiểu 6 ký tự
                    $errors['password'] = "Mật khẩu phải có ít nhất 6 ký tự.";
                }
                if ($password !== $confirmPassword) {
                    $errors['confirmPassword'] = "Mật khẩu xác nhận không khớp.";
                }
            }

            // Xử lý upload ảnh đại diện mới
            $avatarPath = $existingAvatar; // Mặc định giữ đường dẫn avatar cũ
            if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
                try {
                    $newAvatarPath = $this->uploadAvatar($_FILES['avatar']);
                    $avatarPath = $newAvatarPath;
                    if (!empty($existingAvatar) && file_exists($existingAvatar) && strpos($existingAvatar, 'default-avatar.png') === false) {
                        unlink($existingAvatar);
                    }
                } catch (Exception $e) {
                    $errors['avatar'] = $e->getMessage();
                }
            } elseif (isset($_FILES['avatar']) && $_FILES['avatar']['error'] !== UPLOAD_ERR_NO_FILE) {
                $errors['avatar'] = "Lỗi khi upload ảnh đại diện: " . $_FILES['avatar']['error'];
            }

            if (!empty($errors)) {
                $accountToRender = (object)[
                    'id' => $id,
                    'username' => $currentAccount->username ?? '', // Giữ lại username ban đầu
                    'fullname' => $fullname,
                    'email' => $email,
                    'phone' => $phone,
                    'address' => $address,
                    'avatar' => $avatarPath // Sử dụng đường dẫn avatar mới (nếu có) hoặc cũ
                ];
                $data = ['account' => $accountToRender, 'errors' => $errors];
                include 'app/views/account/edit_profile.php';
                return; // Dừng thực thi
            }

            $updateData = [
                'id' => $id,
                'fullname' => $fullname,
                'email' => $email,
                'phone' => $phone,
                'address' => $address,
                'avatar' => $avatarPath // Đường dẫn avatar đã được xác định (mới hoặc cũ)
            ];

            if (!empty($password)) {
                $updateData['password'] = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
            }

            if ($this->accountModel->updateAccount($updateData)) {
                $_SESSION['success_message'] = 'Cập nhật thông tin thành công!';
                
  

                header("Location: /webbanhang/account/profile");
                exit;
            } else {
                $errors['db'] = "Có lỗi xảy ra khi cập nhật thông tin. Vui lòng thử lại.";
                $accountToRender = (object)[ 
                    'id' => $id,
                    'username' => $currentAccount->username ?? '',
                    'fullname' => $fullname,
                    'email' => $email,
                    'phone' => $phone,
                    'address' => $address,
                    'avatar' => $avatarPath
                ];
                $data = ['account' => $accountToRender, 'errors' => $errors];
                include 'app/views/account/edit_profile.php';
                return; // Dừng thực thi
            }
        } else {
            header("Location: /webbanhang/account/profile");
            exit;
        }
    }

    // --- PHƯƠNG THỨC HỖ TRỢ UPLOAD AVATAR ---
    private function uploadAvatar($file)
    {
        $uploadDir = 'public/uploads/avatars/'; 
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true); 
        }

        $filename = uniqid() . '_' . basename($file['name']);
        $targetPath = $uploadDir . $filename;
        $fileType = strtolower(pathinfo($targetPath, PATHINFO_EXTENSION));

        if (!in_array($fileType, ['jpg', 'jpeg', 'png', 'gif'])) {
            throw new Exception("Chỉ cho phép ảnh JPG, JPEG, PNG, GIF.");
        }

        if ($file['size'] > 5 * 1024 * 1024) {
            throw new Exception("Kích thước ảnh không được vượt quá 5MB.");
        }

        if (!move_uploaded_file($file['tmp_name'], $targetPath)) {
            throw new Exception("Lỗi khi tải lên ảnh đại diện.");
        }

        return $targetPath; 
    }

    public function showPurchaseHistory()
    {
        // Đảm bảo session đã được bắt đầu
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // Kiểm tra xem người dùng đã đăng nhập chưa
        if (!isset($_SESSION['user_id'])) {
            // Chuyển hướng đến trang đăng nhập nếu chưa đăng nhập
            header("Location: /webbanhang/account/login");
            exit;
        }

        $accountId = $_SESSION['user_id']; // Lấy ID tài khoản từ session

        // Lấy ngày tìm kiếm từ URL nếu có
        $search_date = null;
        if (isset($_GET['search_date']) && !empty($_GET['search_date'])) {
            $search_date = $_GET['search_date'];
            // Tùy chọn: Thêm validation cơ bản cho định dạng ngày (YYYY-MM-DD)
            // để tránh lỗi SQL injection hoặc lỗi truy vấn nếu dữ liệu không đúng định dạng.
            if (!preg_match("/^\d{4}-\d{2}-\d{2}$/", $search_date)) {
                $search_date = null; // Đặt về null nếu định dạng không hợp lệ
            }
        }

        // Gọi phương thức getPurchaseHistory từ model, truyền accountId và search_date
        $purchaseHistory = $this->accountModel->getPurchaseHistory($accountId, $search_date);

        // Truyền dữ liệu tới view
        // Vì bạn đang sử dụng `include 'app/views/account/purchase_history.php';`
        // nên các biến $purchaseHistory và $search_date (nếu có) sẽ có sẵn trong view.
        // Tuy nhiên, nếu bạn có một phương thức render view riêng (ví dụ: $this->view()),
        // hãy đảm bảo bạn truyền cả search_date vào mảng dữ liệu.
        // Ví dụ: $this->view('account/purchase_history', ['purchaseHistory' => $purchaseHistory, 'search_date' => $search_date]);
        include 'app/views/account/purchase_history.php';
    }
}
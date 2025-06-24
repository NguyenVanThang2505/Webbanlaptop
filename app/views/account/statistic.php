<?php include_once __DIR__ . '/../../../check_admin.php'; ?>
<?php
// Define BASE_PATH if not already defined for robust pathing
if (!defined('BASE_PATH')) {
    define('BASE_PATH', __DIR__ . '/../../../');
}
include BASE_PATH . 'app/views/shares/header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý tài khoản</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Custom styles to maintain specific design elements, prioritizing Tailwind utilities */
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f4f7f6; /* A light grey background consistent with other views */
        }

        /* Replicating .manage-header like styling using Tailwind utilities */
        .manage-header-flex {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.25rem; /* 20px */
        }

        /* Basic table styling for consistency */
        .custom-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1.25rem; /* 20px */
            border-radius: 0.5rem; /* rounded-lg */
            overflow: hidden; /* Ensures rounded corners apply to content */
        }

        .custom-table th, .custom-table td {
            padding: 0.75rem 1rem; /* 12px 16px */
            border: 1px solid #e5e7eb; /* border-gray-200 */
            text-align: center;
            vertical-align: middle; /* Align content vertically in middle */
        }

        .custom-table th {
            background-color: #f9fafb; /* bg-gray-50 */
            color: #4b5563; /* text-gray-700 */
            font-size: 0.75rem; /* text-xs */
            font-weight: 500; /* font-medium */
            text-transform: uppercase; /* uppercase */
            letter-spacing: 0.05em; /* tracking-wider */
        }

        /* Badge styles */
        .badge-role {
            padding: 0.375rem 0.75rem; /* 6px 12px */
            border-radius: 0.75rem; /* 12px */
            font-size: 0.9rem;
            color: white; /* text-white */
            display: inline-block; /* For proper padding and margin */
        }

        .badge-admin {
            background-color: #dc2626; /* bg-red-600 (approx. #dc3545) */
        }

        .badge-user {
            background-color: #6b7280; /* bg-gray-600 (approx. #6c757d) */
        }

        /* Action buttons */
        .action-btn-sm {
            padding: 0.375rem 0.75rem; /* 6px 12px */
            font-size: 0.875rem; /* text-sm */
            border-radius: 0.25rem; /* rounded */
            transition: background-color 0.15s ease-in-out;
        }

        .btn-outline-info {
            background-color: transparent;
            border: 1px solid #3ab7bf; /* Tailwind's cyan-500 approx */
            color: #3ab7bf;
        }
        .btn-outline-info:hover {
            background-color: #3ab7bf;
            color: white;
        }

        .btn-outline-danger {
            background-color: transparent;
            border: 1px solid #ef4444; /* Tailwind's red-500 */
            color: #ef4444;
        }
        .btn-outline-danger:hover {
            background-color: #ef4444;
            color: white;
        }

        .btn-success-custom {
            background-color: #22c55e; /* Tailwind's green-500 */
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            text-decoration: none;
            transition: background-color 0.15s ease-in-out;
        }
        .btn-success-custom:hover {
            background-color: #16a34a; /* Darker green on hover */
        }

        /* Form control specific styling */
        .form-input {
            padding: 0.5rem 0.75rem;
            border: 1px solid #d1d5db; /* border-gray-300 */
            border-radius: 0.375rem;
            width: 100%;
            max-width: 450px; /* From your example */
        }

        .input-group-append .btn {
            padding: 0.5rem 1rem;
            border-top-right-radius: 0.375rem;
            border-bottom-right-radius: 0.375rem;
        }

        .btn-outline-primary-custom {
            background-color: transparent;
            border: 1px solid #3b82f6; /* Tailwind blue-500 */
            color: #3b82f6;
            transition: background-color 0.15s ease-in-out;
        }
        .btn-outline-primary-custom:hover {
            background-color: #3b82f6;
            color: white;
        }

        /* Dropdown specific styles */
        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            z-index: 1;
            border-radius: 0.375rem;
            right: 0; /* Align dropdown to the right */
        }

        .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
            text-align: left;
        }

        .dropdown-content a:hover {
            background-color: #f1f1f1;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }

        .dropbtn {
            background-color: #4CAF50; /* Example button color */
            color: white;
            padding: 0.5rem 1rem;
            font-size: 1rem;
            border: none;
            cursor: pointer;
            border-radius: 0.375rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .dropbtn:hover {
            background-color: #45a049;
        }


        /* Card styles */
        .custom-card {
            background-color: white;
            border-radius: 0.5rem; /* rounded-lg */
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06); /* shadow-sm */
            overflow: hidden; /* Ensures rounded corners on children */
        }

        .custom-card-header {
            background-color: #3b82f6; /* bg-blue-500 */
            color: white; /* text-white */
            padding: 1rem 1.25rem; /* py-4 px-5 (approx) */
            text-align: center;
            font-weight: 700; /* fw-bold */
            font-size: 1.25rem; /* text-xl */
        }

        /* Utility for margin-right in action buttons */
        .mr-1 {
            margin-right: 0.25rem; /* 4px */
        }

        /* Modal for confirmation */
        .modal {
            display: none; /* Hidden by default */
            position: fixed; /* Stay in place */
            z-index: 1000; /* Sit on top */
            left: 0;
            top: 0;
            width: 100%; /* Full width */
            height: 100%; /* Full height */
            overflow: auto; /* Enable scroll if needed */
            background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background-color: #fefefe;
            margin: auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 500px;
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            text-align: center;
        }

        .modal-buttons {
            margin-top: 1.5rem;
            display: flex;
            justify-content: center;
            gap: 1rem;
        }

        .modal-btn {
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            cursor: pointer;
            transition: background-color 0.15s ease-in-out;
        }

        .modal-btn-confirm {
            background-color: #ef4444; /* red-500 */
            color: white;
        }
        .modal-btn-confirm:hover {
            background-color: #dc2626; /* red-600 */
        }

        .modal-btn-cancel {
            background-color: #d1d5db; /* gray-300 */
            color: #1f2937; /* gray-800 */
        }
        .modal-btn-cancel:hover {
            background-color: #9ca3af; /* gray-400 */
        }
    </style>
</head>
<body>
    <div class="container mx-auto px-4 py-8">
        <h3 class="text-center text-blue-600 mb-4 font-bold text-2xl">Thống kê tài khoản hệ thống</h3>

        <div class="flex justify-between items-center mb-4">
            <form class="flex-grow flex justify-start" method="get" action="/webbanhang/account/statistic">
                <div class="flex max-w-xl w-full">
                    <input type="text" name="search" class="form-input flex-grow rounded-r-none" placeholder="Tìm theo username..." value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
                    <button class="btn-outline-primary-custom rounded-l-none" type="submit">
                        <i class="fas fa-search"></i> Tìm
                    </button>
                </div>
            </form>
            <div class="flex items-center space-x-4">
                <div class="dropdown">
                    <button class="dropbtn bg-blue-500 hover:bg-blue-600">
                        Lọc theo vai trò <i class="fas fa-caret-down ml-2"></i>
                    </button>
                    <div class="dropdown-content">
                        <a href="/webbanhang/account/statistic?role=user">Người dùng (<?= $userCount ?? 0 ?>)</a>
                        <a href="/webbanhang/account/statistic?role=admin">Quản trị (<?= $adminCount ?? 0 ?>)</a>
                        <a href="/webbanhang/account/statistic">Tất cả</a>
                    </div>
                </div>
                <a href="/webbanhang/account/register" class="btn-success-custom">
                    <i class="fas fa-user-plus mr-2"></i> Thêm tài khoản
                </a>
            </div>
        </div>

        <div class="custom-card">
            <div class="custom-card-header">
                Danh sách tài khoản
            </div>
            <div class="p-0">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>ID người dùng</th>
                            <th>Tên đăng nhập</th>
                            <th>Mật khẩu</th>
                            <th>Vai trò</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($accounts)): ?>
                            <tr>
                                <td colspan="5" class="text-gray-500 py-4">Không có tài khoản nào phù hợp.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($accounts as $acc): ?>
                                <tr>
                                    <td><?= htmlspecialchars($acc->id ?? 'N/A') ?></td>
                                    <td><?= htmlspecialchars($acc->username ?? 'N/A') ?></td>
                                    <td><?= htmlspecialchars($acc->password_plain ?? 'Ẩn') ?></td>
                                    <td>
                                        <span class="badge-role <?= $acc->role === 'admin' ? 'badge-admin' : 'badge-user' ?>">
                                            <?= htmlspecialchars(ucfirst($acc->role ?? 'N/A')) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <a href="/webbanhang/account/profile/<?= htmlspecialchars($acc->id ?? '') ?>" class="action-btn-sm btn-outline-info mr-1">
                                            <i class="fas fa-eye"></i> Xem
                                        </a>
                                        <?php if (isset($_SESSION['username']) && $_SESSION['username'] !== ($acc->username ?? '')): ?>
                                            <button type="button" class="action-btn-sm btn-outline-danger"
                                                    onclick="showDeleteConfirmModal('<?= htmlspecialchars($acc->id ?? '') ?>', '<?= htmlspecialchars($acc->username ?? '') ?>')">
                                                <i class="fas fa-trash"></i> Xóa
                                            </button>
                                        <?php else: ?>
                                            <span class="text-gray-500 text-sm">Không thể xóa</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div id="deleteConfirmModal" class="modal">
        <div class="modal-content">
            <h3 class="text-lg font-semibold mb-4">Xác nhận xóa tài khoản</h3>
            <p>Bạn có chắc chắn muốn xóa tài khoản <strong id="modalAccountUsername"></strong> (ID: <span id="modalAccountId"></span>) không?</p>
            <div class="modal-buttons">
                <button class="modal-btn modal-btn-confirm" onclick="confirmDelete()">Xóa</button>
                <button class="modal-btn modal-btn-cancel" onclick="hideDeleteConfirmModal()">Hủy</button>
            </div>
        </div>
    </div>

    <script>
        let accountIdToDelete = null;

        function showDeleteConfirmModal(accountId, username) {
            accountIdToDelete = accountId;
            document.getElementById('modalAccountId').textContent = accountId;
            document.getElementById('modalAccountUsername').textContent = username;
            document.getElementById('deleteConfirmModal').style.display = 'flex'; // Use flex to center
        }

        function hideDeleteConfirmModal() {
            accountIdToDelete = null;
            document.getElementById('deleteConfirmModal').style.display = 'none';
        }

        function confirmDelete() {
            if (accountIdToDelete) {
                window.location.href = '/webbanhang/account/delete/' + accountIdToDelete;
            }
            hideDeleteConfirmModal();
        }
    </script>
</body>
</html>

<?php include BASE_PATH . 'app/views/shares/footer.php'; ?>
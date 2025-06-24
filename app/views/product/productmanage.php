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
    <title>Quản lý sản phẩm</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Custom styles to maintain specific design elements, prioritizing Tailwind utilities */
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f4f7f6; /* A light grey background consistent with other views */
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

        /* Image sizing in table */
        .custom-table img {
            max-width: 60px;
            height: auto;
            border-radius: 0.25rem;
            display: block; /* Ensures centering if parent is text-align: center */
            margin-left: auto;
            margin-right: auto;
        }

        /* Action buttons */
        .action-btn-sm {
            padding: 0.375rem 0.75rem; /* 6px 12px */
            font-size: 0.875rem; /* text-sm */
            border-radius: 0.25rem; /* rounded */
            transition: background-color 0.15s ease-in-out;
            display: inline-flex; /* For icon alignment */
            align-items: center;
            justify-content: center;
            gap: 0.25rem; /* Space between icon and text */
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

        .btn-warning-custom {
            background-color: transparent;
            border: 1px solid #fcd34d; /* Tailwind's amber-300 */
            color: #fcd34d;
        }
        .btn-warning-custom:hover {
            background-color: #fcd34d;
            color: #333; /* Darker text for contrast on yellow */
        }

        .btn-danger-custom {
            background-color: transparent;
            border: 1px solid #ef4444; /* Tailwind's red-500 */
            color: #ef4444;
        }
        .btn-danger-custom:hover {
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
            max-width: 450px;
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
        <h3 class="text-center text-blue-600 mb-4 font-bold text-2xl">Quản lý sản phẩm</h3>

        <div class="flex justify-between items-center mb-4">
            <form class="flex-grow flex justify-start" method="GET" action="/webbanhang/Product/manage">
                <div class="flex max-w-xl w-full">
                    <input type="text" name="keyword" class="form-input flex-grow rounded-r-none" placeholder="Tìm sản phẩm..." value="<?= htmlspecialchars($_GET['keyword'] ?? '') ?>">
                    <button class="btn-outline-primary-custom rounded-l-none" type="submit">
                        <i class="fas fa-search"></i> Tìm
                    </button>
                </div>
            </form>
            <div class="flex items-center">
                <a href="/webbanhang/Product/add" class="btn-success-custom">
                    <i class="fas fa-plus-circle mr-2"></i> Thêm sản phẩm
                </a>
            </div>
        </div>

        <div class="custom-card">
            <div class="custom-card-header">
                Danh sách sản phẩm
            </div>
            <div class="p-0">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tên</th>
                            <th>Giá</th>
                            <th>Ảnh</th>
                            <th>Hãng</th>
                            <th>CPU</th>
                            <th>RAM</th>
                            <th>SSD</th>
                            <th>Card</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($products)): ?>
                            <tr>
                                <td colspan="10" class="text-gray-500 py-4">Không có sản phẩm nào phù hợp.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($products as $product): ?>
                                <tr>
                                    <td><?= htmlspecialchars($product->id ?? 'N/A') ?></td>
                                    <td><?= htmlspecialchars($product->name ?? 'N/A') ?></td>
                                    <td><?= number_format($product->price ?? 0, 0, ',', '.') ?> VND</td>
                                    <td><img src="/webbanhang/<?= htmlspecialchars($product->image ?? '') ?>" alt="Product Image" /></td>
                                    <td><?= htmlspecialchars($product->category_name ?? 'N/A') ?></td>
                                    <td><?= htmlspecialchars($product->cpu ?? 'N/A') ?></td>
                                    <td><?= htmlspecialchars($product->ram ?? 'N/A') ?></td>
                                    <td><?= htmlspecialchars($product->ssd ?? 'N/A') ?></td>
                                    <td><?= htmlspecialchars($product->card ?? 'N/A') ?></td>
                                    <td>
                                        <a href="/webbanhang/Product/show/<?= htmlspecialchars($product->id ?? '') ?>" class="action-btn-sm btn-outline-info mr-1">
                                            <i class="fas fa-eye"></i> Xem
                                        </a>
                                        <a href="/webbanhang/Product/edit/<?= htmlspecialchars($product->id ?? '') ?>" class="action-btn-sm btn-warning-custom mr-1">
                                            <i class="fas fa-edit"></i> Sửa
                                        </a>
                                        <button type="button" class="action-btn-sm btn-danger-custom"
                                                onclick="showDeleteConfirmModal('<?= htmlspecialchars($product->id ?? '') ?>', '<?= htmlspecialchars($product->name ?? '') ?>')">
                                            <i class="fas fa-trash"></i> Xóa
                                        </button>
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
            <h3 class="text-lg font-semibold mb-4">Xác nhận xóa sản phẩm</h3>
            <p>Bạn có chắc chắn muốn xóa sản phẩm <strong id="modalProductName"></strong> (ID: <span id="modalProductId"></span>) không?</p>
            <div class="modal-buttons">
                <button class="modal-btn modal-btn-confirm" onclick="confirmDelete()">Xóa</button>
                <button class="modal-btn modal-btn-cancel" onclick="hideDeleteConfirmModal()">Hủy</button>
            </div>
        </div>
    </div>

    <script>
        let productIdToDelete = null;

        function showDeleteConfirmModal(productId, productName) {
            productIdToDelete = productId;
            document.getElementById('modalProductId').textContent = productId;
            document.getElementById('modalProductName').textContent = productName;
            document.getElementById('deleteConfirmModal').style.display = 'flex'; // Use flex to center
        }

        function hideDeleteConfirmModal() {
            productIdToDelete = null;
            document.getElementById('deleteConfirmModal').style.display = 'none';
        }

        function confirmDelete() {
            if (productIdToDelete) {
                window.location.href = '/webbanhang/Product/delete/' + productIdToDelete;
            }
            hideDeleteConfirmModal();
        }
    </script>
</body>
</html>

<?php include BASE_PATH . 'app/views/shares/footer.php'; ?>
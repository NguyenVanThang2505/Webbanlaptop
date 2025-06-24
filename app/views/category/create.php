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
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f4f7f6; /* Consistent light grey background */
        }
        .container {
            max-width: 600px; /* Max width for the form container */
            margin-left: auto;
            margin-right: auto;
            padding: 1.5rem; /* p-6 */
        }
        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500; /* Medium font weight */
            color: #374151; /* text-gray-700 */
        }
        .form-input {
            display: block;
            width: 100%;
            padding: 0.75rem 1rem; /* py-3 px-4 */
            border: 1px solid #d1d5db; /* border-gray-300 */
            border-radius: 0.375rem; /* rounded-md */
            font-size: 1rem;
            line-height: 1.5;
            color: #1f2937; /* text-gray-900 */
            background-color: #ffffff; /* bg-white */
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05); /* shadow-sm */
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }
        .form-input:focus {
            outline: none;
            border-color: #3b82f6; /* ring-blue-500 */
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.25); /* ring-4 ring-blue-500/25 */
        }
        .btn-primary-custom {
            background-color: #3b82f6; /* bg-blue-500 */
            color: white;
            padding: 0.75rem 1.5rem; /* py-3 px-6 */
            border-radius: 0.375rem; /* rounded-md */
            font-weight: 600; /* font-semibold */
            text-decoration: none;
            transition: background-color 0.15s ease-in-out;
        }
        .btn-primary-custom:hover {
            background-color: #2563eb; /* bg-blue-600 on hover */
        }
        .btn-secondary-custom {
            background-color: #6b7280; /* bg-gray-500 */
            color: white;
            padding: 0.75rem 1.5rem; /* py-3 px-6 */
            border-radius: 0.375rem; /* rounded-md */
            font-weight: 600; /* font-semibold */
            text-decoration: none;
            transition: background-color 0.15s ease-in-out;
        }
        .btn-secondary-custom:hover {
            background-color: #4b5563; /* bg-gray-600 on hover */
        }
    </style>
</head>
<body>
    <div class="container bg-white shadow-xl rounded-lg my-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Thêm danh mục mới</h2>

        <form action="/webbanhang/Category/create" method="POST">
            <div class="mb-4">
                <label for="name" class="form-label">Tên danh mục:</label>
                <input type="text" id="name" name="name" class="form-input" required placeholder="Nhập tên danh mục">
            </div>

            <div class="mb-6">
                <label for="description" class="form-label">Mô tả:</label>
                <textarea id="description" name="description" rows="4" class="form-input" placeholder="Nhập mô tả danh mục"></textarea>
            </div>

            <div class="flex justify-end space-x-4">
                <a href="/webbanhang/Category/list" class="btn-secondary-custom">Hủy</a>
                <button type="submit" class="btn-primary-custom">Thêm danh mục</button>
            </div>
        </form>
    </div>
</body>
</html>

<?php include __DIR__ . '/../shares/footer.php'; ?>

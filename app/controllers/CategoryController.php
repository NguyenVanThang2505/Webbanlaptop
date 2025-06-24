<?php
// Require SessionHelper and other necessary files
// Yêu cầu SessionHelper và các tệp cần thiết khác
require_once('app/config/database.php');
require_once('app/models/CategoryModel.php');

class CategoryController
{
    private $categoryModel;
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->getConnection();
        $this->categoryModel = new CategoryModel($this->db);
    }

    public function list()
    {
        $categories = $this->categoryModel->getCategories();
        // Use __DIR__ to get the absolute path of the current directory (app/controllers)
        // Sử dụng __DIR__ để lấy đường dẫn tuyệt đối của thư mục hiện tại (app/controllers)
        include __DIR__ . '/../views/category/list.php';
    }

    /**
     * Handles the creation of a new category.
     * Displays the creation form on GET request.
     * Processes form submission on POST request.
     * Xử lý việc tạo danh mục mới.
     * Hiển thị form tạo trên yêu cầu GET.
     * Xử lý gửi form trên yêu cầu POST.
     */
    public function create()
    {
        // Check if the request method is POST (form submission)
        // Kiểm tra xem phương thức yêu cầu có phải là POST (gửi form) không
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Get data from the form
            // Lấy dữ liệu từ form
            $name = $_POST['name'] ?? '';
            $description = $_POST['description'] ?? '';

            // Basic validation
            // Kiểm tra tính hợp lệ cơ bản
            if (empty($name)) {
                echo "<script>alert('Tên danh mục không được để trống!');</script>";
                // Re-include the form to show errors
                // Bao gồm lại form để hiển thị lỗi
                include __DIR__ . '/../views/category/create.php';
                return;
            }

            // Attempt to create the category
            // Cố gắng tạo danh mục
            if ($this->categoryModel->createCategory($name, $description)) {
                // Category created successfully, redirect to the list page
                // Tạo danh mục thành công, chuyển hướng đến trang danh sách
                header('Location: /webbanhang/Category/list'); // Adjust this URL as per your routing
                exit();
            } else {
                // Failed to create category
                // Thêm danh mục thất bại
                echo "<script>alert('Có lỗi xảy ra khi thêm danh mục. Vui lòng thử lại.');</script>";
                // Re-include the form with previous data if desired
                // Bao gồm lại form với dữ liệu đã nhập nếu muốn
                include __DIR__ . '/../views/category/create.php';
            }
        } else {
            // If it's a GET request, display the creation form
            // Nếu là yêu cầu GET, hiển thị form tạo
            include __DIR__ . '/../views/category/create.php';
        }
    }

    /**
     * Handles the deletion of a category.
     * Xử lý việc xóa một danh mục.
     *
     * @param int $id The ID of the category to delete. ID của danh mục cần xóa.
     */
    public function delete($id)
    {
        // Check if the ID is provided and is a valid integer
        // Kiểm tra xem ID có được cung cấp và là số nguyên hợp lệ không
        if (!isset($id) || !is_numeric($id)) {
            echo "<script>alert('ID danh mục không hợp lệ.');</script>";
            header('Location: /webbanhang/Category/list'); // Redirect back to list
            exit();
        }

        // Attempt to delete the category
        // Cố gắng xóa danh mục
        if ($this->categoryModel->deleteCategory($id)) {
            // Category deleted successfully
            // Xóa danh mục thành công
            echo "<script>alert('Danh mục đã được xóa thành công.');</script>";
        } else {
            // Failed to delete category
            // Xóa danh mục thất bại
            echo "<script>alert('Có lỗi xảy ra khi xóa danh mục. Vui lòng thử lại.');</script>";
        }

        // Redirect back to the list page after deletion attempt
        // Chuyển hướng trở lại trang danh sách sau khi thử xóa
        header('Location: /webbanhang/Category/list'); // Adjust this URL as per your routing
        exit();
    }

    /**
     * Handles the editing of an existing category.
     * Displays the edit form on GET request with existing data.
     * Processes form submission on POST request to update data.
     * Xử lý việc chỉnh sửa một danh mục hiện có.
     * Hiển thị form chỉnh sửa trên yêu cầu GET với dữ liệu hiện có.
     * Xử lý gửi form trên yêu cầu POST để cập nhật dữ liệu.
     *
     * @param int $id The ID of the category to edit. ID của danh mục cần chỉnh sửa.
     */
    public function edit($id)
    {
        // Check if the ID is provided and is a valid integer
        // Kiểm tra xem ID có được cung cấp và là số nguyên hợp lệ không
        if (!isset($id) || !is_numeric($id)) {
            echo "<script>alert('ID danh mục không hợp lệ.');</script>";
            header('Location: /webbanhang/Category/list');
            exit();
        }

        // Check if the request method is POST (form submission for update)
        // Kiểm tra xem phương thức yêu cầu có phải là POST (gửi form để cập nhật) không
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Get updated data from the form
            // Lấy dữ liệu đã cập nhật từ form
            $name = $_POST['name'] ?? '';
            $description = $_POST['description'] ?? '';

            // Basic validation
            // Kiểm tra tính hợp lệ cơ bản
            if (empty($name)) {
                echo "<script>alert('Tên danh mục không được để trống!');</script>";
                // Fetch category again to populate the form if validation fails
                // Lấy lại danh mục để điền vào form nếu kiểm tra không thành công
                $category = $this->categoryModel->getCategoryById($id);
                include __DIR__ . '/../views/category/edit.php';
                return;
            }

            // Attempt to update the category
            // Cố gắng cập nhật danh mục
            if ($this->categoryModel->updateCategory($id, $name, $description)) {
                echo "<script>alert('Danh mục đã được cập nhật thành công.');</script>";
                header('Location: /webbanhang/Category/list'); // Redirect to list page
                exit();
            } else {
                echo "<script>alert('Có lỗi xảy ra khi cập nhật danh mục. Vui lòng thử lại.');</script>";
                // Fetch category again to populate the form if update fails
                // Lấy lại danh mục để điền vào form nếu cập nhật thất bại
                $category = $this->categoryModel->getCategoryById($id);
                include __DIR__ . '/../views/category/edit.php';
            }
        } else {
            // If it's a GET request, retrieve the category data and display the edit form
            // Nếu là yêu cầu GET, lấy dữ liệu danh mục và hiển thị form chỉnh sửa
            $category = $this->categoryModel->getCategoryById($id);

            if (!$category) {
                echo "<script>alert('Không tìm thấy danh mục.');</script>";
                header('Location: /webbanhang/Category/list');
                exit();
            }

            include __DIR__ . '/../views/category/edit.php';
        }
    }
}
?>

<?php
// Require SessionHelper and other necessary files
require_once('app/config/database.php');
require_once('app/models/ProductModel.php');
require_once('app/models/CategoryModel.php');

class ProductController
{
    private $productModel;
    private $db;

    private function view($viewPath, $data = [])
    {
        extract($data);
        include "app/views/{$viewPath}.php";
    }

    public function __construct()
    {
        $this->db = (new Database())->getConnection();
        $this->productModel = new ProductModel($this->db);
    }

    public function index()
{
    $products = $this->productModel->getProducts(); // hoặc dữ liệu tạm
    include __DIR__ . '/../views/product/list.php';
}



    public function show($id)
    {
        $product = $this->productModel->getProductById($id);
        if ($product) {
            $relatedProducts = $this->productModel->getRelatedProducts($product->id, $product->category_id);
            include 'app/views/product/show.php';
        } else {
            echo "Không thấy sản phẩm.";
        }
    }

    public function add()
    {
        $categories = (new CategoryModel($this->db))->getCategories();
        include_once 'app/views/product/add.php';
    }

    public function save()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['name'] ?? '';
            $description = $_POST['description'] ?? '';
            $price = $_POST['price'] ?? '';
            $category_id = $_POST['category_id'] ?? null;

            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $image = $this->uploadImage($_FILES['image']);
            } else {
                $image = "";
            }

            $result = $this->productModel->addProduct($name, $description, $price, $category_id, $image, 
                $_POST['cpu'] ?? '', $_POST['ram'] ?? '', $_POST['ssd'] ?? '', $_POST['card'] ?? '');

            if (is_array($result)) {
                $errors = $result;
                $categories = (new CategoryModel($this->db))->getCategories();
                include 'app/views/product/add.php';
            } else {
                header('Location: /webbanhang/Product');
            }
        }
    }

    public function edit($id)
    {
        $product = $this->productModel->getProductById($id);
        $categories = (new CategoryModel($this->db))->getCategories();

        if ($product) {
            include 'app/views/product/edit.php';
        } else {
            echo "Không thấy sản phẩm.";
        }
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $name = $_POST['name'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $category_id = $_POST['category_id'];

            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $image = $this->uploadImage($_FILES['image']);
            } else {
                $image = $_POST['existing_image'];
            }

            $edit = $this->productModel->updateProduct($id, $name, $description, $price, $category_id, $image, 
                $_POST['cpu'] ?? '', $_POST['ram'] ?? '', $_POST['ssd'] ?? '', $_POST['card'] ?? '');

            if ($edit) {
                header('Location: /webbanhang/Product');
            } else {
                echo "Đã xảy ra lỗi khi lưu sản phẩm.";
            }
        }
    }

    public function delete($id)
    {
        if ($this->productModel->deleteProduct($id)) {
            header('Location: /webbanhang/Product');
        } else {
            echo "Đã xảy ra lỗi khi xóa sản phẩm.";
        }
    }

    private function uploadImage($file)
    {
        $target_dir = "uploads/";

        // Kiểm tra và tạo thư mục nếu chưa tồn tại
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        $target_file = $target_dir . basename($file["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Kiểm tra xem file có phải là hình ảnh không
        $check = getimagesize($file["tmp_name"]);
        if ($check === false) {
            throw new Exception("File không phải là hình ảnh.");
        }

        // Kiểm tra kích thước file (10 MB = 10 * 1024 * 1024 bytes)
        if ($file["size"] > 10 * 1024 * 1024) {
            throw new Exception("Hình ảnh có kích thước quá lớn.");
        }

        // Chỉ cho phép một số định dạng hình ảnh nhất định
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            throw new Exception("Chỉ cho phép các định dạng JPG, JPEG, PNG và GIF.");
        }

        // Lưu file
        if (!move_uploaded_file($file["tmp_name"], $target_file)) {
            throw new Exception("Có lỗi xảy ra khi tải lên hình ảnh.");
        }

        return $target_file;
    }

    public function addToCart($id)
{
    // Nếu chưa đăng nhập, chuyển hướng sang trang đăng nhập
    if (!SessionHelper::isLoggedIn()) {
        header('Location: /webbanhang/account/login');
        exit;
    }

    // Lấy username làm key lưu giỏ hàng
    $user = $_SESSION['username']; // Hoặc dùng $_SESSION['user_id'] nếu bạn có ID

    // Lấy sản phẩm từ DB
    $product = $this->productModel->getProductById($id);
    if (!$product) {
        echo "Không tìm thấy sản phẩm.";
        return;
    }

    // Khởi tạo giỏ hàng riêng cho người dùng nếu chưa có
    if (!isset($_SESSION['cart_by_user'][$user])) {
        $_SESSION['cart_by_user'][$user] = [];
    }

    // Nếu sản phẩm đã có thì tăng số lượng
    if (isset($_SESSION['cart_by_user'][$user][$id])) {
        $_SESSION['cart_by_user'][$user][$id]['quantity']++;
    } else {
        // Thêm sản phẩm mới vào giỏ
        $_SESSION['cart_by_user'][$user][$id] = [
            'name' => $product->name,
            'price' => $product->price,
            'quantity' => 1,
            'image' => $product->image
        ];
    }

    // Chuyển hướng sang trang giỏ hàng
    header('Location: /webbanhang/Product/cart');
    exit;
}



public function cart()
{
    if (isset($_SESSION['username'])) {
        $user = $_SESSION['username'];
        $cart = $_SESSION['cart_by_user'][$user] ?? [];
    } else {
        $user = null;
        $cart = [];
  
    }

    include 'app/views/product/cart.php';
}



    public function checkout()
    {
        include 'app/views/product/checkout.php';
    }

    public function processCheckout()
{
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $user = $_SESSION['username']; // Tên người dùng để lấy giỏ hàng
        // SỬA TẠI ĐÂY: Dùng $_SESSION['user_id'] thay vì $_SESSION['account_id']
        $account_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

        $cart = isset($_SESSION['cart_by_user'][$user]) ? $_SESSION['cart_by_user'][$user] : [];

        if (empty($cart)) {
            echo "Giỏ hàng trống.";
            return;
        }

        // Bắt đầu giao dịch
        $this->db->beginTransaction();

        try {
            $name = $_POST['name'];
            $phone = $_POST['phone'];
            $address = $_POST['address'];

            // Lưu thông tin đơn hàng vào bảng orders
            $query = "INSERT INTO orders (name, phone, address, account_id) VALUES (:name, :phone, :address, :account_id)";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':phone', $phone);
            $stmt->bindParam(':address', $address);
            $stmt->bindParam(':account_id', $account_id, PDO::PARAM_INT); // Gán giá trị account_id
            $stmt->execute();
            $order_id = $this->db->lastInsertId();

            // Lưu chi tiết đơn hàng
            foreach ($cart as $product_id => $item) {
                $query = "INSERT INTO order_details (order_id, product_id, quantity, price)
                                 VALUES (:order_id, :product_id, :quantity, :price)";
                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':order_id', $order_id, PDO::PARAM_INT);
                $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
                $stmt->bindParam(':quantity', $item['quantity'], PDO::PARAM_INT);
                $stmt->bindParam(':price', $item['price'], PDO::PARAM_STR);
                $stmt->execute();
            }

            // Xóa giỏ hàng sau khi đặt hàng thành công
            unset($_SESSION['cart_by_user'][$user]);

            $this->db->commit();
            header('Location: /webbanhang/Product/orderConfirmation');
        } catch (Exception $e) {
            $this->db->rollBack();
            echo "Đã xảy ra lỗi khi xử lý đơn hàng: " . $e->getMessage();
        }
    }
}

    public function detail($id) {
        $productModel = new ProductModel($this->db);
        $product = $productModel->getProductById($id);
    
        if (!$product) {
            // Xử lý nếu sản phẩm không tồn tại
            $this->view('error/404');
            return;
        }
    
        // ✅ Lấy danh sách sản phẩm cùng danh mục, loại trừ sản phẩm hiện tại
        $relatedProducts = $productModel->getRelatedProducts($product->category_id, $product->id);
    
        // Truyền cả $product và $relatedProducts xuống view
        $this->view('product/detail', [
            'product' => $product,
            'relatedProducts' => $relatedProducts
        ]);
    }
    
    public function orderConfirmation()
    {
        include 'app/views/product/orderConfirmation.php';
    }

    public function updateQuantity()
{
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    // Kiểm tra người dùng đã đăng nhập chưa
    if (!isset($_SESSION['username'])) {
        header("Location: /webbanhang/account/login");
        exit;
    }

    $username = $_SESSION['username'];
    $id = $_POST['id'];
    $action = $_POST['action'];

    // Kiểm tra giỏ hàng tồn tại và sản phẩm có trong giỏ
    if (isset($_SESSION['cart_by_user'][$username][$id])) {
        if ($action === 'increase') {
            $_SESSION['cart_by_user'][$username][$id]['quantity']++;
        } elseif ($action === 'decrease') {
            $_SESSION['cart_by_user'][$username][$id]['quantity']--;
            if ($_SESSION['cart_by_user'][$username][$id]['quantity'] <= 0) {
                unset($_SESSION['cart_by_user'][$username][$id]);
            }
        }
    }

    header("Location: /webbanhang/Product/cart");
    exit;
}


    public function removeFromCart()
{
    $id = $_POST['id'];

    if (isset($_SESSION['cart'][$id])) {
        unset($_SESSION['cart'][$id]);
    }

    header("Location: /webbanhang/Product/cart");
    exit;
}

public function search() {
    $query = $_GET['query'] ?? '';
    $productModel = new ProductModel($this->db);
    $results = $productModel->searchByName($query);
    include 'app/views/product/search_results.php';
}

public function list()
{
    $allProducts = $this->productModel->getProducts(); // Lấy tất cả sản phẩm từ DB

    // Gom nhóm sản phẩm theo category_name
    $groupedProducts = [];
    foreach ($allProducts as $product) {
        $groupedProducts[$product->category_name][] = $product;
    }

    $this->view('product/list', ['groupedProducts' => $groupedProducts]);
}

public function search_result()
{
    $keyword = $_GET['keyword'] ?? '';

    $products = $this->productModel->searchByName($keyword);
    include 'app/views/product/search_result.php';
}

public function search_results()
{
    $keyword = $_GET['keyword'] ?? '';

    require_once 'app/models/ProductModel.php';
    $productModel = new ProductModel($this->db);

    // PHẢI dùng biến $results để view nhận đúng
    $results = $productModel->searchByKeyword($keyword);

    include 'app/views/product/search_results.php';
}

public function manage()
{
    $keyword = $_GET['keyword'] ?? '';

    if ($keyword) {
        $products = $this->productModel->searchProducts($keyword);
    } else {
        $products = $this->productModel->getProducts();
    }

    include 'app/views/product/productmanage.php';
}


}
?>

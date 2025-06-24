<?php
class ProductModel
{
    private $conn;
    private $table_name = "product";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getProducts()
{
    $query = "SELECT p.id, p.name, p.description, p.price, p.image,
                     p.cpu, p.ram, p.ssd, p.card,
                     c.name as category_name
              FROM " . $this->table_name . " p
              LEFT JOIN category c ON p.category_id = c.id";

    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_OBJ);
}


    public function getProductById($id)
{
    try {
        $query = "SELECT p.*, c.name AS category_name 
                  FROM " . $this->table_name . " p
                  LEFT JOIN category c ON p.category_id = c.id
                  WHERE p.id = :id
                  LIMIT 1";

        $stmt = $this->conn->prepare($query);

        // Ép kiểu id là số nguyên để tránh lỗi SQL Injection
        $id = intval($id);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        $stmt->execute();

        // Lấy dữ liệu dưới dạng object
        $product = $stmt->fetch(PDO::FETCH_OBJ);

        return $product;
    } catch (PDOException $e) {
        // Ghi log lỗi hoặc hiển thị thông báo phù hợp
        error_log("Lỗi truy vấn getProductById: " . $e->getMessage());
        return false; // Hoặc null nếu muốn
    }
}


public function addProduct($name, $description, $price, $category_id, $image, $cpu, $ram, $ssd, $card)
{
    $errors = [];

    if (empty($name)) $errors['name'] = 'Tên sản phẩm không được để trống';
    if (empty($description)) $errors['description'] = 'Mô tả không được để trống';
    if (!is_numeric($price) || $price < 0) $errors['price'] = 'Giá sản phẩm không hợp lệ';

    if (count($errors) > 0) return $errors;

    $query = "INSERT INTO " . $this->table_name . " 
              (name, description, price, category_id, image, cpu, ram, ssd, card)
              VALUES (:name, :description, :price, :category_id, :image, :cpu, :ram, :ssd, :card)";
    $stmt = $this->conn->prepare($query);

    // Làm sạch dữ liệu
    $name = htmlspecialchars(strip_tags($name));
    $description = htmlspecialchars(strip_tags($description));
    $price = htmlspecialchars(strip_tags($price));
    $category_id = htmlspecialchars(strip_tags($category_id));
    $image = htmlspecialchars(strip_tags($image));
    $cpu = htmlspecialchars(strip_tags($cpu));
    $ram = htmlspecialchars(strip_tags($ram));
    $ssd = htmlspecialchars(strip_tags($ssd));
    $card = htmlspecialchars(strip_tags($card));

    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':price', $price);
    $stmt->bindParam(':category_id', $category_id);
    $stmt->bindParam(':image', $image);
    $stmt->bindParam(':cpu', $cpu);
    $stmt->bindParam(':ram', $ram);
    $stmt->bindParam(':ssd', $ssd);
    $stmt->bindParam(':card', $card);

    return $stmt->execute();
}


public function updateProduct($id, $name, $description, $price, $category_id, $image, $cpu, $ram, $ssd, $card)
{
    $query = "UPDATE " . $this->table_name . " 
              SET name = :name, description = :description, price = :price, 
                  category_id = :category_id, image = :image,
                  cpu = :cpu, ram = :ram, ssd = :ssd, card = :card
              WHERE id = :id";

    $stmt = $this->conn->prepare($query);

    // Làm sạch dữ liệu
    $name = htmlspecialchars(strip_tags($name));
    $description = htmlspecialchars(strip_tags($description));
    $price = htmlspecialchars(strip_tags($price));
    $category_id = htmlspecialchars(strip_tags($category_id));
    $image = htmlspecialchars(strip_tags($image));
    $cpu = htmlspecialchars(strip_tags($cpu));
    $ram = htmlspecialchars(strip_tags($ram));
    $ssd = htmlspecialchars(strip_tags($ssd));
    $card = htmlspecialchars(strip_tags($card));

    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':price', $price);
    $stmt->bindParam(':category_id', $category_id);
    $stmt->bindParam(':image', $image);
    $stmt->bindParam(':cpu', $cpu);
    $stmt->bindParam(':ram', $ram);
    $stmt->bindParam(':ssd', $ssd);
    $stmt->bindParam(':card', $card);

    return $stmt->execute();
}


    public function deleteProduct($id)
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function getRelatedProducts($productId, $categoryId)
    {
        $sql = "SELECT * FROM product WHERE category_id = :category_id AND id != :id LIMIT 4";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ':category_id' => $categoryId,
            ':id' => $productId
        ]);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function searchByName($keyword)
{
    $sql = "SELECT * FROM product WHERE name LIKE :kw";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute(['kw' => "%$keyword%"]);
    return $stmt->fetchAll(PDO::FETCH_OBJ);
}

public function searchByKeyword($keyword)
{
    $db = new PDO('mysql:host=localhost;dbname=laptop_store;charset=utf8', 'root', '');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Tìm trong cả tên & mô tả, không phân biệt hoa thường
    $stmt = $db->prepare("SELECT * FROM product WHERE LOWER(name) LIKE LOWER(?) OR LOWER(description) LIKE LOWER(?)");
    $stmt->execute(["%$keyword%", "%$keyword%"]);

    return $stmt->fetchAll(PDO::FETCH_OBJ);
}

public function searchProducts($keyword)
{
    $sql = "SELECT p.*, c.name AS category_name
            FROM product p
            LEFT JOIN category c ON p.category_id = c.id
            WHERE p.name LIKE :keyword";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute(['keyword' => "%$keyword%"]);
    return $stmt->fetchAll(PDO::FETCH_OBJ);}


}


?>

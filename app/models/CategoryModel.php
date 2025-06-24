<?php
class CategoryModel
{
    private $conn;
    private $table_name = "category";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getCategories()
    {
        $query = "SELECT id, name, description FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $result;
    }

    /**
     * Creates a new category in the database.
     * Tạo một danh mục mới trong cơ sở dữ liệu.
     *
     * @param string $name The name of the category. Tên của danh mục.
     * @param string $description The description of the category. Mô tả của danh mục.
     * @return bool True on success, false on failure. Trả về true nếu thành công, false nếu thất bại.
     */
    public function createCategory($name, $description)
    {
        // SQL query to insert a new record into the category table
        // Truy vấn SQL để chèn một bản ghi mới vào bảng danh mục
        $query = "INSERT INTO " . $this->table_name . " (name, description) VALUES (:name, :description)";

        // Prepare the statement
        // Chuẩn bị câu lệnh
        $stmt = $this->conn->prepare($query);

        // Sanitize data to prevent SQL injection
        // Làm sạch dữ liệu để ngăn chặn SQL injection
        $name = htmlspecialchars(strip_tags($name));
        $description = htmlspecialchars(strip_tags($description));

        // Bind the values
        // Gắn các giá trị
        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":description", $description);

        // Execute the query
        // Thực thi truy vấn
        if ($stmt->execute()) {
            return true;
        }

        // Print error if something goes wrong (for debugging)
        // In lỗi nếu có vấn đề xảy ra (để gỡ lỗi)
        printf("Error: %s.\n", $stmt->errorInfo()[2]); // Use errorInfo() for PDO errors
        return false;
    }

    /**
     * Deletes a category from the database.
     * Xóa một danh mục khỏi cơ sở dữ liệu.
     *
     * @param int $id The ID of the category to delete. ID của danh mục cần xóa.
     * @return bool True on success, false on failure. Trả về true nếu thành công, false nếu thất bại.
     */
    public function deleteCategory($id)
    {
        // SQL query to delete a record from the category table
        // Truy vấn SQL để xóa một bản ghi khỏi bảng danh mục
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";

        // Prepare the statement
        // Chuẩn bị câu lệnh
        $stmt = $this->conn->prepare($query);

        // Sanitize the ID
        // Làm sạch ID
        $id = htmlspecialchars(strip_tags($id));

        // Bind the ID
        // Gắn ID
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);

        // Execute the query
        // Thực thi truy vấn
        if ($stmt->execute()) {
            return true;
        }

        // Print error if something goes wrong (for debugging)
        // In lỗi nếu có vấn đề xảy ra (để gỡ lỗi)
        printf("Error: %s.\n", $stmt->errorInfo()[2]);
        return false;
    }

    /**
     * Retrieves a single category by its ID.
     * Lấy thông tin một danh mục dựa trên ID.
     *
     * @param int $id The ID of the category to retrieve. ID của danh mục cần lấy.
     * @return object|null The category object if found, null otherwise. Đối tượng danh mục nếu tìm thấy, ngược lại là null.
     */
    public function getCategoryById($id)
    {
        $query = "SELECT id, name, description FROM " . $this->table_name . " WHERE id = :id LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_OBJ);
        return $row;
    }

    /**
     * Updates an existing category in the database.
     * Cập nhật một danh mục hiện có trong cơ sở dữ liệu.
     *
     * @param int $id The ID of the category to update. ID của danh mục cần cập nhật.
     * @param string $name The new name of the category. Tên mới của danh mục.
     * @param string $description The new description of the category. Mô tả mới của danh mục.
     * @return bool True on success, false on failure. Trả về true nếu thành công, false nếu thất bại.
     */
    public function updateCategory($id, $name, $description)
    {
        // SQL query to update a record in the category table
        // Truy vấn SQL để cập nhật một bản ghi trong bảng danh mục
        $query = "UPDATE " . $this->table_name . " SET name = :name, description = :description WHERE id = :id";

        // Prepare the statement
        // Chuẩn bị câu lệnh
        $stmt = $this->conn->prepare($query);

        // Sanitize data
        // Làm sạch dữ liệu
        $id = htmlspecialchars(strip_tags($id));
        $name = htmlspecialchars(strip_tags($name));
        $description = htmlspecialchars(strip_tags($description));

        // Bind the values
        // Gắn các giá trị
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":description", $description);

        // Execute the query
        // Thực thi truy vấn
        if ($stmt->execute()) {
            return true;
        }

        // Print error if something goes wrong (for debugging)
        // In lỗi nếu có vấn đề xảy ra (để gỡ lỗi)
        printf("Error: %s.\n", $stmt->errorInfo()[2]);
        return false;
    }
}

<?php
class AccountModel
{
    private $conn;
    private $table_name = "account";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getAccountByUsername($username)
    {
        $query = "SELECT * FROM account WHERE username = :username";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        return $result;
    }

    // Phương thức lưu tài khoản mới
    public function save($username, $fullname, $password, $email, $phone, $address, $avatar, $role = "user")
    {
        $query = "INSERT INTO {$this->table_name}
                  (username, fullname, password, email, phone, address, avatar, role)
                  VALUES (:username, :fullname, :password, :email, :phone, :address, :avatar, :role)";

        $stmt = $this->conn->prepare($query);

        // Làm sạch dữ liệu đầu vào (áp dụng cho các trường chuỗi)
        $username = htmlspecialchars(strip_tags($username));
        $fullname = htmlspecialchars(strip_tags($fullname));
        $email = htmlspecialchars(strip_tags($email));
        $phone = htmlspecialchars(strip_tags($phone));
        $address = htmlspecialchars(strip_tags($address));
        $avatar = htmlspecialchars(strip_tags($avatar)); // Đường dẫn avatar cũng cần được làm sạch

        // Gán giá trị
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':fullname', $fullname);
        $stmt->bindParam(':password', $password); // Password đã được hash ở controller
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':avatar', $avatar);
        $stmt->bindParam(':role', $role);

        return $stmt->execute();
    }

    // Phương thức lấy tài khoản theo ID
    public function getAccountById($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM account WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    // Phương thức cập nhật thông tin tài khoản
    public function updateAccount($data)
    {
        $query = "UPDATE {$this->table_name} SET
                    fullname = :fullname,
                    email = :email,
                    phone = :phone,
                    address = :address";

        // Chỉ thêm password vào query nếu có password mới được cung cấp trong $data
        if (isset($data['password']) && !empty($data['password'])) {
            $query .= ", password = :password";
        }
        // Chỉ thêm avatar vào query nếu có avatar mới được cung cấp trong $data
        if (isset($data['avatar']) && !empty($data['avatar'])) {
            $query .= ", avatar = :avatar";
        }

        $query .= " WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        // Làm sạch và bind các tham số
        $stmt->bindParam(':fullname', htmlspecialchars(strip_tags($data['fullname'])));
        $stmt->bindParam(':email', htmlspecialchars(strip_tags($data['email'])));
        $stmt->bindParam(':phone', htmlspecialchars(strip_tags($data['phone'])));
        $stmt->bindParam(':address', htmlspecialchars(strip_tags($data['address'])));

        // Bind password nếu có
        if (isset($data['password']) && !empty($data['password'])) {
            $stmt->bindParam(':password', $data['password']); // Password đã được hash ở controller
        }
        // Bind avatar nếu có
        if (isset($data['avatar']) && !empty($data['avatar'])) {
            $stmt->bindParam(':avatar', htmlspecialchars(strip_tags($data['avatar'])));
        }

        $stmt->bindParam(':id', $data['id'], PDO::PARAM_INT);

        return $stmt->execute();
    }

    // Các phương thức khác của AccountModel (được giữ nguyên)
    public function hasAdmin()
    {
        $query = "SELECT COUNT(*) AS total FROM account WHERE role = 'admin'";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'] > 0;
    }

    public function getAccountStatistics()
    {
        $query = "SELECT role, COUNT(*) as total FROM account GROUP BY role";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function getAllAccounts()
    {
        $query = "SELECT id, username, role FROM account ORDER BY id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function getFilteredAccounts($search = '', $role = '')
    {
        $query = "SELECT id, username, role FROM account WHERE 1=1";
        $params = [];

        if (!empty($search)) {
            $query .= " AND username LIKE :search";
            $params[':search'] = "%$search%";
        }

        if (!empty($role)) {
            $query .= " AND role = :role";
            $params[':role'] = $role;
        }

        $stmt = $this->conn->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function countByRole($role)
    {
        $stmt = $this->conn->prepare("SELECT COUNT(*) FROM account WHERE role = :role");
        $stmt->execute([':role' => $role]);
        return $stmt->fetchColumn();
    }
    
    public function deleteById($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM account WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }

    public function getPurchaseHistory($accountId, $search_date = null) // Thêm tham số $search_date
    {
        $query = "
            SELECT
                a.username,
                a.phone AS account_phone,
                o.order_date,
                o.address AS shipping_address,
                p.name AS product_name,
                od.quantity,
                od.price AS item_price,
                o.id AS order_id
            FROM
                account a
            JOIN
                orders o ON a.id = o.account_id
            JOIN
                order_details od ON o.id = od.order_id
            JOIN
                product p ON od.product_id = p.id
            WHERE
                a.id = :accountId
        ";

        $params = [':accountId' => $accountId];

        // Thêm điều kiện tìm kiếm theo ngày nếu $search_date được cung cấp
        if ($search_date !== null) {
            $query .= " AND DATE(o.order_date) = :search_date";
            $params[':search_date'] = $search_date;
        }

        $query .= " ORDER BY o.order_date DESC, o.id DESC";

        $stmt = $this->conn->prepare($query);

        foreach ($params as $key => &$val) {
            $stmt->bindParam($key, $val, is_int($val) ? PDO::PARAM_INT : PDO::PARAM_STR);
        }

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
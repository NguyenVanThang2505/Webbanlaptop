<?php include 'app/views/shares/header.php'; ?>

<style>
    /* Tổng thể Body và Font */
    body {
        background-color: #f0f2f5; /* Nền nhẹ nhàng hơn */
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; /* Font hiện đại, dễ đọc */
        margin: 0;
        padding: 0;
        color: #343a40; /* Màu chữ chính tối hơn chút */
        line-height: 1.6; /* Tăng khoảng cách dòng */
    }

    /* Container chính */
    .container.purchase-history-container {
        max-width: 950px; /* Tăng nhẹ chiều rộng tối đa */
        margin: 60px auto; /* Tăng margin trên dưới */
        background: #ffffff; /* Nền trắng tinh khôi */
        padding: 40px; /* Tăng padding */
        border-radius: 12px; /* Bo góc nhiều hơn */
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1); /* Bóng đổ mềm mại, rõ hơn */
        overflow: hidden; /* Đảm bảo nội dung không tràn ra ngoài bo góc */
    }

    /* Tiêu đề trang */
    h1.page-title {
        text-align: center;
        color: #212529; /* Màu tối hơn cho tiêu đề */
        margin-bottom: 40px; /* Tăng margin */
        font-size: 2.8em; /* To hơn */
        font-weight: 700; /* Rất đậm */
        padding-bottom: 15px;
        border-bottom: 3px solid #e9ecef; /* Viền dưới đậm hơn, màu nhẹ nhàng */
        text-transform: uppercase; /* Chữ hoa */
        letter-spacing: 1.5px; /* Tăng khoảng cách chữ */
    }

    /* Form tìm kiếm */
    .search-form-container {
        margin-bottom: 40px; /* Tăng khoảng cách dưới form */
        padding: 25px; /* Tăng padding */
        background-color: #e9f5ff; /* Nền xanh nhạt đẹp mắt */
        border: 1px solid #cce5ff; /* Viền xanh nhạt */
        border-radius: 10px; /* Bo góc */
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08); /* Bóng đổ nhẹ */
        display: flex;
        flex-wrap: wrap;
        gap: 20px; /* Tăng khoảng cách giữa các phần tử */
        align-items: flex-end;
    }

    .search-form-container .form-group {
        flex: 1;
        min-width: 220px; /* Tăng min-width */
        margin-bottom: 0;
    }

    .search-form-container label {
        font-weight: 600; /* Đậm hơn */
        color: #495057; /* Màu chữ rõ ràng */
        margin-bottom: 10px; /* Tăng khoảng cách dưới label */
        display: block;
        font-size: 0.95em;
    }

    .search-form-container .form-control[type="date"] {
        padding: 12px 15px; /* Tăng padding */
        border: 1px solid #a7d9ff; /* Viền xanh đậm hơn chút */
        border-radius: 6px; /* Bo góc */
        width: 100%;
        box-sizing: border-box;
        font-size: 1em;
        color: #343a40;
        transition: border-color 0.3s ease, box-shadow 0.3s ease;
    }

    .search-form-container .form-control[type="date"]:focus {
        border-color: #007bff; /* Viền xanh nổi bật khi focus */
        box-shadow: 0 0 0 0.25rem rgba(0, 123, 255, 0.25); /* Thêm shadow focus */
        outline: none; /* Bỏ outline mặc định */
    }

    .search-form-container .btn-primary-search {
        background-color: #007bff; /* Màu xanh chính */
        color: white;
        border: none;
        padding: 12px 28px; /* Tăng padding */
        border-radius: 6px; /* Bo góc */
        cursor: pointer;
        font-weight: 600; /* Đậm hơn */
        font-size: 1.05em;
        transition: background-color 0.3s ease, transform 0.2s ease, box-shadow 0.2s ease;
        height: 44px; /* Phù hợp với input */
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 3px 8px rgba(0, 123, 255, 0.2); /* Bóng đổ cho nút */
    }

    .search-form-container .btn-primary-search:hover {
        background-color: #0056b3; /* Xanh đậm hơn khi hover */
        transform: translateY(-2px); /* Nhấc nhẹ lên */
        box-shadow: 0 6px 12px rgba(0, 123, 255, 0.3); /* Bóng đổ rõ hơn */
    }

    /* Khối đơn hàng */
    .order-block {
        border: 1px solid #e0e0e0;
        border-radius: 10px; /* Bo góc nhất quán */
        margin-bottom: 35px; /* Tăng khoảng cách */
        padding: 25px; /* Tăng padding */
        background-color: #fefefe; /* Trắng nhẹ hơn */
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.07); /* Bóng đổ rõ nhưng mềm mại */
        transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
        display: flex;
        flex-direction: column; /* Đảm bảo các phần tử xếp dọc */
    }

    .order-block:hover {
        transform: translateY(-5px); /* Nhấc lên nhiều hơn */
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15); /* Bóng đổ mạnh hơn khi hover */
    }

    /* Header của đơn hàng */
    .order-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px; /* Tăng margin */
        padding-bottom: 20px; /* Tăng padding */
        border-bottom: 1px dashed #ced4da; /* Viền dash mềm mại */
    }

    .order-header h3 {
        margin: 0;
        color: #007bff; /* Giữ màu xanh nổi bật */
        font-size: 2em; /* To hơn */
        font-weight: 700;
        letter-spacing: 0.5px;
    }

    .order-header p.order-date {
        margin: 0;
        font-size: 1.1em; /* To hơn */
        color: #6c757d; /* Màu xám đậm hơn */
        font-weight: 500;
    }

    /* Thông tin đơn hàng */
    .order-info p {
        margin-bottom: 10px; /* Tăng khoảng cách */
        font-size: 1.05em; /* To hơn */
        color: #495057; /* Màu chữ rõ ràng */
    }
    .order-info strong {
        color: #212529; /* Màu đậm hơn cho strong */
        font-weight: 600;
    }

    /* Chi tiết sản phẩm trong đơn hàng (Bảng) */
    .order-details table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px; /* Tăng margin */
        background-color: #ffffff; /* Nền bảng trắng */
    }

    .order-details th, .order-details td {
        border: 1px solid #dee2e6; /* Viền bảng nhẹ nhàng */
        padding: 15px; /* Tăng padding */
        text-align: left;
        font-size: 0.98em; /* Kích thước font hợp lý */
        vertical-align: middle; /* Căn giữa theo chiều dọc */
    }

    .order-details th {
        background-color: #f8f9fa; /* Nền header bảng nhẹ */
        color: #495057; /* Màu chữ header */
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }

    /* Hàng tổng cộng */
    .order-details .total-row {
        background-color: #e2edff; /* Nền xanh nhạt cho hàng tổng */
        font-weight: bold;
        color: #0056b3; /* Màu xanh đậm cho chữ tổng */
    }
    .order-details .total-row td {
        border-top: 2px solid #a7d9ff; /* Viền trên đậm và xanh hơn */
        font-size: 1.1em; /* To hơn */
    }
    .order-details .total-row td:last-child {
        color: #dc3545; /* Màu đỏ nổi bật cho tổng tiền */
        font-size: 1.2em; /* To hơn nữa */
        font-weight: 700;
    }

    /* Không có lịch sử mua sắm */
    .no-history {
        text-align: center;
        color: #6c757d;
        padding: 70px; /* Tăng padding */
        font-size: 1.2em; /* To hơn */
        border: 2px dashed #ced4da; /* Viền dash đậm hơn */
        border-radius: 10px;
        background-color: #fdfdfd;
        margin-top: 40px;
        box-shadow: 0 3px 10px rgba(0,0,0,0.05);
    }

    /* Nút quay lại */
    .back-link-container {
        text-align: center;
        margin-top: 50px; /* Tăng khoảng cách trên */
    }

    .back-link-btn {
        display: inline-block;
        padding: 14px 30px; /* Tăng padding */
        background-color: #28a745; /* Màu xanh lá cây đẹp mắt */
        color: white;
        text-decoration: none;
        border-radius: 8px; /* Bo góc nhiều hơn */
        font-weight: 600; /* Đậm hơn */
        font-size: 1.15em; /* To hơn */
        transition: background-color 0.3s ease, transform 0.2s ease, box-shadow 0.2s ease;
        box-shadow: 0 4px 12px rgba(40, 167, 69, 0.2); /* Bóng đổ cho nút */
    }

    .back-link-btn:hover {
        background-color: #218838; /* Xanh lá đậm hơn khi hover */
        transform: translateY(-3px); /* Nhấc lên nhiều hơn */
        box-shadow: 0 7px 18px rgba(40, 167, 69, 0.3); /* Bóng đổ rõ hơn */
    }

    /* Điều chỉnh Responsive */
    @media (max-width: 768px) {
        .container.purchase-history-container {
            padding: 25px;
            margin-top: 40px;
            margin-bottom: 40px;
        }
        h1.page-title {
            font-size: 2.2em;
            margin-bottom: 30px;
        }
        .order-header {
            flex-direction: column;
            align-items: flex-start;
            margin-bottom: 15px;
            padding-bottom: 10px;
        }
        .order-header h3 {
            margin-bottom: 8px;
            font-size: 1.6em;
        }
        .order-header p.order-date {
            font-size: 0.95em;
        }
        .order-details th, .order-details td {
            padding: 10px;
            font-size: 0.88em;
        }
        .order-info p {
            font-size: 0.98em;
        }
        .back-link-btn {
            padding: 12px 25px;
            font-size: 1.05em;
        }
        .search-form-container {
            flex-direction: column;
            align-items: stretch;
            gap: 15px;
            padding: 18px;
        }
        .search-form-container .form-group {
            width: 100%;
        }
        .search-form-container .btn-primary-search {
            width: 100%; /* Nút tìm kiếm full width trên mobile */
            height: auto; /* Chiều cao tự động */
            padding: 12px 20px;
        }
    }

    @media (max-width: 480px) {
        h1.page-title {
            font-size: 1.8em;
            margin-bottom: 25px;
        }
        .container.purchase-history-container {
            padding: 15px;
        }
        .order-block {
            padding: 15px;
        }
        .order-header h3 {
            font-size: 1.4em;
        }
        .order-details th, .order-details td {
            font-size: 0.8em;
            padding: 8px;
        }
    }
</style>
<body>
    <div class="container purchase-history-container">
        <h1 class="page-title">Lịch sử mua sắm của bạn</h1>

        <div class="search-form-container">
            <form method="get" action="/webbanhang/account/showPurchaseHistory" class="d-flex align-items-end w-100 flex-wrap">
                <div class="form-group me-3 flex-grow-1">
                    <label for="search_date">Tìm kiếm theo ngày:</label>
                    <input type="date" id="search_date" name="search_date" class="form-control"
                           value="<?php echo htmlspecialchars($_GET['search_date'] ?? ''); ?>">
                </div>
                <button type="submit" class="btn btn-primary-search">Tìm kiếm</button>
            </form>
        </div>
        <?php if (empty($purchaseHistory)): ?>
            <p class="no-history">Bạn chưa có đơn hàng nào.</p>
        <?php else: ?>
            <?php
            $groupedOrders = [];
            foreach ($purchaseHistory as $item) {
                // Nhóm các mặt hàng theo order_id
                $groupedOrders[$item['order_id']][] = $item;
            }

            // Sắp xếp các đơn hàng theo ID giảm dần (thường ID tăng theo thời gian)
            krsort($groupedOrders);
            ?>

            <?php foreach ($groupedOrders as $orderId => $items):
                $firstItem = $items[0]; // Lấy thông tin chung của đơn hàng từ item đầu tiên
                $orderTotal = 0;
            ?>
                <div class="order-block">
                    <div class="order-header">
                        <h3>Đơn hàng #<?php echo htmlspecialchars($orderId); ?></h3>
                        <p class="order-date">Ngày đặt: <?php echo htmlspecialchars(date('d/m/Y H:i', strtotime($firstItem['order_date']))); ?></p>
                    </div>
                    <div class="order-info">
                        <p><strong>Tên tài khoản:</strong> <?php echo htmlspecialchars($firstItem['username']); ?></p>
                        <p><strong>SĐT liên hệ:</strong> <?php echo htmlspecialchars($firstItem['account_phone']); ?></p>
                        <p><strong>Địa chỉ nhận hàng:</strong> <?php echo htmlspecialchars($firstItem['shipping_address']); ?></p>
                    </div>

                    <div class="order-details">
                        <table>
                            <thead>
                                <tr>
                                    <th>Tên sản phẩm</th>
                                    <th>Số lượng</th>
                                    <th>Giá/sản phẩm</th>
                                    <th>Tổng mặt hàng</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($items as $item):
                                    $itemTotalPrice = $item['quantity'] * $item['item_price'];
                                    $orderTotal += $itemTotalPrice;
                                ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($item['product_name']); ?></td>
                                        <td><?php echo htmlspecialchars($item['quantity']); ?></td>
                                        <td><?php echo number_format($item['item_price'], 0, ',', '.'); ?> VNĐ</td>
                                        <td><?php echo number_format($itemTotalPrice, 0, ',', '.'); ?> VNĐ</td>
                                    </tr>
                                <?php endforeach; ?>
                                <tr class="total-row">
                                    <td colspan="3" style="text-align: right;"><strong>Tổng cộng đơn hàng:</strong></td>
                                    <td><strong><?php echo number_format($orderTotal, 0, ',', '.'); ?> VNĐ</strong></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

        <div class="back-link-container">
            <a href="/webbanhang/product/" class="back-link-btn">Quay lại trang chính</a>
        </div>
    </div>
</body>
</html>

<?php include 'app/views/shares/footer.php'; ?>
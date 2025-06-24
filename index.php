<?php
session_start();

// ✅ Autoload models/controllers/helpers
spl_autoload_register(function ($className) {
    $paths = ['app/controllers/', 'app/models/', 'app/helpers/'];

    foreach ($paths as $path) {
        $file = $path . $className . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

// 1. Lấy URL và tách thành phần
$url = $_GET['url'] ?? '';
$url = rtrim($url, '/');
$url = filter_var($url, FILTER_SANITIZE_URL);
$urlParts = explode('/', $url);

// 2. Xác định tên controller và action
$controllerName = isset($urlParts[0]) && $urlParts[0] !== ''
    ? ucfirst($urlParts[0]) . 'Controller'
    : 'DefaultController';

$action = isset($urlParts[1]) && $urlParts[1] !== ''
    ? $urlParts[1]
    : 'index';

$controllerPath = 'app/controllers/' . $controllerName . '.php';

// 3. Kiểm tra file controller
if (!file_exists($controllerPath)) {
    http_response_code(404);
    echo "<h2 style='color: red;'>❌ Controller <b>$controllerName</b> không tồn tại.</h2>";
    exit;
}

// 4. Gọi file controller
require_once $controllerPath;

// 5. Kiểm tra class có tồn tại
if (!class_exists($controllerName)) {
    http_response_code(500);
    echo "<h2 style='color: red;'>❌ Lớp <b>$controllerName</b> không được định nghĩa trong file.</h2>";
    exit;
}

$controller = new $controllerName();

// 6. Kiểm tra action (method)
if (!method_exists($controller, $action)) {
    http_response_code(404);
    echo "<h2 style='color: red;'>❌ Phương thức <b>$action()</b> không tồn tại trong <b>$controllerName</b>.</h2>";
    exit;
}

// 7. Gọi action và truyền tham số
$params = array_slice($urlParts, 2);
call_user_func_array([$controller, $action], $params);



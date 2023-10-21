<?php
session_start();
require_once 'models/UserModel.php';
$userModel = new UserModel();




// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['id'])) {
    header('location: login.php'); // Chuyển hướng đến trang đăng nhập
    exit;
}

// Kiểm tra xem có tham số id và csrf_token được truyền qua không
if (!empty($_GET['id']) && !empty($_SESSION['csrf_token_delete'])) {
    $id = $_GET['id'];
    $csrfToken = $_SESSION['csrf_token_delete'];

    // Kiểm tra xem id từ URL khớp với id trong session và CSRF token khớp với token trong session không
    if ($id === $_SESSION['id'] && $csrfToken === $_SESSION['csrf_token_delete']) {
        // Tiến hành xóa người dùng
        $userModel->deleteUserById($id);

        // Chuyển hướng về trang danh sách người dùng hoặc trang chính của người dùng (tùy vào yêu cầu của bạn)
        header('location: list_users.php');
        exit;
    } else {
        // Id hoặc token không khớp với id hoặc token trong session, từ chối yêu cầu
        echo "Invalid ID or CSRF Token!";
        exit;
    }
} else {
    // Yêu cầu không hợp lệ
    echo "Invalid Request!";
    exit;
}

?>

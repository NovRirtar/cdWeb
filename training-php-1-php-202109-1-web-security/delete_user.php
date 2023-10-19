<?php
session_start();
require_once 'models/UserModel.php';
$userModel = new UserModel();

$user = NULL; // Thêm người dùng mới
$id = NULL;

// Kiểm tra xem có tham số id được truyền qua không
if (!empty($_GET['id']) && isset($_GET['csrf_token'])) {
    // Lấy giá trị id và CSRF token từ tham số
    $id = $_GET['id'];
    $csrfToken = $_GET['csrf_token'];

    // Kiểm tra xem token từ liên kết có khớp với token trong session không
    if ($csrfToken === $_SESSION['csrf_token']) {
        // Token hợp lệ, tiến hành xóa người dùng
        $userModel->deleteUserById($id);

        // Chuyển hướng về trang danh sách người dùng
        header('location: list_users.php');
        exit;
    } else {
        // Token không hợp lệ, từ chối yêu cầu
        echo "Invalid CSRF Token!";
        exit;
    }
} else {
    // Yêu cầu không hợp lệ
    echo "Invalid Request!";
    exit;
}
?>

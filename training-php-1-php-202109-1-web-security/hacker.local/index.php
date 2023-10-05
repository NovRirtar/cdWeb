<?php

// Kết nối với cơ sở dữ liệu MySQL
$conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);

// Nếu kết nối thất bại, hãy thoát
if ($conn->connect_error) {
    die("Không thể kết nối với cơ sở dữ liệu: " . $conn->connect_error);
}

// Lấy thông tin session của người dùng
$session_id = $_SESSION["session_id"];

// Tìm thông tin session trong bảng
$sql = "SELECT * FROM `" . SESSION_TABLE . "` WHERE `session_id` = '" . $session_id . "'";
$result = $conn->query($sql);

// Nếu không tìm thấy thông tin session, hãy chuyển hướng người dùng đến trang đăng nhập
if ($result->num_rows == 0) {
    header('location: login.php');
}

// Đóng kết nối
$conn->close();


?>

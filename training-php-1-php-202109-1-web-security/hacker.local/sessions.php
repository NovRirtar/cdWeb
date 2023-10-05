<?php

// Kết nối với cơ sở dữ liệu MySQL
$conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);

// Nếu kết nối thất bại, hãy thoát
if ($conn->connect_error) {
    die("Không thể kết nối với cơ sở dữ liệu: " . $conn->connect_error);
}

// Lấy thông tin session của người dùng
$session_id = $_GET["session_id"];

// Tìm thông tin session trong bảng
$sql = "SELECT * FROM `" . SESSION_TABLE . "` WHERE `session_id` = '" . $session_id . "'";
$result = $conn->query($sql);

// Nếu tìm thấy thông tin session, hãy in ra thông báo
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo "Thông tin session:<br>";
    echo "Session ID: " . $row["session_id"] . "<br>";
    echo "User ID: " . $row["user_id"] . "<br>";
}

// Đóng kết nối
$conn->close();

?>

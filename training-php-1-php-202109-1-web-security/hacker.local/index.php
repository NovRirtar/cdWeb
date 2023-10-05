
<!DOCTYPE html>
<html>
<head>
    <title>User form</title>
    <?php include 'views/meta.php' ?>
</head>
<body>
<?php include 'views/header.php'?>

    <div class="container">
        <div id="loginbox" style="margin-top:50px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
            <div class="panel panel-info" >
                <div class="panel-heading">
                    <div class="panel-title">Login</div>
                    <div style="float:right; font-size: 80%; position: relative; top:-10px"><a href="#">Forgot password?</a></div>
                </div>

                <div style="padding-top:30px" class="panel-body" >
                    <form method="post" class="form-horizontal" role="form">

                        <div class="margin-bottom-25 input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                            <input id="login-username" type="text" class="form-control" name="username" value="" placeholder="username or email">
                        </div>

                        <div class="margin-bottom-25 input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                            <input id="login-password" type="password" class="form-control" name="password" placeholder="password">
                        </div>

                        <div class="margin-bottom-25">
                            <input type="checkbox" tabindex="3" class="" name="remember" id="remember">
                            <label for="remember"> Remember Me</label>
                        </div>

                        <div class="margin-bottom-25 input-group">
                            <!-- Button -->
                            <div class="col-sm-12 controls">
                                <button type="submit" name="submit" value="submit" class="btn btn-primary">Submit</button>
                                <a id="btn-fblogin" href="#" class="btn btn-primary">Login with Facebook</a>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-12 control">
                                    Don't have an account!
                                    <a href="form_user.php">
                                        Sign Up Here
                                    </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</body>
</html>

<?php
// Kết nối với cơ sở dữ liệu MySQL
$conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);

// Nếu kết nối thất bại, hãy thoát
if ($conn->connect_error) {
    die("Không thể kết nối với cơ sở dữ liệu: " . $conn->connect_error);
}

// Lấy thông tin session của người dùng
$session_id = $_SESSION["session_id"];

// Thêm thông tin session vào bảng
$sql = "INSERT INTO `" . SESSION_TABLE . "` (`session_id`, `user_id`) VALUES ('" . $session_id . "', $_SESSION['id'])";
$result = $conn->query($sql);

// Đóng kết nối
$conn->close();

?>
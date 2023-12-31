<?php
session_start();

require_once 'models/UserModel.php';
$userModel = new UserModel();
$users = [];
$keyword = '';


if (!empty($_GET['keyword'])) {
    // Lấy giá trị từ trường tìm kiếm và tránh SQL Injection
    $keyword = $_GET['keyword'];
    $users = $userModel->findUser($keyword);
} else {
    // Nếu không có keyword, không cần truyền tham số vào hàm getUsers()
    $users = $userModel->getUsers();
}

?>
<!DOCTYPE html>
<html>

<head>
    <title>Home</title>
    <?php include 'views/meta.php' ?>
</head>

<body>
    <?php include 'views/header.php' ?>
    <div class="container">
        <?php if (!empty($users)) { ?>
            <div class="alert alert-warning" role="alert">
                List of users! <br>
                Hacker: http://php.local/list_users.php?keyword=ASDF%25%22%3BTRUNCATE+banks%3B%23%23
            </div>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Username</th>
                        <th scope="col">Fullname</th>
                        <th scope="col">Type</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user) { ?>
                        <tr>
                            <th scope="row"><?php echo $user['id'] ?></th>
                            <td>
                                <?php echo $user['name'] ?>
                            </td>
                            <td>
                                <?php echo $user['fullname'] ?>
                            </td>
                            <td>
                                <?php echo $user['type'] ?>
                            </td>
                            <?php
                            if ($user['type'] === 'admin' && $user['id'] == '1' && $user['id'] === $id) {
                                foreach ($users as $user) { ?>
                                    <td>
                                        <a href="form_user.php?id=<?php echo $user['id'] ?>">
                                            <i class="fa fa-pencil-square-o" aria-hidden="true" title="Update"></i>
                                        </a>
                                        <a href="view_user.php?id=<?php echo $user['id'] ?>">
                                            <i class="fa fa-eye" aria-hidden="true" title="View"></i>
                                        </a>
                                        <a href="delete_user.php?id=<?php echo $user['id'] ?>">
                                            <i class="fa fa-eraser" aria-hidden="true" title="Delete"></i>
                                        </a>
                                    </td>
                                <?php }
                            }  elseif ($user['type'] === 'user' && $user['id'] === $id  ) { ?>
                                <td>
                                    <a href="form_user.php?id=<?php echo $user['id'] ?>">
                                        <i class="fa fa-pencil-square-o" aria-hidden="true" title="Update"></i>
                                    </a>
                                    <a href="view_user.php?id=<?php echo $user['id'] ?>">
                                        <i class="fa fa-eye" aria-hidden="true" title="View"></i>
                                    </a>
                                    <a href="delete_user.php?id=<?php echo $user['id'] ?>">
                                        <i class="fa fa-eraser" aria-hidden="true" title="Delete"></i>
                                    </a>
                                </td>
                            <?php } ?>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } else { ?>
            <div class="alert alert-dark" role="alert">
                This is a dark alert—check it out!
                No users found.
            </div>
        <?php } ?>
    </div>
</body>

</html>
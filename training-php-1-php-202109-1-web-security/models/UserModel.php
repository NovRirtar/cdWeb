<?php

require_once 'BaseModel.php';
function isValidUsername($username) {
    // Kiểm tra xem chuỗi có chứa ký tự đặc biệt không
    if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $username)) {
        return false; // Nếu có, trả về false
    }
    return true; // Nếu không, trả về true
}


class UserModel extends BaseModel {

    public function findUserById($id) {
        $sql = 'SELECT * FROM users WHERE id = '.$id;
        $user = $this->select($sql);
        // var_dump($user);
        return $user;
    }

   public function findUser($keyword) {
    // Tránh lỗ hổng SQL injection bằng cách sử dụng mysqli_real_escape_string()
    $escapedKeyword = mysqli_real_escape_string(self::$_connection, $keyword);
    
    // Sử dụng dấu nháy đơn xung quanh chuỗi trong câu lệnh SQL
    $sql = "SELECT * FROM users WHERE name LIKE '%$escapedKeyword%' OR email LIKE '%$escapedKeyword%'";
    
    // Gọi hàm select với câu lệnh SQL đã chuẩn bị
    $users = $this->select($sql);

    return $users;
}


    /**
     * Authentication user
     * @param $userName
     * @param $password
     * @return array
     */
    public function auth($userName, $password) {
        $md5Password = md5($password);
        $sql = 'SELECT * FROM users WHERE name = "' . $userName . '" AND password = "'.$md5Password.'"';

        $user = $this->select($sql);
        return $user;
    }

    /**
     * Delete user by id
     * @param $id
     * @return mixed
     */
    public function deleteUserById($id) {
        $sql = 'DELETE FROM users WHERE id = '.$id;
        return $this->delete($sql);

    }

    /**
     * Update user
     * @param $input
     * @return mixed
     */
    
    
    public function updateUser($input) {
        $rowVersion = $input['row_version'];
        $name = mysqli_real_escape_string(self::$_connection, $input['name']);
        $password = md5($input['password']);
        
        // Kiểm tra xem tên người dùng hợp lệ hay không
        if (!isValidUsername($name)) {
            // Nếu tên người dùng không hợp lệ, xử lý hoặc hiển thị thông báo lỗi tùy ý
            echo "Tên người dùng không hợp lệ. Vui lòng không sử dụng các ký tự đặc biệt.";
            // Hoặc xử lý lỗi khác tùy theo yêu cầu của bạn
            // ...
        } else {
            // Nếu tên người dùng hợp lệ, tiếp tục thực hiện câu lệnh SQL
            $sql = 'UPDATE users SET name="' . $name .'", password="' . $password .'", row_version=row_version+1
                    WHERE id=' . $input['id'] . ' AND row_version=' . $rowVersion;
            
            $user = $this->update($sql);
            return $user;
        }
    }
    
    // public function updateUser($input) {
    //     $rowVersion = $input['row_version'];
    //     $sql = 'UPDATE users SET 
    //              name = "' . mysqli_real_escape_string(self::$_connection, $input['name']) .'", 
    //              password="'. md5($input['password']) .'" ,row_version = row_version + 1
    //              WHERE id = ' . $input['id'].' AND row_version = '.$rowVersion ;

    //     $user = $this->update($sql);
        
    //     return $user;
        
    // }

    /**
     * Insert user
     * @param $input
     * @return mixed
     */
    public function insertUser($input) {
        $sql = "INSERT INTO `app_web1`.`users` (`name`, `password`) VALUES (" .
                "'" . $input['name'] . "', '".md5($input['password'])."')";

        $user = $this->insert($sql);

        return $user;
    }

    /**
     * Search users
     * @param array $params
     * @return array
     */
    public function getUsers($params = []) {
        //Keyword
        if (!empty($params['keyword'])) {
            $sql = 'SELECT * FROM users WHERE name LIKE "%' . $params['keyword'] .'%"';

            //Keep this line to use Sql Injection
            //Don't change
            //Example keyword: abcef%";TRUNCATE banks;##
            $users = self::$_connection->multi_query($sql);
        } else {
            $sql = 'SELECT * FROM users';
            $users = $this->select($sql);
        }

        return $users;
    }
}
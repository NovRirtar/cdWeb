<?php
require_once 'configs/database.php';

abstract class BaseModel {
    // Database connection
    protected static $_connection; // Đặt thuộc tính tĩnh để có thể truy cập vào nó từ các phương thức tĩnh

    // Hàm khởi tạo để thiết lập giá trị cho $_connection
    public function __construct() {
        // Khởi tạo và thiết lập kết nối database ở đây
        self::$_connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        // Kiểm tra kết nối
        if (self::$_connection->connect_error) {
            die("Connection failed: " . self::$_connection->connect_error);
        }
    }

    public function __destruct() {
        self::$_connection->close();
    }
    /**
     * Query in database
     * @param $sql
     */
    protected function query($sql) {

        $result = self::$_connection->query($sql);
        return $result;
    }

    /**
     * Select statement
     * @param $sql
     */
    protected function select($sql) {
        $result = $this->query($sql);
        $rows = [];
        if (!empty($result)) {
            while ($row = $result->fetch_assoc()) {
                $rows[] = $row;
            }
        }
        return $rows;
    }

    /**
     * Delete statement
     * @param $sql
     * @return mixed
     */
    protected function delete($sql) {
        $result = $this->query($sql);
        return $result;
    }

    /**
     * Update statement
     * @param $sql
     * @return mixed
     */
    protected function update($sql) {
        $result = $this->query($sql);
        return $result;
    }

    /**
     * Insert statement
     * @param $sql
     */
    protected function insert($sql) {
        $result = $this->query($sql);
        return $result;
    }
    protected function prepare($sql) {
        $result = $this->_connection->prepare($sql);
        return $result;
    }
}

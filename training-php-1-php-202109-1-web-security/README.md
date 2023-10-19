# php-training
* Repository: https://github.com/tailieuweb/training-php

## System requirements
* Apache: 2.4
* MySQL: 5.7 ; MariaDB: 10.x
* PHP: 7.x, 8.x
* Wamp/Xampp

# Features
- CRUD user


ALTER TABLE your_table_name
ADD COLUMN row_version INT NOT NULL DEFAULT 0;

if (!empty($_GET['keyword'])) {
    $params['keyword'] = $_GET['keyword'];
}

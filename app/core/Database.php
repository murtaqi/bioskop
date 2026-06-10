<?php

    class Database {
        private $host = DB_HOST;
        private $user = DB_USER;
        private $pass = DB_PASS;
        private $db_name = DB_NAME;

        private $dbh;
        private $stmt;

        public function __construct(){
            $option = [ PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];

            try {
                // Connect to MySQL server first without selecting DB to ensure DB exists
                $dsn = 'mysql:host='.$this->host;
                $this->dbh = new PDO($dsn, $this->user, $this->pass, $option);
                $this->dbh->exec("CREATE DATABASE IF NOT EXISTS " . $this->db_name);
                $this->dbh->exec("USE " . $this->db_name);

                // Run tables schema if 'user' table is missing
                $query = $this->dbh->query("SHOW TABLES LIKE 'user'");
                if ($query->rowCount() == 0) {
                    $sql_path = dirname(dirname(__DIR__)) . '/public/database/bioskop_db.sql';
                    if (file_exists($sql_path)) {
                        $sql = file_get_contents($sql_path);
                        $this->dbh->exec($sql);
                    }
                }

                // Ensure default admin exists if table is empty
                $userCheck = $this->dbh->query("SELECT COUNT(*) FROM user");
                if ($userCheck->fetchColumn() == 0) {
                    $admin_hash = '$2y$10$HTM.7h9iIg89SQKToiTrZODwDI8YTpMcJt5K0Lq8SkBMjPRg.sZzO';
                    $this->dbh->exec("INSERT INTO user (id_user, nama, username, password, no_telp, role) VALUES ('USR000', 'Administrator', 'admin', '$admin_hash', '08123456789', 'admin')");
                }
            } catch (PDOException $e) {
                // If permission restricts creating databases, fallback to direct db connection
                try {
                    $dsnDb = 'mysql:host='.$this->host.';dbname='.$this->db_name;
                    $this->dbh = new PDO($dsnDb, $this->user, $this->pass, $option);
                } catch (PDOException $e2) {
                    echo "Database connection failed: " . $e2->getMessage();
                    die();
                }
            }
        }

        public function query($query){
            $this->stmt = $this->dbh->prepare($query);
        }

        public function bind($param, $value, $type = null){
            if(is_null($type)){
                switch(true){
                    case is_int($value):
                        $type = PDO::PARAM_INT;
                        break;
                    case is_bool($value):
                        $type = PDO::PARAM_BOOL;
                        break;
                    case is_null($value):
                        $type = PDO::PARAM_NULL;
                        break;
                    default:
                        $type = PDO::PARAM_STR;
                }
            }
            $this->stmt->bindValue($param, $value, $type);
        }

        public function execute(){
            $this->stmt->execute();
        }

        public function resultSet(){
            $this->execute();
            return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function single(){
            $this->execute();
            return $this->stmt->fetch(PDO::FETCH_ASSOC);
        }

        public function rowCount(){
            return $this->stmt->rowCount();
        }
    }
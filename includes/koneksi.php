<?php

class Database
{
    private static $instance = null;
    private $conn;

    private function __construct()
    {
        $host = DB_HOST;
        $dbname = DB_NAME;
        $user = DB_USER;
        $pass = DB_PASS;

        try {
            $this->conn = new PDO(
                "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
                $user,
                $pass,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ]
            );
        } catch (PDOException $e) {
            error_log($e->getMessage());
            die("Koneksi database gagal");
        }
    }

    // return instance class
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    // akses PDO
    public function getConnection()
    {
        return $this->conn;
    }

    // shortcut biar model tetap bisa pakai prepare()
    public function prepare($sql)
    {
        return $this->conn->prepare($sql);
    }

    public function exec($sql)
    {
        return $this->conn->exec($sql);
    }

    public function lastInsertId()
    {
        return $this->conn->lastInsertId();
    }

    // ⭐ TRANSACTION SUPPORT
    public function beginTransaction()
    {
        if (!$this->conn->inTransaction()) {
            return $this->conn->beginTransaction();
        }
        return true;
    }

    public function commit()
    {
        if ($this->conn->inTransaction()) {
            return $this->conn->commit();
        }
        return true;
    }

    public function rollback()
    {
        if ($this->conn->inTransaction()) {
            return $this->conn->rollBack();
        }
        return true;
    }
}

<?php

class ConnectionPdo {

    private $dbh;
    private $error;
    private $stmt;
    private $dsn;

    public function __construct() {
        $this->dsn = 'mysql:host=' . VP_DB_HOST . '; dbname=' . VP_DB_HOST_NAME;
        $this->options = array(
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET CHARACTER SET utf8"
        );

        try {
            $this->dbh = new PDO($this->dsn, VP_DB_HOST_USER, VP_DB_HOST_PASS, $this->options);
        } catch (PDOException $e) {
            logMsg($e->getMessage(), 'error', $e->getTraceAsString());
            $this->error = $e->getMessage();
        }
    }

    public function query($query) {
        try {
            $this->stmt = $this->dbh->prepare($query);
        } catch (PDOException $e) {
            logMsg($e->getMessage(), 'error', $e->getTraceAsString());
        }
    }

    public function restStmt() {
        $this->stmt = null;
        $this->dbh = null;
        try {
            $this->dbh = new PDO($this->dsn, VP_DB_HOST_USER, VP_DB_HOST_PASS, $this->options);
        } catch (PDOException $e) {
            logMsg($e->getMessage(), 'error', $e->getTraceAsString());
            $this->error = $e->getMessage();
        }
    }

    public function bind($param, $value, $type = null) {
        if (is_null($type)) {
            switch (true) {
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

    public function close() {
        $this->stmt = null;
        $this->dbh = null;
    }

    public function execute() {
        try {
            return $this->stmt->execute();
        } catch (PDOException $e) {
            logMsg($e->getMessage(), 'error', $e->getTraceAsString());
        }
    }

    public function getResultStmt() {
        return $this->stmt;
    }

    public function resultset() {
        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function single() {
        return $this->stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getColCount() {
        return $this->stmt->columnCount();
    }

    public function rowCount() {
        return $this->stmt->rowCount();
    }

    public function lastInsertId() {
        return $this->dbh->lastInsertId();
    }

    public function beginTransaction() {
        $this->dbh->beginTransaction();
    }

    public function endTransaction() {
        $this->dbh->commit();
    }

    public function cancelTransaction() {
        $this->dbh->rollBack();
    }

    public function debugDumpParams() {
        return $this->stmt->debugDumpParams();
    }

    public function disconnect() {
        return $this->dbh = null;
    }

    public function getErro() {
        return $this->error;
    }

    public function setErro($erro) {
        $this->error = $erro;
    }

}

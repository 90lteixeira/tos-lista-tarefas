<?php
include_once filter_input(INPUT_SERVER, 'DOCUMENT_ROOT') . '/config.php';
require_once 'db.php';

class TablePdo {

    private $conn;
    private $tabela;
    private $id = 0;
    private $wr = '';
    private $all = FALSE;
    private $posicao;
    private $rst;
    private $qr;
    private $returning = '';
    private $protect;
    private $strlu = '';
    private $limit = 0;
    private $wrc = '';
    private $wrv = '';
    private $wrcOr = '';
    private $wrvOr = '';
    private $delall = false;

    public function __construct() {
        $this->conn = new ConnectionPdo();
    }

    public function setTabela($param) {
        $this->tabela = $param;
    }

    public function setId($valor) {
        $str_valor = anti_injection($valor, false);
        $this->id = addslashes($str_valor);
    }

    public function setInner($param) {
        $this->inner .= ' inner join ' . $param;
    }

    public function setWhere($campo, $valor) {
        $str_valor = anti_injection($valor, false);
        if (strlen($this->wrc) > 0) {
            $this->wrc .= ' and ' . $campo . '=?';
            $this->wrv .= '#' . addslashes($str_valor);
        } else {
            $this->wrc = $campo . '=?';
            $this->wrv = addslashes($str_valor);
        }
    }

    public function setWhereArray($campo, $valor) {
        $str_valor = $valor;
        if (strlen($this->wrc) > 0) {
            $this->wrc .= ' and ' . $campo . ' in (?)';
            $this->wrv .= '#' . addslashes($str_valor);
        } else {
            $this->wrc = $campo . ' in (?)';
            $this->wrv = addslashes($str_valor);
        }
    }

    public function setWhereV($campo, $valor, $variavel) {
        $str_valor = anti_injection($valor, false);
        $vl = $valor != '' ? '?' : '';
        if (strlen($this->wrc) > 0) {
            $this->wrc .= ' and ' . $campo . " $variavel " . $vl;
            $this->wrv .= $str_valor != '' ? '#' . addslashes($str_valor) : '';
        } else {
            $this->wrc = $campo . " $variavel " . $vl;
            $this->wrv .= $str_valor != '' ? addslashes($str_valor) : '';
        }
    }

//            $this->wrv = addslashes($str_valor);

    public function setWhereMe($campo, $valor) {
        $str_valor = anti_injection($valor, false);
        if (strlen($this->wrc) > 0) {
            $this->wrc .= ' and ' . $campo . '<?';
            $this->wrv .= '#' . addslashes($str_valor);
        } else {
            $this->wrc = $campo . '<?';
            $this->wrv = addslashes($str_valor);
        }
    }

    public function setWhereMa($campo, $valor) {
        $str_valor = anti_injection($valor, false);
        if (strlen($this->wrc) > 0) {
            $this->wrc .= ' and ' . $campo . '>?';
            $this->wrv .= '#' . addslashes($str_valor);
        } else {
            $this->wrc = $campo . '>?';
            $this->wrv = addslashes($str_valor);
        }
    }

    public function setWhereLk($campo, $valor) {
        $str_valor = anti_injection($valor, false);
        if (strlen($this->wrc) > 0) {
            $this->wrc .= ' and ' . $campo . ' like ?';
            $this->wrv .= '#' . addslashes('%' . $str_valor . '%');
        } else {
            $this->wrc = $campo . ' like ?';
            $this->wrv = addslashes('%' . $str_valor . '%');
        }
    }

    public function setWhereLkOr($campo, $valor) {
        $str_valor = anti_injection($valor, false);
        if (strlen($this->wrc) > 0) {
            $this->wrc .= ' or ' . $campo . ' like ?';
            $this->wrv .= '#' . addslashes('%' . $str_valor . '%');
        } else {
            $this->wrc = $campo . ' like ?';
            $this->wrv = addslashes('%' . $str_valor . '%');
        }
    }

    public function setWhereDiff($campo, $valor) {
        $str_valor = anti_injection($valor, false);
        if (strlen($this->wrc) > 0) {
            $this->wrc .= ' and ' . $campo . '<>?';
            $this->wrv .= '#' . addslashes($str_valor);
        } else {
            $this->wrc = $campo . '<>?';
            $this->wrv = addslashes($str_valor);
        }
    }

    public function setWhereBetween($campo, $valor, $valor1) {
        $str_valor = anti_injection($valor, false);
        $str_valor1 = anti_injection($valor1, false);
        if (strlen($this->wrc) > 0) {
            $this->wrc .= ' and ' . $campo . ' between ? and ?';
            $this->wrv .= '#' . addslashes($str_valor) . '#' . addslashes($str_valor1);
        } else {
            $this->wrc = $campo . ' between ? and ?';
            $this->wrv = addslashes($str_valor) . '#' . addslashes($valor1);
        }
    }

    public function setWhereOr($campo, $valor) {
        $str_valor = anti_injection($valor, false);
        if (strlen($this->wrcOr) > 0) {
            $this->wrcOr .= ' and ' . $campo . '=?';
            $this->wrvOr .= '#' . addslashes($str_valor);
        } else {
            $this->wrcOr = $campo . '=?';
            $this->wrvOr = addslashes($str_valor);
        }
    }

    public function setWhereOrNew($campo, $valor) {
        $str_valor = anti_injection($valor, false);
        if (strlen($this->wrc) > 0) {
            $this->wrc .= ' or ' . $campo . '=?';
            $this->wrv .= '#' . addslashes($str_valor);
        } else {
            $this->wrc = $campo . '=?';
            $this->wrv = addslashes($str_valor);
        }
    }

    public function setAll() {
        $this->all = TRUE;
    }

    public function setDelAll() {
        $this->delall = true;
    }

    public function setClear() {
        $this->tabela = '';
        $this->conn->restStmt();
        $this->id = 0;
        $this->order = '';
        $this->all = FALSE;
        $this->wr = '';
        $this->group = '';
        $this->strup = '';
        $this->strcp = '';
        $this->strl = '';
        $this->posicao = '';
        $this->inner = '';
        $this->returning = '';
        $this->wrc = '';
        $this->wrv = '';
        $this->strlPdo = '';
        $this->strlu = '';
        $this->arr = '';
        $this->rst = '';
        $this->limit = 0;
        $this->wrcOr = '';
        $this->wrvOr = '';
    }

    public function beginTransaction() {
        $this->conn->beginTransaction();
    }

    public function endTransaction() {
        $this->conn->endTransaction();
    }

    public function cancelTransaction() {
        $this->conn->cancelTransaction();
    }

    public function setCampo($nome, $valor = '') {
        $str_valor = anti_injection($valor, false);
        $this->setCampoUpdatePdo($nome, addslashes($str_valor));
        $this->setCampoPdo($nome);
        $this->setValorPdo(addslashes($str_valor));
    }

    public function setLimit($param) {
        $this->limit = $param;
    }

    public function getPosicao() {
        return $this->posicao;
    }

    public function getRst() {
        return $this->rst;
    }

    public function setOrder($param) {
        $this->order = $param;
    }

    public function setGroup($param) {
        $this->group = $param;
    }

    public function setReturning($param) {
        $this->returning = $param;
    }

    public function setProcNull($param) {
        $this->protect = $param;
    }

    public function query() {
        $this->qr = "select ";
        if ($this->all == TRUE) {
            $this->qr .= (strlen($this->strcp) > 0) ? '*, ' . $this->strcp : ' * ';
        } else {
            $this->qr .= (strlen($this->strcp) > 0) ? $this->strcp : '';
        }
        $this->qr .= ' from ' . $this->tabela;
        $this->qr .= ' ' . $this->inner;


        $whereId = ($this->id > 0) ? ' where id' . $this->tabela . '=?' : ''; // . $this->id
        $where = $whereId;

        if ($where == '') {
            $where = ($this->wrc == '') ? '' : ' where ' . $this->wrc;
        } else {
            $where = ($this->wrc == '') ? $where : $where . ' and ' . $this->wrc;
        }

        if ($where == '') {
            $where = ($this->wrcOr == '') ? '' : ' where ' . $this->wrcOr;
        } else {
            if ($whereId == '') {
                $where = ($this->wrcOr == '') ? $where : $where . ' or ' . $this->wrcOr;
            } else {
                $where = ($this->wrcOr == '') ? $where : $where . ' or ' . $whereId . " and " . $this->wrcOr;
            }
        }

        $this->qr .= $where;
        $this->qr .= ($this->group != '') ? ' group by ' . $this->group : '';
        $this->qr .= ($this->order != '') ? ' order by ' . $this->order : '';

        $this->qr .= ($this->limit != 0) ? ' limit ' . $this->limit : '';

        $this->conn->query($this->qr);

        $i = 1;
        if ($this->id > 0) {
            $this->conn->bind(1, $this->id);
            $i = 2;
        }

        if (strlen($this->wrv) > 0) {
            $arr = explode('#', $this->wrv);
            foreach ($arr as $linha) {
//                echo "$i";
                $this->conn->bind($i, $linha);
                $i++;
            }
        }

        if (strlen($this->wrvOr) > 0) {
            $arr = explode('#', $this->wrvOr);
            foreach ($arr as $linha) {
                $this->conn->bind($i, $linha);
                $i++;
            }
        }

        try {
            $this->conn->execute();
        } catch (PDOException $e) {
//            erroS('qr ' . $this->qr);
//            erroS('id ' . $this->id);
//            erroS('wrv ' . $this->wrv);
//            erroS('wrvOr ' . $this->wrvOr);
//            erro($this->qr . "\n" . $this->conn->getErro());
            logMsg($e->getMessage(), 'error', $e->getTraceAsString());
            $this->conn->setErro($e->getMessage());
            return 'false';
        }

        $rst = $this->conn->resultset();
        $q = 0;
        $arr = NULL;

        foreach ($rst as $linha) {
            $arr[$q] = $linha;
            $q++;
        }
        if (isset($arr)) {
            $this->rst = $arr;
        } else {
            $this->rst = $rst;
        }
        $this->posicao = $this->conn->rowCount();
        return true;
    }

    public function query_func() {
        $this->qr = "select ";
        $this->qr .= $this->tabela;
        $this->qr .= "(";
        $this->qr .= $this->strl;
        $this->qr .= ")";

        $this->conn->query($this->qr);
        $arrDo = explode(',', $this->strcp);
        $x = 1;
        $max = sizeof($arrDo);
        for ($i = 0; $i < $max; $i++) {
            $this->conn->bind($x, $arrDo[$i]);
            $x++;
        }

        try {
            $this->conn->execute();
        } catch (PDOException $e) {
//            erroS('qr ' . $this->qr);
//            erroS('strcp ' . $this->strcp);
//            erroS($e->getMessage());
            logMsg($e->getMessage(), 'error', $e->getTraceAsString());
            $this->conn->setErro($e->getMessage());
            return false;
        }
        $rst = $this->conn->resultset();
        if (!$rst) {
//            erro($this->qr . "\n" . $this->conn->getErro());
            logMsg($e->getMessage(), 'error', $e->getTraceAsString());
            return false;
        }

        $q = 0;
        foreach ($rst as $linha) {
            $arr[$q] = $linha;
            $q++;
        }
        if (isset($arr)) {
            $this->rst = $arr;
        } else {
            $this->rst = $rst;
        }
        $this->posicao = $this->conn->rowCount();
        return true;
    }

    public function insert() {
        $this->qr = "insert into " . $this->tabela;
        $this->qr .= "(" . $this->strcp . ") values";
        $this->qr .= "(" . $this->strl . ")";
        $this->qr .= ($this->returning != '') ? ' RETURNING ' . $this->returning : '';

        $this->conn->query($this->qr);
        $arr = explode('#', $this->strlPdo);
        $x = 1;
        //$max = sizeof($arr);
        foreach ($arr as $linha) {
            $this->conn->bind($x, $linha);
            $x++;
        }
        try {
            $this->conn->execute();
        } catch (PDOException $e) {
//            erroS($this->qr);
//            erroS($this->strlPdo);
//            erroS($ex->getMessage());
            logMsg($e->getMessage(), 'error', $e->getTraceAsString());
            $this->conn->setErro($ex->getMessage());
            return FALSE;
        }

        if ($this->returning != '') {
            $rst = $this->conn->resultset();

            $q = 0;
            foreach ($rst as $linha) {
                $array[$q] = $linha;
                $q++;
            }
            if (isset($array)) {
                $this->rst = $array;
            } else {
                $this->rst = $rst;
            }
            $this->posicao = $this->conn->rowCount();
            return true;
        }
        return TRUE;
    }
    
    public function ultimoRegistro(){
        return $this->conn->lastInsertId();
    }

    public function update() {
        $this->qr = 'update ' . $this->tabela . ' set ';
        $this->qr .= $this->strup;

        $were = ($this->id > 0) ? ' where id' . $this->tabela . '=?' : ''; // . $this->id 

        if (strlen($were) > 0) {
            $this->qr .= (strlen($this->wrc) > 0) ? ' ' . $were . ' and ' . $this->wrc : $were;
        } else {
            $this->qr .= (strlen($this->wrc) > 0) ? ' where ' . $this->wrc : '';
        }

        $this->conn->query($this->qr);

        $i = 1;

        $arr = explode('#', $this->strlu);
        foreach ($arr as $linha) {
            $this->conn->bind($i, $linha);
            $i++;
        }

        if ($this->id > 0) {
            $this->conn->bind($i, $this->id);
            $i++;
        }

        if (strlen($this->wrv) > 0) {
            $arr = explode('#', $this->wrv);
            foreach ($arr as $linha) {
//                echo $linha . "<br/>";
                $this->conn->bind($i, $linha);
                $i++;
            }
        }
//        echo '$this->id=' . $i . " " . $this->id . "<br/>";


        try {
            $this->conn->execute();

            return TRUE;
        } catch (PDOException $e) {
//            erroS('i ' . $this->id);
//            erroS('qr ' . $this->qr);
//            erroS('wrv ' . $this->wrv);
//            erroS('strlu ' . $this->strlu);
//            erro($e->getMessage());
            logMsg($e->getMessage(), 'error', $e->getTraceAsString());
            $this->conn->setErro($e->getMessage());

            return FALSE;
        }
    }

    public function delete() {
        $this->qr = "delete from " . $this->tabela . ' ';

        $were = ($this->id > 0) ? ' where id' . $this->tabela . '=?' : ''; // . $this->id 

        if (strlen($were) > 0) {
            $were .= (strlen($this->wrc) > 0) ? ' and ' . $this->wrc : '';
        } else {
            $were .= (strlen($this->wrc) > 0) ? 'where ' . $this->wrc : '';
        }

        $this->qr .= $were;

        if ($were == '') {
            return FALSE;
        }

//        if ($were == '' && $this->delall == false) {
//            return FALSE;
//        }

        $this->conn->query($this->qr);
        $i = 1;
        if ($this->id > 0) {
            $this->conn->bind($i, $this->id);
            $i++;
        }

        if (strlen($this->wrv) > 0) {
            $arr = explode('#', $this->wrv);
            foreach ($arr as $linha) {
                $this->conn->bind($i, $linha);
                $i++;
            }
        }

        try {
            $this->conn->execute();
            return true;
        } catch (PDOException $e) {
//            erroS('qr ' . $this->qr);
//            erroS('id ' . $this->id);
//            erroS('wrv ' . $this->wrv);
//            erroS($e->getMessage());
            logMsg($e->getMessage(), 'error', $e->getTraceAsString());
            return FALSE;
        }
    }

    private function setCampoUpdatePdo($campo, $valor) {
        if (strlen($this->strup) > 0) {
            $this->strup .= ", " . $campo . "=?";
            $this->strlu .= "#" . $valor;
        } else {
            $this->strup = $campo . "=?";
            $this->strlu = $valor;
        }
    }

//$this->strcp . ") values";
//        $this->qr .= "(" . $this->strl 
    private function setCampoPdo($campo) {
        $this->strcp = (strlen($this->strcp) > 0) ? $this->strcp . ',' . $campo : $campo;
    }

    private function setValorPdo($valor) {
        $this->strl = (strlen($this->strl) > 0) ? $this->strl . ',' . '?' : '?';
        $this->strlPdo = (strlen($this->strlPdo) > 0) ? $this->strlPdo . '#' . $valor : $valor;
    }

    public function getLog() {
        $txt = '';
        try {
            $stmt = $this->conn->getResultStmt();
            foreach (range(0, $stmt->columnCount() - 1) as $column_index) {
                //print_r($stmt->getColumnMeta($column_index));
                $nome[] = $stmt->getColumnMeta($column_index)['name'];
                $tipo[] = $stmt->getColumnMeta($column_index)['native_type'];
            }
            $q = 0;
            $this->conn->execute();
            $rst = $this->conn->resultset()[0];
            foreach ($rst as $linha) {
                if ($tipo[$q] == 'bool') {
                    $txtlinha = ($linha == TRUE) ? 'TRUE' : 'FALSE';
                    $txt .= $nome[$q] . "\t=\t" . $txtlinha . "\n";
                } else {
                    $txt .= $nome[$q] . "\t=\t" . $linha . "\n";
                }
                $q++;
            }
        } catch (PDOException $e) {
//            erroS('Erro getCampo ' . $e->getMessage());
            logMsg($e->getMessage(), 'error', $e->getTraceAsString());
        }

        return $txt;
    }

}

class BcryptHash {

    protected static $_saltPrefix = '2a';
    protected static $_defaultCost = 10;
    protected static $_saltLength = 22;

    /**
     * Hash a string
     * 
     * @param  string  $string The string
     * @param  integer $cost   The hashing cost
     * 
     * @return string
     */
    public static function hash($string, $cost = null) {
        if (empty($cost)) {
            $cost = self::$_defaultCost;
        }
        // Salt
        $salt = self::generateRandomSalt();
        // Hash string
        $hashString = self::__generateHashString((int) $cost, $salt);
        return crypt($string, $hashString);
    }

    /**
     * Check a hashed string
     * 
     * @param  string $string The string
     * @param  string $hash   The hash
     * 
     * @return boolean
     */
    public static function check($string, $hash) {
        return (crypt($string, $hash) === $hash);
    }

    /**
     * Generate a random base64 encoded salt
     * 
     * @return string
     */
    public static function generateRandomSalt() {
        // Salt seed
        $seed = uniqid(mt_rand(), true);
        // Generate salt
        $salt = base64_encode($seed);
        $salt = str_replace('+', '.', $salt);
        return substr($salt, 0, self::$_saltLength);
    }

    /**
     * Build a hash string for crypt()
     * 
     * @param  integer $cost The hashing cost
     * @param  string $salt  The salt
     * 
     * @return string
     */
    private static function __generateHashString($cost, $salt) {
        return sprintf('$%s$%02d$%s$', self::$_saltPrefix, $cost, $salt);
    }

}

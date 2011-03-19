<?php
$dbconfig = unserialize(dbconfig);

define('DB_DRIVER'	, $dbconfig[Ambiente]['driver']);
define('DB_HOST'	, $dbconfig[Ambiente]['host']);
define('DB_NAME'	, $dbconfig[Ambiente]['db']);
define('DB_USER'	, $dbconfig[Ambiente]['user']);
define('DB_PASS'	, $dbconfig[Ambiente]['pass']);

define('STRING', 	PDO::PARAM_STR);
define('BIGINT', 	PDO::PARAM_STR);
define('DOUBLE', 	PDO::PARAM_STR);
define('DATE',	 	PDO::PARAM_STR);
define('TIMESTAMP',	PDO::PARAM_STR);
define('CHAR',	 	PDO::PARAM_STR);
define('VARCHAR', 	PDO::PARAM_STR);
define('INTEGER', 	PDO::PARAM_INT);
define('BOOLEAN', 	PDO::PARAM_BOOL);
define('NULL', 		PDO::PARAM_NULL);


class BDo extends PDO {

	private $db;

	private $query;

	private $stmt = null;

	private $result;
	
	public function BDo($driverParams = array()) {
		global $erros;
		$this->erros=$erros;
		$driverParams[]=array(PDO::ATTR_PERSISTENT=>true);
		$dsn = DB_DRIVER.':host='.DB_HOST.';dbname='.DB_NAME;

//print_r(get_defined_constants());
		
		try {
			//echo "$dsn, ".DB_USER.", ".DB_PASS.", $driverParams";
			parent::__construct($dsn, DB_USER, DB_PASS, $driverParams);
			$this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$this->setAttribute(PDO::ATTR_STATEMENT_CLASS, array('BDoStatement', array($this)));
		} catch (PDOException $e) {
			echo $e->getMessage();
			//$this->erros->showError($e->getMessage());
			return false;
		}
	}

	public function queryParam($sql, $params = array()) {
		try {
				
			$this->stmt = $this->prepare($sql);
			$index = 1;
			for($i = 0; $i < count($params); $i++) {
				if(!isset($params[$i]['param'])) $indexKey = $index;
				else $indexKey =  $params[$i]['param'];
				
				if(isset($params[$i]['typeParam'])) $this->stmt->bindParam($indexKey, $params[$i]['value'], constant($params[$i]['typeParam']));
				else $this->stmt->bindParam($indexKey, $params[$i]['value']);
				
				$index++;
			}
				
			return $this->stmt;
				
		} catch (PDOException $e) {
			$this->erros->showError($e->getMessage());
			return false;
		}
	}
	
	public function getColumns($table) {
		try {
			$this->stmt = $this->query('SHOW COLUMNS FROM '.$table);
			$index = 0;
			$columns = array();
			while($field = $this->stmt->fetch(PDO::FETCH_ASSOC)) {

				$columns[$index][$field['Field']] = $field['Type'];
			}
		} catch (PDOException $e) {
			$this->erros->showError($e->getMessage());
			return false;
		}
		return $columns;
	}
}



class BDoStatement extends PDOStatement {

	const NO_MAX_LENGTH = -1;

	protected $connection 	= null;

	protected $boundParam 	= array();

	protected function BDoStatement(PDO $connection) {
		$this->connection = $connection;
	}

	public function bindParam($paramno, $param, $type = PDO::PARAM_STR, $maxlen = null, $driverdata = null) {
		$this->boundParam[$paramno] = array('value' => $param, 'type' => $type, 'maxlen' => (is_null($maxlen) ? self::NO_MAX_LENGTH : $maxlen));
		parent::bindParam($paramno, $param, $type, $maxlen, $driverdata);
	}

	public function bindValue($parameter, $value, $dataType = PDO::PARAM_STR) {
		$this->boundParam[$parameter] = array('value' => $value, 'type' => $dataType, 'maxlen' => self::NO_MAX_LENGTH);
		parent::bindValue($parameter, $value, $dataType);
	}

	public function getQuery($values = array()) {
		$sql = $this->queryString;

		if(count($values) > 0) {
			foreach($values as $key => $value) {
				$sql = str_replace($key, $this->connection->quote($value), $sql);
			}
		}

		if(count($this->boundParam) > 0) {
			foreach($this->boundParam as $key => $param) {
				$value = $param['value'];
				if(!is_null($param['type']))
				$value = self::cast($value, $param['type']);
				if($param['maxlen'] && $param['maxlen'] != self::NO_MAX_LENGTH)
				$value = self::truncate($value, $param['maxlen']);
				if(!is_null($value))
				$sql = str_replace($key, $this->connection->quote($value), $sql);
				else
				$sql = str_replace($key, 'NULL', $sql);
			}
		}

		return $sql;
	}

	protected static function cast($value, $type) {
		switch($type) {
			case PDO::PARAM_BOOL:
				return (bool) $value;
				break;
			case PDO::PARAM_NULL:
				return null;
				break;
			case PDO::PARAM_INT:
				return (int) $value;
				break;
			case PDO::PARAM_STR:
			default:
				return $value;
		}
	}

	protected static function truncate($value, $length) {
		return substr($value, 0, $lenth);
	}
	
	function __destruct(){
	//echo "fechou";  

	}
}

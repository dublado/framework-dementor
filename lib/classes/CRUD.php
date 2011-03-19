<?php
/**
 * @author Thiado Machado
 * @example INSERT  $obj = new CRUD("TABELA",$_POST,"insert","id",true);
 * @example UPDATE $obj = new CRUD("TABELA",$_POST,"update","id",false);
 * @example DELETE $obj = new CRUD("TABELA",$_POST,"delete","id",true);
 * @example SHOW QUERY $obj->result;
 **/
class CRUD {

	public function CRUD() {
		$args = func_get_args();
		$this->args = $args;

		$fields = ''; 
		$values = '';

		$arg  = $args[1];

		switch($args[2]) {
			case 'insert':
				unset($arg[$args[3]]);
				$this->arg = $arg;
				$unset = explode(',',$args[4]);
				array_walk($unset,array(&$this,'process_unset'));
				$arg = $this->arg;

				$fields = implode(',',array_keys($arg));
				$values = array_values($arg);
				array_walk($values, array(&$this,'process_insert'));
				$values = implode(',',$values);
				$this->result = 'insert into '.$args[0].' ('.strtolower($fields).') values ('.$values.')';

			break;
			case 'update':
				$where = "where " . $args[3] . " = " . $arg[$args[3]];unset($arg[$args[3]]);

				$this->arg = $arg;
				$unset = explode(",",$args[4]);
				array_walk($unset,array(&$this,'process_unset'));$arg=$this->arg;

				array_walk($arg, array(&$this, 'process_update'));
				$values = implode(",",$arg);
				$this->result = (string) 'update '.$args[0].' set '.$values.' '.$where;
			break;
			case "delete":
				$where = "where " . $args[3] . " = " . $arg[$args[3]];unset($arg[$args[3]]);
				$this->result = "delete from ".$args[0]." $where";
			break;
		}
	}

	public function process_insert(&$item1, $key) {
		$item1 = "'".$this->escapes($item1)."'";
	}

	public function process_update(&$item1, $key) {
		$item1 = strtolower($key)." = '".mysql_escape_string($item1)."'";
	}

	public function process_unset(&$item1, $key){
		unset($this->arg[$item1]);
	}

	public function escapes($sql) {
		switch (DB_DRIVER) {
			case 'mssql':
				$fix_str = stripslashes($sql);
				$fix_str = str_replace("'","''",$sql);
				$fix_str = str_replace("\0","[NULL]",$fix_str);

				return $fix_str;
			break;
			case 'mysql':
				return (string) mysql_escape_string($sql);
			break;
			default:
				return (string) $sql;
			break;
		}
	}
}

<?php
class membro extends siteman 
{

	function __construct ()
	{
		global $membro;
		
		parent::__construct(
		array(
		"titulo"=>" la pagina",
		"skel"=>"global",
		"description"=>"i need a miracle"
		));
		
		$this->bd = new BDo();
	
		$sql = "select * from membros where nome = '".parametros(1)."'";//echo $sql;
		$rss = $this->bd->query($sql);
		$membro = $rss->fetchObject();	
		
	}
	
	function __destruct()
	{
		parent::__destruct();
		//include ()		
	}

}


?>
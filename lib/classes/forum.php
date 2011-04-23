<?php
//new siteman();

class forum extends siteman 
{

	function __construct ()
	{
		//global $membro;
		
		parent::__construct(
		array(
		"titulo"=>"agora é a página do forum!!!",
		"skel"=>"header_left_footer",
		"description"=>"i need a miracle"
		));
		
		
		$this->bd = new BDo();
	
		$sql = "select * from membros where nome = '".parametros(1)."'";//echo $sql;
		$rss = $this->bd->query($sql);
		$this->membro = $rss->fetchObject();	
		
		
	}
	
	function __destruct()
	{
		parent::__destruct();
		//include ()		
	}

}


?>

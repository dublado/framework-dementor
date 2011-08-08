<?php
class membro extends siteman 
{

	function __construct ()
	{
		global $membro;
		
		$this->bd = new BDo();
	
		$sql = "select * from membros where nome = '".parametros(1)."'";//echo $sql;
		$rss = $this->bd->query($sql);
		$membro = $rss->fetchObject();	

        if($membro){
        $titulo = " pagina dos membros / " . $membro->nome;
        }else {$titulo = "pagina de membros";}
        
		parent::__construct(
		array(
		"titulo"=>$titulo,
		"skel"=>"header_left_footer",
		"description"=>"i need a miracle"
		));
		
		
	}
	
	function __destruct()
	{
		parent::__destruct();
		//include ()		
	}

}


?>

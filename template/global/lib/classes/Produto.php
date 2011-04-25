<?php

class Produto
{

    function __construct ($id)
    {

		$this->bd = new BDo();
	
		$sql = "select * from produtos where id = '$id'";//echo $sql;
		$rss = $this->bd->query($sql);
		$rs = $rss->fetchObject();	
        $this->titulo=$rs->titulo;		    
        $this->qtd=1;		    
        $this->valor=1;		    
        $this->presente=array($rs->presente,false);		    
        $this->img='bttf.jpg';		    
        
    }

}

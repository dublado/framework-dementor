<?php

class Produto
{

    function __construct ($id)
    {
    
        $this->id = $id;
		$this->bd = new BDo();
	
    }
    
	function check()
	{

		$sql = "select * from produtos where id = '$this->id'";//echo $sql;
		$rss = $this->bd->query($sql);
		if($rss->rowCount()>0)
		{
		    $rs = $rss->fetchObject();	
            $this->titulo=$rs->titulo;		    
            $this->qtd=1;		    
            $this->valor=1;		    
            $this->presente=array($rs->presente,false);		    
            $this->img='bttf.jpg';	
        }else{return false;}

            return true;	    


	}    

}

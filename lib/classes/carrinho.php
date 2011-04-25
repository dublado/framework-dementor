<?php
class carrinho extends siteman 
{

	function __construct ()
	{

        parent::__construct(array(
        "titulo"=>" carrinho",
        "skel"=>"header_footer",
        "description"=>"i need a miracle"
        ));

        //echo "o loko";

         if(isset($_SESSION['carrinho'])){ $this->carrinho=$_SESSION['carrinho']; }
         
         
	
	}
	


    function add($id)
    {
        //$this->carrinho;
        //echo $id;
        if (
        
        
        (isset($this->carrinho['item']) ? (is_array($this->carrinho['item']) ? array_key_exists($id, $this->carrinho['item']) : false) : false) 
        
        ) 
        {
            //echo $id;
            $this->carrinho['item'][$id]['qtd']++;
            //var_dump($this->carrinho);
            $_SESSION['carrinho']=$this->carrinho;
        }else{
        
        
        $produto = loader('global/Produto',$id);

        $this->carrinho['item'][$id]=array
        (
            
            'titulo'=>$produto->titulo,
            'qtd'=>'1',
            'valor'=>'11.10',
            'presente'=>array('1',true),
            'img'=>'bttf.jpg'
        );
        $_SESSION['carrinho']=$this->carrinho;
        
        }

    }
	
    function del($id)
    {
        //$this->carrinho;
        //echo $id;
        if (array_key_exists($id, $this->carrinho['item'])) 
        {
            unset($this->carrinho['item'][$id]);
        }

    }
	
	
	function __destruct()
	{   
        
		parent::__destruct();
		//include ()		
	}

}

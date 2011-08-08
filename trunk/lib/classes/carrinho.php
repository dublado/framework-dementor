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
        
        if(!isset($this->carrinho['cep'])){ $this->carrinho['cep']=""; }

        switch(parametros(1))
        {
            case "add":
                $this->add(parametros(2));
            break;
            case "del":
                $this->del(parametros(2));
            break;
            case "limpa":
                $this->limpa();
            break;
        
        }         
	
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

        if($produto->check())
        {
            $this->carrinho['item'][$id]=array
            (
                
                'titulo'=>$produto->titulo,
                'qtd'=>'1',
                'valor'=>'11.10',
                'presente'=>array('1',true),
                'img'=>'bttf.jpg'
            );
        }

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
            $_SESSION['carrinho']=$this->carrinho;
        }

    }
    
    function limpa()
    {
    
        unset($_SESSION['carrinho']);
    
    }
    
    function frete_valido(){

        return (
        
        isset($this->carrinho['cep']) ? 
        (is_array($this->carrinho['cep']) 
        ? true : false) : false
        
        );
        
    }
	
	function valido()
	{
	    return (
	    isset($this->carrinho['item']) ? 
	    (is_array($this->carrinho['item']) 
	    ? 
	    
	    (count($this->carrinho['item'])>0? true : false) 
	     : false) : false
	    );
	}
	

	function frete()
	{

        if( $this->frete_valido() )
        {
            $frete = new frete($this->carrinho['cep']);
            
                if(is_array($frete->frete))
                    {
                        if($frete->valor>0){echo " Frete: R$ " . number_format($frete->valor,2,',','.');$total+=$frete->valor;}else{echo " Frete Grátis";}
                    }
                    else{
                       // echo "<br>" . $frete->frete;
                    }
        }

	}

	
	function __destruct()
	{   
        
		parent::__destruct();
		//include ()		
	}

}

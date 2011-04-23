<?php
class erros
{
	#	internal variables
	
	#	Constructor
	function __construct ($param=false)
	{
		$this->param=$param;
	}
	
	function __destruct()
	{
	
		if($this->param==true) { $this->depuracao(); }

	
	}
	
	function depuracao()
	{
	

echo '<div style="border:1px solid;padding:10px;background-color:black;color:white;"><pre>';
print_r(get_declared_classes());
		echo "GET
		";
		var_dump($_GET);
		echo "POST
		";
		var_dump($_POST);
		echo "REQUEST
		";
		var_dump($_REQUEST);
		echo '</pre></div>';	
	
	}
	
	function showError($param)
	{
		error_log==true ? error_log($param) : print($param) ;
	}

}

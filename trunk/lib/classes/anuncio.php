<?php
class anuncio extends siteman 
{

	function __construct ()
	{

	parent::__construct(array(
	"titulo"=>"Somente anuncio",
	"description"=>"anunciando",
	"js"=>array("record.js")
	));

//echo "o loko";

		
	}
	
	function __destruct()
	{
		parent::__destruct();
		//include ()		
	}

}

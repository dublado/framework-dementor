<?php
if(isset($_REQUEST['parametros']))
{
	define('parametros',$_REQUEST['parametros']);
}

//carrega classes padrão e passa parametros se necessario
//$load['BDo']="";

if(defined('mode'))
{
	switch(mode)
	{
		case "dev":
			$load['erros'] = true;
		break;
		default:
			$load['erros'] = false;
	}
}

//var_dump($load);
isset($load) ? is_array($load) ? array_walk($load,'class_preloader') : false : false;

function parametros($param)
{
	if(defined('parametros'))
	{
		$temp = split("/",parametros);

		if(array_key_exists($param,$temp)){

		return $temp[$param];
		}else{

		return false;
		}
	}else{
	return "index";
	}
}

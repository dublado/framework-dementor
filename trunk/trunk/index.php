<?php
require_once("lib/global.php");

$classe=parametros(0);
loader($classe);
/*
switch(parametros(0))
{
	case "membro":
		require_once("template/membro/ini.php");
	break;
	
	case "forum":
		require_oncee("template/forum/index.php");
	break;
	default:
		require_once("template/index/index.php");
}*/


/*
require_once("lib/class.inc.php");

$parametros = array("titulo" => "Home");
$mostra = new siteman($parametros);
*/

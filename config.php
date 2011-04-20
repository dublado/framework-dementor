<?php
define("Titulo","Clube de Lideres Online"); //define titulo padrao
define("Ambiente","local"); //prod e local

$_base['prod'] = array
(
	"base"		=>	"/home/users/web/b568/moo.sportweb/atreyocom/LABS/clo",
	"base_url"	=>	"http://www.clubedelider.org/"
);

$_base['local'] = array
(
	"base"		=>	"/var/www/dementor/framework-dementor",
	"base_url"	=>	"http://localhost/dementor/framework-dementor/"
);


$dbconfig['prod'] = array
(
	"driver"	=>	"mysql",
	"host"  	=>	"mysql.ants.com.br",
	"db"		=>	"ants_dev",
	"user"		=>	"antscomunicacao",
	"pass"		=>	"ants2201"
);


// TESTE/LOCAL
$dbconfig['local'] = array
(
	"driver"	=>	"mysql",
	"host"		=>	"localhost",
	"db"		=>	"clo",
	"user"		=>	"root",
	"pass"		=>	"root"
);


switch(Ambiente){
	case "prod":
		//define("base","/home1/atreyoco/public_html/clubedelider");
		//define("base",$_base[Ambiente]["base"]);
		//define("base","/home/antscomunicacao/ants.com.br/clientes/dublado");
		//define("base_url",$_base[Ambiente]["base_url"]); 
		//define("base_url","http://atreyo.com/LABS/clo/"); 
		//define("base_url","http://www.ants.com.br/clientes/dublado/"); 
	break;
	default:
		//define("base","/var/www/dementor/framework-dementor");
		//define("base_url","http://localhost/dementor/framework-dementor/"); 
	break;
}

define("base","/var/www/dementor/framework-dementor");
define("base_url","http://localhost/dementor/framework-dementor/"); 

set_include_path(base);

if(!file_exists(base)){
echo "Defina Base(sugestão): " . $_SERVER["DOCUMENT_ROOT"] . '<br>';
}

//define("mode","dev"); //mode = dev ativa o depurador _GET _POST _REQUEST
define("error_log",true); 
// true para exeuctar error_log e false para imprimir na tela
// algum servidores não deixam acessar o log diretamente do arquivo

define("error-ip","192.168.1.113"); //define ip que verá a depuração

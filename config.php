<?php
define("Titulo","Clube de Lideres Online"); //define titulo padrao

define("Ambiente","local"); //prod e local

// PRODUCAO
/*$dbconfig['prod'] = array(
"driver"=>"mysql",
"host"=>"sportweb.fatcowmysql.com",
"db"=>"atreyo",
"user"=>"atreyo",
"pass"=>"s7c8e9"
);*/

$dbconfig['prod'] = array(
"driver"=>"mysql",
"host"=>"mysql.ants.com.br",
"db"=>"ants_dev",
"user"=>"antscomunicacao",
"pass"=>"ants2201"
);


// TESTE/LOCAL
$dbconfig['local'] = array(
"driver"=>"mysql",
"host"=>"localhost",
"db"=>"clo",
"user"=>"root",
"pass"=>"root"
);


switch(Ambiente){
	case "prod":
		//define("base","/home1/atreyoco/public_html/clubedelider");
		define("base","/home/users/web/b568/moo.sportweb/atreyocom/LABS/clo");
		//define("base","/home/antscomunicacao/ants.com.br/clientes/dublado");
		define("base_url","http://www.clubedelider.org/"); 
		//define("base_url","http://atreyo.com/LABS/clo/"); 
		//define("base_url","http://www.ants.com.br/clientes/dublado/"); 
	break;
	default:
		define("base","/var/www/clo");
		define("base_url","http://localhost/clo/"); 
	break;
}

set_include_path(base);

if(!file_exists(base)){
echo "Defina Base(sugestão): " . $_SERVER["DOCUMENT_ROOT"];
}

//define("mode","dev"); //mode = dev ativa o depurador _GET _POST _REQUEST
define("error_log",true); 
// true para exeuctar error_log e false para imprimir na tela
// algum servidores não deixam acessar o log diretamente do arquivo

define("error-ip","192.168.0.103"); //define ip que verá a depuração

<?php
$script_start=0;
set_time_limit(5);

//session_start();

function sendcompressedcontent( $content )
{
    header( "Content-Encoding: gzip" );
    return gzencode( $content, 9 );
}

ob_start( 'sendcompressedcontent' );


require_once "config.php"; // parametros de configuracao simples
define('dbconfig', serialize($dbconfig)); //serializa os dados de conexao para o BDo

//echo get_include_path()."/lib/autoload.php";
require_once("lib/autoload.php"); 
//$erros = new erros(); //instancia a classe de depuracao (analisar melhor);

//var_dump($erros);
require_once("lib/classes/parametros.php");

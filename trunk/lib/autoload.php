<?php
function loader($param,$class)
{ 
	if($param==""){$param=null;}
	new $class($param); 
}

function __autoload($class_name) {
	if(!class_exists($class_name)){
	//echo "okok " .get_class(parent);
	
//echo "<br>".$class_name;
	//echo dirname(__FILE__).'/classes/' . $class_name . '.php<br>';
	//echo dirname(__FILE__);

   // require_once dirname(__FILE__).'/classes/' . $class_name . '.php';
   //echo "<h3>".dirname(__FILE__)."/../</h3>";
//   set_include_path(__DIR__);    
//if($class_name=="doContent"){echo "mostra conteudo";}

    //echo '<br/>autoload: '.get_include_path().'lib/classes/' . $class_name . '.php<br/>';
    //echo __DIR__;
    switch($class_name){
    case "template":echo "oh noooooooooo";break;
    case "BDo":
    $php = base . '/lib/classes/' . $class_name . '.php';
    //echo "autoload: $php<br>";
    //error_log("Pagina carregada: " . $php);
    if(file_exists($php)){
    require_once($php);    
    }else{echo('Não foi possivel carregar ' . $php);return false;}
    break;
    default:
    $php = get_include_path() . '/lib/classes/' . $class_name . '.php';
    //echo "autoload: $php<br>";
    //error_log("Pagina carregada: " . $php);
    if(file_exists($php)){
    require_once($php);    
    }else{echo('Não foi possivel carregar ' . $php);return false;}
    }
    
    } 
    //echo "<br>".get_include_path();
}

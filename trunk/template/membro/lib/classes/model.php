<?php
	class model
	{

		function __construct ($obj)
		{
		?>
		<img src="template/membro/img/gall01.jpg" style="float:left;margin-right:10px;"/> 
		<h2 style='margin:0;padding:0;'>Nishimura</h2><?php if($obj){echo $obj->nome;}?>
		<!--[if ie]>sei nao<![endif]--> 
		<?php
			
		}

	
	}


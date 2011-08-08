<div class="menu_global">
<?php loader("global/Topo"); ?>
</div>
<div class="conteudo">

<div class="mleft"><?php	
loader("global/leftMenu");
?>
<br clear="both"/>
</div>
<div class="meio">
<?php

	$this->doContent();

?>
<br clear="both"/>
</div>
</div>
<div class="footer">
<?php

	loader("global/Footer");

?>
</div>


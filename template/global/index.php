<div style="padding:10px;border:1px dashed;">
<a href="<?php echo base_url;?>">HOME</a> | <a href="<?php echo base_url?>forum">FORUM</a>
</div>
<div class="conteudo">

<div class="mleft"><?php	
loader("global/leftMenu");
?>
<br clear="both"/>
</div>
<div class="mright"><?php	
loader("global/rightMenu");
loader("global/twitterfoz");
?>
<br clear="both"/>
</div>
<div class="meio">
<?php>

	$this->doContent();

?>
<br clear="both"/>
</div>
</div>
<div class="footer">
Organização Atreyo comunicações
<?php

	new Footer();

?>
</div>


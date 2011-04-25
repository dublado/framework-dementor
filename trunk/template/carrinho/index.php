<?php
/*
    $carrinho['item'][2312]=array(
    'titulo'=>'De volta para o futuro(edição de colecionador)',
    'qtd'=>'2',
    'valor'=>'11.10',
    'presente'=>'1',
    'img'=>'bttf.jpg'
    );

    $carrinho['item'][9812]=array(
    'titulo'=>'Blade Runner',
    'qtd'=>'3',
    'valor'=>'9.13',
    'presente'=>'1.5',
    'img'=>'blade-runner-blu-ray.jpg'
    );
    
    $carrinho['cep'] = "04552050";
    
    $_SESSION['carrinho']=$carrinho;
    */
    switch(parametros(1))
    {
        case "add":
        $this->add(parametros(2));
        break;
        case "del":
        $this->del(parametros(2));
        break;
    
    }
    

?>


<?php 
if( (isset($this->carrinho['item']) ? (is_array($this->carrinho['item']) ? true : false) : false) ){
?>
<table border="1" width='100%'>
<tr><td></td>
    <td>produtos</td>
    <td width='50'>qtd</td>
    <td width='150'>para presente</td>
    <td width='30'></td>
    <td width='150'>preço unitário</td>
    <td width='150'>preço total</td>
</tr>
<?php
$total="";

foreach($this->carrinho['item'] as $id=>$val){
$item = $val;
?>
<tr>
    <td width='100'><img src="arquivos/img/<?php echo $item['img'];?>" width="100" height="100"/></td>
    <td valign="center" height="100"><?php echo $item['titulo'];?></td>
    <td><?php echo $item['qtd'];?></td>
    <td>
        <input type='checkbox' <?php if($item['presente'][1]){ echo "checked='checked'"; }?>  />
        <?php if($item['presente'][1]){ echo 'R$ '.number_format($item['presente'][0],2,',','.'); }?>
    </td>
    <td><a href='carrinho/del/<?php
    
        echo $id;
    
    ?>'>x</a></td>
    <td>R$ <?php echo number_format($item['valor'],2,',','.');?></td>
    <td>R$ <?php echo number_format($item['valor'] * $item['qtd'],2,',','.');?></td>
</tr>
<?php 

$total+=$item['valor'] * $item['qtd'];
if($item['presente'][1]){$total+=$item['presente'][0];}

}
}?>
</table>
<?php
//echo "<pre>";
//   var_dump($_SESSION['carrinho']);
//echo "</pre>";

if( (isset($this->carrinho['cep']) ? (is_array($this->carrinho['cep']) ? true : false) : false) ){

$frete = new frete($this->carrinho['cep']);
?>
<div style='border:1px solid;text-align:right;padding:10px;margin-top:10px;'>
<?php 

?>
CEP: <input type='text' size='7' value='<?php echo substr($this->carrinho['cep'],0,5);?>'> - <input type='text' size='3' value='<?php echo substr($this->carrinho['cep'],5,3);?>'>
<?php
    if(is_array($frete->frete))
        {
            if($frete->valor>0){echo " Frete: R$ " . number_format($frete->valor,2,',','.');}else{echo " Frete Grátis";}
        }
        else{
           // echo "<br>" . $frete->frete;
        }
?>
</div>
<div style='border:1px solid;text-align:right;padding:10px;margin-top:10px;'>
TOTAL: R$ <?php echo number_format($total+$frete->valor,2,',','.');?>
</div>
<?php

    }

?>
<input type='button' value='comprar mais produtos'>
<input type='button' value='limpar carrinho'>
<input type='button' value='fechar pedido'>



<?php if( $this->valido() ): ?>
    <table border="1" width='100%'>
    <tr><td></td>
        <td>produtos</td>
        <td width='50'>qtd</td>
        <td width='150'>para presente</td>
        <td width='30'></td>
        <td width='150'>preço unitário</td>
        <td width='150'>preço total</td>
    </tr>
    <?php foreach($this->carrinho['item'] as $id=>$item): ?>
            <tr>
                <td width='100'><img src="arquivos/img/<?php echo $item['img'];?>" width="100" height="100"/></td>
                <td valign="center" height="100"><?php echo $item['titulo'];?></td>
                <td><?php echo $item['qtd'];?></td>
                <td>
                    <input type='checkbox' <?php if($item['presente'][1]){ echo "checked='checked'"; }?>  />
                    <?php if($item['presente'][1]){ echo 'R$ '.number_format($item['presente'][0],2,',','.'); }?>
                </td>
                <td><a href='carrinho/del/<?php echo $id;?>'>x</a></td>
                <td>R$ <?php echo number_format($item['valor'],2,',','.');?></td>
                <td>R$ <?php echo number_format($item['valor'] * $item['qtd'],2,',','.');?></td>
            </tr>
            <?php 
                (isset($total) ? $total=0 : $total="");
                $total+=$item['valor'] * $item['qtd'];
                if($item['presente'][1]){$total+=$item['presente'][0];}

            endforeach;?>
</table>
<?php endif;?>
        <div style='border:1px solid;text-align:right;padding:10px;margin-top:10px;'>
            CEP: <input type='text' size='7' value='<?php echo substr($this->carrinho['cep'],0,5);?>'> - 
            <input type='text' size='3' value='<?php echo substr($this->carrinho['cep'],5,3);?>'>
            <?php $this->frete(); ?>
        </div>

<?php if( $this->valido() ): ?>
    <div style='border:1px solid;text-align:right;padding:10px;margin:0 10px;'>
    TOTAL: R$ <?php echo number_format($total,2,',','.');?>
    </div>
<?php endif; ?>

<input type='button' value='comprar mais produtos'>
<input type='button' value='limpar carrinho'>
<input type='button' value='fechar pedido'>



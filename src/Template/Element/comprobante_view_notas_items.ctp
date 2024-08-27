<div class="notasCuerposItems index large-10 medium-9 columns">
    <table class='tablasearch' cellpadding="0" cellspacing="0">

	 <?php $indice=0;?>
	 
    <?php foreach ($notasCuerposItems as $notasCuerposItem): ?>
        <?php if($indice==0) {
        if (!empty($notasCuerposItem->articulo))
        
            echo '<thead><tr><th>Cantidad</th><th>Descripción</th><th>EAN</th><th>Troquel</th><th>Importe Unit</th><th>IVA</th><th>Nota Corrección</th></tr></thead><tbody>';
        
            else
         
            echo '<thead><tr><th>Cantidad</th><th>Descripción</th><th>Importe Unit</th><th>IVA</th><th>Nota Corrección</th></tr></thead><tbody>';
        }
        ?>
		<tr>
            <td class='colcenter'><?= $this->Number->format($notasCuerposItem['cantidad']) ?></td>
            <td><?= $notasCuerposItem->descripcion; ?></td>
            <?php
            if (!empty($notasCuerposItem->articulo))
            {
            echo '<td>'.$notasCuerposItem->articulo->codigo_barras.'</td>';
            echo '<td class=colcenter>'.$notasCuerposItem->articulo['troquel'].'</td>';
            }
            ?>
            <td class=colcenter>
            <?php	
            $precio_unitario = $notasCuerposItem['precio_unitario'];
            //$precio_total = $notasCuerposItem['precio_total'];
            //$precio_publico = $notasCuerposItem['precio_publico'];
            /*
            if  ($notasCuerposItem['descuento']>0)
            {
                $precio_unitario = $notasCuerposItem['precio_unitario'] - ($notasCuerposItem['precio_unitario']* $notasCuerposItem['descuento'] ) /100; 
                $precio_total = $precio_unitario * $notasCuerposItem->cantidad_facturada;
            }
      
            if ($notasCuerposItem['articulo']['categoria_id']==1 && $notasCuerposItem['iva'] &&  $notasCuerposItem['descuento']>0)
            {
                $precio_publico = $precio_publico *1.21;
            }
      

            
            if ($notasCuerposItem['descuento']>0) echo '% '.$notasCuerposItem['descuento']; else echo '0,00' */ ?>

			<?php	echo '$ '.number_format($precio_unitario,2,',','.');  ?></td>
            <td class="colcenter"><?php 
			if ($notasCuerposItem['iva']==1) { echo $this->Html->image('iva.png',['title' => 'IVA']); }
			?></td>
			<td class='colprecio'><?php	echo $notasCuerposItem['nota_correccion'];  ?></td>
			
              <?php $indice+=1;?>
        </tr>
	<?php endforeach; $indice+=2; ?>
   
    </tbody>
    </table>
</div>

  <script type="text/javascript">
	$("tr").not(':first').hover(
	function () {
		$(this).css("background","#8FA800");
		$(this).css("color","#000");
		$(this).css("font-weight","");
		}, 
	function () {
		$(this).css("background","");
		$(this).css("color","#464646");
		$(this).css("font-weight","");
		}
	);
</script>
<div class="facturasCuerposItems index large-10 medium-9 columns">
    <table class='tablasearch' cellpadding="0" cellspacing="0">
    <thead>
        <tr>
            <th><?= $this->Paginator->sort('cantidad_facturada','Cantidad') ?></th>
            <th><?= $this->Paginator->sort('descripcion','Descripción del Producto') ?></th>
            <th><?= $this->Paginator->sort('codigo_barra','EAN') ?></th>
            <th><?= $this->Paginator->sort('troquel','Troquel') ?></th>
            <th><?= $this->Paginator->sort('descuento','%Dto') ?></th>
            <th><?= $this->Paginator->sort('precio_publico','P.Púb') ?></th>
            <th><?= $this->Paginator->sort('precio_unitario' ,'P.c/Dto') ?></th>
            
			<th><?= $this->Paginator->sort('precio_total','P.Total') ?></th>
           <th><?= $this->Paginator->sort('iva',' ') ?></th>
        </tr>
    </thead>
    <tbody>
	<?php $indice=0;
    	$descuento_pf = $this->request->session()->read('Auth.User.pf_dcto');
        $condicion = $this->request->session()->read('Auth.User.condicion');
        $coef = $this->request->session()->read('Auth.User.coef');
        $condiciongeneral = (1-($descuento_pf * (1-$condicion/100)));
        $condiciongeneralmsd = 100*(1-($descuento_pf));
        $condiciongeneralcf = 100*(1-($descuento_pf *1.0248* (1-$condicion/100)));
        $condiciongeneralaz = 100*(1-($descuento_pf *0.892));
        $coef_pyf = $this->request->session()->read('Auth.User.coef_pyf');
    ?>  


    <?php foreach ($facturasCuerposItems as $facturasCuerposItem): ?>
        <?php $indice+=1;?>
		<tr>
            <td class='colcenter'><?= $this->Number->format($facturasCuerposItem->cantidad_facturada) ?></td>
            <td><?= $facturasCuerposItem->descripcion; ?></td>
            <td><?= $facturasCuerposItem->codigo_barra; ?></td>
            <td class='colcenter'><?= $facturasCuerposItem->troquel; ?></td>
            <td class='colcenter'>
            <?php	
            $precio_unitario = $facturasCuerposItem['precio_unitario'];
            $precio_total = $facturasCuerposItem['precio_total'];
            $precio_publico = $facturasCuerposItem['precio_publico'];
      
            if  ($facturasCuerposItem['descuento']>0)
            {
                $precio_unitario = $facturasCuerposItem['precio_unitario'] - ($facturasCuerposItem['precio_unitario']* $facturasCuerposItem['descuento'] ) /100; 
                $precio_total = $precio_unitario * $facturasCuerposItem->cantidad_facturada;
            }
      
            if ($facturasCuerposItem['articulo']['categoria_id']==1 && $facturasCuerposItem['iva'] &&  $facturasCuerposItem['descuento']>0)
            {
                $precio_publico = $precio_publico *1.21;
            }
            if ($this->request->session()->read('Auth.User.provincia_id') ==23)
                {
                    if ($facturasCuerposItem['descuento']>0)
                    {
                        $descuentoI = 1-$facturasCuerposItem['descuento']/100;
                        $precio_publico = $facturasCuerposItem['precio_publico'];
                    }
                    else
                    {
                    $descuentoI = $condiciongeneral;

                    $precio_publico = $facturasCuerposItem['precio_unitario']/(1 - $descuentoI);
                    }

                }

            
            if ($facturasCuerposItem['descuento']>0) echo '% '.$facturasCuerposItem['descuento']; else echo '0,00'  ?>
			</td>
			
            
            <td class='colprecio'><?php	
            
            if (($facturasCuerposItem['articulo']['categoria_id']==1) ||  ($facturasCuerposItem['articulo']['categoria_id']==6) ||  ($facturasCuerposItem['articulo']['categoria_id']==7))
            echo '$ '.number_format($precio_publico,2,',','.');  ?></td>
            
            <td class='colprecio'><?php	echo '$ '.number_format($precio_unitario,2,',','.');  ?></td>
			<td class='colprecio'><?php	echo '$ '.number_format($precio_total,2,',','.');  ?></td>
			<td class="colcenter"><?php 
			if ($facturasCuerposItem->iva==1) { echo $this->Html->image('iva.png',['title' => 'IVA']); }
			?></td>
            
        </tr>
	<?php endforeach; $indice+=2; ?>
   
    </tbody>
    </table>
   <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->prev('< ' . __('Anterior')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('Siguiente') . ' >',['tabindex'=>$indice]) ?>
			<div class="pagination_count"><span><?= $this->Paginator->counter('{{count}} Articulos') ?> </span></div>
        </ul>
    </div>
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
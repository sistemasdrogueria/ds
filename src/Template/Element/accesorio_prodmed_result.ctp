

<?php $indice=0; $cat = $categorias; $lab = $laboratorios; $titulolab=0; $preciot=""; $articulos2 = $articulos->toArray();?>
<?= $this->Form->create('Carritos',['url'=>['controller'=>'Carritos','action'=>'carritoaddall'],'id'=>'formaddcart','onsubmit'=>'return validaragregar()']); ?>
<div style="  margin:0;
      display: -webkit-box;
      display: -moz-box;
      display: -ms-flexbox;
      display: -webkit-flex;
      /*display: flow-root;*/
      justify-content: center;
      align-items: center;" >
<div class ="col-md-x" >
	<table class='tablasearch' cellpadding="0" cellspacing="0">
		<?php 
		$max2 = sizeof($articulos2);
		$max = (int)($max2/2);
		$first =0;
		$descuento_pf = $this->request->session()->read('Auth.User.pf_dcto');
		$condicion = $this->request->session()->read('Auth.User.condicion');
		//$coef = $this->request->session()->read('Auth.User.coef');
		//$condiciongeneral = 100*(1-($descuento_pf * (1-$condicion/100)));
		$condiciongeneral = 100*(1-($descuento_pf * (1-$condicion/100)));
		for($i = 0; $i < $max;$i++)
		{
			$articulo =  $articulos2[$i];
			if ($articulo['laboratorio_id']!= $titulolab || $first ==0 || $preciot != $articulo['descuentos'][0]['tipo_precio'])
			{
					if ($first !=0)
						echo '<tr><td colspan="6" style =" text-align: center; background: #fff";></td></tr>';
					$first =1;
					$titulolab = $articulo['laboratorio_id'];
					$preciot= $articulo['descuentos'][0]['tipo_precio'];
					
					echo '<tr><td colspan="6" align="center" style =" text-align: center; background: #ebebeb; font-weight: bold;">'.$lab[$articulo['laboratorio_id']].'</td></tr>';
					echo '<tr><th>Cant.</th><th>'. $this->Paginator->sort('stock') .'</th>
				  	<th>'. $this->Paginator->sort('descripcion_pag','Descripción').'</th>
					<th>';
					if ($articulo['descuentos'] !=null)	
					if ($articulo['descuentos'][0]['tipo_precio']=='P')
						echo 'P.S.P.';
					else
						echo 'P.F.';
					echo '</th><th>Plazo</th><th>U.Min</th></tr>';
			}	?>
		<tbody>
		<tr>
			<?php $encabezado = $indice.'.';	$indice=$i+1;	?>
			<td class='formcartcanttd' >
				<?php
				if ($articulo['carritos'] !=null )
				{
					$cantidadencarrito = $articulo['carritos'][0]['cantidad'];
					echo $this->Form->input($encabezado.'cantidad',['tabindex'=>$indice,'value' =>$cantidadencarrito ,'class'=>'formcartcant','target'=>'_blank','onchange'=>'javascript:document.confirmInput.submit();','onkeydown'=>'if(event.keyCode==13) event.keyCode=9;','autocomplete'=>'off', 'style'=>'padding: 1px 1px; width:35px;']);
				}
				else	
				{
					echo $this->Form->input($encabezado.'cantidad',['tabindex'=>$indice,'class'=>'formcartcant','target'=>'_blank',  'onchange'=>'javascript:document.confirmInput.submit();','onkeydown'=>'if(event.keyCode==13) event.keyCode=9;', 'autocomplete'=>'off' , 'style'=>'padding: 1px 1px; width:35px;']);
				}		
				echo $this->Form->input($encabezado.'articulo_id',['type'=>'hidden','value'=>$articulo['id']]);
				echo $this->Form->input($encabezado.'categoria_id',['type'=>'hidden','value'=>$articulo['categoria_id']]);	
				echo $this->Form->input($encabezado.'precio_publico',['type'=>'hidden','value'=>$articulo['precio_publico']]);
				echo $this->Form->input($encabezado.'descripcion',['type'=>'hidden','value'=>$articulo['descripcion_pag']]);
				echo $this->Form->input($encabezado.'compra_min',['type'=>'hidden','value'=>$articulo['compra_min']]);
				echo $this->Form->input($encabezado.'compra_multiplo',['type'=>'hidden','value'=>$articulo['compra_multiplo']]);
				echo $this->Form->input($encabezado.'compra_max',['type'=>'hidden','value'=>$articulo['compra_max']]);
				
				if ($articulo['descuentos'] !=null and $articulo['stock']!='F'){	
					if ($articulo['descuentos'][0]['tipo_venta']=='D')
					{
						if ($articulo['descuentos'][0]['tipo_oferta']!='TH')
						{
							echo $this->Form->input($encabezado.'descuento',['type'=>'hidden','value'=>$articulo['descuentos'][0]['dto_drogueria']]); 	
						}
						else
						{
							$descuento_off=$articulo['descuentos'][0]['dto_drogueria']+$condiciongeneral;
							echo $this->Form->input($encabezado.'descuento',['type'=>'hidden','value'=>$descuento_off]); 	
						}		

					//echo $this->Form->input($encabezado.'descuento',['type'=>'hidden','value'=>$articulo['descuentos'][0]['dto_drogueria']]); 	
					echo $this->Form->input($encabezado.'plazoley_dcto',['type'=>'hidden','value'=>$articulo['descuentos'][0]['plazo']]); 	
					echo $this->Form->input($encabezado.'unidad_minima',['type'=>'hidden','value'=>$articulo['descuentos'][0]['uni_min']]); 	
					echo $this->Form->input($encabezado.'tipo_oferta',['type'=>'hidden','value'=>$articulo['descuentos'][0]['tipo_oferta']]); 
					echo $this->Form->input($encabezado.'tipo_venta',['type'=>'hidden','value'=>$articulo['descuentos'][0]['tipo_venta']]); 
					echo $this->Form->input($encabezado.'tipo_precio',['type'=>'hidden','value'=>$articulo['descuentos'][0]['tipo_precio']]); 
					}
					else
					{
							echo $this->Form->input($encabezado.'descuento',['type'=>'hidden','value'=>0]); 	
							echo $this->Form->input($encabezado.'plazoley_dcto',['type'=>'hidden','value'=>'HABITUAL']); 	
							echo $this->Form->input($encabezado.'unidad_minima',['type'=>'hidden','value'=>null]); 	
							echo $this->Form->input($encabezado.'tipo_oferta',['type'=>'hidden','value'=>null]); 
							echo $this->Form->input($encabezado.'tipo_venta',['type'=>'hidden','value'=>null]); 
							echo $this->Form->input($encabezado.'tipo_precio',['type'=>'hidden','value'=>null]); 
					}
				}
				else
				{			
					echo $this->Form->input($encabezado.'descuento',['type'=>'hidden','value'=>0]); 	
					echo $this->Form->input($encabezado.'plazoley_dcto',['type'=>'hidden','value'=>'HABITUAL']); 	
					echo $this->Form->input($encabezado.'unidad_minima',['type'=>'hidden','value'=>null]); 	
					echo $this->Form->input($encabezado.'tipo_oferta',['type'=>'hidden','value'=>null]); 
					echo $this->Form->input($encabezado.'tipo_venta',['type'=>'hidden','value'=>null]); 
					echo $this->Form->input($encabezado.'tipo_precio',['type'=>'hidden','value'=>null]); 
				}
				?>
			</td>
			<td class='colstock'><?php
				switch ($articulo['stock']) {
					case 'B':
						echo $this->Html->image('bajo.png',['title' => 'Stock Bajo, Consultar Operadora'] );
						break;
					case 'F':
						echo $this->Html->image('falta.png',['title' => 'Producto en Falta']);
						break;
					case 'S':
						echo $this->Html->image('alto.png',['title' => 'Stock Habitual']);
						break;
					case 'R':
						echo $this->Html->image('restrin.png',['title' => 'Producto sujeto a stock']);
						break;
					case 'D':
						echo $this->Html->image('descont.png',['title' => 'Producto Discontinuo']);
						break;
				}?>
			</td>
            <td class='masinfoband'>
				<div 
					onmouseover="showdiv(event,'<?php 
					echo str_replace('"', '', $articulo['descripcion_pag']).'</br>'; 
					echo 'Laboratorio: '.$lab[$articulo['laboratorio_id']].'</br>';
					echo 'Categoría: '.$cat[$articulo['categoria_id']].'</br>';
					echo 'Troquel: '.$articulo['troquel'].'</br>';
					echo 'EAN: '.$articulo['codigo_barras'].'</br>';
					if ($articulo['descuentos'] !=null && $articulo['stock']!='F')
					{
						if ($articulo['descuentos'][0]['tipo_venta']=='D')
						{
							echo 'Oferta: '.$articulo['descuentos'][0]['dto_drogueria'].'% por '.$articulo['descuentos'][0]['uni_min'].'unidad(es)</br>';
							echo 'Plazo: '. $articulo['descuentos'][0]['plazo'].'</br>';
							echo 'Tipo de oferta: '. $articulo['descuentos'][0]['tipo_oferta'].'</br>';
						}
						else
						if (count($articulo['descuentos'])>1)
						{
							if ($articulo['descuentos'][1]['tipo_venta']=='D')
							{
								echo 'Oferta: '.$articulo['descuentos'][1]['dto_drogueria'].'% por '.$articulo['descuentos'][1]['uni_min'].'unidad(es)</br>';
								echo 'Plazo: '. $articulo['descuentos'][1]['plazo'].'</br>';
								echo 'Tipo de oferta: '. $articulo['descuentos'][1]['tipo_oferta'].'</br>';
							}
						}
					}
					?>
					','<?php echo $articulo['iva'];?>'
					,'<?php echo $articulo['trazable'];?>'
					,'<?php echo $articulo['cadena_frio'];?>'
					,'<?php echo $articulo['categoria_id'];?>'
					,'<?php echo $articulo['pack'];?>'
					,'<?php echo $articulo['fv_cerca'];?>'
					,'<?php echo $articulo['fv'];?>'
					
					,'<?php echo $articulo['imagen'];?>'
					);"	
					
					onMouseOut='hiddenDiv()' 
					style='display:table;'>
					<?php 
						echo $articulo['descripcion_pag']; 
						if ($articulo['compra_min']>1)
						{echo ' (Vta.Min. '.$articulo['compra_min'],')';}
						if ($articulo['compra_multiplo']>1)
						{echo ' (Multiplo. '.$articulo['compra_multiplo'],')';}
						if ($articulo['fv_cerca']==1) { echo $this->Html->image('fv.png',['title' => 'Vencimiento Cercano']);	}
					if ($articulo['pack'] !=null){
					echo ' <font color="red" >PACK</font>';
					}
					?>	
				</div>				

			</td>
			<td class="td-sub-tabla">
				<?php 
					if ($articulo['descuentos'][0]['tipo_venta']=='D' )	
					{
						if ($articulo['descuentos'][0]['tipo_precio']=='P')
						if ($articulo['descuentos'][0]['tipo_oferta']!='TH')
						echo ' <font color="red" style="font-weight: bold;">'.$articulo['descuentos'][0]['dto_drogueria'].'% '.'</font>'; 
						else {
							echo ' <font color="red" style="font-weight: bold;">'.number_format(round($articulo['descuentos'][0]['dto_drogueria']+$condiciongeneral, 3),2,',','.').'% '.'</font>'; 
				
						}	
						//	echo ' <font color="red" style="font-weight: bold;">'.$articulo['descuentos'][0]['dto_drogueria'].'% '.'</font>'; 
						else
						{
							if ($articulo['iva']==0)
							{$condiciongeneralfinal = 100*(1-($descuento_pf * (1-$condicion/100)*(1-$articulo['descuentos'][0]['dto_drogueria']/100)));
							echo ' <font color="red" style="font-weight: bold;">';
							echo number_format(round($condiciongeneralfinal, 3),2,',','.'). '% </font>'; }
							else
							echo ' <font color="red" style="font-weight: bold;">'.$articulo['descuentos'][0]['dto_drogueria'].'% '.'</font>'; 

						}
						//echo ' <font color="red" style="font-weight: bold;">'.$articulo['descuentos'][0]['dto_drogueria'].'% '.'</font>'; 
					}
					else
					if (count($articulo['descuentos'])>1)
						if ($articulo['descuentos'][1]['tipo_venta']=='D')	
						if ($articulo['descuentos'][1]['tipo_precio']=='P')
						if ($articulo['descuentos'][1]['tipo_oferta']!='TH')
							echo ' <font color="red" style="font-weight: bold;">'.$articulo['descuentos'][1]['dto_drogueria'].'% '.'</font>'; 
							else {
								echo ' <font color="red" style="font-weight: bold;">'.number_format(round($articulo['descuentos'][1]['dto_drogueria']+$condiciongeneral, 3),2,',','.').'% '.'</font>'; 
					
							}	

							//echo ' <font color="red" style="font-weight: bold;">'.$articulo['descuentos'][1]['dto_drogueria'].'% '.'</font>'; 
						else
						{
							if ($articulo['iva']==0)
							{$condiciongeneralfinal = 100*(1-($descuento_pf * (1-$condicion/100)*(1-$articulo['descuentos'][1]['dto_drogueria']/100)));
							echo ' <font color="red" style="font-weight: bold;">';
							echo number_format(round($condiciongeneralfinal, 3),2,',','.'). '% </font>'; }
							else
							echo ' <font color="red" style="font-weight: bold;">'.$articulo['descuentos'][1]['dto_drogueria'].'% '.'</font>'; 

						}
						
				?>
			</td>
			<td class="td-sub-tabla">
			<?php 
				
				if ($articulo['descuentos'][0]['tipo_venta']=='D')
				{
					 $plazo =$articulo['descuentos'][0]['plazo'];
					 $plazo = str_replace("HABITUAL","HAB",$plazo );
					 
					 $plazo = str_replace("030","30",$plazo);
					 $plazo = str_replace("045","45",$plazo);
					 $plazo = str_replace("060","60",$plazo);
					 $plazo = str_replace("075","75",$plazo);
					 echo $plazo;
				}
				else
				if (count($articulo['descuentos'])>1)
				if ($articulo['descuentos'][1]['tipo_venta']=='D')
				
				{
					//echo $articulo['descuentos'][1]['plazo'];
					$plazo =$articulo['descuentos'][1]['plazo'];
					$plazo = str_replace("HABITUAL","HAB",$plazo );
					
					$plazo = str_replace("030","30",$plazo);
					$plazo = str_replace("045","45",$plazo);
					$plazo = str_replace("060","60",$plazo);
					$plazo = str_replace("075","75",$plazo);
		
				}
				/*
					if ($articulo['descuentos'][0]['tipo_venta']=='D')
					echo $articulo['descuentos'][0]['plazo'];
				else
					if (count($articulo['descuentos'])>1)
					if ($articulo['descuentos'][1]['tipo_venta']=='D')
					echo $articulo['descuentos'][1]['plazo'];
				*/
			?>
			</td>
			<td class="td-sub-tabla">
			<?php 
				
				if ($articulo['descuentos'][0]['tipo_venta']=='D')
					echo $articulo['descuentos'][0]['uni_min'];
				else
					if (count($articulo['descuentos'])>1)
					if ($articulo['descuentos'][1]['tipo_venta']=='D')
					echo $articulo['descuentos'][1]['uni_min'];
				
			?>
			</td>
        </tr>		
		<?php }	?>
		</tbody>
	</table>
</div>
	
<div class ="col-md-x" >
	<table class='tablasearch' cellpadding="0" cellspacing="0">	
		
		<?php 
		$first=0;
		$preciot="";
		for($i = $max; $i < $max2;$i++)
		{
			$articulo =  $articulos2[$i];
		
		if ($articulo['laboratorio_id']!= $titulolab || $first ==0 || $preciot != $articulo['descuentos'][0]['tipo_precio'])
		{
				if ($first !=0)
					echo '<tr><td colspan="6" style =" text-align: center; background: #fff";></td></tr>';
				$first =1;
				$titulolab = $articulo['laboratorio_id'];
				$preciot= $articulo['descuentos'][0]['tipo_precio'];
				echo '<tr><td colspan="6" align="center" style =" text-align: center; background: #ebebeb; font-weight: bold;">'.$lab[$articulo['laboratorio_id']].'</td></tr>';
				echo '<tr><th>Cant.</th><th>'. $this->Paginator->sort('stock') .'</th>
				<th>'. $this->Paginator->sort('descripcion_pag','Descripción').'</th>
				<th>';
				if ($articulo['descuentos'] !=null)	
				if ($articulo['descuentos'][0]['tipo_precio']=='P')
					echo 'P.S.P.';
				else
					echo 'P.F.';
				echo '</th><th>Plazo</th><th>U.Min</th></tr>';
		} ?>
		<tbody>
		<tr>
			<?php $encabezado = $indice.'.';	$indice=$i+1;	?>
			<td class='formcartcanttd'>
				<?php
				if ($articulo['carritos'] !=null )
				{
					$cantidadencarrito = $articulo['carritos'][0]['cantidad'];
					echo $this->Form->input($encabezado.'cantidad',['tabindex'=>$indice,'value' =>$cantidadencarrito ,'class'=>'formcartcant','target'=>'_blank','onchange'=>'javascript:document.confirmInput.submit();','onkeydown'=>'if(event.keyCode==13) event.keyCode=9;','autocomplete'=>'off','style'=>'padding: 1px 1px; width:35px;']);
				}
				else	
				{
					echo $this->Form->input($encabezado.'cantidad',['tabindex'=>$indice,'class'=>'formcartcant','target'=>'_blank',  'onchange'=>'javascript:document.confirmInput.submit();','onkeydown'=>'if(event.keyCode==13) event.keyCode=9;', 'autocomplete'=>'off','style'=>'padding: 1px 1px; width:35px;']);
				}		
				echo $this->Form->input($encabezado.'articulo_id',['type'=>'hidden','value'=>$articulo['id']]);
				echo $this->Form->input($encabezado.'categoria_id',['type'=>'hidden','value'=>$articulo['categoria_id']]);	
				echo $this->Form->input($encabezado.'precio_publico',['type'=>'hidden','value'=>$articulo['precio_publico']]);
				echo $this->Form->input($encabezado.'descripcion',['type'=>'hidden','value'=>$articulo['descripcion_pag']]);
				echo $this->Form->input($encabezado.'compra_min',['type'=>'hidden','value'=>$articulo['compra_min']]);
				echo $this->Form->input($encabezado.'compra_multiplo',['type'=>'hidden','value'=>$articulo['compra_multiplo']]);
					echo $this->Form->input($encabezado.'compra_max',['type'=>'hidden','value'=>$articulo['compra_max']]);
				if ($articulo['descuentos'] !=null and $articulo['stock']!='F'){	
					if ($articulo['descuentos'][0]['tipo_venta']=='D')
					{
						if ($articulo['descuentos'][0]['tipo_oferta']!='TH')
						{
							echo $this->Form->input($encabezado.'descuento',['type'=>'hidden','value'=>$articulo['descuentos'][0]['dto_drogueria']]); 	
						}
						else
						{
							$descuento_off=$articulo['descuentos'][0]['dto_drogueria']+$condiciongeneral;
							echo $this->Form->input($encabezado.'descuento',['type'=>'hidden','value'=>$descuento_off]); 	
						}

					//echo $this->Form->input($encabezado.'descuento',['type'=>'hidden','value'=>$articulo['descuentos'][0]['dto_drogueria']]); 	
					echo $this->Form->input($encabezado.'plazoley_dcto',['type'=>'hidden','value'=>$articulo['descuentos'][0]['plazo']]); 	
					echo $this->Form->input($encabezado.'unidad_minima',['type'=>'hidden','value'=>$articulo['descuentos'][0]['uni_min']]); 	
					echo $this->Form->input($encabezado.'tipo_oferta',['type'=>'hidden','value'=>$articulo['descuentos'][0]['tipo_oferta']]); 
					echo $this->Form->input($encabezado.'tipo_venta',['type'=>'hidden','value'=>$articulo['descuentos'][0]['tipo_venta']]); 
					echo $this->Form->input($encabezado.'tipo_precio',['type'=>'hidden','value'=>$articulo['descuentos'][0]['tipo_precio']]); 
					}
					else
					{
							echo $this->Form->input($encabezado.'descuento',['type'=>'hidden','value'=>0]); 	
							echo $this->Form->input($encabezado.'plazoley_dcto',['type'=>'hidden','value'=>'HABITUAL']); 	
							echo $this->Form->input($encabezado.'unidad_minima',['type'=>'hidden','value'=>null]); 	
							echo $this->Form->input($encabezado.'tipo_oferta',['type'=>'hidden','value'=>null]); 
							echo $this->Form->input($encabezado.'tipo_venta',['type'=>'hidden','value'=>null]); 
							echo $this->Form->input($encabezado.'tipo_precio',['type'=>'hidden','value'=>null]); 
					}
				}
				else
				{			
					echo $this->Form->input($encabezado.'descuento',['type'=>'hidden','value'=>0]); 	
					echo $this->Form->input($encabezado.'plazoley_dcto',['type'=>'hidden','value'=>'HABITUAL']); 	
					echo $this->Form->input($encabezado.'unidad_minima',['type'=>'hidden','value'=>null]); 	
					echo $this->Form->input($encabezado.'tipo_oferta',['type'=>'hidden','value'=>null]); 
					echo $this->Form->input($encabezado.'tipo_venta',['type'=>'hidden','value'=>null]); 
					echo $this->Form->input($encabezado.'tipo_precio',['type'=>'hidden','value'=>null]); 
				}
				?>
			</td>
			<td class='colstock'><?php
				switch ($articulo['stock']) {
					case 'B':
						echo $this->Html->image('bajo.png',['title' => 'Stock Bajo, Consultar Operadora'] );
						break;
					case 'F':
						echo $this->Html->image('falta.png',['title' => 'Producto en Falta']);
						break;
					case 'S':
						echo $this->Html->image('alto.png',['title' => 'Stock Habitual']);
						break;
					case 'R':
						echo $this->Html->image('restrin.png',['title' => 'Producto sujeto a stock']);
						break;
					case 'D':
						echo $this->Html->image('descont.png',['title' => 'Producto Discontinuo']);
						break;
				}	?>
			</td>
            <td class='masinfoband'>
				<div 
					onmouseover="showdiv(event,'<?php 
					echo str_replace('"', '', $articulo['descripcion_pag']).'</br>'; 
					echo 'Laboratorio: '.$lab[$articulo['laboratorio_id']].'</br>';
					echo 'Categoría: '.$cat[$articulo['categoria_id']].'</br>';
					echo 'Troquel: '.$articulo['troquel'].'</br>';
					echo 'EAN: '.$articulo['codigo_barras'].'</br>';
					if ($articulo['descuentos'] !=null && $articulo['stock']!='F')
					{
						if ($articulo['descuentos'][0]['tipo_venta']=='D')
						{
							echo 'Oferta: '.$articulo['descuentos'][0]['dto_drogueria'].'% por '.$articulo['descuentos'][0]['uni_min'].'unidad(es)</br>';
							echo 'Plazo: '. $articulo['descuentos'][0]['plazo'].'</br>';
							echo 'Tipo de oferta: '. $articulo['descuentos'][0]['tipo_oferta'].'</br>';
						}
						else
						if (count($articulo['descuentos'])>1)
						{
							if ($articulo['descuentos'][1]['tipo_venta']=='D')
							{
								echo 'Oferta: '.$articulo['descuentos'][1]['dto_drogueria'].'% por '.$articulo['descuentos'][1]['uni_min'].'unidad(es)</br>';
								echo 'Plazo: '. $articulo['descuentos'][1]['plazo'].'</br>';
								echo 'Tipo de oferta: '. $articulo['descuentos'][1]['tipo_oferta'].'</br>';
							}
						}
					}
					?>
					','<?php echo $articulo['iva'];?>'
					,'<?php echo $articulo['trazable'];?>'
					,'<?php echo $articulo['cadena_frio'];?>'
					,'<?php echo $articulo['categoria_id'];?>'
					,'<?php echo $articulo['pack'];?>'
					,'<?php echo $articulo['fv_cerca'];?>'
					,'<?php echo $articulo['fv'];?>'
					
					,'<?php echo $articulo['imagen'];?>'
					);"	
					
					onMouseOut='hiddenDiv()' 
					style='display:table;'>
					<?php 
						echo $articulo['descripcion_pag']; 
						if ($articulo['compra_min']>1)
						{echo ' (Vta.Min. '.$articulo['compra_min'],')';}
						if ($articulo['compra_multiplo']>1)
						{echo ' (Multiplo. '.$articulo['compra_multiplo'],')';}
						if ($articulo['fv_cerca']==1) { echo $this->Html->image('fv.png',['title' => 'Vencimiento Cercano']);	}
					if ($articulo['pack'] !=null){
					echo ' <font color="red" >PACK</font>';
					}
					?>	
				</div>				

			</td>
			<td class="td-sub-tabla">
				<?php 
					if ($articulo['descuentos'][0]['tipo_venta']=='D' )	
					{
						if ($articulo['descuentos'][0]['tipo_precio']=='P')
						if ($articulo['descuentos'][0]['tipo_oferta']!='TH')
						echo ' <font color="red" style="font-weight: bold;">'.$articulo['descuentos'][0]['dto_drogueria'].'% '.'</font>'; 
					else {
						echo ' <font color="red" style="font-weight: bold;">'.number_format(round($articulo['descuentos'][0]['dto_drogueria']+$condiciongeneral, 3),2,',','.').'% '.'</font>'; 
			
					}	

							//echo ' <font color="red" style="font-weight: bold;">'.$articulo['descuentos'][0]['dto_drogueria'].'% '.'</font>'; 
						else
						{
							if ($articulo['iva']==0)
							{$condiciongeneralfinal = 100*(1-($descuento_pf * (1-$condicion/100)*(1-$articulo['descuentos'][0]['dto_drogueria']/100)));
							echo ' <font color="red" style="font-weight: bold;">';
							echo number_format(round($condiciongeneralfinal, 3),2,',','.'). '% </font>'; }
							else
							echo ' <font color="red" style="font-weight: bold;">'.$articulo['descuentos'][0]['dto_drogueria'].'% '.'</font>'; 

						}
						//echo ' <font color="red" style="font-weight: bold;">'.$articulo['descuentos'][0]['dto_drogueria'].'% '.'</font>'; 
					}
					else
					if (count($articulo['descuentos'])>1)
						if ($articulo['descuentos'][1]['tipo_venta']=='D')	
						if ($articulo['descuentos'][1]['tipo_precio']=='P')
						if ($articulo['descuentos'][1]['tipo_oferta']!='TH')
						echo ' <font color="red" style="font-weight: bold;">'.$articulo['descuentos'][1]['dto_drogueria'].'% '.'</font>'; 
					else {
						echo ' <font color="red" style="font-weight: bold;">'.number_format(round($articulo['descuentos'][0]['dto_drogueria']+$condiciongeneral, 3),2,',','.').'% '.'</font>'; 
			
					}	
							//echo ' <font color="red" style="font-weight: bold;">'.$articulo['descuentos'][1]['dto_drogueria'].'% '.'</font>'; 
						else
						{
							if ($articulo['iva']==0)
							{$condiciongeneralfinal = 100*(1-($descuento_pf * (1-$condicion/100)*(1-$articulo['descuentos'][1]['dto_drogueria']/100)));
							echo ' <font color="red" style="font-weight: bold;">';
							echo number_format(round($condiciongeneralfinal, 3),2,',','.'). '% </font>'; }
							else
							echo ' <font color="red" style="font-weight: bold;">'.$articulo['descuentos'][1]['dto_drogueria'].'% '.'</font>'; 

						}		
						
						//echo ' <font color="red" style="font-weight: bold;">'.$articulo['descuentos'][1]['dto_drogueria'].'% '.'</font>'; 
						
				?>
			</td>
			<td class="td-sub-tabla">
				<?php 
					if ($articulo['descuentos'][0]['tipo_venta']=='D')
					{
					     $plazo =$articulo['descuentos'][0]['plazo'];
						 $plazo = str_replace("HABITUAL","HAB",$plazo );
						 
						 $plazo = str_replace("030","30",$plazo);
						 $plazo = str_replace("045","45",$plazo);
						 $plazo = str_replace("060","60",$plazo);
						 $plazo = str_replace("075","75",$plazo);
						 echo $plazo;
					}
					else
					if (count($articulo['descuentos'])>1)
					if ($articulo['descuentos'][1]['tipo_venta']=='D')
					
					{
						//echo $articulo['descuentos'][1]['plazo'];
						$plazo =$articulo['descuentos'][1]['plazo'];
						$plazo = str_replace("HABITUAL","HAB",$plazo );
						
						$plazo = str_replace("030","30",$plazo);
						$plazo = str_replace("045","45",$plazo);
						$plazo = str_replace("060","60",$plazo);
						$plazo = str_replace("075","75",$plazo);
			
					}			
				?>
			</td>
			<td class="td-sub-tabla">
				<?php 
				if ($articulo['descuentos'][0]['tipo_venta']=='D')
					echo $articulo['descuentos'][0]['uni_min'];
				else
					if (count($articulo['descuentos'])>1)
					if ($articulo['descuentos'][1]['tipo_venta']=='D')
					echo $articulo['descuentos'][1]['uni_min'];
				?>
			</td>
        </tr>

		<?php	}	?>
		</tbody>
	</table>
</div>

</div>


<div 
style="  margin:0;
      display: -webkit-box;
      display: -moz-box;
      display: -ms-flexbox;
      display: -webkit-flex;
      display: flex;
      justify-content: center;
      align-items: center;">
<div class ="col-md-12" > 
<div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->prev('< ' . __('Anterior')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('Siguiente') . ' >',['tabindex'=>$indice]) ?>
			<div class="pagination_count"><span><?= $this->Paginator->counter('{{count}} Articulos') ?> </span></div>
        </ul>
		<div class="importconfirm2">	
		<div class="button-holder5">
			<?php echo $this->Form->submit('Agregar Seleccionados',['class'=>'btn_agregarvarios']);?>	
		 </div>	
	   </div>	
	    <?= $this->Form->end() ?>	
</div>
</div>
</div>


<div id="flotante"></div>


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
/**
* Funcion que muestra el div en la posicion del mouse
*/
function showdiv(event,text,iva,traza,frio,categ,pack,fv_cerca,fv,ean)
{
//determina un margen de pixels del div al raton
margin=0;
//La variable IE determina si estamos utilizando IE
var IE = document.all?true:false;
var tempX = 0;
var tempY = 0;
//document.body.clientHeight = devuelve la altura del body
if(IE)
{ //para IE
IE6=navigator.userAgent.toLowerCase().indexOf('msie 6');
IE7=navigator.userAgent.toLowerCase().indexOf('msie 7');
//event.y|event.clientY = devuelve la posicion en relacion a la parte superior visible del navegador
//event.screenY = devuelve la posicion del cursor en relaciona la parte superior de la pantalla
//event.offsetY = devuelve la posicion del mouse en relacion a la posicion superior de la caja donde se ha pulsado
if(IE6>0 || IE7>0)
{
tempX = event.x
tempY = event.y
if(window.pageYOffset){
tempY=(tempY+window.pageYOffset);
tempX=(tempX+window.pageXOffset);
}else{
tempY=(tempY+Math.max(document.body.scrollTop,document.documentElement.scrollTop));
tempX=(tempX+Math.max(document.body.scrollLeft,document.documentElement.scrollLeft));
}
}else{
//IE8
tempX = event.x
tempY = event.y
}
}else{ //para netscape
//window.pageYOffset = devuelve el tamaño en pixels de la parte superior no visible (scroll) de la pagina
//document.captureEvents(Event);
tempX = event.pageX;
tempY = event.pageY;
}
if (tempX < 0){tempX = 0;}
if (tempY < 0){tempY = 0;}
// Modificamos el contenido de la capa  
var trazaimg='';
var cadenaimg='';
var psiimg='';
var valeoficialimg='';
var ivaimg='';
var fvimg='';
var fvcerca ='';
if (iva==1)
{
ivaimg = '<?php echo $this->Html->image('iva.png',['title' => 'IVA']);?>';
}
if (traza==1)
{
trazaimg = '<?php echo $this->Html->image('trazable.png',['title' => 'Trazable']);?>';
}
if (frio==1)
{
cadenaimg = '<?php echo $this->Html->image('cadenafrio.png',['title' => 'Cadena de Frio']);?>';
}
if (categ==7)
{
valeoficialimg = '<?php echo $this->Html->image('valeoficial.png',['title' => 'Vale Oficial']);?>';
}	 
if (categ==6)
{
psiimg = '<?php echo $this->Html->image('psi.png',['title' => 'Psicotropicos']);?>';
}	 
if (pack==1) 
{
psiimg = '<?php echo $this->Html->image('pack.png',['title' => 'Pack']);?>';
}	
if (fv_cerca==1) 
{ 
fvimg = '<?php echo $this->Html->image('fv.png',['title' => 'Vencimiento Cercano']);?>';
fvcerca= 'Vencimiento: ';
fvcerca= fvcerca.concat(fv);			 
}			
eanimg ='<img src="https://www.drogueriasur.com.ar/ds/webroot/img/productos/'+ean+'" alt="'+ean+'" width="200px">';
document.getElementById('flotante').innerHTML="<div id='flotante_text'>"+text+ivaimg+trazaimg+cadenaimg+psiimg+valeoficialimg+fvimg+fvcerca+"</div><div id='flotante_img'>"+eanimg+"</div>";
// Posicionamos la capa flotante
document.getElementById('flotante').style.top = (tempY-120)+"px";
document.getElementById('flotante').style.left = (tempX-10)+"px";
document.getElementById('flotante').style.display='block';
//document.getElementById('flotante_img').appendChild(eanimg);
return;
}
/**
* Funcion para esconder el div
*/
function hiddenDiv()
{
document.getElementById('flotante').style.display='none';
}

function myFunction() {
/*document.confirmInput.submit();*/
document.getElementById("formaddcart").submit();
}
</script>
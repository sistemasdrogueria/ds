<div class="articulos index large-10 medium-9 columns">
    <table class='tablesorter' cellpadding="0" cellspacing="0">
    <thead>
        <tr>	
			
			<th><?= $this->Paginator->sort('stock') ?></th>
            <th><?= $this->Paginator->sort('descripcion_pag','Descripción') ?></th>
            <th><?= $this->Paginator->sort('precio_publico','P.Farmacia') ?></th>
			<th><?= $this->Paginator->sort('precio_publico','P.Publico') ?></th>
           <th><div id="th-sub-tabla">Dto</div></td>
			<th><div id="th-sub-tabla">U.Min</div></td>
			<th><div id="th-sub-tabla">Plazo</div></td>
			<th><div id="th-sub-tabla">Tipo Of.</div></td>
			
			<th>Ref.</th>
			<th></th>
		</tr>

    </thead>
    <tbody>
	<div id="flotante"></div>
    <?php $indice=0;?>
	<?php //<div class='coldescripcion'></div> 
				
				 $cat = $categorias;
				 $lab = $laboratorios; 
				?>
	<?php foreach ($articulos as $articulo): ?>
       <?= $this->Form->create('Ofertas',['url'=>['controller'=>'Ofertas','action'=>'add_admin_search'],'id'=>'formaddcart','onsubmit'=>'return validaragregar()']); ?>
		
		<tr onchange="javascript:document.confirmInput.submit();">
		<?php $indice+=1;?>
			
				<?php
				
				echo $this->Form->input('articulo_id',['type'=>'hidden','value'=>$articulo['id']]);
				echo $this->Form->input('precio_publico',['type'=>'hidden','value'=>$articulo['precio_publico']]);
				echo $this->Form->input('descripcion',['type'=>'hidden','value'=>$articulo['descripcion_pag']]);
				
				if ($articulo['descuentos'] !=null and $articulo['stock']!='F'){	
					if ($articulo['descuentos'][0]['tipo_venta']=='D')
					{
					echo $this->Form->input('descuento',['type'=>'hidden','value'=>$articulo['descuentos'][0]['dto_drogueria']]); 	
					echo $this->Form->input('plazoley_dcto',['type'=>'hidden','value'=>$articulo['descuentos'][0]['plazo']]); 	
					echo $this->Form->input('unidad_minima',['type'=>'hidden','value'=>$articulo['descuentos'][0]['uni_min']]); 	
					echo $this->Form->input('tipo_oferta',['type'=>'hidden','value'=>$articulo['descuentos'][0]['tipo_oferta']]); 
					echo $this->Form->input('tipo_venta',['type'=>'hidden','value'=>$articulo['descuentos'][0]['tipo_venta']]); 
					echo $this->Form->input('tipo_precio',['type'=>'hidden','value'=>$articulo['descuentos'][0]['tipo_precio']]); 
					}
					else
					{
						if (count($articulo['descuentos'])>1)
						{
						if ($articulo['descuentos'][0]['tipo_venta']=='D')
						{
							echo $this->Form->input('descuento',['type'=>'hidden','value'=>$articulo['descuentos'][1]['dto_drogueria']]); 	
							echo $this->Form->input('plazoley_dcto',['type'=>'hidden','value'=>$articulo['descuentos'][1]['plazo']]); 	
							echo $this->Form->input('unidad_minima',['type'=>'hidden','value'=>$articulo['descuentos'][1]['uni_min']]); 	
							echo $this->Form->input('tipo_oferta',['type'=>'hidden','value'=>$articulo['descuentos'][1]['tipo_oferta']]); 
							echo $this->Form->input('tipo_venta',['type'=>'hidden','value'=>$articulo['descuentos'][1]['tipo_venta']]); 
							echo $this->Form->input('tipo_precio',['type'=>'hidden','value'=>$articulo['descuentos'][1]['tipo_precio']]); 
					
						}
						else
						{
							echo $this->Form->input('descuento',['type'=>'hidden','value'=>null]); 	
							echo $this->Form->input('plazoley_dcto',['type'=>'hidden','value'=>null]); 	
							echo $this->Form->input('unidad_minima',['type'=>'hidden','value'=>null]); 	
							echo $this->Form->input('tipo_oferta',['type'=>'hidden','value'=>null]); 
							echo $this->Form->input('tipo_venta',['type'=>'hidden','value'=>null]); 
							echo $this->Form->input('tipo_precio',['type'=>'hidden','value'=>null]); 
						}
						}
						else
						{
							echo $this->Form->input('descuento',['type'=>'hidden','value'=>null]); 	
							echo $this->Form->input('plazoley_dcto',['type'=>'hidden','value'=>null]); 	
							echo $this->Form->input('unidad_minima',['type'=>'hidden','value'=>null]); 	
							echo $this->Form->input('tipo_oferta',['type'=>'hidden','value'=>null]); 
							echo $this->Form->input('tipo_venta',['type'=>'hidden','value'=>null]); 
							echo $this->Form->input('tipo_precio',['type'=>'hidden','value'=>null]); 
							
						}
					}
				}
				else
				{			
					echo $this->Form->input('descuento',['type'=>'hidden','value'=>null]); 	
					echo $this->Form->input('plazoley_dcto',['type'=>'hidden','value'=>null]); 	
					echo $this->Form->input('unidad_minima',['type'=>'hidden','value'=>null]); 	
					echo $this->Form->input('tipo_oferta',['type'=>'hidden','value'=>null]); 
					echo $this->Form->input('tipo_venta',['type'=>'hidden','value'=>null]); 
					echo $this->Form->input('tipo_precio',['type'=>'hidden','value'=>null]); 
				}
				?>
			
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
			}
			/*
			%aStock  = ("S" => "Stock habitual",
            "B" => "Stock bajo. Confirme con su operadora",
            "F" => "Producto en Falta",
            "D" => "Producto discontinuado",
            "R" => "Producto sujeto a stock");*/
			
			?></td>
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
					,'<?php echo $articulo['pack'];?>
					');" onMouseOut='hiddenDiv()' 
					style='display:table;'>
					
					<?php 
					if ($articulo['stock']=='F')
						echo '<div class="tachado">'.$articulo['descripcion_pag'].'</div>'; 
					else
						echo $articulo['descripcion_pag']; 
					?>

					<?php
					if ($articulo['pack'] !=null){
					echo ' <font color="red" >PACK</font>';
					}
					
					if ($articulo['descuentos']!=null){ 
						if ($articulo['descuentos'][0]['tipo_venta']=='D' and $articulo['stock']!='F')
						{
							echo ' '.$this->Html->image('oferta.png',['title' => 'Oferta']);
						}	
						else
						{	
					
					if (count($articulo['descuentos'])>1)
							{
								if ($articulo['descuentos'][1]['tipo_venta']=='D' and $articulo['stock']!='F')
									echo ' '.$this->Html->image('oferta.png',['title' => 'Oferta']);
							}
						}
					}
				
					?>	
				</div>				

			</td>
			<td class='colprecio'>
				<?php echo '$ '.number_format(round(h($articulo['precio_publico'])*0.807, 3),2,',','.'); ?>
			</td>
			<td class='colprecio'>
				<?php 
				if (($articulo['categoria_id'] !=6) && ($articulo['categoria_id'] !=5)  && ($articulo['categoria_id'] !=4))
					{
						echo '$ '.number_format($articulo['precio_publico'],2,',','.'); 
					}
				?>
			</td>
			<td class="td-sub-tabla">
				<?php 
					if ($articulo['descuentos'] !=null and $articulo['stock']!='F'){
					if ($articulo['descuentos'][0]['tipo_venta']=='D' )	
					{
						echo ' <font color="red" style="font-weight: bold;">'.$articulo['descuentos'][0]['dto_drogueria'].'% '.'</font>'; 
					}
					else
					if (count($articulo['descuentos'])>1)
						if ($articulo['descuentos'][1]['tipo_venta']=='D')	
								echo ' <font color="red" style="font-weight: bold;">'.$articulo['descuentos'][1]['dto_drogueria'].'% '.'</font>'; 
						
					}
					
				?>
			</td>
			<td class="td-sub-tabla">
			<?php 
				if ($articulo['descuentos'] !=null and $articulo['stock']!='F'){
					if ($articulo['descuentos'][0]['tipo_venta']=='D')
					echo $articulo['descuentos'][0]['uni_min'];
				else
					if (count($articulo['descuentos'])>1)
					if ($articulo['descuentos'][1]['tipo_venta']=='D')
					echo $articulo['descuentos'][1]['uni_min'];
				}
			?>
			</td>
			<td class="td-sub-tabla">
			<?php 
				if ($articulo['descuentos'] !=null and $articulo['stock']!='F'){
					if ($articulo['descuentos'][0]['tipo_venta']=='D')
					echo $articulo['descuentos'][0]['plazo'];
				else
					if (count($articulo['descuentos'])>1)
					if ($articulo['descuentos'][1]['tipo_venta']=='D')
					echo $articulo['descuentos'][1]['plazo'];
				}
			?>
			</td>
			<td class="td-sub-tabla">
			<?php 
				if ($articulo['descuentos'] !=null and $articulo['stock']!='F'){
					if ($articulo['descuentos'][0]['tipo_venta']=='D')
					{
						echo $articulo['descuentos'][0]['tipo_oferta'];
					}
					else
					if (count($articulo['descuentos'])>1)
					if ($articulo['descuentos'][1]['tipo_venta']=='D')
					{
						echo $articulo['descuentos'][1]['tipo_oferta'];
					}
				}
			?>
			</td>
			<td class='coliva'>
			<?php 
				if ($articulo['iva']==1) { echo $this->Html->image('iva.png',['title' => 'IVA']); }
				if ($articulo['trazable']==1) { echo $this->Html->image('trazable.png',['title' => 'Trazable']); } 
				if ($articulo['cadena_frio']==1) { echo $this->Html->image('cadenafrio.png',['title' => 'cadena de frio']); }
				if ($articulo['categoria_id']==7) { echo $this->Html->image('valeoficial.png',['title' => 'Vale Oficial']); }
				if ($articulo['categoria_id']==6) { echo $this->Html->image('psi.png',['title' => 'Psicotropicos']); }
				if ($articulo['pack']==1) { echo $this->Html->image('pack.png',['title' => 'Pack']); }
				if ($articulo['nuevo']==1){ echo $this->Html->image('nuevo.png',['title' => 'Producto Nuevo']);	}
				if ($articulo['msd']==1 and $articulo['categoria_id']=1){ echo $this->Html->image('msd.png',['title' => 'Medicamento Sin descuento']);	}
				if (($articulo['imagen']!="perfumeria.jpg" && $articulo['imagen']!="sinimagen.png") && ($articulo['imagen']!="medicamento.jpg"))
				echo $this->Html->image('foto.png',['title' => 'Ampliar la foto','class'=>'imgFoto','data-id'=>$articulo['imagen']]);
				
				//if ($articulo['descuentos']!=null){ echo $this->Html->image('oferta2.png',['title' => 'Oferta']);	}
				//if ($articulo['descuentos']!=null){ echo $this->Html->image('oferta3.png',['title' => 'Oferta']);	}	
			?>
			
			</td> 
			<td>
			<?= $this->Form->submit('Selecionar')?>
			</td> 
		 <?= $this->Form->end() ?>	
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

	/**
	* Funcion que muestra el div en la posicion del mouse
	*/
	function showdiv(event,text,iva,traza,frio,categ,pack)
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
						
		document.getElementById('flotante').innerHTML=text+ivaimg+trazaimg+cadenaimg+psiimg+valeoficialimg;
		// Posicionamos la capa flotante

		document.getElementById('flotante').style.top = (tempY-120)+"px";
		document.getElementById('flotante').style.left = (tempX-10)+"px";
		
		document.getElementById('flotante').style.display='block';
		return;
	}
	/**
	* Funcion para esconder el div
	*/
	function hiddenDiv()
	{
		document.getElementById('flotante').style.display='none';
	}
	
</script>
            
<style>.imgFoto{cursor: zoom-in;}</style>
<div class="articulos index large-10 medium-9 columns">
<table class='tablasearch' cellpadding="0" cellspacing="0">
<thead>
<tr>	
<th rowspan="2">Cant.</th>
<th rowspan="2"><?= $this->Paginator->sort('stock') ?></th>
<th rowspan="2"><?= $this->Paginator->sort('descripcion_pag','Descripción') ?></th>
<th rowspan="2"><?= $this->Paginator->sort('precio_publico','P.Publico') ?></th>
<th rowspan="2"><?= $this->Paginator->sort('precio_publico','P.Farmacia') ?></th>
<th rowspan="2"><?= $this->Paginator->sort('precio_publico','P.c/ Dto') ?></th>
<th colspan="2" align="center"></th>
<th rowspan="2">Ref.</th>
</tr>
<tr>
<th><div id="th-sub-tabla">Plazo</div></td>
<th><div id="th-sub-tabla">Tipo</div></td>
</tr>
</thead>
<tbody>
<div id="flotante"></div>
<?php $indice=0; $cat = $categorias; $lab = $laboratorios; ?>
<?= $this->Form->create('Carritos',['url'=>['controller'=>'Carritos','action'=>'carritoaddall'],'id'=>'formaddcart','onsubmit'=>'return validaragregar()']); ?>
<?php foreach ($articulos as $articulo): ?>
<tr>
<?php $indice+=1;$encabezado = $indice.'.'; $indice+=1;?>
<td class='formcartcanttd'>
<?php
if ($articulo['carritos'] !=null )
{
$cantidadencarrito = $articulo['carritos'][0]['cantidad'];
echo $this->Form->input($encabezado.'cantidad',['tabindex'=>$indice,'value' =>$cantidadencarrito ,'class'=>'formcartcant','target'=>'_blank','onchange'=>'javascript:document.confirmInput.submit();','onkeydown'=>'if(event.keyCode==13) event.keyCode=9;','autocomplete'=>'off']);
}
else	
echo $this->Form->input($encabezado.'cantidad',['tabindex'=>$indice,'class'=>'formcartcant','target'=>'_blank',  'onchange'=>'javascript:document.confirmInput.submit();','onkeydown'=>'if(event.keyCode==13) event.keyCode=9;', 'autocomplete'=>'off']);
echo $this->Form->input($encabezado.'articulo_id',['type'=>'hidden','value'=>$articulo['id']]);
echo $this->Form->input($encabezado.'categoria_id',['type'=>'hidden','value'=>$articulo['categoria_id']]);	
echo $this->Form->input($encabezado.'precio_publico',['type'=>'hidden','value'=>$articulo['precio_publico']]);
echo $this->Form->input($encabezado.'descripcion',['type'=>'hidden','value'=>$articulo['descripcion_pag']]);
echo $this->Form->input($encabezado.'compra_min',['type'=>'hidden','value'=>$articulo['compra_min']]);
echo $this->Form->input($encabezado.'compra_multiplo',['type'=>'hidden','value'=>$articulo['compra_multiplo']]);
echo $this->Form->input($encabezado.'compra_max',['type'=>'hidden','value'=>$articulo['compra_max']]);	
if ($articulo['descuentos'] !=null){	
	if ($articulo['descuentos'][0]['tipo_venta']=='D')
		{
		echo $this->Form->input($encabezado.'descuento',['type'=>'hidden','value'=>$articulo['descuentos'][0]['dto_drogueria']]); 	
		echo $this->Form->input($encabezado.'plazoley_dcto',['type'=>'hidden','value'=>$articulo['descuentos'][0]['plazo']]); 	
		echo $this->Form->input($encabezado.'unidad_minima',['type'=>'hidden','value'=>$articulo['descuentos'][0]['uni_min']]); 	
		echo $this->Form->input($encabezado.'tipo_oferta',['type'=>'hidden','value'=>$articulo['descuentos'][0]['tipo_oferta']]); 
		echo $this->Form->input($encabezado.'tipo_venta',['type'=>'hidden','value'=>$articulo['descuentos'][0]['tipo_venta']]); 
		echo $this->Form->input($encabezado.'tipo_precio',['type'=>'hidden','value'=>$articulo['descuentos'][0]['tipo_precio']]); 
		}
	else
		{
		if (count($articulo['descuentos'])>1)
		{
		if ($articulo['descuentos'][1]['tipo_venta']=='D')
		{
		echo $this->Form->input($encabezado.'descuento',['type'=>'hidden','value'=>$articulo['descuentos'][1]['dto_drogueria']]); 	
		echo $this->Form->input($encabezado.'plazoley_dcto',['type'=>'hidden','value'=>$articulo['descuentos'][1]['plazo']]); 	
		echo $this->Form->input($encabezado.'unidad_minima',['type'=>'hidden','value'=>$articulo['descuentos'][1]['uni_min']]); 	
		echo $this->Form->input($encabezado.'tipo_oferta',['type'=>'hidden','value'=>$articulo['descuentos'][1]['tipo_oferta']]); 
		echo $this->Form->input($encabezado.'tipo_venta',['type'=>'hidden','value'=>$articulo['descuentos'][1]['tipo_venta']]); 
		echo $this->Form->input($encabezado.'tipo_precio',['type'=>'hidden','value'=>$articulo['descuentos'][1]['tipo_precio']]); 
		}
		else
		{
		echo $this->Form->input($encabezado.'descuento',['type'=>'hidden','value'=>0]); 	
		echo $this->Form->input($encabezado.'plazoley_dcto',['type'=>'hidden','value'=>null]); 	
		echo $this->Form->input($encabezado.'unidad_minima',['type'=>'hidden','value'=>null]); 	
		echo $this->Form->input($encabezado.'tipo_oferta',['type'=>'hidden','value'=>null]); 
		echo $this->Form->input($encabezado.'tipo_venta',['type'=>'hidden','value'=>null]); 
		echo $this->Form->input($encabezado.'tipo_precio',['type'=>'hidden','value'=>null]); 
		}
		}
		else
		{
		echo $this->Form->input($encabezado.'descuento',['type'=>'hidden','value'=>0]); 	
		echo $this->Form->input($encabezado.'plazoley_dcto',['type'=>'hidden','value'=>null]); 	
		echo $this->Form->input($encabezado.'unidad_minima',['type'=>'hidden','value'=>null]); 	
		echo $this->Form->input($encabezado.'tipo_oferta',['type'=>'hidden','value'=>null]); 
		echo $this->Form->input($encabezado.'tipo_venta',['type'=>'hidden','value'=>null]); 
		echo $this->Form->input($encabezado.'tipo_precio',['type'=>'hidden','value'=>null]); 
		}
		}
		}
		else
		{			
		echo $this->Form->input($encabezado.'descuento',['type'=>'hidden','value'=>0]); 	
		echo $this->Form->input($encabezado.'plazoley_dcto',['type'=>'hidden','value'=>null]); 	
		echo $this->Form->input($encabezado.'unidad_minima',['type'=>'hidden','value'=>null]); 	
		echo $this->Form->input($encabezado.'tipo_oferta',['type'=>'hidden','value'=>null]); 
		echo $this->Form->input($encabezado.'tipo_venta',['type'=>'hidden','value'=>null]); 
		echo $this->Form->input($encabezado.'tipo_precio',['type'=>'hidden','value'=>null]); 
		}
		?>
</td>
<td class='colstock'><?php
switch ($articulo['stock']) {
case 'B': echo $this->Html->image('bajo.png',['title' => 'Stock Bajo, Consultar Operadora'] );	break;
case 'F': echo $this->Html->image('falta.png',['title' => 'Producto en Falta']);				break;
case 'S': echo $this->Html->image('alto.png',['title' => 'Stock Habitual']);					break;
case 'R': echo $this->Html->image('restrin.png',['title' => 'Producto sujeto a stock']);		break;
case 'D': echo $this->Html->image('descont.png',['title' => 'Producto Discontinuo']);			break;
}
?></td>
<td class='masinfoband'>
<div onmouseover="showdiv(event,'<?php 
	echo str_replace('"', '', $articulo['descripcion_pag']).'</br>'; 
	echo 'Laboratorio: '.$lab[$articulo['laboratorio_id']].'</br>';
	echo 'Categoría: '.$cat[$articulo['categoria_id']].'</br>';
	echo 'Troquel: '.$articulo['troquel'].'</br>';
	echo 'EAN: '.$articulo['codigo_barras'].'</br>';
	if ($articulo['descuentos'] !=null && $articulo['stock']!='F')
	{
	if ($articulo['descuentos'][0]['tipo_venta']=='D')
	{
	//echo 'Oferta: '.$articulo['descuentos'][0]['dto_drogueria'].'% por '.$articulo['descuentos'][0]['uni_min'].'unidad(es)</br>';
	echo 'Plazo: '. $articulo['descuentos'][0]['plazo'].'</br>';
	//echo 'Tipo de oferta: '. $articulo['descuentos'][0]['tipo_oferta'].'</br>';
	}
	else
	if (count($articulo['descuentos'])>1)
	{
	if ($articulo['descuentos'][1]['tipo_venta']=='D')
	{
	//echo 'Oferta: '.$articulo['descuentos'][1]['dto_drogueria'].'% por '.$articulo['descuentos'][1]['uni_min'].'unidad(es)</br>';
	echo 'Plazo: '. $articulo['descuentos'][1]['plazo'].'</br>';
	//echo 'Tipo de oferta: '. $articulo['descuentos'][1]['tipo_oferta'].'</br>';
	}
	}
	}?>','<?php echo $articulo['iva'];?>','<?php echo $articulo['trazable'];?>','<?php echo $articulo['cadena_frio'];?>'
		,'<?php echo $articulo['categoria_id'];?>','<?php echo $articulo['pack'];?>','<?php echo $articulo['fv_cerca'];?>'
		,'<?php echo $articulo['fv'];?>','<?php echo $articulo['imagen'];?>');" onMouseOut='hiddenDiv()' style='display:table;'>
<?php 
echo $articulo['descripcion_pag']; 
	if ($articulo['compra_min']>1) {echo ' (Vta.Min. '.$articulo['compra_min'],')';}
	if ($articulo['compra_multiplo']>1) {echo ' (Multiplo. '.$articulo['compra_multiplo'],')';}
	if ($articulo['fv_cerca']==1) { echo $this->Html->image('fv.png',['title' => 'Vencimiento Cercano']);	}
	if ($articulo['pack'] !=null){ echo ' <font color="red" >PACK</font>';}
	
?>	
</div>				
</td>
<td class='colprecio'>
<?php 
if (($articulo['categoria_id'] !=5) && ($articulo['categoria_id'] !=4)  && ($articulo['categoria_id'] !=3))
{
	if ($articulo['iva']==0) echo '$ '.number_format($articulo['precio_publico'],2,',','.'); 
}
?>
</td>
<td class='colprecio'>
<?php 
if (($articulo['categoria_id'] !=5) && ($articulo['categoria_id'] !=4)  && ($articulo['categoria_id'] !=3))
{
	if ($articulo['categoria_id'] ===1)	$coef =1;
	else $coef = $this->request->session()->read('Auth.User.coef');
	if ($articulo['laboratorio_id']==15) $coef = 0.892; 
	if ($articulo['descuentos']!=null){ 
		if ($articulo['descuentos'][0]['tipo_venta']=='D' && $articulo['descuentos'][0]['tipo_precio']=='F')
		{	
		echo '$ '.number_format(round(h($articulo['precio_publico'])*0.807*$coef, 3),2,',','.'); 
		}	
		else
		{	
		if ($articulo['descuentos'][0]['tipo_venta']=='L')
			echo '$ '.number_format(round(h($articulo['precio_publico'])*0.807*$coef, 3),2,',','.'); 
		else
			echo '$ '.number_format($articulo['precio_publico'],2,',','.'); 
		}
	}
	else
		echo '$ '.number_format(round(h($articulo['precio_publico'])*0.807*$coef, 3),2,',','.'); 
}
else
{
	$coef = 1;//$this->request->session()->read('Auth.User.coef');
	$precio = $articulo['precio_publico']*0.807;
	if ($coef !=1)
	$precio = $precio*$coef;
	echo '$ '.number_format(round($precio, 3),2,',','.'); 
}
?>
</td>
<td class='colprecio'>
<?php 
if (($articulo['categoria_id'] !=5) && ($articulo['categoria_id'] !=4)  && ($articulo['categoria_id'] !=3) &&($articulo['categoria_id'] !=2))
{
	if ($articulo['descuentos']!=null){ 				
	if ($articulo['descuentos'][0]['tipo_venta']=='L')
	{
		if ($articulo['msd']!=1){
		$condicion = $this->request->session()->read('Auth.User.condicion');									
		$coef = 1;//$this->request->session()->read('Auth.User.coef');
		$precio = $articulo['precio_publico']*0.807;
		if ($condicion >0 ) $precio -= $precio*$condicion/100;
		echo '$ '.number_format(round($precio, 3),2,',','.'); 
		}
	}
	}
	else
	{
	if ($articulo['msd']!=1){
		$condicion = $this->request->session()->read('Auth.User.condicion');
		$coef = 1;//$this->request->session()->read('Auth.User.coef');
		$precio = $articulo['precio_publico']*0.807;
		if ($condicion >0 ) $precio -= $precio*$condicion/100;
		echo '$ '.number_format(round($precio, 3),2,',','.'); }
	}
}
else
	{
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
if ($articulo['msd']==1 and ($articulo['categoria_id']==1 or $articulo['categoria_id']==6 or $articulo['categoria_id']==7)){ echo $this->Html->image('msd.png',['title' => 'Medicamento Sin descuento']);	}
if ($articulo['fv_cerca']==1) { echo $this->Html->image('fv.png',['title' => 'Vencimiento Cercano']);	}
if (($articulo['imagen']!="perfumeria.jpg" && $articulo['imagen']!="sinimagen.png") && ($articulo['imagen']!="medicamento.jpg"))
echo $this->Html->image('foto.png',['title' => 'Vencimiento Cercano','class'=>'imgFoto','data-id'=>$articulo['imagen']]);
?>
</td> 
<td></td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
<div class="modal fade" id="enlargeImageModal" tabindex="-1" role="dialog" aria-labelledby="enlargeImageModal" aria-hidden="true">
<div class="modal-dialog modal-lg" role="document">
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
</div>
<div class="modal-body">       
<img src="" class="enlargeImageModalSource" style="width: 100%;">       
</div>
</div>
</div>
</div>

<div class="paginator">
<ul class="pagination">
<?= $this->Paginator->prev('< ' . __('Anterior')) ?>
<?= $this->Paginator->numbers() ?>
<?= $this->Paginator->next(__('Siguiente') . ' >',['tabindex'=>$indice]) ?>
<div class="pagination_count"><span><?= $this->Paginator->counter('{{count}} Articulos') ?> </span></div>
</ul>
<div class="importconfirm2">	
	<div class="button-holder5"><?php echo $this->Form->submit('Agregar Seleccionados',['class'=>'btn_agregarvarios']);?></div>	
</div><?= $this->Form->end() ?>	
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
	/** Funcion que muestra el div en la posicion del mouse */
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
		eanimg ='<img src="http://www.drogueriasur.com.ar/ds/webroot/img/productos/'+ean+'" alt="'+ean+'">';
			
		
		//document.getElementById('flotante').innerHTML=text+ivaimg+trazaimg+cadenaimg+psiimg+valeoficialimg+fvimg+fvcerca;
		// Posicionamos la capa flotante
		document.getElementById('flotante').innerHTML="<div id='flotante_text'>"+text+ivaimg+trazaimg+cadenaimg+psiimg+valeoficialimg+fvimg+fvcerca+"</div><div id='flotante_img'>"+eanimg+"</div>";
		
		document.getElementById('flotante').style.top = (tempY-120)+"px";
		document.getElementById('flotante').style.left = (tempX-10)+"px";
		
		document.getElementById('flotante').style.display='block';
		return;
	}
	
	$(function() {
    	$('.imgFoto').on('click', function() {
			var str =  $(this).attr('src');
			
			var str = str.replace("foto.png", "productos/"+$(this).data("id"));
			var res = str.replace("productos/", "productos/big_");
			
			var a = new XMLHttpRequest;
				a.open( "GET", res, false );
				a.send( null );
				
		if (a.status === 404)
		{
				
				var res =  $(this).attr('src');
				var res = res.replace("foto.png", "productos/"+$(this).data("id"));
		}			
			
			
						//var res =  $(this).attr('src');
			
			$('.enlargeImageModalSource').attr('src',res);
			$('#enlargeImageModal').modal('show');
		});
	});
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
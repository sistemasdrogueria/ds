<style>.imgFoto{cursor: zoom-in;}</style>
<div class="articulos index large-10 medium-9 columns">
<table class='tablasearch' cellpadding="0" cellspacing="0">
<thead>
<tr>	
<th rowspan="2">Cant.</th>
<th rowspan="2">Pack</th>
<th rowspan="2"><?= $this->Paginator->sort('stock') ?></th>
<th rowspan="2"><?= $this->Paginator->sort('descripcion_pag','Descripción') ?></th>
<th rowspan="2"><?= $this->Paginator->sort('precio_publico','P.Publico') ?></th>
<!--th rowspan="2"><?PHP // $this->Paginator->sort('precio_publico','P.Farmacia *') ?></th -->
<!--th rowspan="2"><?//= $this->Paginator->sort('precio_publico','P.C/ Dto') ?></th-->
<th rowspan="2">P.C/ Dto</th>
<th rowspan="2">Dto</th>
<th colspan="3" align="center">Ofertas</th>
<th rowspan="2">Ref.</th>
</tr>
<tr>
<th><div id="th-sub-tabla">U.Min</div></th>
<th><div id="th-sub-tabla">Plazo</div></th>
<th><div id="th-sub-tabla">Tipo Of.</div></th>
</tr>
</thead>
<tbody>
<div id="flotante"></div>
<?php $indice=0; $cat = $categorias; $lab = $laboratorios; 
$descuento_pf = $this->request->session()->read('Auth.User.pf_dcto');
$condicion = $this->request->session()->read('Auth.User.condicion');
$coef = $this->request->session()->read('Auth.User.coef');
$condiciongeneral = 100*(1-($descuento_pf * (1-$condicion/100)));
$condiciongeneralmsd = 100*(1-($descuento_pf));
$condiciongeneralcf = 100*(1-($descuento_pf *1.0248* (1-$condicion/100)));
$condiciongeneralaz = 100*(1-($descuento_pf *0.892));
$coef_pyf = $this->request->session()->read('Auth.User.coef_pyf');
?>
<?= $this->Form->create('Carritos',['url'=>['controller'=>'Carritos','action'=>'#'],'id'=>'formaddcart','onsubmit'=>'return false;']); ?>
<?php foreach ($articulos as $articulo): ?>
<tr>
<?php $indice+=1;$encabezado = $indice.'.'; $indice+=0;?>
<td class='formcartcanttd'>
<?php
		if ($articulo['carritos'] !=null )
			
		$cantidadencarrito = $articulo['carritos'][0]['cantidad'];
	
	else
	$cantidadencarrito ="";
if ($articulo['descuentos'] !=null){	
if ($articulo['descuentos'][0]['tipo_venta']=='D')
{
	echo $this->Form->input($encabezado.'cantidad',['id'=>'tab'.$indice,'tabindex'=>$indice,'value'=>$cantidadencarrito, 'data-id-input'=>'tab'.$indice,'data-id'=> $articulo['id'],'data-cantidad-car'=>$cantidadencarrito, 'value'=>$cantidadencarrito,'data-pv-id'=> $articulo['descuentos'][0]['id'], 'onkeypress'=>'return soloNumeros(event)','class'=>'formcartcant formcartcantletters','_class'=>'formcartcant','target'=>'_blank'  , 'autocomplete'=>'off']);

	
}
else
{
if (count($articulo['descuentos'])>1)
{
if ($articulo['descuentos'][1]['tipo_venta']=='D')
{
		echo $this->Form->input($encabezado.'cantidad',['id'=>'tab'.$indice,'data-cantidad-car'=>$cantidadencarrito, 'data-id-input'=>'tab'.$indice,'tabindex'=>$indice,'data-id'=> $articulo['id'],'data-pv-id'=>  $articulo['descuentos'][1]['id'],'value'=>$cantidadencarrito,'class'=>'formcartcant formcartcantletters', 'onkeypress'=>'return soloNumeros(event)','_class'=>'formcartcant','target'=>'_blank'  , 'autocomplete'=>'off']);

}
else
{
	echo $this->Form->input($encabezado.'cantidad',[ 'id'=>'tab'.$indice,'data-cantidad-car'=>$cantidadencarrito, 'data-id-input'=>'tab'.$indice,'tabindex'=>$indice,'value'=>$cantidadencarrito, 'data-id'=> $articulo['id'],'data-pv-id'=> 0,'class'=>'formcartcant formcartcantletters','_class'=>'formcartcant', 'onkeypress'=>'return soloNumeros(event)','target'=>'_blank'  , 'autocomplete'=>'off']);

/*
echo $this->Form->input($encabezado.'descuento',['type'=>'hidden','value'=>0]); 	
echo $this->Form->input($encabezado.'plazoley_dcto',['type'=>'hidden','value'=>'HABITUAL']); 	
echo $this->Form->input($encabezado.'unidad_minima',['type'=>'hidden','value'=>1]); 	
echo $this->Form->input($encabezado.'tipo_oferta',['type'=>'hidden','value'=>null]); 
echo $this->Form->input($encabezado.'tipo_venta',['type'=>'hidden','value'=>null]); 
echo $this->Form->input($encabezado.'tipo_precio',['type'=>'hidden','value'=>null]); 
echo $this->Form->input($encabezado.'combo_id',['type'=>'hidden','value'=>0]); 
echo $this->Form->input($encabezado.'multiplo',['type'=>'hidden','value'=>1]); 
echo $this->Form->input($encabezado.'combo_tipo_id',['type'=>'hidden','value'=>0]);
echo $this->Form->input($encabezado.'descuento_id',['type'=>'hidden','value'=>0]); */
}
}
else
{
	echo $this->Form->input($encabezado.'cantidad',[ 'id'=>'tab'.$indice,'data-cantidad-car'=>$cantidadencarrito, 'data-id-input'=>'tab'.$indice,'tabindex'=>$indice,'data-id'=> $articulo['id'],'data-pv-id'=> 0,'value'=>$cantidadencarrito,'class'=>'formcartcant formcartcantletters','_class'=>'formcartcant', 'onkeypress'=>'return soloNumeros(event)','target'=>'_blank'  , 'autocomplete'=>'off']);
}
}
}
else
{				
	echo $this->Form->input($encabezado.'cantidad',['id'=>'tab'.$indice,'data-cantidad-car'=>$cantidadencarrito, 'data-id-input'=>'tab'.$indice,'tabindex'=>$indice,'data-id'=> $articulo['id'],'data-pv-id'=> 0, 'value'=>$cantidadencarrito, 'class'=>'formcartcant formcartcantletters','_class'=>'formcartcant', 'onkeypress'=>'return soloNumeros(event)','target'=>'_blank'  , 'autocomplete'=>'off']);
}
?>
</td>
<td class='colstock'> <b>
<?php if ($articulo['venta_paq']>0)
	  if ($articulo['paq']>1)
		echo $articulo['paq'];
?></b>
</td>

<td class='colstock'><?php
switch ($articulo['stock']) {
case 'B': echo $this->Html->image('bajo.png',['title' => 'Stock Bajo, Consultar Operadora'] );	break;
case 'F': echo $this->Html->image('falta.png',['title' => 'Producto en Falta']);				break;
case 'S': echo $this->Html->image('alto.png',['title' => 'Stock Habitual']);					break;
case 'R': echo $this->Html->image('restrin.png',['title' => 'Producto sujeto a stock']);		break;
case 'D': echo $this->Html->image('descont.png',['title' => 'Producto Discontinuo']);			break;
}
?>
<?php 
$texto ='';
$texto =  $texto . str_replace('"', '', $articulo['descripcion_pag']).'</br>';
if ($articulo['laboratorio_id']!=388)
$texto= $texto .'Proveedor: '.$lab[$articulo['laboratorio_id']].'</br>';
else
$texto= $texto .'Proveedor: </br>';
$texto= $texto .'Categoría: '.$cat[$articulo['categoria_id']].'</br>';
$texto= $texto .'Troquel: '.$articulo['troquel'].'</br>';
$texto= $texto .'EAN: '.$articulo['codigo_barras'].'</br>';
if ($articulo['descuentos'] !=null && $articulo['stock']!='F')
{
if ($articulo['descuentos'][0]['tipo_venta']=='D')
{
	if ($articulo['descuentos'][0]['tipo_oferta']!='TH')
	{
		$texto= $texto .'Oferta: '.$articulo['descuentos'][0]['dto_drogueria'].'% por '.$articulo['descuentos'][0]['uni_min'].'unidad(es)</br>';
	}
	else
	{
		$descuento_off = number_format(round($articulo['descuentos'][0]['dto_drogueria']+$condiciongeneral, 3),2,',','.') ;
		$texto= $texto .'Oferta: '.$descuento_off.'% por '.$articulo['descuentos'][0]['uni_min'].'unidad(es)</br>';
	}
	$texto= $texto .'Plazo: '. $articulo['descuentos'][0]['plazo'].'</br>';
	if ($articulo['descuentos'][0]['tipo_oferta']!='TH')
	{
		$texto= $texto .'Tipo de oferta: '. $articulo['descuentos'][0]['tipo_oferta'].'</br>';
	}
	else
	{
		$texto= $texto .'Tipo de oferta: TD </br>';
	}

	
}
else
if (count($articulo['descuentos'])>1)
{
if ($articulo['descuentos'][1]['tipo_venta']=='D')
{
	if ($articulo['descuentos'][1]['tipo_oferta']!='TH')
	{
		$texto= $texto .'Oferta: '.$articulo['descuentos'][1]['dto_drogueria'].'% por '.$articulo['descuentos'][1]['uni_min'].'unidad(es)</br>';	
	}
	else
	{
		$descuento_off = number_format(round($articulo['descuentos'][1]['dto_drogueria']+$condiciongeneral, 3),2,',','.') ;
		$texto= $texto .'Oferta: '.$descuento_off.'% por '.$articulo['descuentos'][1]['uni_min'].'unidad(es)</br>';
	}
	$texto= $texto .'Plazo: '. $articulo['descuentos'][1]['plazo'].'</br>';
	if ($articulo['descuentos'][1]['tipo_oferta']!='TH')
	{
		$texto= $texto .'Tipo de oferta: '. $articulo['descuentos'][1]['tipo_oferta'].'</br>';
	}
	else
	{
		$texto= $texto .'Tipo de oferta: TD </br>';
	}
	
	
}
}
}?>

</td>
<td class='masinfoband'>
<div onmouseover="showdiv(event,'<?php echo $texto?>','<?php echo $articulo['iva'];?>','<?php echo $articulo['trazable'];?>','<?php echo $articulo['cadena_frio'];?>','<?php echo $articulo['categoria_id'];?>','<?php echo $articulo['pack'];?>','<?php echo $articulo['fv_cerca'];?>','<?php echo $articulo['fv'];?>','<?php echo $articulo['imagen'];?>','<?php if($articulo['id']==48687) {echo 1;} else{echo 0;}  ?>');" onMouseOut='hiddenDiv()' style='display:table;'>
<?php 
echo $articulo['descripcion_pag']; 
if ($articulo['compra_min']>1) {echo ' (Vta.Min. '.$articulo['compra_min'],')';}
if ($articulo['compra_multiplo']>1) {echo ' (Multiplo. '.$articulo['compra_multiplo'],')';}
if ($articulo['fv_cerca']==1) { echo $this->Html->image('fv.png',['title' => 'Vencimiento Cercano']);	}
if ($articulo['pack'] !=null){ echo ' <font color="red" >PACK</font>';}
if ($articulo['descuentos']!=null){ 
if ($articulo['descuentos'][0]['tipo_venta']=='D' && $articulo['stock']!='F' && $articulo['descuentos'][0]['dto_drogueria']>0)
{
	
echo ' '.$this->Html->image('oferta.png',['title' => 'Oferta']);
}	
else
{	
if (count($articulo['descuentos'])>1)
{
if ($articulo['descuentos'][1]['tipo_venta']=='D' && $articulo['stock']!='F')
echo ' '.$this->Html->image('oferta.png',['title' => 'Oferta']);
}
}
}

//if ( $articulo['restringido_unid']>0  && $articulo['stock']!='F')
if (($articulo['restringido_unid_w']>0 || $articulo['restringido_unid']>0) && $articulo['stock']!='F')
{
	if ($articulo['restringido_unid']>0) 
	echo '<font color=#fe4c04><b>  MÁX '.$articulo['restringido_unid'].' UNI</b></font>';
	else
	if ($articulo['restringido_unid_w']>0)

	echo '<font color=#fe4c04><b>  MÁX '.$articulo['restringido_unid_w'].' UNI</b></font>';
}
?>	
<?php /*
if($articulo['id']==48687) {echo $this->Html->image('MELCHOR.png',['title' => 'Stock Bajo, Consultar Operadora', 'width'=>20] );} */
 ?>
</div>				
</td>
<td class='colprecio' style=" border: solid #fff; border-width: 0px 1px 0px 1px;">
    <?php echo $this->element('precio_publicox',['articulo'=>$articulo ,'descuento_pf'=>$descuento_pf,'coef'=>$coef,'coef_pyf'=>$coef_pyf] );?>
</td>
<td class='colprecio' style=" border: solid #fff; border-width: 0px 1px 0px 1px;">
    <?php echo $this->element('precio_con_descuento',['articulo'=>$articulo ,'descuento_pf'=>$descuento_pf,'condicion'=>$condicion,'coef'=>$coef,'condiciongeneral'=>$condiciongeneral] );?>
</td>

<td class="td-sub-tabla" style=" border: solid #fff; border-width: 0px 1px 0px 1px;">
<?php 
if ($articulo['descuentos'] !=null && $articulo['stock']!='F')
{
if ($articulo['descuentos'][0]['tipo_venta']=='D' )	
//echo ' <font color="red" style="font-weight: bold;">'.$articulo['descuentos'][0]['dto_drogueria'].'% '.'</font>'; 
if ($articulo['descuentos'][0]['tipo_precio']=='P')
	{
		if ($articulo['descuentos'][0]['tipo_oferta']!='TH')
			echo ' <font color="red" style="font-weight: bold;">'.$articulo['descuentos'][0]['dto_drogueria'].'% '.'</font>'; 
		else {
			echo ' <font color="red" style="font-weight: bold;">'.number_format(round($articulo['descuentos'][0]['dto_drogueria']+$condiciongeneral, 3),2,',','.').'% '.'</font>'; 

		}	
	}
	else
	{
		if ($articulo['iva']==0)
		{$condiciongeneralfinal = 100*(1-($descuento_pf * (1-$condicion/100)*(1-$articulo['descuentos'][0]['dto_drogueria']/100)));
		echo ' <font color="red" style="font-weight: bold;">';
		echo number_format(round($condiciongeneralfinal, 3),2,',','.'). '% </font>'; }
		else
		echo ' <font color="red" style="font-weight: bold;">'.$articulo['descuentos'][0]['dto_drogueria'].'% '.'</font>'; 

	}

else
if (count($articulo['descuentos'])>1)
if ($articulo['descuentos'][1]['tipo_venta']=='D')	
if (  $articulo['descuentos'][1]['tipo_precio']=='P')
if ($articulo['descuentos'][1]['tipo_oferta']!='TH')
echo ' <font color="red" style="font-weight: bold;">'.$articulo['descuentos'][1]['dto_drogueria'].'% '.'</font>'; 
else {

echo ' <font color="red" style="font-weight: bold;">'.number_format(round($articulo['descuentos'][1]['dto_drogueria']+$condiciongeneral, 3),2,',','.').'% '.'</font>'; 
}			


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
else
{
	if (($articulo['categoria_id']==1|| $articulo['categoria_id']==6|| $articulo['categoria_id']==7))// && $articulo['iva']==0)
	//echo number_format(round($condiciongeneral, 3),2,',','.'). "% ";
	//if ($articulo['categoria_id']==1 && $articulo['iva']==0)
	{
		if ($articulo['msd']==0)
		{
		if ($articulo['cadena_frio']==0 )
		{
			/*
			if ($articulo['laboratorio_id']==15) 
				echo number_format(round($condiciongeneralaz, 3),2,',','.'). "% ";
			else
			{*/
				if ($articulo['mcdp']==0)
				echo number_format(round($condiciongeneral, 3),2,',','.'). "% ";
				else
				echo number_format(round($condiciongeneralmsd, 3),2,',','.'). "% ";

			//}
				
		}
		
		else
		if  ($articulo['subcategoria_id']<10)
			echo number_format(round($condiciongeneralcf, 3),2,',','.'). "% ";
			else
			if ($articulo['mcdp']==0)
				echo number_format(round($condiciongeneral, 3),2,',','.'). "% ";
				else
				echo number_format(round($condiciongeneral-1, 3),2,',','.'). "% ";
		}
		else
		{
			/*
			if ($articulo['laboratorio_id']==15) 
				echo number_format(round($condiciongeneralaz, 3),2,',','.'). "% ";
			else*/
			if ($articulo['mcdp']==0)
			echo number_format(round($condiciongeneral, 3),2,',','.'). "% ";
			else
			echo number_format(round($condiciongeneralmsd, 3),2,',','.'). "% ";
		}
	}

}
else
{
	if (($articulo['categoria_id']==1|| $articulo['categoria_id']==6|| $articulo['categoria_id']==7))// && $articulo['iva']==0)
    //echo number_format(round($condiciongeneral, 3),2,',','.'). "% ";
	//if ($articulo['categoria_id']==1 && $articulo['iva']==0)
	{
		if ($articulo['msd']==0)
		{
		if ($articulo['cadena_frio']==0 )
		{
			/*
			if ($articulo['laboratorio_id']==15) 
				echo number_format(round($condiciongeneralaz, 3),2,',','.'). "% ";
			else */
			if ($articulo['mcdp']==0)
			echo number_format(round($condiciongeneral, 3),2,',','.'). "% ";
			else
			echo number_format(round($condiciongeneral-1, 3),2,',','.'). "% ";
				
		}
		
		else
		if  ($articulo['subcategoria_id']<10 && $articulo['subcategoria_id']>=0)
			echo number_format(round($condiciongeneralcf, 3),2,',','.'). "% ";
			else
			if ($articulo['mcdp']==0)
				echo number_format(round($condiciongeneral, 3),2,',','.'). "% ";
				else
				echo number_format(round($condiciongeneral-1, 3),2,',','.'). "% ";
			
		}
		else
		{
			/*
			if ($articulo['laboratorio_id']==15) 
				echo number_format(round($condiciongeneralaz, 3),2,',','.'). "% ";
			else*/
				echo number_format(round($condiciongeneralmsd, 3),2,',','.'). "% ";
		}
		
	}
}
}	
else
{
	if (($articulo['categoria_id']==1|| $articulo['categoria_id']==6|| $articulo['categoria_id']==7))// && $articulo['iva']==0)
   // echo number_format(round($condiciongeneral, 3),2,',','.'). "% ";
   //if ($articulo['categoria_id']==1 && $articulo['iva']==0)
   {
	if ($articulo['msd']==0)
	{
	if ($articulo['cadena_frio']==0 )

	{
		/*
		if ($articulo['laboratorio_id']==15) 
			echo number_format(round($condiciongeneralaz, 3),2,',','.'). "% ";
		else*/
		if ($articulo['mcdp']==0)
		echo number_format(round($condiciongeneral, 3),2,',','.'). "% ";
		else
		echo number_format(round($condiciongeneral-1, 3),2,',','.'). "% ";
	}
	
	else
	if  ($articulo['subcategoria_id']<10 && $articulo['subcategoria_id']>=0)
		echo number_format(round($condiciongeneralcf, 3),2,',','.'). "% ";
		else
		if ($articulo['mcdp']==0)
				echo number_format(round($condiciongeneral, 3),2,',','.'). "% ";
				else
				echo number_format(round($condiciongenera-1, 3),2,',','.'). "% ";
	}
	else
	{
		/*
		if ($articulo['laboratorio_id']==15) 
			echo number_format(round($condiciongeneralaz, 3),2,',','.'). "% ";
		else*/
			echo number_format(round($condiciongeneralmsd, 3),2,',','.'). "% ";
	}
	
   }
}
?>
</td>
<td class="td-sub-tabla" style=" border: solid #fff; border-width: 0px 1px 0px 1px;">
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
<td class="td-sub-tabla" style=" border: solid #fff; border-width: 0px 1px 0px 1px;">
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
<td class="td-sub-tabla" style=" border: solid #fff; border-width: 0px 1px 0px 1px;">
<?php 
if ($articulo['descuentos'] !=null and $articulo['stock']!='F'){
if ($articulo['descuentos'][0]['tipo_venta']=='D')
{
	if ($articulo['descuentos'][0]['tipo_oferta']!='TH')
	{
		echo $articulo['descuentos'][0]['tipo_oferta'];
	}
	else
	{
		echo 'TD';
	}
}
else
if (count($articulo['descuentos'])>1)
if ($articulo['descuentos'][1]['tipo_venta']=='D')
{
	if ($articulo['descuentos'][0]['tipo_oferta']!='TH')
	{
		echo $articulo['descuentos'][1]['tipo_oferta'];
	}
	else
	{
		echo 'TD';
	}
}
}
?>
</td>
<td class='coliva' style="text-align: center;">
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
if (($articulo['imagen']!="perfumeria.jpg" && $articulo['imagen']!="sinimagen.png" && $articulo['imagen']!="sin_imagen.png") && ($articulo['imagen']!="medicamento.jpg" && $articulo['imagen']!="sin_imagen.png")) echo $this->Html->image('foto.png',['title' => 'Ampliar la foto','class'=>'imgFoto','data-id'=>$articulo['imagen']]);

if ($articulo['categoria_id']==1 || $articulo['categoria_id']==6 || $articulo['categoria_id']==7 ) echo $this->Html->image('equivalent.png',['url'=>['controller'=>'carritos','action'=>'alternativo',$articulo['id']]]);
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
<?= $this->Paginator->prev('< Anterior') ?>
<?= $this->Paginator->numbers() ?>
<?= $this->Paginator->next('Siguiente'.' >',['tabindex'=>$indice]) ?>
<div class="pagination_count"><span><?= $this->Paginator->counter('{{count}} Articulos') ?> </span></div>
</ul>
<!-- div class="importconfirm2">	
<div class="button-holder5"><?php //echo $this->Form->submit('Agregar Seleccionados',['class'=>'btn_agregarvarios']);?></div>	
</div -->
<?= $this->Form->end() ?>	
</div>
</div>
<script type="text/javascript">
	     $(document).ready(function() {
      // Obtener el elemento de entrada usando jQuery
      var $input = $('.formcartcant');
      
      // Desactivar el evento de pegado
      $input.on('paste', function (e) {
        e.preventDefault();
      });
      
      // Desactivar el evento de arrastrar y soltar
      $input.on('drop', function (e) {
        e.preventDefault();
      });
    });
       
	   
	$('#terminobuscar').val("");
	$('#terminobuscar').focus();
	if ($('#codigobarras').length) {
	var isChecked = document.getElementById('codigobarras').checked;
if(isChecked) {
 $('#terminobuscar').focus();
}
	}
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
function showdiv(event,text,iva,traza,frio,categ,pack,fv_cerca,fv,ean,dataimg)
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
eanimg ='<img src="https://www.drogueriasur.com.ar/ds/webroot/img/productos/'+ean+'" alt="'+ean+'" width="200px">';
//imgmelchor ='<img src="https://www.drogueriasur.com.ar/dsx/webroot/img/MELCHOR.png" width="50">';
//if(dataimg== 1){

//document.getElementById('flotante').innerHTML="<div id='flotante_text'>"+text+ivaimg+trazaimg+cadenaimg+psiimg+valeoficialimg+fvimg+fvcerca+"</div><div id='flotante_img'>"+eanimg+"</div><div id='flotante_img'>"+imgmelchor+"</div>";
//}else{

document.getElementById('flotante').innerHTML="<div id='flotante_text'>"+text+ivaimg+trazaimg+cadenaimg+psiimg+valeoficialimg+fvimg+fvcerca+"</div><div id='flotante_img'>"+eanimg+"</div>";
//}
// Posicionamos la capa flotante
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

document.getElementById("formaddcart").submit();
}
</script>
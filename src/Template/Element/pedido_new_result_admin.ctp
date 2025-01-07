<style>
.tablesorter td { border-left: 1px dotted #ccc;}
.header{ text-align: center;}
.colcenter{ text-align: center;}

#scrollToTopBtn { display: none; position: fixed; bottom: 20px; right: 20px; font-size: 24px; padding: 10px 15px; text-align: center; cursor: pointer; z-index: 1000; text-decoration: none; }

</style>
<div>		
<div id="tab1" class="tab_content">
<table class="tablesorter" cellspacing="0"> 
<thead> 
<tr>
<th class="header"><?= $this->Paginator->sort('id','Nro') ?></th>
<th class="header"><?= $this->Paginator->sort('cliente_id','Codigo') ?></th>
<th class="header"><?= $this->Paginator->sort('cliente_id','Razón Social') ?></th>
<th class="header"><?= $this->Paginator->sort('Fecha Recepción') ?></th>
<th class="header"><?= $this->Paginator->sort('tipo_fact', 'T. Fact.') ?></th>
<th class="header"><?= $this->Paginator->sort('estado_id','Estado') ?></th>
<th class="header"><?= $this->Paginator->sort('nro_pedido_ds','Nro. DS') ?></th>
<th class="header"><?= $this->Paginator->sort('comentario','Comentario') ?></th>
<th class="actions"><?= $this->Paginator->sort('pedidos_status_id','OTROS' )?></th>
<th class="header"><?= $this->Paginator->sort('id','PDF' )?></th>
</tr>
</thead>
<tbody>
<?php foreach ($pedidos as $pedido): ?>
<?php
if ($pedido['estado_id'] == 1) 
{
$esisla = 0;
if ( $pedido['c']['codigo']>79000 && $pedido['c']['codigo']<79999 )
{
if ($pedido['c']['codigo']!=70051 &&$pedido['c']['codigo']!=70122&& $pedido['c']['codigo']!=70319) $esisla = 1;
}
switch ($pedido['tipo_fact']) {
case '': $colorfondo = '#FFFF00';break;
case 'N': 
if ($esisla==1)	$colorfondo = '#ffbbaa';
else $colorfondo = '#ffbbff';break;
case 'TR': 
if ($esisla==1)	$colorfondo = '#bbffaa';
else $colorfondo = '#bbffff';break;
case 'TL': 
if ($esisla==1)	$colorfondo = '#ccffaa';
else $colorfondo = '#ccffff';break;
default: $colorfondo = '#FFFFFF'; break;
}
} 
else
{        
if ($pedido['estado_id'] == 2) $colorfondo = '#cccccc';
else $colorfondo = '#FFFFFF';
$esisla = 0;
if ( $pedido['c']['codigo']>79000 && $pedido['c']['codigo']<79999 )
{
if ($pedido['c']['codigo']!=70051 &&$pedido['c']['codigo']!=70122&& $pedido['c']['codigo']!=70319)
$esisla = 1;
}
switch ($pedido['tipo_fact']) {
case '': $colorfondo = '#FFFF00';break;
case 'N': 
if ($esisla==1)	$colorfondo = '#ffeeee';
break;
case 'TR': 
if ($esisla==1)	$colorfondo = '#f1ffed';
break;
case 'TL': 
if ($esisla==1)	$colorfondo = '#f6ffff';
break;
}
}           
echo '<tr bgcolor='.$colorfondo.'>';?>
<td class=colcenter><?php echo $pedido['id']; ?></td>
<td class=colcenter><?php echo $pedido['c']['codigo']; ?></td>
<td><?php echo $pedido['c']['razon_social'];?></td>
<td class=colcenter><?php echo date_format($pedido['creado'],'d-m-Y H:i:s');?></td>
<td class=colcenter><?php echo $pedido['tipo_fact']; ?></td>
<td class=colcenter><?php echo $estados[$pedido['estado_id']-1]['nombre']; ?></td>
<td class=colcenter><?php echo $pedido['nro_pedido_ds']; ?></td>
<td class=colcenter><?php if ($pedido['comentario']!=null )	
switch ($pedido['comentario']) {
    case 'TRANSFER':echo 'TRANSFER L'; break;
    case 'P.PAMI ': echo 'PAÑALES P';   break;
    case 'PA.PAMI ': echo 'PAÑALES P';   break;
    case 'Avion M': echo 'MED. X AEREO';   break;
    case 'Tierra M': echo 'MED. X TIERRA';   break;
    case 'TRANSFER T': echo 'TRANSFER T';break;
    case 'TFP': echo '<strong> >>RETIRA TFP<< </strong>';   break;
    case 'Tierra AP': echo 'AyP. X TIERRA';   break;
    case 'Avion AP': echo 'AyP. X TIERRA';   break;
    default: echo 'TIENE';
    }  
 ?></td>
<td class="actions">
<?php 
echo $this->Html->image("admin/admin_view.png", ["alt" => "View",'url'=>['controller' => 'pedidos', 'action' => 'view_admin_new',  $pedido['id']],'escape' => false,'target'=>'_blank',
'data-static'=>'../img/admin/admin_view.png','data-hover'=>'../img/admin/admin_view_i.gif','class'=>'hover-gif','style'=>'width=50px']);

$mensaje='';
switch ($pedido['pedidos_status_id']) {
case 1: $mensaje = 'No Habilitada';break;
// case 2: $mensaje = 'Cta. Export';break;
case 3: $mensaje = 'Posible Duplicado';break;
case 4: $mensaje = 'Cod. Cliente Incorrecto';break;
case 5: $mensaje = 'Limite Compra';break;
case 8: $mensaje = 'Anulado'; break;
case 9: $mensaje = 'Pos. Duplicado';break;
case 10: $mensaje = 'Sin NC PAMI'; break;
}
switch ($pedido['pedidos_status_id']) {
    case 3: 
        echo $this->Html->image("admin/admin_pos_duplicado.png", ["alt" => "View",'data-static'=>'../img/admin/admin_pos_duplicado.png','data-hover'=>'../img/admin/admin_pos_duplicado.gif','class'=>'hover-gif','style'=>'width=50px']);
        $mensaje = 'Posible Duplicado';break;
    case 4: $mensaje = 'Cod. Cliente Incorrecto';
    echo $this->Html->image("admin/admin_codigo_incorrecto.png", ["alt" => "View",'data-static'=>'../img/admin/admin_codigo_incorrecto.png','data-hover'=>'../img/admin/admin_codigo_incorrecto.gif','class'=>'hover-gif','style'=>'width=50px']);
    break;
    case 9: $mensaje = 'Pos. Duplicado';
    echo $this->Html->image("admin/admin_pos_duplicado.png", ["alt" => "View",'data-static'=>'../img/admin/admin_pos_duplicado.png','data-hover'=>'../img/admin/admin_pos_duplicado.gif','class'=>'hover-gif','style'=>'width=50px']);
break;
    default :
    echo  '<span style=" color:red;">'.$mensaje.'</span>';
}

if ($pedido['forma_envio']==99)
echo $this->Html->image("admin/admin_retiro.png", ["alt" => "Retira Cadete",
'data-static'=>'../img/admin/admin_retiro.png','data-hover'=>'../img/admin/admin_retiro.gif','class'=>'hover-gif','style'=>'width=50px']);

//echo $this->Html->image('admin/retira.png',['title' => 'Retira Cadete'] );
if (( $pedido['c']['codigo']>79000 && $pedido['c']['codigo']<79999 ))
{
echo $this->Html->image("admin/admin_avion.png", ["alt" => "Tierra del Fuego",
'data-static'=>'../img/admin/admin_avion.png','data-hover'=>'../img/admin/admin_avion.gif','class'=>'hover-gif','style'=>'width=50px']);

if ($pedido['impreso'])
echo $this->Html->image('admin/impreso.png',['title' => 'impreso'] );
}
?>
</td>
<td>
<?php
echo $this->Html->image('pdf.png',['title' => 'Descargar PDF','url'=>['controller'=>'Comprobantes','action' => 'downloadfile', $pedido['nro_pedido_ds'], 1,date_format($pedido['creado'],'Ymd')]]); 			
echo $this->Html->image('pdf_view.png',['title' => 'Visualizar PDF','url'=>['controller'=>'Comprobantes','action' => 'view_nota_admin', $pedido['cliente_id'],$pedido['nro_pedido_ds'],date_format($pedido['creado'],'Ymd')]]); 
//if ($pedido['imporeso'])
//echo $this->Html->image('admin/impreso.png',['title' => 'impreso'] );
?>
</td>
</tr>
<?php endforeach; ?>
</tbody> 
</table>
</div><!-- end of #tab1 -->
</div><!-- end of .tab_container -->
<div class="pagination">
<ul >
<?php
echo $this->Paginator->prev(__('Anterior'), array('tag' => 'li'), null, array('tag' => 'li','disabledTag' => 'a'));
echo $this->Paginator->numbers(array('separator' => '','currentTag' => 'a', 'currentClass' => 'active','tag' => 'li','first' => 1));
echo $this->Paginator->next(__('Siguiente'), array('tag' => 'li','currentClass' => 'disabled'), null, array('tag' => 'li','disabledTag' => 'a'));
?>
</ul>
<div class="total">
<?php
echo $this->Paginator->counter('{{count}} Total');
?>
</div>
</div>
</div>		
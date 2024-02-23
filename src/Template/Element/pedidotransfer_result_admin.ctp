<style>
    .tdcelda , .header{ text-align: center;}
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
<th class="header"><?= $this->Paginator->sort('transfer','Transfer') ?></th>
<th class="actions"><?= $this->Paginator->sort('pedidos_status_id','OTROS' )?></th>
</tr>
</thead>
<tbody>
<?php

                    use Symfony\Component\Console\Style\StyleInterface;

foreach ($pedidostransfers as $pedido): ?>
<?php
if ($pedido['estado_id'] == 1) 
{
$esisla = 0;
if (( $pedido['cliente']['codigo']>79000 && $pedido['cliente']['codigo']<79999 )||( $pedido['cliente']['codigo']>70000 && $pedido['cliente']['codigo']<70999 ) )
{
if ($pedido['cliente']['codigo']!=70051 &&$pedido['cliente']['codigo']!=70122&& $pedido['cliente']['codigo']!=70319) $esisla = 1;
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
if (( $pedido['cliente']['codigo']>79000 && $pedido['cliente']['codigo']<79999 )||( $pedido['cliente']['codigo']>70000 && $pedido['cliente']['codigo']<70999 ) )
{
if ($pedido['cliente']['codigo']!=70051 &&$pedido['cliente']['codigo']!=70122&& $pedido['cliente']['codigo']!=70319)
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
echo '<tr style="height: 45px; " bgcolor='.$colorfondo.'>';?>
<td><?php echo $pedido['id']; ?></td>
<td class=tdcelda><?php echo $pedido['cliente']['codigo']; ?></td>
<td><?php echo $pedido['cliente']['razon_social'];?></td>
<td class=tdcelda><?php echo date_format($pedido['creado'],'d-m-Y H:i:s');?></td>
<td class=tdcelda><?php echo $pedido['tipo_fact']; ?></td>
<td class=tdcelda><?php echo  $pedido['estado_id'] ;

            //echo $estados[$pedido['estado_id']-1]['nombre']; ?></td>
<td class=tdcelda><?php echo $pedido['nro_pedido_ds']; ?></td>
<td><?php if ($pedido['comentario']!=null )	echo $pedido['comentario']; ?></td>
<td class=tdcelda><?php echo $pedido['transfer']; ?></td>
<td class="actions">
<?php 
echo $this->Html->link($this->Html->image("admin/icn_view.png", ["alt" => "Ver"]),['controller' => 'TransfersProveedors', 'action' => 'view_admin',  $pedido['id']],['escape' => false,'target'=>'_blank']);
$mensaje='';
switch ($pedido['pedidos_status_id']) {
case 1: $mensaje = 'No Habilitada';break;
// case 2: $mensaje = 'Cta. Export';break;
case 3: $mensaje = 'Posible Duplicado';break;
case 4: $mensaje = 'Cod. Cliente Incorrecto';break;
case 5: $mensaje = 'Limite Compra';break;
case 7: $mensaje = 'Con Faltas';break;
case 8: $mensaje = 'Anulado'; break;
case 9: $mensaje = 'Pos. Duplicado';break;
case 10: $mensaje = 'Sin NC PAMI'; break;
case 25: $mensaje = 'P Enviado (L)';break;
case 27: $mensaje = 'P Enviado (F)';break;
case 31: $mensaje = 'P Enviado (NH)';break;
}
if ($pedido['pedidos_status_id']==7 || $pedido['pedidos_status_id'] ==5 || $pedido['pedidos_status_id']==1)
echo $this->Html->link($this->Html->image("admin/icon_refacturar.png", ["alt" => "Ver",'style'=>'margin-left:10px;margin-right:10px;']),['controller' => 'TransfersProveedors', 'action' => 'volver_enviar_admin',  $pedido['id']],['escape' => false,'target'=>'_blank']);

echo  '<div style ="float:right;margin: 10px 0px 10px 0px;color:red;">'.$mensaje.'</div>';


if ($pedido['forma_envio']==99)
echo $this->Html->image('admin/retira.png',['title' => 'Retira Cadete'] );
if (( $pedido['cliente']['codigo']>79000 && $pedido['cliente']['codigo']<79999 )||( $pedido['cliente']['codigo']>70000 && $pedido['cliente']['codigo']<70999 ) )
{
if ($pedido['cliente']['codigo']!=70051 && $pedido['cliente']['codigo']!=70122 && $pedido['cliente']['codigo']!=70319)
echo $this->Html->image('admin/export.png',['title' => 'Tierra del Fuego' ,'style'=>'margin-left:10px;margin-right:10px;'] );
if ($pedido['impreso'])
echo $this->Html->image('admin/impreso.png',['title' => 'impreso'] );
}


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
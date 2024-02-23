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
</tr>
</thead>
<tbody>
<?php foreach ($pedidos as $pedido): ?>
<?php
if ($pedido['estado_id'] == 1) 
{
$esisla = 0;
if (( $pedido['c']['codigo']>79000 && $pedido['c']['codigo']<79999 )||( $pedido['c']['codigo']>70000 && $pedido['c']['codigo']<70999 ) )
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
if (( $pedido['c']['codigo']>79000 && $pedido['c']['codigo']<79999 )||( $pedido['c']['codigo']>70000 && $pedido['c']['codigo']<70999 ) )
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
<td><?php echo $pedido['id']; ?></td>
<td><?php echo $pedido['c']['codigo']; ?></td>
<td><?php echo $pedido['c']['razon_social'];?></td>
<td><?php echo date_format($pedido['creado'],'d-m-Y H:i:s');?></td>
<td><?php echo $pedido['tipo_fact']; ?></td>
<td><?php echo $estados[$pedido['estado_id']-1]['nombre']; ?></td>
<td><?php echo $pedido['nro_pedido_ds']; ?></td>
<td><?php if ($pedido['comentario']!=null )	echo 'TIENE'; ?></td>
<td class="actions">
<?php 
$mensaje='';
switch ($pedido['pedidos_status_id']) {
case 1: $mensaje = 'No Habilitada';break;
// case 2: $mensaje = 'Cta. Export';break;
case 3: $mensaje = 'Posible Duplicado';break;
case 4: $mensaje = 'Cod. Cliente Incorrecto';break;
case 5: $mensaje = 'Limite Compra';break;
case 8: $mensaje = 'Anulado'; break;
}
echo  '<span style=" color:red;">'.$mensaje.'</span>';
if ($pedido['forma_envio']==99)
echo $this->Html->image('admin/retira.png',['title' => 'Retira Cadete'] );
if (( $pedido['c']['codigo']>79000 && $pedido['c']['codigo']<79999 )||( $pedido['c']['codigo']>70000 && $pedido['c']['codigo']<70999 ) )
{
if ($pedido['c']['codigo']!=70051 &&$pedido['c']['codigo']!=70122&& $pedido['c']['codigo']!=70319)
echo $this->Html->image('admin/export.png',['title' => 'Tierra del Fuego'] );
if ($pedido['impreso'])
echo $this->Html->image('admin/impreso.png',['title' => 'impreso'] );
}
echo $this->Html->link($this->Html->image("admin/icn_view.png", ["alt" => "Ver"]),['controller' => 'pedidos', 'action' => 'view_admin',  $pedido['id']],['escape' => false,'target'=>'_blank']);
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
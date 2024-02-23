<style>
.button_continuar .label{
	width : 150px; 
}
label{
	width : 250px;
}
</style>
<div class="col-md-12">
<div class="product-item-3" style="margin-bottom: 0px;">
<div class="product-content">
<h1>Nuevo Transfer</h1>
</div><!-- /.product-content -->
</div> <!-- /.col-md- -->
<div class="product-item-3">

<div class="product-thumb">
<!--div style="height:100px" -->
<div class="search-form">
<?= $this->Form->create('Transfers',['url'=>['controller'=>'Transfers','action' => 'add'],'id'=>'searchform5']) ?>
<?php echo $this->Form->control('codigo', ['empty' => true,'class' =>'codigoimput','label'=>'Ingrese un código de cliente','placeholder'=>'Ingrese un código de cliente']);  
	  echo $this->Form->submit('Continuar',['class'=>'mainBtn']);?>
<?= $this->Form->end() ?>
</div>
</div><!-- /.product-content -->
</div> <!-- /.col-md- -->
</div>
<div class="col-md-12">
<div class="product-item-3" >
<div class="product-thumb"><h3><?= __('Pedidos Transfers') ?></h3>
</div> <!-- /.product-thumb -->
<div class="product-content" style ="position:relative; height:100%">
<table class='tablasearch' cellpadding="0" cellspacing="0">
<thead>
<tr>
<th scope="col"><?= $this->Paginator->sort('id','Nro') ?></th>
<th scope="col"><?= $this->Paginator->sort('creado') ?></th>
<th scope="col"><?= $this->Paginator->sort('cliente_id','Codigo') ?></th>
<th scope="col"><?= $this->Paginator->sort('cliente_id','Razón Social') ?></th>
<th scope="col"><?= $this->Paginator->sort('oferta_plazo') ?></th>
<th scope="col"><?= $this->Paginator->sort('pedidos_status_id') ?></th>
<th scope="col"><?= $this->Paginator->sort('cantidad_item') ?></th>
<th scope="col" class="actions"><?= __('Actions') ?></th>
</tr>
</thead>
<tbody>
<?php foreach ($pedidosPreventas as $pedidosPreventa): ?>
<tr>
<td><?= $this->Number->format($pedidosPreventa->id) ?></td>
<td><?= h($pedidosPreventa->creado) ?></td>
<td><?php echo $pedidosPreventa['cliente']['codigo'];?></td>
<td><?php echo $pedidosPreventa['cliente']['nombre'];?></td>
<td><?= h($pedidosPreventa->oferta_plazo) ?></td>
<td><?= $this->Number->format($pedidosPreventa->pedidos_status_id) ?></td>
<td><?= $this->Number->format($pedidosPreventa->cantidad_item) ?></td>
<td class="actions">
<?php echo $this->Html->link(
$this->Html->image("admin/icn_view.png", ["alt" => "Ver"]),
['controller' => 'Transfers', 'action' => 'view',  $pedidosPreventa['id']],['escape' => false,'target'=>'_blank']);
?>
<?php 
echo $this->Form->postLink(
$this->Html->image('admin/icn_trash.png',
array("alt" => __('Delete'), "title" => __('Delete'))), 
array('controller' => 'Transfers','action' => 'delete_transfer', $pedidosPreventa->id), 
array('escape' => false, 'confirm' => __('Esta seguro de eliminar a # {0}?', $pedidosPreventa->id)));
?>
</td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
<div class="paginator">
<ul class="pagination">
<?= $this->Paginator->first('<< ' . __('first')) ?>
<?= $this->Paginator->prev('< ' . __('previous')) ?>
<?= $this->Paginator->numbers() ?>
<?= $this->Paginator->next(__('next') . ' >') ?>
<?= $this->Paginator->last(__('last') . ' >>') ?>
</ul>
<p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
</div>
</div><!-- /.product-content -->
</div> <!-- /.col-md-3 -->
</div>
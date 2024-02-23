
<style>
	.tablasearch th {
    padding: 0.75rem;
    vertical-align: top;
    border-top: 1px solid #dee2e6;
}
.tablasearch {
    width: 100%;
    max-width: 100%;
    margin-bottom: 1rem;
    background-color: transparent;
}
</style>
<article class="module width_3_quarter">
		<header><h3 class="tabs_involved"><?= $titulo ?></h3></header>
		<div class="tab_container">



		<div class="form_search">

<div style="float: left; margin: 15px; font-size:  15px;">TOTAL UNIDADES PEDIDAS :<b> <?php echo $total;//""; $total["total"];?></b> </div>

<div  style="float: left; margin: 15px; font-size:  13px;">
<table class='tablasearch' cellpadding="1" cellspacing="1" style="border: 2px   solid #1c2e4c;">
<thead>
<tr style="border: 2px   solid #1c2e4c;">
<th scope="col"><?= $this->Paginator->sort('Nombre','PROVEEDORES') ?></th>
<th scope="col"><?= $this->Paginator->sort('subTotal','UNIDADES') ?></th>
<th scope="col"><?= $this->Paginator->sort('Clientes','VENTAS') ?></th>
<th scope="col"><?= $this->Paginator->sort('Clientes','CLIENTES') ?></th>
</tr>
</thead>
<tbody style="border: 2px   solid #1c2e4c;">

<?php
if (!empty($subtotales))
{
    $max= sizeof($subtotales);
}
else
	$max=0;
$i=0;
foreach ($subtotales as $query): ?>
<tr>
<td><?php echo $query['nombre']; ?></td>
<td style="text-align: center;"><?php echo $query['subtotal']; ?></td>
<?= $this->Form->create('Users',['url'=>['controller'=>'Descuentos','action'=>'excelventasclientes'],'id'=>'searchform6']); ?>
<td style="text-align: center;"><input name="laboratorioid" hidden value="<?php echo $query['laboratorio_id']; ?>">  <p><button type="submit" style="background: transparent;border: none;color: transparent;cursor:pointer;"><?php echo  $this->Html->image('excel.png'); ?></button></p></td>
<?= $this->Form->end() ?>
<?= $this->Form->create('Users',['url'=>['controller'=>'Descuentos','action'=>'excelclientes'],'id'=>'searchform6']); ?>
<td style="text-align: center;"><input name="laboratorioid" hidden value="<?php echo $query['laboratorio_id']; ?>">  <p><button type="submit" style="background: transparent;border: none;color: transparent;cursor:pointer;"><?php echo  $this->Html->image('excel.png'); ?></button></p></td>
<?= $this->Form->end() ?>
</tr>
<?php endforeach; ?>
</tbody>
</table >

</div>
<div  style="float: left; margin: 15px; font-size:  13px;">
    <?= $this->Form->create('Users',['url'=>['controller'=>'Descuentos','action'=>'excel'],'id'=>'searchform4']); ?>
	<label>DESCARGAR LISTADO DE TODAS LAS UNIDADES PEDIDAS</label>
<button class="btn-success" style="color: #fff;background-color: #28a745;border-color: #28a745;display: flex;flex-direction: row;flex-wrap: nowrap; align-content: center;justify-content: center;align-items: center;"title="Descargar Listado de todas las unidades pedidas." type="submit">DESCARGAR<?php echo  $this->Html->image('excel.png'); ?></button>
	<?= $this->Form->end() ?>
</div>
<div  style="float: left; margin: 15px; font-size:  13px;">
    <?= $this->Form->create('Users',['url'=>['controller'=>'Descuentos','action'=>'excelventastodosclientes'],'id'=>'searchform4']); ?>
	<label>DESCARGAR LISTADO DE LO FACTURADO</label>
<button class="btn-success" style="color: #fff;background-color: #28a745;border-color: #28a745;display: flex;flex-direction: row;flex-wrap: nowrap; align-content: center;justify-content: center;align-items: center;"title="Descargar Listado de todas las unidades pedidas." type="submit">DESCARGAR<?php echo  $this->Html->image('excel.png'); ?></button>
	<?= $this->Form->end() ?>
</div>
</div>

		<?php //echo $this->element('descuentos_search_admin'); ?>
		<?php echo $this->element('descuentos_result_admin'); ?>
		 </div><!-- end of .tab_container -->
</article><!-- end of content manager article -->

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
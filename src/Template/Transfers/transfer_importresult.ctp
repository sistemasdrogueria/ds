<div class="articulos index large-10 medium-9 columns">
<table class='tablasearch' cellpadding="0" cellspacing="0">
<thead>
<tr>	
<th >EAN</th>
<th>Descripción</th>
<th><div id="th-sub-tabla">Dto</div></td>
<th><div id="th-sub-tabla">U.Min</div></td>
<th><div id="th-sub-tabla">Plazo</div></td>
<th><div id="th-sub-tabla">Tipo Of.</div></td>
<th>Ref.</th>
<th ></th>
</tr>
</thead>
<tbody>
<div id="flotante"></div>
<?php $indice=0; ?>
<?= $this->Form->create('CarritosTemps',['url'=>['controller'=>'Carritos','action'=>'carritotempaddall'],'id'=>'formaddcart','onsubmit'=>'return validaragregar()']); ?>
<?php 	
foreach ($articulos as $articulo):
$indice+=1;
$encabezado = $indice.'.';
?>
<tr>
<td><?php echo $articulo['codigo_barras']; ?></td>
<td class='masinfoband'>
<?php echo $articulo['descripcion_pag']; ?>	
</td>
<td class="td-sub-tabla">
<?php echo $articulo['preventas'][0]['dto_drogueria'].'% '.'</font>'; ?>
</td>
<td class="td-sub-tabla">
<?php echo $articulo['preventas'][0]['uni_min'];?>
</td>
<td class="td-sub-tabla">
<?php echo $articulo['preventas'][0]['plazo'];?>
</td>
<td class="td-sub-tabla">
<?php echo $articulo['preventas'][0]['tipo_oferta'];?>
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
//if ($articulo['msd']==1 and $articulo['categoria_id']=1){ echo $this->Html->image('msd.png',['title' => 'Medicamento Sin descuento']);	}
?>
</td> 
<td class="actions">
<?php
$articulo_id= $articulo['id'];
echo $this->Html->link($this->Html->image("delete_ico.png", ["alt" => "Quitar del carro"]),"/carritos/delete_temp/".$articulo_id,['escape' => false]);
?>
</td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
<div class="paginatorimport">
<ul class="pagination">
<?= $this->Paginator->prev('< ' . __('Anterior')) ?>
<?= $this->Paginator->numbers() ?>
<?= $this->Paginator->next(__('Siguiente') . ' >',['tabindex'=>$indice]) ?>
</ul>
<div class="importconfirm3">	
<div class="button-holder3">
<?=
$this->Html->link(
'Confirmar',
['controller' => 'Transfers', 'action' => 'import_confirm'],
['confirm' => 'Esta importar los articulos en esta lista']
)
?>
</div>
<div class="button-holder3">
<?=
$this->Html->link('Vaciar',['controller' => 'Transfers', 'action' => 'vaciar_import'],['confirm' => 'Esta seguro de vaciar esta lista de articulos importados'])
?>
</div>
<div class="button-holder3">
<?php echo $this->Form->submit('Modificar Seleccionados',['class'=>'btn_agregarvarios']);?>	
</div>	
</div>	
<?= $this->Form->end() ?>	
</div>
</div>
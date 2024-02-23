<style>
.marca_img{
    width: 150px;
  height: 75px;
  object-fit: contain;

}
.tablesorter{
  text-align: center;
}
.tablesorter td {

    padding-left: 5px;
    border-right: 2px solid #ccc !important;
    border-bottom: 1px dotted #ccc;
    margin: 0;
}

</style>

<div>	
<div id="tab1" class="tab_content">
<table class="tablesorter" cellpadding="0" cellspacing="0"> 
<thead> 
<tr>

  <th><?= $this->Paginator->sort('codigo','Codigo p') ?></th>
  <th><?= $this->Paginator->sort('hora_n',' Hora Nocturno') ?></th>
  <th><?= $this->Paginator->sort('hora_d', 'Hora Diurno') ?></th>
  <th><?= $this->Paginator->sort('hora_f', 'Hora Domingo') ?></th>
  <th><?= $this->Paginator->sort('dia_n') ?></th>
  <th><?= $this->Paginator->sort('dia_d') ?></th>
  <th><?= $this->Paginator->sort('dia_f') ?></th>
  <th><?= $this->Paginator->sort('proximo_h','Proximo Hora') ?></th>
  <th><?= $this->Paginator->sort('salida_n_id','Transporte Nocturno') ?></th>
  <th><?= $this->Paginator->sort('salida_d_id','Transporte Diurno') ?></th>
  <th><?= $this->Paginator->sort('salida_f_id','Transporte Domingo') ?></th>
<th class="actions"><?= __('') ?></th>
</tr>
</thead>
<tbody>
<?php $indice=0;  ?>
<?php foreach ($cortes as $corte): ?>
<tr>
<td><?= $corte->codigo ?></td>
<td><?php  echo date_format($corte->hora_n,'H:i').' Hs'; ?></td>
<td><?php  echo date_format($corte->hora_d,'H:i').' Hs'; ?></td>
<td><?php  echo date_format($corte->hora_f,'H:i').' Hs'; ?></td>


<td><?php if ($corte->dia_n  ==0) echo 'Diario';
          if ($corte->dia_n  ==2) echo 'Lunes';
          if ($corte->dia_n  ==  135) echo 'Lu Mi Vi';
          if ($corte->dia_n  ==  46) echo 'Mi-Vi';
?></td>
<td><?php if ($corte->dia_d  ==0)   echo 'Diario';
            if ($corte->dia_d  == 2) echo 'Lunes';
            if ($corte->dia_d  ==  135) echo 'Lu Mi Vi';
            if ($corte->dia_d  ==  46) echo 'Mi-Vi';

?></td>

<td><?php   if ($corte->dia_f  == 7 ) echo 'Domingo';
           

?></td>


<td><?= h($corte->proximo_h) ?></td>

<td><?php if ($corte["salida_n_id"]>0) echo $salidas[$corte["salida_n_id"]]; ?></td>
<td><?php if ($corte["salida_d_id"]>0) echo $salidas[$corte["salida_d_id"]]; ?></td>
<td><?php if ($corte["salida_f_id"]>0) echo $salidas[$corte["salida_f_id"]]; ?></td>
<td class="actions">
<?=	$this->Html->image("admin/icn_edit.png", [ "alt" => "Edit",'url' => ['controller' => 'Cortes', 'action' => 'edit_admin',  $corte->id]]); ?>
<?php echo $this->Form->postLink(
$this->Html->image('admin/icn_trash.png',["alt" => __('Delete'), "title" => __('Delete')]), ['action' => 'delete_admin', $corte->id], ['escape' => false, 'confirm' => __('Esta seguro de eliminar a # {0}?', $corte->id)]);
?>
</td>
</tr>
<?php endforeach; ?>
</tbody> 
</table>


</div><!-- end of .tab_container -->
<div class="pagination">
<ul>
<?php
echo $this->Paginator->prev(__('Anterior'), array('tag' => 'li'), null, array('tag' => 'li','disabledTag' => 'a'));
echo $this->Paginator->numbers(array('separator' => '','currentTag' => 'a', 'currentClass' => 'active','tag' => 'li','first' => 1));
echo $this->Paginator->next(__('Siguiente'), array('tag' => 'li','currentClass' => 'disabled'), null, array('tag' => 'li','disabledTag' => 'a')); ?>

<div class="total">
<?php echo $this->Paginator->counter('{{count}} Total'); ?>
</div>
</ul>
</div>

</div>		

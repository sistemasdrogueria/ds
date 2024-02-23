<div class="index large-10 medium-9 columns">
<table class='tablasearch' cellpadding="0" cellspacing="0">
<thead>
<tr>	
<th><?= $this->Paginator->sort('fecha','Fecha') ?></th>
<th><?= $this->Paginator->sort('obra_social_id','Obra Social') ?></th>
<th><?= $this->Paginator->sort('tipo_nota','Tipo Nota') ?></th>
<th><?= $this->Paginator->sort('nro_nota','Nro Nota') ?></th>
<th><?= $this->Paginator->sort('importe') ?></th>
</tr>
</thead>

<tbody>
<div id="flotante"></div>
<?php $indice=0;
$tiporegistros = $obrasociales->toArray();
?>

<?php foreach ($ctacteObrasSociales as $ctacteObrasSociale):	?>
<?php $indice+=1;?>
<tr>
<td class="colcenter">
<?php echo date_format($ctacteObrasSociale->fecha,'d-m-Y');	?>
</td>
<td>
<?php echo $tiporegistros[$ctacteObrasSociale['obra_social_id']]; ?>
</td>
<td class="colcenter">
<?php echo $ctacteObrasSociale->tipo_nota;	?>
</td>
<td class="colcenter">
<?php echo $ctacteObrasSociale->nro_nota;	?>
</td>
<td class='colprecio2'> <?php 
if ($ctacteObrasSociale->signo)
echo '$ '.number_format(round($ctacteObrasSociale->importe*-1, 3),2,',','.'); 
else
echo '$ '.number_format(round($ctacteObrasSociale->importe, 3),2,',','.'); 
?>
</td>
</tr>
<?php endforeach; $indice+=2;?>
</tbody>
</table>
<div class="paginator">
<ul class="pagination">
<?= $this->Paginator->prev('< ' . __('Anterior')) ?>
<?= $this->Paginator->numbers() ?>
<?= $this->Paginator->next(__('Siguiente') . ' >',['tabindex'=>$indice]) ?>
<div class="pagination_count"><span><?= $this->Paginator->counter('{{count}} Registros') ?> </span></div>
</ul>
</div>
</div>
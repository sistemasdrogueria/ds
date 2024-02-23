<style> 
.input_file_option{width: 200px; float: left; margin-right: 20px;     
   
  }
  .input_file_option select{      
    height: 25px;
    border: 1px solid #bbb;border-radius:4px; padding: 5px;
  }
.input_file_date{ width: 200px; float: left;}
.input_file_last{width: 150px;float: left; margin-right: 20px;}
.input_file_period{width: 155px;float: left;}
</style>
<div class="clear"></div>
<article class="module width_full">
<?php
if (!empty($transfersimport_id))
{if ($transfersimport_id>5)
echo $this->Form->create('TransfersProveedors',['url'=>['controller'=>'TransfersProveedors','action'=>'downloadfiletxtfortransfer',$transfersimport_id]]);
else
echo $this->Form->create('TransfersProveedors',['url'=>['controller'=>'TransfersProveedors','action'=>'downloadfiletxtforday']]);
}
else
echo $this->Form->create('TransfersProveedors',['url'=>['controller'=>'TransfersProveedors','action'=>'downloadfiletxt']]) ;
?>
<header>
<legend><h3 class="tabs_involved"><?= $titulo ?></legend>
</header>
<div class="module_content">
<fieldset>
<div class="input_file_option">
<?php echo $this->Form->input('option_prov', ['label'=>'Proveedor','options' => $tfl,'empty'=>'Proveedor']);?>
</div>
<div class="input_file_last">
<?php	echo $this->Form->input('ultimo', ['label'=>'Ultimo Número']);		?>
</div>
<div class="input_file_period">
<?php	
$fecha = new DateTime();
date_format($fecha, 'YYMM'); 
echo $this->Form->input('periodo', ['label'=>'Periodo','value'=>date_format($fecha, 'Ym')]);?>
</div>
</fieldset>
<fieldset>

<div class="input_file_date">
<?= $this->Form->input('fechadesde', ['label'=>'Desde','id'=>'fechadesde','name'=>'fechadesde', 'type'=>'text','placeholder'=>'Desde:']);?>
</div>
<div class="input_file_date">
<?=	$this->Form->input('fechahasta', ['label'=>'Hasta','id'=>'fechahasta','name'=>'fechahasta', 'type'=>'text','placeholder'=>'Hasta:']);?>
</div>

</fieldset>
</div><div class="clear"></div>
<footer>
<div class="submit_link">
<?= $this->Form->button(__('Generar Archivo')) ?>
<?= $this->Form->end() ?>
</div>
</footer>
</article><!-- end of post new article -->
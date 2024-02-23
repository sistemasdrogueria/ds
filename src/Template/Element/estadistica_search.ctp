<style>	label {display: none;}</style>
<?= $this->Html->css('estadistica/daterangepicker');?>
<?= $this->Html->css('estadistica/bootstrap-datetimepicker');?>

<div class="col-md-12 col-sm-12 col-xs-12">		   
<div class="x_panel">
<div class="x_title">
    <h2>Filtro - Estadisticas de Compras</h2>
    <ul class="nav navbar-right panel_toolbox">
    
    <li><a class="close-link"><i class="fa fa-close"></i></a>
    </li>
    </ul>
    <div class="clearfix"></div>
 </div> <!-- x_title -->
<div class="x_content">
    <?= $this->Form->create('',['url'=>['controller'=>'Estadisticas','action'=>'index'],'class'=>'form-horizontal form-label-left input_mask','id'=>'searchform4']); ?>
    <?php $select = 
    $meses = array();
    $meses = ["12", "11", "10", "9", "8", "7", "6", "5", "4", "3", "2", "1"];
    ?>
    <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
    <?=	$this->Form->input('fechadesde', ['class'=>'form-control has-feedback-left','label'=>'','id'=>'fechadesde','name'=>'fechadesde', 'type'=>'text','placeholder'=>'Fecha Desde:']);?>
    <span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span>
    </div>
    <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
    <?=	$this->Form->input('fechahasta', ['class'=>'form-control','label'=>'','id'=>'fechahasta','name'=>'fechahasta', 'type'=>'text','placeholder'=>'Fecha Hasta:']);?>
    <span class="fa fa-calendar form-control-feedback right" aria-hidden="true"></span>
    </div>
    <div class="col-md-6 col-sm-6 col-xs-12 ">
<label class="control-label col-md-4 col-sm-4 col-xs-12" style="display: block !important;    text-align: left; ">Cantidad de meses a mostrar</label>
<div class="col-md-3 col-sm-3 col-xs-12" style=" text-align: left;">
<?php echo $this->Form->select('meses',$meses,['empty' => 'Cantidad','class'=>'form-control','id'=>'meses','onChange'=>'document.getElementById("searchform4").submit();']);?>
</div>
</div>
    <div class="form-group">
        <div class="col-md-12 col-sm-12 col-xs-12"  style="margin-top: 20px;">
        <!-- ?= $this->Form->button('Cancelar', ['type' => 'button','class' => 'btn btn-danger','onclick' => 'location.href=\'/ds/carritos/index\'']);? -->
        <?= $this->Form->button('Reset', ['type'=>'reset','class' => 'btn btn-primary','div' => false]); ?>
        <?= $this->Form->button(__('Buscar'),['type'=>'submit','class'=>'btn btn-success']) ?>	  
        </div>
    </div>
<?= $this->Form->end() ?>
</div> <!-- x_content -->
</div> <!-- x_panel-->
</div> <!-- col-md-12 col-sm-12 col-xs-12-->
<?= $this->Html->css('estadistica/switchery.min');?>
<?= $this->Html->script('estadistica/switchery.min');?>
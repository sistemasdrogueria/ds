<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Corte $corte
 */
?>

<style>

.inputhora {
    float: left;
    width: 150px;
    margin-right: 15px;
}
.inputdia {
    float: left;
    width: 152px;
    margin-right: 15px;
    margin-left: 20px;    padding-left: 10px;

}
.inputsalida {
    float: left;
    width: 152px;
    margin-right: 15px;
    margin-left: 20px;    padding-left: 10px;

}
.proximo_h {width: 150px;}
.proximo_h input[type=datetime] { width: 50px; float: left;}
.proximo_h input[type=date] { width: 80px;}

.containerb {
    font-size: 0; /* Elimina el espacio entre los divs */
}

.box {
    display: inline-block;
    width: 33%; /* Distribuye los divs en tercios */
    vertical-align: top; /* Alinea los divs en la parte superior */
    font-size: 16px; /* Reajusta el tamaño de fuente */
}

.box label{
    width: 210px;
}
</style>

<?php //><script type="text/javascript">
$previous = "javascript:history.go(-1)";
if(isset($_SERVER['HTTP_REFERER'])) {
$previous = $_SERVER['HTTP_REFERER'];
}
?>
<div class="clear"></div>
<article class="module width_full">
<header><h3 class="tabs_involved"><?= $titulo ?></h3>
<div class="volveratras"><a href="<?= $previous ?>"><?= $this->Html->image('icn_volver.png');?></a></div>
</header>
<?= $this->Form->create($corte, ['url'=>['controller'=>'Cortes','action'=>'edit_admin']]) ?>
<fieldset>	
<?php echo $this->Form->input('codigo'); ?>
</fieldset>	
<fieldset>		
<div class="containerb">		
<div class="box">
<?= $this->Form->control('hora_n',['label'=>'HORA NOCTURNO','type' =>'text','empty' => true, 'value'=> date_format($corte->hora_n,'H:i:s')]); ?>
</div>
<div class="box">
<?= $this->Form->control('hora_d',['label'=>'HORA DIURNO','type' =>'text','empty' => true,'value'=> date_format($corte->hora_d,'H:i:s')]); ?>
</div>
<div class="box">
<?= $this->Form->control('hora_f',['label'=>'HORA FINDE','type' =>'text','empty' => true,'value'=> date_format($corte->hora_f,'H:i:s')]); ?>
</div>
</div>
</fieldset>
<fieldset>	
<?php $opciones =  [ 0 =>'LUNES A VIERNES', 8 =>'NINGUNO', 2 =>'LUNES', 35 =>'MARTES Y JUEVES', 4 =>'MIERCOLES y VIERNES',7 =>'DOMINGO'];?>
<div class="containerb">
<div class="box">
<?= $this->Form->control('dia_n', ['label'=>'DIA NOCTURNO','options' =>$opciones]); ?>
</div>
<div class="box">
<?= $this->Form->control('dia_d', ['label'=>'DIA DIURNO','options' =>$opciones]); ?>
</div>
<div class="box">
<?= $this->Form->control('dia_f', ['label'=>'DIA FINDE','options' =>$opciones]); ?>
</div>
</div>
</fieldset>	
<fieldset>	
<?php 
echo $this->Form->input('proximo_h', ['label'=>'PROXIMO HORARIO','empty' => true,'type'=>'text', 'style=float:left; width:50px;']);?>
</fieldset>	

<fieldset>
	

<div class="containerb">
<div class="box">
<?= $this->Form->control('salida_n_id',['label'=>'TRANSPORTE NOCTURNO','options' =>$salidas,'empty' => true]); ?>
</div>
<div class="box">
<?= $this->Form->control('salida_d_id', ['label'=>'TRANSPORTE DIURNO','options' =>$salidas,'empty' => true]); ?>
</div>
<div class="box"> 
<?= $this->Form->control('salida_f_id', ['label'=>'TRANSPORTE FINDE','options' =>$salidas,'empty' => true]); ?>
</div>
</div>
</fieldset>			
	

<fieldset>
<div class="ofertainputbotton">
<?= $this->Form->button(__('GUARDAR')) ?>
</div>
<?= $this->Form->end() ?>
</fieldset>
</article> 

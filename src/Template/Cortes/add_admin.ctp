

<?php //><script type="text/javascript">
$previous = "javascript:history.go(-1)";
if(isset($_SERVER['HTTP_REFERER'])) {
$previous = $_SERVER['HTTP_REFERER'];
}
?>
<div class="ofertas form large-10 medium-9 columns">
<article class="module width_3_quarter">
<header><h3 class="tabs_involved"><?= $titulo ?></h3>
<div class="volveratras"><a href="<?= $previous ?>"><?= $this->Html->image('icn_volver.png');?></a></div>
</header>
<?= $this->Form->create($corte, ['url'=>['controller'=>'Cortes','action'=>'add_admin']]) ?>
<fieldset>	
<?= $this->Form->input('codigo',['label'=>'CODIGO POSTAL']); ?>
</fieldset>	
<fieldset>	
<?php $opciones =  [ 0 =>'LUNES A VIERNES', 8 =>'NINGUNO', 2 =>'LUNES', 35 =>'MARTES Y JUEVES', 4 =>'MIERCOLES y VIERNES',7 =>'DOMINGO'];?>

<div class="containerb">
<div class="box">
<?= $this->Form->control('dia_n', ['label'=>'DIA NOCTURNO','options' =>$opciones,'empty' => true,'value'=>8]); ?>
</div>
<div class="box">
<?= $this->Form->control('dia_d', ['label'=>'DIA DIURNO','options' =>$opciones,'empty' => true,'value'=>8]); ?>
</div>
<div class="box">
<?= $this->Form->control('dia_f', ['label'=>'DIA FINDE','options' =>$opciones,'empty' => true,'value'=>8]); ?>
</div>
</div>

</fieldset>	
<fieldset>		
<div class="containerb">		
<div class="box">
<?= $this->Form->control('hora_n',['label'=>'HORA NOCTURNO','type' =>'text','empty' => true,'value'=>'00:00:00']); ?>
</div>
<div class="box">
<?= $this->Form->control('hora_d',['label'=>'HORA DIURNO','type' =>'text','empty' => true,'value'=>'00:00:00']); ?>
</div>
<div class="box">
<?= $this->Form->control('hora_f',['label'=>'HORA FINDE','type' =>'text','empty' => true,'value'=>'00:00:00']); ?>
</div>
</div>
</fieldset>	
<fieldset>	     
<?= $this->Form->control('proximo_h', ['label'=>'PROXIMO HORARIO','id'=>'proximohorario','type'=>"text",'name'=>'proximohorario','empty' => true]);?>
</fieldset>			
<fieldset>	
<div class="containerb">
<div class="box">
<?= $this->Form->control('salida_n_id',['options' =>$salidas,'empty' => true]); ?>
</div>
<div class="box">
<?= $this->Form->control('salida_d_id', ['options' =>$salidas,'empty' => true]); ?>
</div>
<div class="box"> 
<?= $this->Form->control('salida_f_id', ['options' =>$salidas,'empty' => true]); ?>
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
</div>

<style>
.containerb {
    font-size: 0; /* Elimina el espacio entre los divs */
}

.box {
    display: inline-block;
    width: 33%; /* Distribuye los divs en tercios */
    vertical-align: top; /* Alinea los divs en la parte superior */
    font-size: 16px; /* Reajusta el tamaño de fuente */
}
</style>
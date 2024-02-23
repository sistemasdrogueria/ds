<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\TransfersProveedor $transfersProveedor
 */
?>
<style>
.input_file_tfl_file{	float: left; }
.input_file_tfl_file label{	margin: 0 10px 0 10px;	width: 150px;	padding-top:5px;}
.input_file_tfl_file input[type=file]{	width: 200px;	height:30px;}
.input_file_tfl_option label{	margin: 0 10px 0 10px;	width: 100px;	float: left;	padding-top: 5px;}
.input_file_tfl_option{	float: left;}
.input_file_tfl_option select {	width: 200px;	padding: 5px;	height:30px;	}
.input_file_tfl_option input[type=select]{	width: 200px;}
</style>
<article class="module width_4_quarter">
<header><h3 class="tabs_involved"><?= $titulo ?></h3></header>
<fieldset>
<?= $this->Form->create('TransfersProveedors',['type' => 'file','url'=>['controller'=>'TransfersProveedors','action'=>'importresultexcel'],'id'=>'searchform4']); ?>	
<div class="input_file_tfl_file">
<?php echo $this->Form->input('filetext', ['id'=>'uploadBtn','type' => 'file','class'=>'upload','label'=>'Buscar Archivo','name'=>'filetext']);?>
</div>
<div class="input_file_tfl_option">
<?php echo $this->Form->input('tfl_id', ['label'=>'Proveedor','options' => $tfl,'empty'=>'Proveedor']);?>
</div>
<div>
		<?= $this->Form->submit('Procesar',['class'=>'submit_link','id'=>'button_import']); ?>
		</div>

<?php	echo $this->Form->end() 	?>

</fieldset>
<!-- fieldset>
<div style="width: 40% ; float: left">
<?php echo $this->Form->input('nsheet', ['label'=>'Nombre Hoja']);?>
<div style="width: 45% ; float: left">
<?php echo $this->Form->input('fini', ['label'=>'Fila inicio']);?>
</div>
<div style="width: 45% ; float: right">
<?php echo $this->Form->input('fend', ['label'=>'Fila ultima']);?>
</div>
<div style="width: 45% ; float: left">
<?php echo $this->Form->input('cini', ['label'=>'Columna Inicio']); ?>
</div>
<div style="width: 45% ; float: right">
<?php echo $this->Form->input('cend', ['label'=>'Columna Ultima']);?>
</div>
</fieldset -->

</article><!-- end of content manager article -->	
<script>
	document.getElementById("uploadBtn").onchange = function () {
		document.getElementById("uploadFile").value = this.value;
	};
</script>

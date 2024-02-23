<div class="search-form">
<?= $this->Form->create('Transfer',['type' => 'file','url'=>['controller'=>'Transfers','action'=>'importresult'],'id'=>'searchform4']); ?>
<?php
echo $this->Form->input('filetext', ['id'=>'uploadBtn','type' => 'file','class'=>'upload','label'=>'Buscar Archivo','name'=>'filetext']);
echo '<br>';
echo $this->Form->input('nsheet', ['label'=>'Nombre Hoja']);
echo $this->Form->input('fini', ['label'=>'Fila inicio']);
echo $this->Form->input('fend', ['label'=>'Fila ultima']);
echo $this->Form->input('ccomb', ['label'=>'Columna Combo']);
echo $this->Form->input('cean', ['label'=>'Columna EAN']);
echo $this->Form->input('cdto', ['label'=>'Columna Descuento']);
echo $this->Form->input('cdesc', ['label'=>'Columna Descripcion']);
echo $this->Form->input('cplazo', ['label'=>'Columna plazo']);
echo $this->Form->input('cumin', ['label'=>'Columna Unid. Min ']);
echo $this->Form->submit('Procesar',['class'=>'mainBtn']);
echo $this->Form->end() ?>
</div>
<script>
document.getElementById("uploadBtn").onchange = function () {
document.getElementById("uploadFile").value = this.value;};
</script>
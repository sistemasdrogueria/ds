<div class="search-form">
    <?= $this->Form->create('Carritos',['type' => 'file','url'=>['controller'=>'Carritos','action'=>'importresultexcel'],'id'=>'searchform4']); ?>
				
	<?php
			
			echo $this->Form->input('filetext', ['id'=>'uploadBtn','type' => 'file','class'=>'upload','label'=>'Buscar Archivo','name'=>'filetext']);
			echo '<br>';
			echo $this->Form->input('nsheet', ['label'=>'Nombre Hoja']);
			echo $this->Form->input('fini', ['label'=>'Fila inicio']);
			echo $this->Form->input('fend', ['label'=>'Fila ultima']);
			
			echo $this->Form->input('cean', ['label'=>'Columna EAN']);
			echo $this->Form->input('ccant', ['label'=>'Columna Cantidad']);
			echo $this->Form->input('cdesc', ['label'=>'Columna Descripcion']);


			echo $this->Form->submit('Procesar',['class'=>'mainBtn']);
			echo $this->Form->end() 
	?>
</div> <!-- /.search-form -->
<script>
	document.getElementById("uploadBtn").onchange = function () {
		document.getElementById("uploadFile").value = this.value;
	};
</script>
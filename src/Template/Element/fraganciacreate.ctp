<div class="form_search">
<?= $this->Form->create('Fragancias', ['url'=>['controller'=>'Fragancias','action'=>'add_admin'],'type' => 'file'])?>

<div class="input_text_search">
<?= $this->Form->input('nombre', ['class'=>'terminobusqueda','label'=>'', 'style'=>'width:280px']);?>  
</div>
<div class="input_select_search">
<?= $this->Form->input('marca_id', ['class'=>'terminobusquedaselect','label'=>'','options' => $marcas,'empty'=>'MARCA']);	?>	
</div>

<div class="input_select_search">
<?= $this->Form->input('genero_id', ['class'=>'terminobusquedaselect','label'=>'','options' => $generos,'empty'=>'GENERO']);	?>	
</div>
<div class="input_file_search">
<?php
echo $this->Form->input('file',['type' => 'file','label'=>'', 'class'=>'custom-file-input']);?>
</div>

<?= $this->Form->button(__('Guardar'),['id'=>'button_search']) ?>
<?= $this->Form->end() ?>

</div><!-- end of .tab_container -->
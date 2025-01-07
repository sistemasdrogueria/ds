<?= $this->Form->create('Nutricion',['url'=>['controller'=>'Nutricion','action'=>'search'],'id'=>'searchform']); ?>

<div  style="display: flex;   justify-content: center;">
<div style="margin-top: 20px;">
<?php echo $this->Form->input('terminobuscar', ['label'=>'','id'=>'terminobuscar','name'=>'terminobuscar','value'=>'', 'style'=>'width: 200px;' ,'type'=>'text','placeholder'=>'Buscar', 'onchange'=>'javascript:document.confirmInput.submit();']);?>
</div>
<div style="margin-top: 20px;">
<?php echo $this->Form->input('grupo_id', ['label'=>'','options' => $grupos,'empty'=>'Grupos','style'=>'color: #000000;	border: 1px solid #909090; width: 200px; ','onChange'=>'document.getElementById("searchform").submit();']);?>
</div>
<div style="margin-top: 20px;">
<?php echo $this->Form->input('marca_id', ['label'=>'','options' => $marcas,'empty'=>'Marcas','style'=>'color: #000000;	border: 1px solid #909090; width: 200px; ','onChange'=>'document.getElementById("searchform").submit();']);?>
</div>
</div> <!-- /.search-form -->
<?php echo $this->Form->end() ?>
</br>
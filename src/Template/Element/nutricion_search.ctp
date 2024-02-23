<?= $this->Form->create('NutricionYDeportes',['url'=>['controller'=>'NutricionYDeportes','action'=>'search'],'id'=>'searchform']); ?>

<div  style="display: flex;   justify-content: center;">
<div style="margin-top: 20px;">
<?php echo $this->Form->input('terminobuscar', ['label'=>'','id'=>'terminobuscar','name'=>'terminobuscar','value'=>'', 'style'=>'width: 200px;' ,'type'=>'text','placeholder'=>'Buscar', 'onchange'=>'javascript:document.confirmInput.submit();']);?>
</div>
<div style="margin-top: 20px;">
<?php echo $this->Form->input('marca_id', ['label'=>'','options' => $marcas,'empty'=>'Marcas','style'=>'color: #000000;	border: 1px solid #909090; width: 200px; ','onChange'=>'document.getElementById("searchform").submit();']);?>
</div>
<div style="margin-left: 20px;"><h1 style="text-align: center; color: #008F39; ">  

<?php echo $this->Html->link('SALUD&BIENESTAR' ,['controller'=>'nutricion_y_deportes','action'=>'index'],['alt'=>'SALUD&BIENESTAR','style' =>'color: #008F39;']);?>

</h1></div>

</div> <!-- /.search-form -->
<?php echo $this->Form->end() ?>
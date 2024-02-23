<?= $this->Form->create('Bienestar',['url'=>['controller'=>'Bienestar','action'=>'search'],'id'=>'searchform','onsubmit'=>'return false;']); ?>
<div  style="display: flex;   justify-content: center;">
<div style="margin-top: 20px;">
<?php
echo $this->Form->input('terminobuscar', ['label'=>'','id'=>'terminobuscarnutri','name'=>'terminobuscar','class'=>'terminobuscarnutri','value'=>'','style'=>'width: 200px;','type'=>'text','placeholder'=>'Buscar']);	
?>
</div>
<div style="margin-top: 20px;">
<?php
echo $this->Form->input('grupo_id', ['label'=>'','options' => $gruposf,'empty'=>'Categorias','style'=>'color: #000000;	border: 1px solid #909090; width: 200px; ','class'=>'grupo-id','onChange'=>'document.getElementById("searchform").submit();']);
?>
</div>
<div style="margin-left: 20px;"><h1 style="text-align: center; color: #8dc641;  margin-top: 20px;  font-size: 3.0em;">  
<?php echo $this->Html->link('BIENESTAR' ,['controller'=>'Bienestar','action'=>'index'],['alt'=>'BIENESTAR','style' =>'color: #8dc641;']);?>
</h1></div>

</div> <!-- /.search-form -->
<?= $this->Form->create('HomeYDecos',['url'=>['controller'=>'HomeYDecos','action'=>'search'],'id'=>'searchform']); ?>
<div  style="display: flex;   justify-content: center;">
<div style="margin-top: 20px;">
<?php echo $this->Form->input('terminobuscar', ['label'=>'','id'=>'terminobuscarnutri','name'=>'terminobuscar','class'=>'terminobuscarnutri','value'=>'','style'=>'width: 200px;','type'=>'text','placeholder'=>'Buscar','onchange'=>'javascript:document.confirmInput.submit();']);	?>
</div>
<div style="margin-top: 20px;">
<?php echo $this->Form->input('grupo_id', ['label'=>'','options' => $gruposf,'empty'=>'Categorias','style'=>'color: #000000;	border: 1px solid #909090; width: 200px; ','class'=>'grupo-id', 'onChange'=>'document.getElementById("searchform").submit();']); ?>
</div>
<?php 
if (!empty($gruposf2))
echo '<div style="margin-top: 20px;">'.$this->Form->input('grupo_id_2', ['label'=>'','options' => $gruposf2,'empty'=>'Subcategorias','style'=>'color: #000000;	border: 1px solid #909090; width: 200px; ','class'=>'grupo-id2', 'onChange'=>'document.getElementById("searchform").submit();']).'</div>'; 
else
echo $this->Form->input('grupo_id_2', ['label'=>'','value'=>'0','empty'=>'Subcategorias','style'=>'color: #000000;	border: 1px solid #909090; width: 200px; ','class'=>'grupo-id2', 'hidden'=>1]) ?>

<div style="margin-left: 20px;"><h1 style="text-align: center; color: #7abcc8;  margin-top: 20px;  font-size: 3.0em;">  
<?php echo $this->Html->link('HOME&DECO' ,['controller'=>'HomeYDecos','action'=>'index'],['alt'=>'HOME&DECO','style' =>'color: #7abcc8;']);?>
</h1></div>
</div> <!-- /.search-form -->
<?php echo $this->Form->end() ?>
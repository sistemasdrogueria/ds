<div>
<div class="search-form" >
<?= $this->Form->create('DeliaPerfumerias',['url'=>['controller'=>'DeliaPerfumerias','action'=>'resultdermo'],'id'=>'searchform']); ?>
<?php
//echo $this->Form->input('subgrupo_id', ['label'=>'','options' => $subgrupos,'empty'=>'Acción Dermica','class'=>'subgrupo_id','style'=>'width: 150px; '/*,'onChange'=>'document.getElementById("searchform").submit();'*/]);
echo '<div class=search-form-input>'.$this->Form->input('terminobuscar', ['label'=>'','name'=>'terminobuscar','id'=>'dermoterminobuscar','value'=>'', 'type'=>'text','placeholder'=>'Buscar']) .'</div>';
echo '<div class=search-form-input>'.$this->Form->input('marca_id', ['label'=>'','options' => $marcas,'empty'=>'Marcas','class'=>'dermomarca2_id','style'=>'width: 200px;','onChange'=>'document.getElementById("searchform").submit() ']) .'</div>';
//echo '<div class=search-form-input>'.$this->Form->input('grupo_id', ['label'=>'','options' => $grupos,'empty'=>'Categoria','class'=>'dermogrupo2_id','style'=>'width: 150px; ']) .'</div>';
echo $this->Form->end();
echo '<div class=search-form-input>'. $this->Html->image('icn_volver.png', ['url'=>['controller'=>'DeliaPerfumerias','action'=>'dermo'],'alt' => 'volver']).'</div>';


?>
</div> <!-- /.search-form -->
</div>
<div class="search-form" >
<?php if (!is_null($marcas2))
$pass2 = null; 
else $pass2 = $pass;
?>
<?= $this->Form->create('Carritos',['url'=>['controller'=>'DeliaPerfumerias','action'=>'resultfragancia',$pass],'id'=>'searchform']); ?>
<?php
echo '<div class=search-form-input>'.$this->Form->input('terminobuscar', ['label'=>'','id'=>'terminobuscar','name'=>'terminobuscar','value'=>'', 'type'=>'text','placeholder'=>'Buscar', 'onchange'=>'javascript:document.confirmInput.submit();']) .'</div>';
echo '<div class=search-form-input>'.$this->Form->input('marca_id', ['label'=>'','options' => $marcas,'empty'=>'Marcas','onChange'=>'document.getElementById("searchform").submit();']).'</div>';
echo '<div class=search-form-input>'.$this->Form->input('genero_id', ['label'=>'','options' => $generos,'empty'=>'Genero','onChange'=>'document.getElementById("searchform").submit();']).'</div>';

echo $this->Form->end();
echo '<div class=search-form-input>'. $this->Html->image('icn_volver.png', ['url'=>['controller'=>'DeliaPerfumerias','action'=>'fragancia',$pass2],'alt' => 'volver']).'</div>';

?>
</div> <!-- /.search-form -->


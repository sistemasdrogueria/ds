<div>
<div class="search-form" >
<div style="float:left; width: 50%;">
<?= $this->Form->create('NutricionYDeportes',['url'=>['controller'=>'NutricionYDeportes','action'=>'search'],'id'=>'searchform']); ?>
		<?php
            echo $this->Form->input('terminobuscar', ['label'=>'','id'=>'terminobuscar','name'=>'terminobuscar','value'=>'', 'style'=>'min-width: 150px; width: 40%;float: left;' ,'type'=>'text','placeholder'=>'Buscar', 'onchange'=>'javascript:document.confirmInput.submit();']);	
			echo $this->Form->input('marca_id', ['label'=>'','options' => $marcas,'empty'=>'Marcas','style'=>'color: #000000;	border: 1px solid #909090; min-width: 150px; width: 40%;float: left; ','onChange'=>'document.getElementById("searchform").submit();']);
		
			echo $this->Form->end() 
		?>
</div>
<div style="float:left; width: 50%;"><h1 style="text-align: center; color: #008F39; margin: 0px; ">  ALIMENTOS </h1></div>

</div> <!-- /.search-form -->
</div>

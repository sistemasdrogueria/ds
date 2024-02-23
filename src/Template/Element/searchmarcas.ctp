<div class="search-genero">

CATEGORIAS <br>
<?php echo $this->Html->link('Fragancia Masculina', ['controller' => 'Carritos', 'action' => 'resultfraganciaselectiva',0,1]).'<br>';?>
<?php echo $this->Html->link('Fragancia Femenina', ['controller' => 'Carritos', 'action' => 'resultfraganciaselectiva',0,2]).'<br>';?>
<?php echo $this->Html->link('Fragancia Unisex', ['controller' => 'Carritos', 'action' => 'resultfraganciaselectiva',0,4]).'<br>';?>

<?php echo $this->Html->link('Estuche', ['controller' => 'Carritos', 'action' => 'resultfraganciaselectiva',0,5]).'<br>';?>
</div>
<div class="search-marca">

MARCAS <br>
<?php
		///$marcas= $marcas->toArray();
		//$max = count($marcas);
		//for ($i = 1; $i <= $max; $i++) {
			echo $this->Html->link('TODAS LAS MARCAS', ['controller' => 'Carritos', 'action' => 'resultfraganciaselectiva',100,0]).'<br>';
			foreach ($marcas as $attributeKey => $attributes): 
			$i=0;
			
			echo $this->Html->link($attributes, ['controller' => 'Carritos', 'action' => 'resultfraganciaselectiva',$attributeKey,0]).'<br>';
//}
endforeach; ?>


</div> <!-- /.search-form -->
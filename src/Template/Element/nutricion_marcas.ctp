<?php 
		$indice=0;
		$marcas= $marcas->toArray();
?>
<div class="nutricioncontenedor">
	  <?php foreach ($marcas2 as $marca): ?>
		<div class="nutricionmarcadiv" >
			<div  align="center">
			<?php 
			$uploadPath = 'marcas/';
			if (file_exists('www.drogueriasur.com.ar/ds/webroot/img/'.$uploadPath.$marca['imagen'] ))
				echo $this->Html->image($uploadPath.$marca['imagen'], ['alt' => str_replace('"', '', $marca['nombre']),'width' => 200]);
			else
				echo $this->Html->image($uploadPath.$marca['imagen'], ['alt' => str_replace('"', '', $marca['nombre']),'width' => 200, 'url' => ['controller' => 'NutricionYDeportes', 'action' => 'search',$marca['id']]]);
			?> 
			</div> 
		 </div>
    <?php endforeach; ?>
</div>
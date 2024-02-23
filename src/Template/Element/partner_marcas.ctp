<?php 
		$indice=0;
		$marcas= $marcas->toArray();
?>


<div class="partnercontenedor" style="margin: 0px auto;">
	  <?php foreach ($marcas2 as $marca): ?>
		<div class="partnermarcadiv" style="display: inline-block; width: 350px;">
			<div  align="center">
			<?php 
			$uploadPath = 'marcas/';
			if (file_exists('www.drogueriasur.com.ar/ds/webroot/img/'.$uploadPath.$marca['imagen'] ))
				echo '<a href="'.$marca['descripcion_sistema'].'" target ="_blank">'.$this->Html->image($uploadPath.$marca['imagen'], ['alt' => str_replace('"', '', $marca['nombre'])]) .'</a>';
			else
				echo '<a href="'.$marca['descripcion_sistema'].'" target ="_blank">'.$this->Html->image($uploadPath.$marca['imagen'], ['alt' => str_replace('"', '', $marca['nombre'])]) .'</a>';
				//echo $this->Html->image($uploadPath.$marca['imagen'], ['alt' => str_replace('"', '', $marca['nombre']),'width' => 200, 'url' => ['controller' => 'NutricionYDeportes', 'action' => 'search',$marca['id']]]);
			?> 
			</div> 
		 </div>
    <?php endforeach; ?>
</div>
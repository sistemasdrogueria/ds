	    <?php $indice=0;
				$marcas= $marcas->toArray();
    	?>
	  <div class="fraganciacontenedor">
	  <?php foreach ($marcas2 as $marca): ?>
		<div class="fraganciamarcadiv">
			<!--div class="product-thumb" -->
			<div  align="center">
			<?php 
			$uploadPath = 'marcas/';
			if (file_exists('www.drogueriasur.com.ar/ds/webroot/img/'.$uploadPath.$marca['imagen'] ))
			echo $this->Html->image($uploadPath.$marca['imagen'], ['alt' => str_replace('"', '', $marca['nombre']),'width' => 125]);
			else
				echo $this->Html->image($uploadPath.$marca['imagen'], ['alt' => str_replace('"', '', $marca['nombre']),'width' => 125, 
	
			'url' => ['controller' => 'Carritos', 'action' => 'resultfraganciaselectiva',$marca['id'] ,0]]);
			

			?> 
			</div> 
		 </div>
    <?php endforeach; ?>
  </div>
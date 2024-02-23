	    <?php 
				$indice=0;
				$marcas= $marcas->toArray();
    	?>
		<div class=" hide dermocontenedor_search"></div>
<div class="dermocontenedor" style="background-color: #fff;" >

	  <?php foreach ($marcas2 as $marca): ?>
		<div class="dermomarcadiv" id="<?php echo $marca['id'] ?>">
			<div  align="center">
			<?php 
			$uploadPath = 'marcas/';
			if (file_exists('www.drogueriasur.com.ar/ds/webroot/img/'.$uploadPath.$marca['imagen'] ))
				echo $this->Html->image($uploadPath.$marca['imagen'], ['alt' => str_replace('"', '', $marca['nombre']),'width' => 125]);
			else
				echo $this->Html->image($uploadPath.$marca['imagen'], ['alt' => str_replace('"', '', $marca['nombre']),'width' => 125, 'url' => ['controller' => 'DeliaPerfumerias', 'action' => 'resultmakeup',$marca['id'] ,0]]);
			

			?> 
			</div> 
		 </div>
    <?php endforeach; ?>
  </div>
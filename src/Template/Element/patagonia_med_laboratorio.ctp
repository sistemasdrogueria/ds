<?php 
		$indice=0;
?>

<div class="row" style ="text-align: center;">
<div class = "gallery-contenedor"     style="margin:0px auto;">

<!-- div class="nutricioncontenedor" -->
	  <?php foreach ($PatagoniaMed as $lab): ?>
		<div class="gallery-oferta">
		<!--div class="nutricionmarcadiv" -->
			<div class=product-item-6 style="
			
			height: 210px;
    width: 210px;
    border: 5px solid #2a80b9;
    display: flex;
    justify-content: center;
    align-items: center;
border-radius: 4px;
			">
			<div>
			<?php 
			$uploadPath = 'logos/';
			if (file_exists('www.drogueriasur.com.ar/ds/webroot/img/'.$uploadPath.$lab['Laboratorios']['id'].'.jpg' ))
			echo $this->Html->image($uploadPath.$lab['Laboratorios']['id'].'.jpg', ['alt' => str_replace('"', '', $lab['Laboratorios']['nombre']),'width' => 200, 'url' => ['controller' => 'PatagoniaMed', 'action' => 'search',$lab['Laboratorios']['id']]]);	
				//echo $this->Html->image($uploadPath.$marca['imagen'], ['alt' => str_replace('"', '', $marca['lab']),'width' => 200]);
			else
				echo $this->Html->image($uploadPath.$lab['Laboratorios']['id'].'.jpg', ['alt' => str_replace('"', '', $lab['Laboratorios']['nombre']),'width' => 200, 'url' => ['controller' => 'PatagoniaMed', 'action' => 'search',$lab['Laboratorios']['id']]]);
			?> 
			</div> 
	  </div>
		 </div>
    <?php endforeach; ?>

</div>
</div>




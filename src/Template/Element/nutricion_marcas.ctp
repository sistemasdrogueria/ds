
<style>
    .lab_name{height:200px;width: 200px;   display: flex;   justify-content: center;  align-items: center;}
    .lab_name a{ color: #000; font-size: 15px; text-align: center; font-weight: bold;}

	.nutricionmarcadiv{ background: #fff;}

</style>
<?php 
		$indice=0;
		//$marcas= $marcas->toArray();
?>
<div class="nutricioncontenedor">
	  <?php foreach ($marcas2 as $marca): ?>
		<div class="nutricionmarcadiv" >
			<div  align="center">
			<?php 
			$uploadPath = 'marcas/';
			if (file_exists('www.drogueriasur.com.ar/ds/webroot/img/'.$uploadPath.$marca['marca']['imagen'] ))
				echo $this->Html->image($uploadPath.$marca['marca']['imagen'], ['alt' => str_replace('"', '', $marca['marca']['nombre']),'width' => 200]);
			else
				if ($marca['marca']['imagen'] != null)
				echo $this->Html->image($uploadPath.$marca['marca']['imagen'], ['alt' => str_replace('"', '', $marca['marca']['nombre']),'width' => 200, 'url' => ['controller' => 'Nutricion', 'action' => 'search',$marca['marca']['id'],$marca['grupo_id']]]);
				else
				echo '<div class=lab_name>'.$this->Html->link(str_replace('"', '', $marca['marca']['nombre']), ['controller' => 'Nutricion', 'action' => 'search',$marca['marca']['id'],$marca['grupo_id']]).'</div>';

			?> 
			</div> 
		 </div>
    <?php endforeach; ?>
</div>
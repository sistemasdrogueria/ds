<div class="col-md-12">
    <div class="product-item-3"> 
		<div class="product-content3">
		<h3 align="center"><?php echo 'Exhibidores';?></h3>
		<?php echo $this->Html->css('engine1/style.css');	?>	
		<div class="row" align="center">
		<div id="wowslider-container1">
			<div class="ws_images"><ul>
				<?php $i=0;
				foreach ($incorporations as $incorporation): 
				$i = $i+1;
				if ($incorporation['incorporations_tipos_id']==5) 
					echo '<li><img src="../img/exhibidores/'.$incorporation['imagen'].'" alt="'.$incorporation['descripcion'].'"title="Exhibidor" id="wows1_'.$i.'"/></li>';
				endforeach; ?>
			</ul></div>
			<div class="ws_thumbs"><div>
				<?php foreach ($incorporations as $incorporation): 
					if ($incorporation['incorporations_tipos_id']==5) 
							echo '<a href="#" title="Exhibidor"><img width="95" src="../img/exhibidores/'.$incorporation['imagen'].'" alt="'.$incorporation['descripcion'].'"/></a>';
					endforeach; ?>
			</div></div>
		</div>	
		</div>
			<div class="row" style="text-align: center; font-size: 16px;">
				<br>
				Las imágenes publicadas son meramente ilustrativas. <br>
				Los precios pueden modificarse sin previo aviso.<br>
				Productos sujetos a disponibilidad de stock.
			</div>
		</div>
	</div>	
</div>
<?php echo $this->Html->script('engine1/wowslider');?>	
<?php echo $this->Html->script('engine1/script');?>
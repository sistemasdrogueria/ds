<div class="col-md-12">
    <div class="product-item-3"> 
		<div class="product-content3">
		
		<?php echo $this->Html->css('engine1/style.css');	?>	
	
	
		<div class="row" align="center">
		<div id="wowslider-container1">
		<div class="ws_images"><ul>
						<?php 
						$i=0;
						foreach ($incorporations as $incorporation): 
						$i = $i+1;
						if ($incorporation['incorporations_tipos_id']==1) 
						{
							echo '<li><img src="../img/incorporations/selectivas/'.$incorporation['imagen'].'" alt="'.$incorporation['descripcion'].'" 
							title="Frag. Selectivas" id="wows1_'.$i.'"/></li>';
							
						}
						if ($incorporation['incorporations_tipos_id']==2) 
						{
							echo '<li><img src="../img/incorporations/semiselectivas/'.$incorporation['imagen'].'" alt="'.$incorporation['descripcion'].'" 
							title="Frag. Semiselectivas" id="wows1_'.$i.'"/></li>';

						}
						
						
						if ($incorporation['incorporations_tipos_id']==3) 
						{		echo '<li><img src="../img/incorporations/dermo/'.$incorporation['imagen'].'" alt="'.$incorporation['descripcion'].'" 
							title="Perfumeria" id="wows1_'.$i.'"/></li>';

							
						}
						if ($incorporation['incorporations_tipos_id']==4) 
						{		echo '<li><img src="../img/incorporations/makeup/'.$incorporation['imagen'].'" alt="'.$incorporation['descripcion'].'" 
							title="Perfumeria" id="wows1_'.$i.'"/></li>';

							
						}
						if ($incorporation['incorporations_tipos_id']==5) 
						{		echo '<li><img src="../img/incorporations/solares/'.$incorporation['imagen'].'" alt="'.$incorporation['descripcion'].'" 
							title="Perfumeria" id="wows1_'.$i.'"/></li>';

							
						}
						if ($incorporation['incorporations_tipos_id']==6) 
						
						{
							echo '<li><img src="../img/incorporations/perfumerias/'.$incorporation['imagen'].'" alt="'.$incorporation['descripcion'].'" 
							title="Perfumeria" id="wows1_'.$i.'"/></li>';

							
						}
						endforeach; ?>
		
			</ul></div>
			<div class="ws_thumbs">
			<div>
			<?php 
					
						foreach ($incorporations as $incorporation): 
					
						if ($incorporation['incorporations_tipos_id']==1) 
						{
							echo '<a href="#" title="Frag. Selectiva"><img width="95" src="../img/incorporations/selectivas/'.$incorporation['imagen'].'" alt="'.$incorporation['descripcion'].'"/></a>';
													
						}
						if ($incorporation['incorporations_tipos_id']==2) 
						{
							echo '<a href="#" title="Frag. Semiselectivas"><img width="95" src="../img/incorporations/semiselectivas/'.$incorporation['imagen'].'" alt="'.$incorporation['descripcion'].'"/></a>';
							
			

						}
						
						{
						if ($incorporation['incorporations_tipos_id']==3) 
											echo '<a href="#" title="Perfumeria"><img width="95" src="../img/incorporations/dermo/'.$incorporation['imagen'].'" alt="'.$incorporation['descripcion'].'"/></a>';
				
						}


						if ($incorporation['incorporations_tipos_id']==4) 
						{
							echo '<a href="#" title="Frag. Selectiva"><img width="95" src="../img/incorporations/makeup/'.$incorporation['imagen'].'" alt="'.$incorporation['descripcion'].'"/></a>';
													
						}
						if ($incorporation['incorporations_tipos_id']==5) 
						{
							echo '<a href="#" title="Frag. Semiselectivas"><img width="95" src="../img/incorporations/solares/'.$incorporation['imagen'].'" alt="'.$incorporation['descripcion'].'"/></a>';
							
			

						}
						
						{
						if ($incorporation['incorporations_tipos_id']==6) 
											echo '<a href="#" title="Perfumeria"><img width="95" src="../img/incorporations/perfumerias/'.$incorporation['imagen'].'" alt="'.$incorporation['descripcion'].'"/></a>';
				
						}


						



						endforeach; ?>
				
			</div>
		</div>
		</div>	
		
<?php echo $this->Html->script('engine1/wowslider');	?>	
		<?php echo $this->Html->script('engine1/script');	?>	

		
        
			</div>

		

			<div class="row" style="text-align: center; font-size: 16px;">
				<br>

			</div>
		</div>
	</div>	
</div>

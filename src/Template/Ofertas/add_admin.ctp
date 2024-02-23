<article class="module width_3_quarter">
	<header><h3 class="tabs_involved"><?= $titulo ?></h3></header>
	<div class="ofertas form large-10 medium-9 columns">
		<?php echo $this->element('searchofertas'); ?>
	</div>
	<div class="ofertas form large-10 medium-9 columns">
		<?php if ($articulos!=null)
				echo $this->element('searchofertasresult'); 
		?>
	
	</div>
 </article> 
 


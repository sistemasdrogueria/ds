<?php foreach ($novedades as $novedade): ?>
<div class="col-md-6">
	<div class="member wow bounceInUp animated">
		<div class="member-container" data-wow-delay=".1s">
			<div class="inner-container">
				<div class="author-avatar">	
				
					
					<?php
						if ($novedade->img_file!="")
							$nameimagen="novedades/".$novedade->img_file;
						else	
							$nameimagen="sinimagen.png";
						
					
						echo $this->Html->image($nameimagen, ["alt" => "Novedades","class"=>"img-circle",
						'url' => ['controller' => 'novedades', 'action' => 'view',  $novedade->id]]);
						
							
					?>
				</div><!-- /.author-avatar -->
				
			</div><!-- /.inner-container -->
		</div><!-- /.member-container -->
	</div><!-- /.member -->
</div>				
<?php endforeach; ?>
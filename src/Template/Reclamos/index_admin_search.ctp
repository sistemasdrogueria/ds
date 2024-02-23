<script>	  
	  $(function() {$( "#datepicker" ).datepicker(); });
</script>		  
<article class="module width_4_quarter">
		<header><h3 class="tabs_involved"><?= $titulo ?></h3></header>
	<div class="tab_container">
		<?php echo $this->element('reclamo_search_admin'); ?>
		<?php echo $this->element('reclamo_result_admin'); ?>
	</div>	
</article><!-- end of content manager article -->

<article class="module width_3_quarter">
		<header><h3 class="tabs_involved"><?= $titulo ?></h3>
		<div class="tabs_bt_nuevo">
		<?= $this->Html->image("admin/icn-delete-img.png", ["alt" => "Nuevo",'url' => ['controller' => 'Articulos', 'action' => 'index']]);?>
		</div>
	
	</header>
		<div class="tab_container">
		<?php echo $this->element('articulo_search_admin'); ?>
		<?php echo $this->element('articulo_result_admin'); ?>
		 </div><!-- end of .tab_container -->
</article><!-- end of content manager article -->

<?php
//echo $this->Html->css('bootstrap.min');
echo $this->Html->script('bootstrap'); 
?>
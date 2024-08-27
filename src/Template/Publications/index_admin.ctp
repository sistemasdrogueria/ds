<article class="module width_4_quarter">
		<header><h3 class="tabs_involved"><?= $titulo ?></h3>
	
		<div class="tabs_bt_nuevo">
		<?= $this->Html->image("admin/icn-nuevo.png", ["alt" => "Nuevo",'url' => ['controller' => 'Publications', 'action' => 'add_admin']]);?>
		</div>
	</header>
		<div class="tab_container">
		<?php echo $this->element('publication_search_admin'); ?>
		<?php echo $this->element('publication_result_admin'); ?>
		 </div><!-- end of .tab_container -->
</article><!-- end of content manager article -->
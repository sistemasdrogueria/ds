<article class="module width_4_quarter">
<header><h3 class="tabs_involved"><?= $titulo ?></h3>

<div class="tabs_bt_nuevo">
		<?= $this->Html->image("admin/icn-nuevo.png", ["alt" => "Nuevo",'url' => ['controller' => 'Ofertas', 'action' => 'add']]);?>
        
		<?= $this->Html->image("admin/icn-nuevo-pm.png", ["alt" => "Nuevo",'url' => ['controller' => 'Ofertas', 'action' => 'add_admin_oferta_laboratorio']]);?>
		</div>


</header>
<div class="tab_container">
<?php echo $this->element('oferta_search_admin'); ?>
<?php echo $this->element('oferta_result_admin'); ?>
</div><!-- end of .tab_container -->
</article><!-- end of content manager article -->
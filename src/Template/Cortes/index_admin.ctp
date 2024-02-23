<article class="module width_3_quarter">
<header><h3 class="tabs_involved"><?= $titulo ?></h3>
<div class="tabs_bt_nuevo">
<?= $this->Html->image("admin/icn-nuevo.png", ["alt" => "Nuevo",'url' => ['controller' => 'Cortes', 'action' => 'add_admin']]);?>
<div>
</header>
<div class="tab_container">
<?php echo $this->element('corte_search_admin'); ?>
<?php echo $this->element('corte_result_admin'); ?>
</div><!-- end of .tab_container -->
</article><!-- end of content manager article -->

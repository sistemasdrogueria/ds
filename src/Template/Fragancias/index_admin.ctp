<article class="module width_3_quarter">
<header><h3 class="tabs_involved"><?= $titulo ?></h3>
<div class="tabs_bt_nuevo">

<?= $this->Html->image("admin/icn-nuevo.png", ["alt" => "Nuevo",'url' => ['controller' => 'Fragancias', 'action' => 'add_admin']]);?>
</div>
<div class="tabs_bt_nuevo">
<?= $this->Html->image("admin/icon_excel.png", ["alt" => "Nuevo",'url' => ['controller' => 'Fragancias', 'action' => 'excel']]);?>
</div>
</header>
<div class="tab_container">
<?php echo $this->element('fragancia_search_admin'); ?>
<?php echo $this->element('fragancia_result_admin'); ?>
</div><!-- end of .tab_container -->
</article><!-- end of content manager article -->
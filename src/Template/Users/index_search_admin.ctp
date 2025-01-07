<article class="module width_4_quarter">
<header><h3 class="tabs_involved"><?= $titulo ?></h3>
<div class="tabs_bt_nuevo">
<?= $this->Html->image("admin/icn-nuevo.png", array(
"alt" => "Nuevo",
'url' => array('controller' => 'Users', 'action' => 'add_admin'),
));?>
<div>
</header>
<div>
<?php echo $this->element('user_search_admin'); ?>
<?php echo $this->element('user_result_admin'); ?>
</div>
</article><!-- end of content manager article -->



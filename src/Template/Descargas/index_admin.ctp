<article class="module width_3_quarter">
<header><h3 class="tabs_involved"><?= $titulo ?></h3>
<div class="tabs_bt_nuevo">
<?= $this->Html->image("admin/icn-nuevo.png", array(
"alt" => "Nuevo",
'url' => array('controller' => 'Descargas', 'action' => 'add_admin'),
));?>
</div>
</header>
<div>
<?php //echo $this->element('clientsearchadmin'); ?>
<?php echo $this->element('searchresultdescarga'); ?>
</div> 
</article><!-- end of content manager article -->
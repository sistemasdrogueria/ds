
<?php //><script type="text/javascript">
$previous = "javascript:history.go(-1)";
if(isset($_SERVER['HTTP_REFERER'])) {
$previous = $_SERVER['HTTP_REFERER'];
}
?>
<article class="module width_4_quarter">
<header><h3 class="tabs_involved"><?= $titulo ?></h3>
<div class="volveratras"><a href="<?= $previous ?>"><?php echo $this->Html->image('icn_volver.png');?></a></div>
<div class="tabs_bt_nuevo">

<?= $this->Html->image("admin/icn-nuevo.png", ["alt" => "Nuevo",'url' => ['controller' => 'Fragancias', 'action' => 'add_admin']]);?>
</div>
</header>

		<?php echo $this->element('fragancia_add_search_admin'); ?>

		<?php echo $this->element('searchfraganciaproducto'); ?>

	
 </article> 
 
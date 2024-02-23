
<?php //><script type="text/javascript">
$previous = "javascript:history.go(-1)";
if(isset($_SERVER['HTTP_REFERER'])) {
    $previous = $_SERVER['HTTP_REFERER'];
}
?>
<article class="module width_4_quarter">
<header><h3 class="tabs_involved"><?= $titulo ?></h3>
<div style="float: right; padding-top:2px"><?php echo $this->Html->image('admin/icon_transfer_proveedor.png',["alt" => "Transfer",'url' =>['controller' => 'TransfersProveedors', 'action' => 'index_admin']]);    ?></div>
<div class="volveratras"><a href="<?= $previous ?>"><?php echo $this->Html->image('icn_volver.png');?></a></div>
</header>
<div class="tab_container">
<?php echo $this->element('pedido_search_admin'); ?>
<?php echo $this->element('pedidotransfer_result_admin'); ?>
</div><!-- end of .tab_container -->
</article><!-- end of content manager article -->

<?php //><script type="text/javascript">
$previous = "javascript:history.go(-1)";
if(isset($_SERVER['HTTP_REFERER'])) {
$previous = $_SERVER['HTTP_REFERER'];
}
?>
<article class="module width_4_quarter">
<header>
    <h3 class="tabs_involved"><?= $titulo ?></h3>
    <div class="tabs_bt_nuevo">
    <?php echo $this->Html->image('admin/icn_volver.png', ['url' => $previous]);?>	</div>
  </header>


<?php echo $this->element('oferta_add_search_admin'); ?>
<?php if ($articulos!=null)
echo $this->element('oferta_add_result_admin'); 
?>


</article> 
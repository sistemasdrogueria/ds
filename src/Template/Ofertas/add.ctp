
<style>
.header_icon{
	float: right;	
	margin-right: 10px;
	margin-top: 5px;
}
.header_icon_delete{
float: left;
margin-top: 5px;
margin-left: 5px;
margin-right: 5px;
}
.header_icon_return{ 
	float: left;
}
</style>
<?php //><script type="text/javascript">
$previous = "javascript:history.go(-1)";
if(isset($_SERVER['HTTP_REFERER'])) {
    $previous = $_SERVER['HTTP_REFERER'];
}
?>
<article class="module width_3_quarter">
	<header><h3 class="tabs_involved"><?= $titulo ?></h3>
	<div class = header_icon> 
	<div class="header_icon_return">
<?php echo $this->Html->image('admin/icn_volver.png', ['url' => $previous]);?>	</div></div>
</header>
	<div class="ofertas form large-10 medium-9 columns">
		<?php echo $this->element('searchofertas'); ?>
	</div>
	<div class="ofertas form large-10 medium-9 columns">
		<?php if ($articulos!=null)
				echo $this->element('searchofertasresult'); 
		?>
	
	</div>
 </article> 
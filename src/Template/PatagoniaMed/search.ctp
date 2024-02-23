

<div class="col-md-12">
<div class="product-item-3" id="search-bf-pm">
<div class="product-thumb" >
<?php echo $this->element('patagonia_med_search'); ?>
</div> <!-- /.product-thumb -->

<div class="product-content">
<?php if ($articulos!=null )
{echo $this->element('patagonia_med_result'); }
?>
<?php //echo $this->element('referencia'); ?> 
</div>
<!-- /.product-content -->
</div> <!-- /.col-md-3 -->
</div>
<div class="col-md-12">
</div>
<script>
$("#logo_web").attr("src","https://www.drogueriasur.com.ar/ds/webroot/img/logo_pm.png");
</script>
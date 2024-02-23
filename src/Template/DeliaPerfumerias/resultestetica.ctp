<?php echo $this->element('delia_menu'); ?>
<div class="col-md-12">
<div class="product-item-3">
<div class="product-content">
<?php echo $this->element('delia_estetica_search'); ?>
<?php if ($result!=null )
{ echo $this->element('delia_estetica_search_result2'); }
else
{ 
//echo $this->element('delia_fragancia_search_sinresult_marca');
//echo $this->element('delia_fragancia_search_sinresult'); 
}
?>
</div> <!-- /.product-content -->
</div> <!-- /.product-item -->
</div> <!-- /.col-md-3 -->
<script>
document.getElementById("titulo_logo").innerHTML='<img src="https://www.drogueriasur.com.ar/ds/img/titulo_estetica.png" id="titulo_logo_img" style=" margin:0 auto; margin-top:13px; "/>';
//document.getElementById("logo_delia").src = "/ds3/img/logo_delia_fragancia.png";
</script>
<?php echo $this->element('delia_menu'); ?>
<div class="col-md-12">
<div class="product-item-3">
<div class="product-content">
<?php echo $this->element('delia_makeup_search'); ?>
<?php if ($makeup!=null )
{ echo $this->element('delia_makeup_search_result'); }
else
{ 
//echo $this->element('delia_fragancia_search_sinresult_marca');

echo $this->element('delia_makeup_search_sin_result'); 
}
?>
</div> <!-- /.product-content -->
</div> <!-- /.product-item -->
</div> <!-- /.col-md-3 -->
<script>
document.getElementById("titulo_logo").innerHTML='<img src="https://www.drogueriasur.com.ar/ds/img/titulo_makeup.png" id="titulo_logo_img" width=120px style=" margin:0 auto; margin-top:15px; "/>';
//document.getElementById("logo_delia").src = "/ds3/img/logo_delia_fragancia.png";
</script>
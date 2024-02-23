<?php echo $this->element('delia_menu'); ?>
<div class="col-md-12">
<div class="product-item-3">
<div class="product-content">
<?php echo $this->element('delia_solares_search'); ?>
<?php if ($solares!=null )
{ echo $this->element('delia_solares_search_result'); }
else
{ 
echo $this->element('delia_solares_search_sin_result'); 
}
?>
</div> <!-- /.product-content -->
</div> <!-- /.product-item -->
</div> <!-- /.col-md-3 -->
<script>
document.getElementById("titulo_logo").innerHTML='<img src="https://www.drogueriasur.com.ar/ds/img/titulo_solares.png" id="titulo_logo_img" width=130px style=" margin:0 auto; margin-top:10px; "/>';
//document.getElementById("logo_delia").src = "/ds3/img/logo_delia_fragancia.png";
</script>
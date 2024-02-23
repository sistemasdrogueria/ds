<?php echo $this->element('delia_menu'); ?>
<div class="col-md-12">
<div class="product-item-3">
<div class="product-content">

<?php echo $this->element('delia_fragancia_search'); ?>
<?php if ($fragancias!=null )
{ echo $this->element('delia_fragancia_search_result'); }
else
{ 
echo '<div class=cliente_info_class2>Fragancias Selectivas</div></br>';
echo $this->element('delia_fragancia_search_sinresult_marca');

echo $this->element('delia_fragancia_search_sinresult'); 
}
?>

</div> <!-- /.product-content -->
</div> <!-- /.product-item -->
</div> <!-- /.col-md-3 -->
<script>
document.getElementById("titulo_logo").innerHTML='<img src="https://www.drogueriasur.com.ar/ds/img/titulo_seccion_fragancias.png" id="titulo_logo_img" width=150px style=" margin:0 auto; margin-top:13px; "/>';
//document.getElementById("logo_delia").src = "/ds3/img/logo_delia_fragancia.png";
</script>
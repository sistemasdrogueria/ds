<?php echo $this->element('delia_menu'); ?>
<div class="col-md-12">
<div class="product-item-3">
<div class="product-content" >
<?php
echo '<div class=row>'.$this->element('delia_dermo_search').'</div>';
echo '<div class=row><br>'. $this->element('delia_dermo_marcas');
echo $this->element('delia_dermo_sin_result'); 
echo '</div>';
?>
</div> <!-- /.product-content -->
</div> <!-- /.product-item -->
</div> <!-- /.col-md-3 -->
<script>
document.getElementById("titulo_logo").innerHTML='<img src="https://www.drogueriasur.com.ar/ds/img/titulo_dermo.png" id="titulo_logo_img" width=100px style=" margin:0 auto; margin-top:13px; "/>';
</script>
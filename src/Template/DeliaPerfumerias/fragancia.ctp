<?php echo $this->element('delia_menu'); ?>
<div class="col-md-12" >
<div class="product-item-3">
<div class="product-content" >
<?php
if (!is_null($pass)) echo '<div class=row>'.$this->element('delia_fragancia_search').'</div>';
echo '<div class=row><br>'. $this->element('delia_fragancia_marcas');
echo '</div></br>';
echo '<div>'.$this->element('delia_fragancia_sin_result'); 
echo '</div>';
?>
</div> <!-- /.product-content -->
</div> <!-- /.product-item -->
</div> <!-- /.col-md-3 -->
<script>
let  cadena = new String(window.location);

if (cadena.includes("/fragancia/select"))
    document.getElementById("titulo_logo").innerHTML='<img src="../../img/titulo_seccion_fragancias.png" id="titulo_logo_img" width=150px style=" margin:0 auto; margin-top:13px; "/>';
    else if (cadena.includes("/fragancia/semiselect"))
    document.getElementById("titulo_logo").innerHTML='<img src="../../img/titulo_seccion_fragancias.png" id="titulo_logo_img" width=150px style=" margin:0 auto; margin-top:13px; "/>';
    else
    document.getElementById("titulo_logo").innerHTML='<img src="../img/titulo_seccion_fragancias.png" id="titulo_logo_img" width=150px style=" margin:0 auto; margin-top:13px; "/>';
//document.getElementById("logo_delia").src = "/ds/img/logo_delia_fragancia.png";
</script>
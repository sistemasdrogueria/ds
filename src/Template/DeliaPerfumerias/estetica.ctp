<style>
    .esteticandiv{width:160px;min-height:250px;float:left;margin-left:5px;margin-right:5px;margin-top:10px;border-style:solid;border-width:0 0 1px;border-color:#ddd}
#estetica_row_grupos{text-align: center;}
.esteticagrupodiv{ margin:0 10px 15px 0;	width: 310px; height: 210px; border: 5px solid #AED9E0;	padding: 0px; display: inline-block; border-radius: 4px; } /**/
.esteticacontenedor{min-height:300px;width:100%;height:100%;  margin: 0px auto;} /**/
.esteticagrupoimagen img{width:125px}
.esteticapresentaciondiv input{width:20px}
.esteticapresentaciondiv label{display:none}
.esteticapresentaciondiv .fragcant{width:20px;padding:0;font-size:85%}
.esteticapresentaciondiv .fragml{width:50px;padding-left:5px;font-size:85%}
.esteticapresentaciondiv .fragpre{text-align:right;padding-right:5px;width:80px;font-size:90%}
.esteticapresentaciondiv .fragstock{padding-left:5px;width:15px}
</style>
<?php echo $this->element('delia_menu'); ?>
<div class="col-md-12">
<div class="product-item-3">
<div class="product-content" >
<?php
echo '<div class=row>'.$this->element('delia_estetica_search').'</div>';
echo '<div id=estetica_row_grupos ><br>'. $this->element('delia_estetica_marcas');
echo $this->element('delia_estetica_sin_result'); 
echo '</div>';
?>
</div> <!-- /.product-content -->
</div> <!-- /.product-item -->
</div> <!-- /.col-md-3 -->
<script>
document.getElementById("titulo_logo").innerHTML='<img src="/ds/img/titulo_estetica.png" id="titulo_logo_img"  style=" margin:0 auto; margin-top:13px; "/>';
</script>
<style>
.col-item {padding: 0;border: 5px solid #fff;background: 0 0;z-index: 10;position: relative;/*margin-bottom: 50px;*/}
.col-item .info {padding: 12px 15px 15px;}
.col-item .photo {position: relative;}
.col-item .photo a .bg_promo {position: absolute;left: 0;right: 0;top: 0;bottom: 0;background-color: #0d1217;opacity: 0;z-index: 2;}
.col-item .photo a .btn_bg_promo {position: absolute;left: 0;right: 0;margin: 0 auto;top: 130px;width: 130px;padding: 10px 20px 8px;background: #1b82c5;color: #fff;text-align: center;z-index: 3;opacity: 0;}
.col-item .photo a img, .col-item .photo img {margin: 0 auto;width: 100%;z-index: 1;}
.leyenda {float:left;margin-left: 15px;/*font-size:15px;*/font-weight: bold;font-size: 1.0vw;}
.photo {width:35px;float:left;}
.vermas {float:right;color: #3483fa;text-decoration: none;float: left;margin-top: 20px;z-index: 150;color:#fff;margin-left: 50px;position: absolute;font-size: 1.0vw;}
.vermas2 {float:right; color: #3483fa; text-decoration: none; float: left; width: 100%; margin-top: 20px; z-index: 150;color:#fff;margin-left: 130px;position: absolute;font-size: 1.0vw;}
@media (min-width: 500px) {.leyenda{margin-left: 5px;display:none;}.col-item{border: 0;}}
@media (min-width: 770px) {.leyenda{margin-left: 5px;display:none;}}
@media (min-width: 800px) {.col-sm-3, .col-md-3{padding-right: 0px;padding-left: 0px;}.leyenda{margin-left: 5px;display:block;}}
@media (min-width: 1000px) {.col-sm-3, .col-md-3{padding-right: 0px;padding-left: 0px;}.leyenda{margin-left: 5px;}}
@media (min-width: 1200px) {.col-sm-3, .col-md-3{padding-right: 0px;padding-left: 0px;}.leyenda{margin-left: 5px;display:block;}}
@media (min-width: 1300px) {.col-sm-3, .col-md-3{padding-right: 5px;padding-left: 5px;}.leyenda{margin-left: 15px;display:block;}}
.hide-close .ui-dialog-titlebar-close { display: inline-block; }
</style>
<!--div class="col-md-9" -->
<div class="product-item-3" style="margin-bottom:15px;">
<div class="product-thumb">
<div class="col-md-12 col-sm-12">
<!-- div class="row">
<span style="font-size: 18px;">Formas de Pago</span>
</div --> 
<div class="row">
<div class="col-md-3 col-sm-3">
<div class="col-item">
<div class=photo ><?php echo $this->Html->image('ooss_icn.png');?> </div>
<div class=leyenda ><span>Obras Sociales</span></div>
<div class=vermas ><a id=vermas1>Ver más</a></div>
</div>
</div>
<div class="col-md-3 col-sm-3">
<div class="col-item">
<div class=photo ><?php echo $this->Html->image('transferencias_icn.png');?> </div>
<div class=leyenda ><span> Transferencias y <br> depósitos</span></div>
<div class=vermas2 ><a id=vermas2>Ver más</a></div>
</div>
</div>
<div class="col-md-3 col-sm-3">
<div class="col-item">
<div class=photo ><?php echo $this->Html->image('cheques_icn.png');?> </div>
<div class=leyenda ><span>Cheques</span></div>
<div class=vermas ><a id=vermas3>Ver más</a></div>
</div>
</div>
<div class="col-md-3 col-sm-3">
<div class="col-item">
<div class=photo ><?php echo $this->Html->image('tarjetas_icn.png');?> </div>
<div class=leyenda ><span > Tarjetas de débito/<br>crédito</span></div>
<div class=vermas2 ><a id=vermas4>Ver más</a></div>
</div>
</div>
</div> <!-- /.row -->
</div>
</div>
</div> 

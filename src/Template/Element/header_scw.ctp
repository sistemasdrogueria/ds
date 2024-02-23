
<div class="col-md-4 col-sm-3 col-xs-3">
<div class=logods>
<?php echo $this->Html->image('logo_ds_sc.png',['alt'=>'Drogueria Sur S.A.','id'=>'logo_web','url'=>['controller'=>'Carritos','action'=>'index']]);?>
</div>
</div>
<div class="col-md-4 col-sm-3 col-xs-3">
<div class=CYBERMONDAY style="text-align: center; margin-top: 15px;">
<?php //echo $this->Html->image('CORONAVIRUS-BANNER.gif',['alt'=>'Drogueria Sur S.A.','url'=>['controller'=>'Carritos','action'=>'index']]);?>
<?php echo $this->Html->image('SANTA-CLAUS-WEEK.png',['alt'=>'Drogueria Sur S.A.','url'=>['controller'=>'Carritos','action'=>'index']]);?>
<?php //echo $this->Html->image('CYBER-MONDAY-ICONO.png',['alt'=>'Drogueria Sur S.A.','url'=>['controller'=>'Carritos','action'=>'index']]);?>
</div>
</div>
<div class="col-md-4 col-sm-9 col-xs-9">
<div class=main-menu>
<ul class=menu>

<li style='float: right;  height:40px; margin:0 5px 0 5px;'> <?php echo $this->Html->image('icon_salir_scw.png', ['url'=>['controller' => 'Users', 'action' => 'logout']],['alt' => 'Cerrar Sesión','class'=>'codrops-icon codrops-icon-back']);?></li>
<li style='float: right;  height:40px; margin:0 5px 0 5px;'> <?php echo $this->Html->image('icon_configurar_scw.png', ['url'=>['controller'=>'Clientes','action'=>'view']],['alt' => 'Ver Evento']);?></li>
<li style="float: right;  height:40px; margin:0 5px 0 5px;"> <?php echo $this->Html->image('logo_cs_scw.png', ['url'=>['controller' => 'ComunidadSur', 'action' => 'index']], ['alt' => 'Comunidad Sur']);?></li>
<?php if ($this->request->session()->read('Auth.User.farmapoint')==1) 
echo '<li style="float: right;  height:40px; margin:0 5px 0 5px;">'.$this->Html->image('logo_tfp_scw.png', ['url'=>['controller' => 'Carritos', 'action' => 'farmapoint']]).'</li>';?>
<li style='float: right; width: 60px; margin:0 5px 0 10px;'> <?php echo $this->Html->image('icon_carro_scw2.png', ['alt' => 'Ver carro','id'=>'opener']);?></li>
<?php if($this->request->session()->read('totalunidades')<99){echo "<div class='carro_unidades_ico'   id='openert'><div>";echo "<div class='carro_unidades_nro' id='openerts'  data-value=".$this->request->session()->read('totalunidades')." value=".$this->request->session()->read('totalunidades').">".$this->request->session()->read('totalunidades')."</div>";}?>
<?php if($this->request->session()->read('totalunidades')>=99){echo "<div class='carro_unidades_ico'  id='openert'><div>";echo "<div class='carro_unidades_nro'  id='openerts' data-value=".$this->request->session()->read('totalunidades')." value=".$this->request->session()->read('totalunidades').">+99</div>";}?>
</ul>
</div>
</div>
<script>
//hacer click en el carrito
focusMethod = function getFocus() {
 document.getElementById("opener").click();
}

</script>
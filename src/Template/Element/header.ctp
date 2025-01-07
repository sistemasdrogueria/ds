<style>
.simbDay{position:relative;display:inline-block;text-align:center;width:100px}
.temps{position:absolute;top:60%;left:50%;transform:translate(-50%,-50%);color:#000;font-weight:bold;font-size:11px}
.temps60{position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);color:#000;font-weight:bold;font-size:11px}
.centrado{z-index:1;display:inline-flex;flex-direction:row;flex-wrap:nowrap;align-content:center;justify-content:space-evenly;align-items:center}
span.temps span.TMin{color:#111213ab}
span.temps60 span.TMin{color:#111213ab}
span.temps span.TMax{color:#a51010}
span.temps60 span.TMax{color:#a51010}
p.nomDayExt{top:-17%;transform:translate(-50%,-50%);left:50%;position:absolute;white-space:pre;font-size:10px;font-weight:700;text-align:center;text-overflow:ellipsis;overflow:hidden;height:16px}
p.nomDaySim{top:-17%;transform:translate(-50%,-50%);left:50%;position:absolute;white-space:pre;font-size:10px;font-weight:700;text-align:center;text-overflow:ellipsis;overflow:hidden;height:16px}
p.nomCiudad{white-space:pre;font-size:10px;font-weight:700;text-align:center;text-overflow:ellipsis;overflow:hidden;height:16px;transform:translate(0%,150%);position:absolute}
.centrado span img{margin-top:4px}
#logo_web{margin-top: 5px}
@media only screen and (min-width : 800px) and (max-width : 1198px) {.iconoslink{width:41.66666667%}.iconoclima{width: 25%}p.nomDaySim {transform: translate(-40%, -50%)!important}}
</style>
<div class="col-md-4 col-sm-3 col-xs-3" id="logodsmovil">
<div class=logods>
<?php echo $this->Html->image('logo_ds.png',['alt'=>'Drogueria Sur S.A.','id'=>'logo_web','url'=>['controller'=>'Carritos','action'=>'index']]);?>
</div>
</div>
<div class="col-md-4 iconoclima col-sm-3  col-xs-3"  id="iconoclima"style="text-align:center;">
<?php
if(!empty($this->request->session()->read('Auth.User.localidad_id_meteo'))){
$file = @file_get_contents('http://api.meteored.com.ar/index.php?api_lang=ar&localidad='.$this->request->session()->read('Auth.User.localidad_id_meteo').'&affiliate_id=up7kekq351gn&v=3.0');
$items = json_decode($file, true);
if($items != null){
if($items['day'][1]['symbol_value'] == 2 || $items['day'][1]['symbol_value'] == 3 || $items['day'][1]['symbol_value'] == 4){
echo '<div class="centrado"><span class="simbDay"> ' . $this->Html->image('simbolo/weather/' . $items['day'][1]['symbol_value'] . '.png', ['width'=>'58px','height'=>'48px','alt' => '' . $items['day'][1]['symbol_description'] . '', 'title' => '' . $items['day'][1]['symbol_description'] . '']) . '
<span class="temps"> <span class="TMax">'. $items['day'][1]['tempmax'] . '°</span> <span class="TMin">' . $items['day'][1]['tempmin'] . '°</span> 
</span><p class="nomDayExt">Hoy</p></span><p class="nomCiudad">'.trim(preg_replace("/\[(.*?)\]/i"," ",$items['location'])).'</p>
';
if($items['day'][2]['symbol_value'] == 2 || $items['day'][2]['symbol_value'] == 3 || $items['day'][2]['symbol_value'] == 4){
echo '
<span class="simbDay"> ' . $this->Html->image('simbolo/weather/' . $items['day'][2]['symbol_value'] . '.png', ['width'=>'58px','height'=>'48px','alt' => '' . $items['day'][2]['symbol_description'] . '', 'title' => '' . $items['day'][2]['symbol_description'] . '']) . '
<span class="temps"> <span class="TMax">'. $items['day'][2]['tempmax'] . '°</span> <span class="TMin">' . $items['day'][2]['tempmin'] . '°</span> 
</span>
<p class="nomDaySim">Mañana.</p></span>
</div> ';
}else{
echo '
<span class="simbDay"> ' . $this->Html->image('simbolo/weather/' . $items['day'][2]['symbol_value'] . '.png', ['width'=>'58px','height'=>'48px','alt' => '' . $items['day'][2]['symbol_description'] . '', 'title' => '' . $items['day'][2]['symbol_description'] . '']) . '
<span class="temps60"> <span class="TMax">'. $items['day'][2]['tempmax'] . '°</span> <span class="TMin">' . $items['day'][2]['tempmin'] . '°</span> 
</span>
<p class="nomDaySim">Mañana.</p></span>
</div> ';
}
}else{
//dia 1
echo '<div class="centrado"><span class="simbDay"> ' . $this->Html->image('simbolo/weather/' . $items['day'][1]['symbol_value'] . '.png', ['width'=>'58px','height'=>'48px','alt' => '' . $items['day'][1]['symbol_description'] . '', 'title' => '' . $items['day'][1]['symbol_description'] . '']) . '
<span class="temps60"> <span class="TMax">'. $items['day'][1]['tempmax'] . '°</span> <span class="TMin">' . $items['day'][1]['tempmin'] . '°</span> 
</span>
<p class="nomDayExt">Hoy</p></span><p class="nomCiudad">'.trim(preg_replace("/\[(.*?)\]/i"," ",$items['location'])).'</p>
';

if($items['day'][2]['symbol_value'] == 2 || $items['day'][2]['symbol_value'] == 3 || $items['day'][2]['symbol_value'] == 4){
echo '
<span class="simbDay"> ' . $this->Html->image('simbolo/weather/' . $items['day'][2]['symbol_value'] . '.png', ['width'=>'58px','height'=>'48px','alt' => '' . $items['day'][2]['symbol_description'] . '', 'title' => '' . $items['day'][2]['symbol_description'] . '']) . '
<span class="temps"> <span class="TMax">'. $items['day'][2]['tempmax'] . '°</span> <span class="TMin">' . $items['day'][2]['tempmin'] . '°</span> 
</span>
<p class="nomDaySim">Mañana</p></span>
</div> ';
}else{
echo '
<span class="simbDay"> ' . $this->Html->image('simbolo/weather/' . $items['day'][2]['symbol_value'] . '.png', ['width'=>'58px','height'=>'48px','alt' => '' . $items['day'][2]['symbol_description'] . '', 'title' => '' . $items['day'][2]['symbol_description'] . '']) . '
<span class="temps60"> <span class="TMax">'. $items['day'][2]['tempmax'] . '°</span> <span class="TMin">' . $items['day'][2]['tempmin'] . '°</span> 
</span>
<p class="nomDaySim">Mañana</p></span>
</div> ';
}
}}}
?>
<div class="CYBERMONDAY hide" style="text-align: center; margin-top: 7px;">
<?php //echo $this->Html->image('CORONAVIRUS-BANNER.gif',['alt'=>'Drogueria Sur S.A.','url'=>['controller'=>'Carritos','action'=>'index']]);?>
<?php //echo $this->Html->image('CYBER-MONDAY-ICONO.png',['alt'=>'Drogueria Sur S.A.','url'=>['controller'=>'Carritos','action'=>'index']]);?>
</div>
</div>
<div class="col-md-4 col-sm-9 col-xs-9 iconoslink">
<div class=main-menu>
<ul class=menu>
<li style='float: right;  height:40px; margin:0 5px 0 5px;'> <?php echo $this->Html->image('icono_salir.png', ['url'=>['controller' => 'Users', 'action' => 'logout']],['alt' => 'Cerrar Sesión','class'=>'codrops-icon codrops-icon-back']);?></li>
<li style='float: right;  height:40px; margin:0 5px 0 5px;'> <?php echo $this->Html->image('icono_configurar.png', ['url'=>['controller'=>'Clientes','action'=>'view']],['alt' => 'Ver Evento']);?></li>
<?php 
if ($this->request->session()->read('Auth.User.beneficio_comunidadsur')==1) 
echo '<li style="float: right;  height:40px; margin:0 5px 0 5px;">'. $this->Html->image('logo_cs.png', ['url'=>['controller' => 'ComunidadSur', 'action' => 'index']], ['alt' => 'Comunidad Sur']).'</li>';
if ($this->request->session()->read('Auth.User.farmapoint')==1) 
echo '<li style="float: right;  height:40px; margin:0 5px 0 10px;">'.$this->Html->image('logo_TFP.png', ['url'=>['controller' => 'Carritos', 'action' => 'tufarmapoint']]).'</li>';
?>
<li style='float: right; width: 40px; margin:0 5px 0 10px;'> <?php echo $this->Html->image('icono_carro.png', ['alt' => 'Ver carro','id'=>'opener']);?></li>
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

<div class="col-md-5 col-sm-9 col-xs-9">
<div class=main-menu style="    margin-top: 12px;">
<ul class=menu >
<li style='float: right;  height:40px; margin:0 5px 0 5px;'> <?php echo $this->Html->image('icono_salir_blanco.png', ['url' => ['controller' => 'Users', 'action' => 'logout']], ['alt' => 'Cerrar Sesión', 'class' => 'codrops-icon codrops-icon-back']); ?></li>
<li style='float: right;  height:40px; margin:0 5px 0 5px;'><?php echo $this->Html->image('icono_configurar_blanco.png', ['url' => ['controller' => 'Clientes', 'action' => 'view']], ['alt' => 'Ver Evento']); ?></li>
<li style='float: right;  height:40px; margin:0 5px 0 10px;'> <?php echo $this->Html->image('logo_cs_w.png', ['url' => ['controller' => 'ComunidadSur', 'action' => 'index']], ['alt' => 'Comunidad Sur']); ?></li>
<?php if ($this->request->session()->read('Auth.User.farmapoint') == 1)
echo '<li style="float: right;   margin:0 5px 0 5px;">' . $this->Html->image('icono_TFP.png', ['url' => ['controller' => 'Carritos', 'action' => 'farmapoint']]) . '</li>'; ?>
<li style='float: right;  height:40px; margin:0 5px 0 10px;'> <?php echo $this->Html->image('icono_carro_blanco.png', ['alt' => 'Ver carro', 'id' => 'opener']); ?></li>
<?php if ($this->request->session()->read('totalunidades') < 99) {
echo "<div class='carro_unidades_ico'   id='openert'>";
echo "<div  class='carro_unidades_nro' style='Color:#FFFFFF;'id='openerts'  data-value=" .$this->request->session()->read('totalunidades'). " value=" . $this->request->session()->read('totalunidades') . ">" . $this->request->session()->read('totalunidades') . "</div></div>";
} ?>
<?php if ($this->request->session()->read('totalunidades') >= 99) {
echo "<div class='carro_unidades_ico'  id='openert'>";
echo "<div class='carro_unidades_nro' style='color:#FFFFFF;'id='openerts' data-value=" .$this->request->session()->read('totalunidades'). " value=" . $this->request->session()->read('totalunidades') . ">+99</div></div>";

} ?>
<li style='float: left;  height:40px; margin:0 5px 0 5px;'> <?php echo $this->Html->image('icono_volver.png', ['url' => ['controller' => 'Carritos', 'action' => 'index']]); ?></li>

</ul>
</div>
</div>
<script>
//hacer click en el carrito
focusMethod = function getFocus() {
 document.getElementById("opener").click();
}

</script>
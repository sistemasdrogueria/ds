<style> .notificacionfalta{ float: right; margin-right: 10px;  margin-top: -29px; z-index: 100;  width: 30px; height: 30px; text-align: center }
.notificacionfaltacantidad{ margin-left: 23px; z-index: 120; margin-top: -33px; color:white} 
.notificacionfaltacantidadmas{ margin-left: 17px; z-index: 120;  margin-top: -33px; color:white} 
</style>

<div class="col-md-12 col-sm-12">
<div class="button-holder6">
    <a href="#"  class="vaciar" onclick="preguntarSI(<?php echo $_SESSION['Auth']['User']['cliente_id']?>)">Vaciar</a>
</div> 
<div class="button-holder3">
<a class="red-btn" href="#" onsubmit="return false;" onclick="confirmarofertasperdidas()">Enviar</a>
</div>
<div class="button-holder7">
<?= $this->Html->link(__('Ver Carro'),['controller' => 'Carritos', 'action' => 'view'], ['class'=>'red-btn']) ?>
</div>
<div class="button-holder8">
<?= $this->Html->link(__('Faltas'),['controller' => 'Carritos', 'action' => 'faltas'], ['id' => 'vercarro','class'=>'red-btn']) ?>
<div class=notificacionfalta><?php 
if ($this->request->session()->read('Auth.User.notificacionfalta')>0) 
echo $this->Html->image('notificacion_falta.png',['title' => 'FALTA'] );	
?>
<?php 
if ($this->request->session()->read('Auth.User.notificacionfalta')>0)
{
if ($this->request->session()->read('Auth.User.notificacionfalta')>9)  
echo '<div class=notificacionfaltacantidadmas>+9';
else
echo '<div class=notificacionfaltacantidad>'.$this->request->session()->read('Auth.User.notificacionfalta');
echo '</div>';
}?>
</div>
</div> 

</div>
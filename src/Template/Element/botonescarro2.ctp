<div class="col-md-12 col-sm-12">

<div class="button-holder7">
<?= $this->Html->link(__('Enviar'),['controller' => 'Carritos', 'action' => 'confirm'], ['class'=>'red-btn']) ?>
</div>
<div class="button-holder3">
<?= $this->Html->link(__('Ver Carro'),['controller' => 'Carritos', 'action' => 'view'], ['class'=>'red-btn']) ?>
</div>

<div class="button-holder6">
<?= $this->Html->link('Vaciar',['controller' => 'Carritos', 'action' => 'vaciar'],['confirm' => 'Esta seguro de vaciar el carrito'])?>
</div> 
</div>
<?php		
echo $this->Html->css('job/bootstrapvalidator'); 
?>
<?= $this->Form->create($clientesAlta,['url'=>['controller' => 'ClientesAltas', 'action' => 'add'],'type' => 'file','class'=>"well form-horizontal", 'id'=>"contact_form", 'style'=>"background-color: #FFFFFF;"]) ?>
<fieldset>
<legend>APERTURA DE CUENTA</legend>     
<div class="form-group">
<label class="col-md-4 control-label">Razón Social</label>  
<div class="col-md-4 inputGroupContainer">
<div class="input-group">
<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
<?php echo $this->Form->control('razon_social',['placeholder'=>'Razón Social' ,'class'=>'form-control','label' =>'']);?>
</div>
</div>
</div>
<div class="form-group">
<label class="col-md-4 control-label" >Nombre de Fantasía</label> 
<div class="col-md-4 inputGroupContainer">
<div class="input-group">
<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
<?php echo $this->Form->control('nombre_fantasia',['placeholder'=>'Nombre de fantasía' ,'class'=>'form-control','label' =>'']);?>
</div>
</div>
</div>
<div class="form-group">
<label class="col-md-4 control-label" >Dirección</label> 
<div class="col-md-4 inputGroupContainer">
<div class="input-group">
<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
<?php echo $this->Form->control('domicilio',['placeholder'=>'Dirección' ,'class'=>'form-control','label' =>'']);?>
</div>
</div>
</div>
<div class="form-group">
<label class="col-md-4 control-label">Provincia</label>  
<div class="col-md-4 inputGroupContainer">
<div class="input-group">
<span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
<?php echo $this->Form->control('provincia',['options'=>$provincias ,'placeholder'=>'Seleccionar Provincia' ,'class'=>'form-control','label' =>'','required' => true,]);?>
</div>
</div>
</div>
<div class="form-group">
<label class="col-md-4 control-label">Localidad</label>  
<div class="col-md-4 inputGroupContainer">
<div class="input-group">
<span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
<?php echo $this->Form->control('localidad',['placeholder'=>'Localidad' ,'class'=>'form-control','label' =>'','required' => true,]);?>
</div>
</div>
</div>
<div class="form-group">
<label class="col-md-4 control-label">Código Postal</label>  
<div class="col-md-4 inputGroupContainer">
<div class="input-group">
<span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
<?php echo $this->Form->control('codigo_postal',['placeholder'=>'Código Postal' ,'class'=>'form-control','label' =>'','required' => true,]);?>
</div>
</div>
</div>
<div class="form-group">
<label class="col-md-4 control-label">Email</label>  
<div class="col-md-4 inputGroupContainer">
<div class="input-group">
<span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
<?php echo $this->Form->control('email',['placeholder'=>'Ingrese email' ,'class'=>'form-control','label' =>'','required' => true]);?>
</div>
</div>
</div>
<div class="form-group">
<label class="col-md-4 control-label">Código de Area Teléfono</label>  
<div class="col-md-4 inputGroupContainer">
<div class="input-group">
<span class="input-group-addon"><i class="glyphicon glyphicon-earphone"></i></span>
<?php echo $this->Form->control('telefono',['placeholder'=>'0291' ,'class'=>'form-control','label' =>'','required' => true]);?>
</div>
</div>
</div>		
<div class="form-group">
<label class="col-md-4 control-label">Teléfono</label>  
<div class="col-md-4 inputGroupContainer">
<div class="input-group">
<span class="input-group-addon"><i class="glyphicon glyphicon-earphone"></i></span>
<?php echo $this->Form->control('celular',['placeholder'=>'154 400 001' ,'class'=>'form-control','label' =>'','required' => true]);?>
</div>
</div>
</div>


<div class="form-group">
<label class="col-md-4 control-label">CUIT</label>  
<div class="col-md-4 inputGroupContainer">
<div class="input-group">
<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
<?php echo $this->Form->control('cuit',['placeholder'=>'XX-XXXXXXXX-X' ,'class'=>'form-control','label' =>'','required' => true,'type'=>'integer','error' => ['The provided value is invalid' => __('Ingrese un número de CUIT')]]);?>
</div>
</div>
</div>
<div class="form-group">
<label class="col-md-4 control-label" >Comentario</label> 
<div class="col-md-4 inputGroupContainer">
<div class="input-group">
<span class="input-group-addon"><i class="glyphicon glyphicon-comment"></i></span>
<?php echo $this->Form->control('comentario',['placeholder'=>'Comentario' ,'class'=>'form-control','label' =>'']);?>

</div>
</div>
</div>

</fieldset>
<?= $this->Form->button(__('Enviar Solicitud'),['class'=>'button small gradient green rnd5']) ?>
<?= $this->Form->end() ?>

<script>
window.onload = function(){
    $('html, body').animate({scrollTop:$('#contact_form').position().top}, 'slow');
};
</script>
<link rel='stylesheet prefetch' href='http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css'>
<link rel='stylesheet prefetch' href='http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css'>
<?php		
		//echo $this->Html->script('job/modernizr.min');
		//echo $this->Html->css('jquery-ui.min');
		//echo $this->Html->css('job/bootstrap.min'); 
		echo $this->Html->css('job/bootstrapvalidator'); 
		//echo $this->Html->css('job/style');
?>
<?= $this->Form->create($curriculum,['url'=>['controller' => 'Curriculums', 'action' => 'add'],'type' => 'file','class'=>"well form-horizontal", 'id'=>"contact_form", 'style'=>"background-color: #FFFFFF;"]) ?>
<fieldset>
<legend>DATOS PERSONALES</legend>     
<div class="form-group">
  <label class="col-md-4 control-label">Nombre</label>  
  <div class="col-md-4 inputGroupContainer">
  <div class="input-group">
	<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
	<?php echo $this->Form->control('nombres',['placeholder'=>'Nombre' ,'class'=>'form-control','label' =>'']);?>
	</div>
  </div>
</div>
<div class="form-group">
  <label class="col-md-4 control-label" >Apellido</label> 
    <div class="col-md-4 inputGroupContainer">
    <div class="input-group">
  <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
  <?php echo $this->Form->control('apellidos',['placeholder'=>'Apellido' ,'class'=>'form-control','label' =>'']);?>
 
    </div>
  </div>
</div>
<div class="form-group">
  <label class="col-md-4 control-label">Fecha de nacimiento</label>
    <div class="col-md-4 inputGroupContainer">
    <div class="input-group">
		<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
		<input type="date" name="fecha_nacimiento"> 
  </div>
  </div>
</div>	
<div class="form-group">
  <label class="col-md-4 control-label">Documento</label>  
   <div class="col-md-4 inputGroupContainer">
    <div class="input-group">
        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
		  <?php echo $this->Form->control('documento',['placeholder'=>'Documento' ,'class'=>'form-control','label' =>'']);?>
    </div>
  </div>
</div>	
<div class="form-group">
  <label class="col-md-4 control-label">Email</label>  
   <div class="col-md-4 inputGroupContainer">
    <div class="input-group">
        <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
		  <?php echo $this->Form->control('email',['placeholder'=>'Ingrese email' ,'class'=>'form-control','label' =>'']);?>
    </div>
  </div>
</div>	
<div class="form-group">
  <label class="col-md-4 control-label">Telefono</label>  
    <div class="col-md-4 inputGroupContainer">
    <div class="input-group">
        <span class="input-group-addon"><i class="glyphicon glyphicon-earphone"></i></span>
		<?php echo $this->Form->control('telefono',['placeholder'=>'(291)154 400 001' ,'class'=>'form-control','label' =>'']);?>
    </div>
  </div>
</div>
<div class="form-group">
  <label class="col-md-4 control-label">Area</label>  
    <div class="col-md-4 inputGroupContainer">
    <div class="input-group">
        <span class="input-group-addon"><i class="glyphicon glyphicon-briefcase"></i></span>
		<?php echo $this->Form->control('sector_id',['options' => $sectors,'placeholder'=>'Area','class'=>'form-control','label' =>'','empty' => '(Seleccionar)']);?>
    </div>
  </div>
</div>
<div class="form-group">
  <label class="col-md-4 control-label">Curriculum</label>
    <div class="col-md-4 inputGroupContainer">
    <div class="input-group">
		<span class="input-group-addon"><i class="glyphicon glyphicon-file"></i></span>
		
		<?php echo $this->Form->control('file',['type' => 'file','class'=>'form-control','label' =>'']);?>
  </div>
  </div>
</div>
</fieldset>
<?= $this->Form->button(__('Enviar CV'),['class'=>'button small gradient green rnd5']) ?>
<?= $this->Form->end() ?>
<link rel='stylesheet prefetch' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css'>
<link rel='stylesheet prefetch' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css'>
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
<input type="date" name="fecha_nacimiento" required> 
</div>
</div>
</div>	
<div class="form-group">
<label class="col-md-4 control-label">Documento</label>  
<div class="col-md-4 inputGroupContainer">
<div class="input-group">
<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
<?php echo $this->Form->control('documento',['placeholder'=>'Documento' ,'class'=>'form-control','label' =>'',
'required' => true,'type'=>'integer',
'error' => ['The provided value is invalid' => __('Ingrese un número de Documento')]
]);?>
</div>
</div>
</div>	
<div class="form-group">
<label class="col-md-4 control-label">Email</label>  
<div class="col-md-4 inputGroupContainer">
<div class="input-group">
<span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
<?php echo $this->Form->control('email',['placeholder'=>'Ingrese email' ,'class'=>'form-control','label' =>'','required' => true,]);?>
</div>
</div>
</div>	
<div class="form-group">
<label class="col-md-4 control-label">Código de Área Teléfono</label>  
<div class="col-md-4 inputGroupContainer">
<div class="input-group">
<span class="input-group-addon"><i class="glyphicon glyphicon-earphone"></i></span>
<?php echo $this->Form->control('telefono_cod',['placeholder'=>'0291' ,'class'=>'form-control','label' =>'','required' => true]);?>
</div>
</div>
</div>
<div class="form-group">
<label class="col-md-4 control-label">Número de Teléfono</label>  
<div class="col-md-4 inputGroupContainer">
<div class="input-group">
<span class="input-group-addon"><i class="glyphicon glyphicon-earphone"></i></span>
<?php echo $this->Form->control('telefono',['placeholder'=>'154 400 001' ,'class'=>'form-control','label' =>'','required' => true,]);?>
</div>
</div>
</div>
<div class="form-group">
<label class="col-md-4 control-label">Provincia de Residencia</label>  
<div class="col-md-4 inputGroupContainer">
<div class="input-group">
<span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
<?php echo $this->Form->control('ciudad_residencia_provincia_id',['options'=>$provincias ,'placeholder'=>'Seleccionar Provincia','empty' => '(Seleccionar)' ,'class'=>'form-control','label' =>'','required' => true]);?>
</div>
</div>
</div>
<div class="form-group">
<label class="col-md-4 control-label">Ciudad de Residencia</label>  
<div class="col-md-4 inputGroupContainer">
<div class="input-group">
<span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
<?php echo $this->Form->control('ciudad_residencia',['placeholder'=>'Ciudad de Residencia' ,'class'=>'form-control','label' =>'','required' => true]);?>
</div>
</div>
</div>
<div class="form-group">
<label class="col-md-4 control-label">Código Postal de Residencia</label>  
<div class="col-md-4 inputGroupContainer">
<div class="input-group">
<span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
<?php echo $this->Form->control('ciudad_residencia_cp',['placeholder'=>'Codigo Postal' ,'class'=>'form-control','label' =>'','required' => true]);?>
</div>
</div>
</div>
<div class="form-group">
  <label class="col-md-4 control-label">Área</label>  
    <div class="col-md-4 inputGroupContainer">
    <div class="input-group">
        <span class="input-group-addon"><i class="glyphicon glyphicon-briefcase"></i></span>
		<?php echo $this->Form->select('sector_id',$sectors,['placeholder'=>'Area','class'=>'form-control','label' =>'','empty' => '(Seleccionar)']);?>
    </div>
  </div>
</div>
<div class="form-group">
<label class="col-md-4 control-label">Curriculum</label>
<div class="col-md-4 inputGroupContainer">
<div class="input-group">
<span class="input-group-addon"><i class="glyphicon glyphicon-file"></i></span>
<?php echo $this->Form->control('file',['type' => 'file','class'=>'form-control','label' =>'','required' => true ,'accept' => '.pdf, .doc, .docx']);?>
</div>
</div>
</div>
</fieldset>
<?= $this->Form->button(__('Enviar CV'),['class'=>'button small gradient green rnd5']) ?>
<?= $this->Form->end() ?>

<script>
window.onload = function(){
    $('html, body').animate({scrollTop:$('#contact_form').position().top}, 'slow');
};

	document.addEventListener('DOMContentLoaded', function() {
    const fileInput = document.querySelector('input[type="file"]');
    fileInput.addEventListener('change', function(e) {
        const maxSize = 3 * 1024 * 1024; // 3 MB in bytes
        const allowedTypes = ["application/pdf", "application/msword", "application/vnd.openxmlformats-officedocument.wordprocessingml.document"];
        if (this.files[0].size > maxSize) {
             alert('El archivo no debe exceder los 2 MB!');
            this.value = ''; // Clear the file input
            return;
        }
        if (!allowedTypes.includes(this.files[0].type)) {
            alert('Solamente aceptamos archivos PDF y Word!');
            this.value = ''; // Clear the file input
        }
    });
});
</script>
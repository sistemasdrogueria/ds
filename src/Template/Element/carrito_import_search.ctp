<div class="search-form" id="div_import_login_form" style="display:'';">
<?= $this->Form->create('Carritos',['type' => 'file','url'=>['controller'=>'Carritos','action'=>'importresult'],'id'=>'searchform3']); ?>
<?php echo $this->Form->input('namefile', ['id'=>'uploadFile','label'=>'Nombre Archivo','placeholder'=>'Nombre Archivo','disabled'=>'disabled']);?>
<div class="fileUpload btn btn-primary">
<span>Buscar Archivo</span>
<?php echo $this->Form->input('filetext', ['id'=>'uploadBtn','type' => 'file','class'=>'upload','label'=>'Buscar Archivo','name'=>'filetext']);?>	
</div>
<?php
echo $this->Form->select('sistfarm',$sistemas,['empty' => 'Seleccione Sistema']);
echo $this->Form->submit('Procesar',['class'=>'mainBtn','id'=>'mainbuttonmanten']);
echo $this->Form->end() 
?>
</div> <!-- /.search-form -->
<script>
document.addEventListener('DOMContentLoaded', (event) => {
// El DOM está completamente cargado, pero otros recursos como imágenes podrían todavía no estarlo.
// Muestra el formulario de login
document.getElementById('div_import_login_form').style.display = 'block';
});
document.getElementById("uploadBtn").onchange = function () {
document.getElementById("uploadFile").value = this.value;};
</script>
<script>
document.getElementById('searchform3').addEventListener('submit', function(event) {
event.preventDefault();  // Previene el envío inmediato del formulario

grecaptcha.ready(function() {
grecaptcha.execute('6LfgfTkoAAAAADIs76s1DbguGb9c4A8CTlx9zGqB', {action: 'submit'}).then(function(token) {
// Agrega el token al formulario o reemplaza si ya existe
var form = document.getElementById('searchform3');
var existingInput = form.querySelector('input[name="g-recaptcha-response"]');

if (existingInput) {
existingInput.value = token;
} else {
var input = document.createElement('input');
input.type = 'hidden';
input.name = 'g-recaptcha-response';
input.value = token;
form.appendChild(input);
}

// Envía el formulario ahora que el token ha sido agregado
form.submit();
});
});
});


</script>
<fieldset>


<div class="search-form">
    <?= $this->Form->create('Fragancias',['url'=>['controller'=>'Fragancias','action'=>'add_admin_search'],'id'=>'searchformfragancia','onsubmit'=>'return validar()']); ?>
		<?php
			echo $this->Form->input('terminobuscar', ['label'=>'','id'=>'terminobuscar','name'=>'terminobuscar', 'type'=>'text','onchange'=>'javascript:document.confirmInput.submit();']);
			echo $this->Form->submit('Buscar');
			echo $this->Form->end() 
		?>
</div> <!-- /.search-form -->
</fieldset>
<script>
	function validar(){
		//Almacenamos los valores
		var nombre=$('#terminobuscar').val();
		
	   //Comprobamos la longitud de caracteres
		if (nombre.length>2){ 
			return true;
		}
		else 
		{
				var mensaje= 'Minimo 3 caractere ';
				alert(mensaje);
				return false;		
		}
		
	}
</script>
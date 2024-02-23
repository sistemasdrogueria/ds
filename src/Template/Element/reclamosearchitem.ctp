<div class="search-form">
    <?= $this->Form->create('Carritos',['url'=>['controller'=>'Reclamos','action'=>'searchitem'],'id'=>'searchform','onsubmit'=>'return validar()']); ?>
		<?php
			echo $this->Form->input('terminobuscar', ['label'=>'','id'=>'terminobuscar','name'=>'terminobuscar', 'type'=>'text','onchange'=>'javascript:document.confirmInput.submit();']);
			echo $this->Form->input('categoria_id', ['label'=>'','options' => $categorias,'empty'=>'Toda las Categorias']);
            echo $this->Form->input('laboratorio_id', ['label'=>'','options' => $laboratorios,'empty'=>'Todos los Laboratorios']);
			echo $this->Form->submit('Buscar',['class'=>'mainBtn']);
			echo $this->Form->end() 
		?>
</div> <!-- /.search-form -->
<script>
	function validar(){
		//Almacenamos los valores
		var nombre=$('#terminobuscar').val();
		var laboratorio=$('#laboratorio-id').val();
	   //Comprobamos la longitud de caracteres
		if (nombre.length>3){ 
			return true;
		}
		else {
			
			if ((laboratorio.length>1) || (oferta.length>1))
			{
				return true;
			}
			else
			{
				var mensaje= 'Minimo 4 caractere ';
				alert(mensaje);
				return false;		
			}
		}
	}
</script>

<fieldset>
<div class="search-form">
    <?= $this->Form->create('Ofertas',['url'=>['controller'=>'Ofertas','action'=>'add'],'id'=>'searchformofertas','onsubmit'=>'return validar()']); ?>
		<?php
			$ofertastipo= [1=>'Perfumería y Acces.', 2=>'Patagonia Med', 3=>'Todas las Ofertas'];
            echo $this->Form->input('terminobuscar', ['label'=>'','id'=>'terminobuscar','name'=>'terminobuscar', 'type'=>'text','placeholder'=>'Buscar Producto', 'onchange'=>'javascript:document.confirmInput.submit();']);
			echo $this->Form->input('categoria_id', ['label'=>'','options' => $categorias,'empty'=>'Toda las Categorias']);
            echo $this->Form->input('laboratorio_id', ['label'=>'','options' => $laboratorios,'empty'=>'Todos los Laboratorios']);
			echo $this->Form->input('tipoofertas', ['label'=>'','options' => $ofertastipo,'empty'=>'Seleccionar Ofertas']);
		?>	
		
		<?php
		   /*<div id=checkbarra>
		echo $this->Form->checkbox('codigobarras', ['hiddenField' => false,'id'=>'check1']); 
			echo $this->Html->image('cb.png',['id'=>'cbarras','alt'=>'Buscar por codigo de barras']);
		</div>*/
		?>
		
		<?php 
			echo $this->Form->submit('Buscar',['class'=>'mainBtn']);
			echo $this->Form->end() 
		?>
		
</div> <!-- /.search-form -->
</fieldset>
<script>
	document.getElementById("terminobuscar").focus();
	function validar(){
		//Almacenamos los valores
		var nombre=$('#terminobuscar').val();
		var laboratorio=$('#laboratorio-id').val();
		var oferta=$('#ofertas').val();
	   //Comprobamos la longitud de caracteres
		if (nombre.length>3){ 
			return true;
		}
		else {
			
			if ((laboratorio.length>1) || (oferta.length>0))
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

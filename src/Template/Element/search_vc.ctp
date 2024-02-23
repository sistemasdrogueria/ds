<div class="search-form">
    <?= $this->Form->create('Carritos',['url'=>['controller'=>'Carritos','action'=>'ofertavc'],'id'=>'searchform5','onsubmit'=>'return validar()']); ?>
		<?php
			$ofertastipo= [1=>'Perfumería y Acces.', 2=>'Patagonia Med', 3=>'Todas las Ofertas'];
            echo $this->Form->input('terminobuscar', ['label'=>'','id'=>'terminobuscar','name'=>'terminobuscar','value'=>'', 'type'=>'text','placeholder'=>'Buscar Producto', 'onchange'=>'javascript:document.confirmInput.submit();']);
			echo $this->Form->input('categoria_id', ['label'=>'','options' => $categorias,'empty'=>'Toda las Categorias']);
            echo $this->Form->input('laboratorio_id', ['label'=>'','options' => $laboratorios,'empty'=>'Todos los Laboratorios']);
			echo $this->Form->input('ofertas', ['label'=>'','options' => $ofertastipo,'empty'=>'Seleccionar Ofertas']);
		?>	
		
		<div id=checkbarra>
		   	<?php
				echo $this->Form->checkbox('codigobarras', ['hiddenField' => false]);
				echo $this->Html->image('cb.png',['id'=>'cbarras','alt'=>'Buscar por codigo de barras']);?>
		</div>
		
		
		<?php 
			echo $this->Form->submit('Buscar',['class'=>'mainBtn']);
			echo $this->Form->end() 
		?>
</div> <!-- /.search-form -->
<script>
	document.getElementById("terminobuscar").focus();
	function validar(){
		//Almacenamos los valores
		var nombre=$('#terminobuscar').val();
		var laboratorio=$('#laboratorio-id').val();
		var oferta=$('#ofertas').val();
	   //Comprobamos la longitud de caracteres
		if (nombre.length>2){ 
			return true;
		}
		else {
			
			if ((laboratorio.length>0) || (oferta.length>0))
			{
				
				return true;
			}
			else
			{
				var mensaje= 'Minimo 3 caracteres';
				alert(mensaje);
				return false;		
			}
		}
	}
</script>

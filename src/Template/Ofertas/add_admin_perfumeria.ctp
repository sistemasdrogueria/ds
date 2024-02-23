
<article class="module width_3_quarter">
		<header><h3 class="tabs_involved"><?= $titulo ?></h3>
	
		</header>

	<?= $this->Form->create('Ofertas', ['url'=>['controller'=>'Ofertas','action'=>'add_admin_perfumeria'],'type' => 'file']) ?>
	<fieldset>	
			<?php echo $this->Form->input('descripcion'); ?>
	</fieldset>	
	<fieldset>	
		<div class="ofertainputfecha">
			<?= $this->Form->input('fecha_desde', ['label'=>'Desde:','id'=>'fecha_desde','name'=>'fecha_desde', 'type'=>'text','placeholder'=>'Fecha Desde:']);?>
		</div>
		<div class="ofertainputfecha">
			<?=	$this->Form->input('fecha_hasta', ['label'=>'Hasta:','id'=>'fecha_hasta','name'=>'fecha_hasta', 'type'=>'text','placeholder'=>'Fecha Hasta:','onchange'=>'javascript:document.confirmInput.submit();']);?>
		</div>
	</fieldset>		
	<fieldset>				
	<div class="ofertainputopcion">
		<?php	echo $this->Form->input('oferta_tipo_id', ['options' =>$ofertastipos]);  ?>
	</div>
	</fieldset>		
	
	<fieldset>	

			<?php
			echo $this->Form->input('file',['type' => 'file']);
            ?>
			
			<div>Tamaño de la imagen tiene debe ser 1000 x 765. El tipo debe ser .jpg </div>
	</fieldset>		
	<fieldset>	
	<div class="ofertainputcheck">
			<label for="activo" >Activo</label>	
			<?php	echo $this->Form->checkbox('activo', ['hiddenField' => true,'checked'=>true]);?>
	</div>	
	<div class="ofertainputcheck">
		<label for="activo" >Habilitada</label>	
		<?php	echo $this->Form->checkbox('habilitada', ['hiddenField' => true,'checked'=>true]);?>
	</div>	
    </fieldset>
	<fieldset>
	<div class="ofertainputbotton">
		<?= $this->Form->button(__('GUARDAR')) ?>
	</div>
    <?= $this->Form->end() ?>
	</fieldset>

 </article> 
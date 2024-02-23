<article class="module width_3_quarter">
		<header><h3 class="tabs_involved"><?= $titulo ?></h3>
		</header>
	<?= $this->Form->create('Articulos', ['url'=>['controller'=>'Articulos','action'=>'edit',$articulo['id']],'type' => 'file']) ?>
	<fieldset>	
		 <?php
            echo $articulo['troquel'] .'<br>';
            echo $articulo['descripcion_sist'].'<br>';
            //echo $articulo['descripcion_pag'];
            echo $articulo['categoria_id'].'<br>';//'this->Form->input('categoria_id', ['options' => $categorias, 'empty' => true]);
            echo $articulo['codigo_barras'].'<br>';
            echo $articulo['laboratorio_id'];
			
			echo $this->Form->input('id',['type'=>'hidden','value'=>$articulo->id]);
		?>
	</fieldset>	
	<fieldset>	
			<label for="activo" >Imagen Chica</label>	
			<?php echo $this->Form->input('file',['type' => 'file']); ?>
			
			<div>Tamaño de la imagen tiene debe ser 200 x 200. El tipo debe ser .jpg </div>
	</fieldset>		
	<fieldset>	
			<label for="activo" >Imagen Grande</label>	
			<?php echo $this->Form->input('file2',['type' => 'file']); ?>
			
			<div>Tamaño de la imagen tiene debe ser 1000 de ancho. El tipo debe ser .jpg </div>
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
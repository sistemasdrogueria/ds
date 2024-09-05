<?php //><script type="text/javascript">
$previous = "javascript:history.go(-1)";
if(isset($_SERVER['HTTP_REFERER'])) {
    $previous = $_SERVER['HTTP_REFERER'];
}
?>
<article class="module width_3_quarter">
	<header><h3 class="tabs_involved"><?= $titulo ?></h3></header>
	<?= $this->Form->create('Articulos', ['url'=>['controller'=>'Articulos','action'=>'edit',$articulo['id']],'type' => 'file']) ?>
	<fieldset>
		<?php
		echo 'DESCRIPCION: 	'.$articulo['descripcion_sist'].'<br>';
		echo 'TROQUEL:		'.$articulo['troquel'] .'<br>';
		echo 'COD. BARRAS:	'.$articulo['codigo_barras'].'<br>';
		echo 'CATEGORIA:	'.$articulo['categoria_id'].'<br>';//'this->Form->input('categoria_id', ['options' => $categorias, 'empty' => true]);
		echo 'LABORATORIO:	'.$articulo['laboratorio_id'];
		echo $this->Form->input('id',['type'=>'hidden','value'=>$articulo->id]);
		?>
	</fieldset>
	<fieldset>
		<label for="activo">Imagen Chica</label>
		<?php echo $this->Form->input('file',['type' => 'file']); ?>
		<div>Tamaño de la imagen tiene debe ser 200 x 200. El tipo debe ser .jpg </div>
	</fieldset>
	<fieldset>
		<label for="activo">Imagen Grande</label>
		<?php echo $this->Form->input('file2',['type' => 'file']); ?>
		<div>Tamaño de la imagen tiene debe ser 1000 de ancho. El tipo debe ser .jpg </div>
	</fieldset>
	<fieldset>
		<div class="ofertainputcheck">
			<label for="activo">Activo</label>
			<?php echo $this->Form->checkbox('activo', ['hiddenField' => true,'checked'=>true]);?>
		</div>
		<div class="ofertainputcheck">
			<label for="activo">Habilitada</label>
			<?php echo $this->Form->checkbox('habilitada', ['hiddenField' => true,'checked'=>true]);?>
		</div>
	</fieldset>
	<fieldset>
		<div class="">
			<?php	
			if ($articulo->fv_cerca) {
				echo
				$this->Form->checkbox('fv_cerca', ['label' => 'Vencimiento cerca', 'type' => 'checkbox', 'value' => $articulo->fv_cerca, 'checked' => true]);
			} else {
				echo
				$this->Form->checkbox('fv_cerca', ['label' => 'Vencimiento cerca', 'type' => 'checkbox', 'value' => $articulo->fv_cerca, 'checked' => false]);
			}
			?>
		</div>
		<div class="">
			<?php
			if ($articulo->fv_cerca) {
				echo $this->Form->input('fv', ['label' => 'Fecha Vencimiento', 'type' => 'text', 'value' => $articulo->fv, 'disabled' => false]);
			} else {
				echo $this->Form->input('fv', ['label' => 'Fecha Vencimiento', 'type' => 'text', 'value' => $articulo->fv, 'disabled' => true]);
			}

			?>
		</div>
	</fieldset>
	<fieldset>
		<div class="ofertainputbotton">
			<?= $this->Form->button(__('GUARDAR')) ?>
		</div>
		<?= $this->Form->end() ?>
	</fieldset>
</article>
<script>
	$('#fv-cerca').on('change', function() {

		if (document.getElementById('fv-cerca').checked) {

			$('#fv').prop('disabled', false);
		} else {
			$('#fv').prop('disabled', true);
		}

	});
</script>
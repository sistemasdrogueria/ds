<?php //><script type="text/javascript">
$previous = "javascript:history.go(-1)";
if(isset($_SERVER['HTTP_REFERER'])) {
    $previous = $_SERVER['HTTP_REFERER'];
}
?>
<style>
	.fichatecnica{ 	align-content: center;	}
</style>	
<article class="module width_3_quarter">
	<header><h3 class="tabs_involved"><?= $titulo ?></h3>
	<div class="volveratras">
<a href="<?= $previous ?>"><?php echo $this->Html->image('icn_volver.png');?></a>
</div>
</header>
	<?= $this->Form->create('Articulos', ['url'=>['controller'=>'Articulos','action'=>'edit_admin',$articulo['id']],'type' => 'file']) ?>
	<fieldset>
	<h2 style="text-align:center; ">Ficha Técnica</h2>
    <div class="fichatecnica" style="display: flex; align-items: center;">
        <div style="margin-right: 20px; margin-left: 15px;">
            <?php
            // Mostrar la imagen del producto
            echo $this->Html->image('productos/' . $articulo['imagen'], [
                'alt' => str_replace('"', '', $articulo['descripcion']),
                'height' => 200,
                'class' => 'imgFoto',
                'style' => 'border: 1px solid #ddd; border-radius: 4px; padding: 5px;'
            ]);
            ?>
        </div>
		<div>
            <?php
            // Mostrar detalles del producto
            echo '<p><strong>DESCRIPCIÓN SIST:</strong> ' . $articulo['descripcion_sist'] . '</p>';
			echo '<p><strong>DESCRIPCIÓN PAG:</strong> ' . $articulo['descripcion_pag'] . '</p>';
			echo '<p><strong>CLAVE AMP:</strong> ' . $articulo['clave_amp'] . '</p>';
            echo '<p><strong>TROQUEL:</strong> ' . $articulo['troquel'] . '</p>';
            echo '<p><strong>COD. BARRAS:</strong> ' . $articulo['codigo_barras'] . '</p>';
			echo '<p><strong>COD. BARRAS2:</strong> ' . $articulo['codigo_barras2'] . '</p>';
			if ($articulo['codigo_barras3']!="")
            echo '<p><strong>COD. BARRAS3:</strong> ' . $articulo['codigo_barras3'] . '</p>';
            ?>
        </div>
		<div style="margin-left: 15px;">
		<?php
			echo '<p><strong>CATEGORÍA:</strong> ' . strtoupper($articulo['categoria']['nombre']) . '</p>';
			if ($articulo['subcategoria']!=null)
				echo '<p><strong>SUBCATEGORÍA:</strong> ' . strtoupper($articulo['subcategoria']['nombre']) . '</p>';
				if ($articulo['marca_id']!=0)
				echo '<p><strong>MARCA:</strong> '.$marcas[$articulo['marca_id']].'</p>';
				if ($articulo['grupo_id']!=0)
				echo '<p><strong>GRUPO:</strong> '.$grupos[$articulo['grupo_id']].'</p>';
				if ($articulo['subgrupo_id']!=0)
				echo '<p><strong>SUBGRUPO:</strong> '.$subgrupo[$$articulo['subgrupo_id']].'</p>';
			echo '<p><strong>LABORATORIO:</strong> ' . $articulo['laboratorio']['codigo'].' - '.$articulo['laboratorio']['nombre'] . '</p>';
			echo '<p><strong>PROVEEDOR:</strong> ' . $articulo['proveedor']['codigo'].' - '.$articulo['proveedor']['razon_social']. '</p>';
		?>
		</div>
		<div style="margin-left: 15px;">
		<?php
            // Mostrar detalles del producto
			if ($articulo['iva']) $iva = "SI"; else $iva = "NO";
            echo '<p><strong>IVA:</strong> ' . $iva. '</p>';
			if ($articulo['cadena_frio']) $frio = "SI"; else $frio = "NO";
            echo '<p><strong>CADENA DE FRIO:</strong> ' . $frio . '</p>';
            if ($articulo->fecha_alta!=null) 
			echo '<p><strong>FECHA ALTA:</strong> ' . date_format($articulo->fecha_alta ,'d-m-Y') . '</p>';

			if ($articulo['trazable']) $trazable = "SI"; else $trazable = "NO";
			echo '<p><strong>TRAZABLE:</strong> ' . $trazable . '</p>';
            echo '<p><strong>PAQ:</strong> ' . $articulo['paq'].'</p>';
			

            
            ?>
		</div>
		<div style="margin-left: 15px;">
		<?php
            // Mostrar detalles del producto
			 
            echo '<p><strong>STOCK:</strong> ' .$articulo['stock']. '</p>';         
			echo '<p><strong>STOCK FISICO:</strong> ' .$articulo['stock_fisico']. '</p>';   

			if ($articulo->precio_actualizacion!=null) 
			echo '<p><strong>ACTUALIZACION DE PRECIO:</strong> ' . date_format($articulo->precio_actualizacion ,'d-m-Y') . '</p>';


            echo $this->Form->input('id', ['type' => 'hidden', 'value' => $articulo->id]);
            ?>
		</div>		
	</div>	
	</fieldset>
	<fieldset>
	<div style="display: flex; align-items: center;">

		<div>	
		<?php echo $this->Form->input('file',['type' => 'file','label'=>'Imagen Chica']); ?>
		<div>Tamaño de la imagen: 200 x 200px . Tipo: "jpg" </div>
		</div>
			
		<div>
			<?php echo $this->Form->input('file2',['type' => 'file','label'=>'Imagen Grande']); ?>
		<div>Tamaño de la imagen: 1000 x 1000px . Tipo: "jpg" </div>
		</div>
	</div>
	</fieldset>
	<fieldset>
		<div class="ofertainputcheck">
			<label>DESACTIVAR</label>
			<?php echo $this->Form->checkbox('eliminado', ['hiddenField' => true,'value'=>$articulo['eliminado'],'checked'=>$articulo['eliminado']]);?>
		</div>
	</fieldset>
	<fieldset>
	<div style="display: flex; align-items: center;">
	<div>
			<?php
			echo $this->Form->input('fv_cerca', ['label' => 'Vencimiento cerca', 'type' => 'checkbox','checked'=>$articulo['fv_cerca']]);
			
			?>
		</div>
		<div>
			<?php
			if ($articulo->fv_cerca) {
				echo $this->Form->input('fv', ['label' => 'Fecha Vencimiento', 'type' => 'text', 'value' => $articulo->fv, 'disabled' => false]);
			} else {
				echo $this->Form->input('fv', ['label' => 'Fecha Vencimiento', 'type' => 'text', 'value' => $articulo->fv, 'disabled' => true]);
			}

			?>
		</div>
		</div>
	</fieldset>
	<fieldset>
		<div class="ofertainputbotton">
			<?= $this->Form->button(__('GUARDAR')) ?>
		</div>
		<?= $this->Form->end() ?>
	</fieldset>
</article>
<div class="modal fade" id="enlargeImageModal" tabindex="-1" role="dialog" aria-labelledby="enlargeImageModal" aria-hidden="true">
<div class="modal-dialog modal-lg" role="document">
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
</div>
<div class="modal-body">
<img src="" class="enlargeImageModalSource" style="width: 100%;">
</div>
</div>
</div>
</div>
<script>
$('#fv-cerca').on('change', function() {

if (document.getElementById('fv-cerca').checked) {

$('#fv').prop('disabled', false);
} else {
$('#fv').prop('disabled', true);
}
});

$(function() {
$('.imgFoto').on('click', function() {
var str = $(this).attr('src');
var res = str.replace("productos/", "productos/big_");
var a = new XMLHttpRequest;
a.open("GET", res, false);
a.send(null);
if (a.status === 404){
var res = $(this).attr('src');
//var res = res.replace("foto.png", "productos/"+$(this).data("id"));
}			
//var res =  $(this).attr('src');
$('.enlargeImageModalSource').attr('src',res);
$('#enlargeImageModal').modal('show');
});
});
</script>
<?php
//echo $this->Html->css('bootstrap.min');
echo $this->Html->script('bootstrap'); 
?>
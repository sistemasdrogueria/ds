
<style>
.header_icon{
float: right;	
margin-right: 10px;
margin-top: 5px;
}
.header_icon_delete{
float: left;
margin-top: 5px;
margin-left: 5px;
margin-right: 5px;
}
.header_icon_return{ 
float: left;
}
#busqueda_sect{
width: 400px;
}
</style>

<article class="module width_3_quarter">
		<header><h3 class="tabs_involved"><?= $titulo ?></h3>
	
        <div class = header_icon> 
<div class="header_icon_delete">
<?php 
echo $this->Form->postLink(
$this->Html->image('admin/icn_trash.png',
["alt" => __('Delete'), "title" => __('Delete')]), 
['action' => 'delete_admin', $oferta->id], 
['escape' => false, 'confirm' => __('Esta seguro de eliminar a # {0}?', $oferta->id)]
);
?>
</div>
<div class="header_icon_return">
<?php echo $this->Html->image('admin/icn_volver.png', ['url' => $previous]);?>	</div>
</div>

	</header>
		<div class="tab_container">


        <fieldset>
	<h2 style="text-align:center; ">Ficha Técnica</h2>

    <?php if ($oferta->articulo!=null)
    $articulo = $oferta->articulo; ?>

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


<div class="ofertas view large-10 medium-9 columns">
    
    <div class="row">
        <div class="large-5 columns strings">
            <h1 class="subheader"><?= __('Articulo') ?></h1>
            
            <h1 class="subheader"><?= __('Imagen') ?></h1>
            <p><?= h($oferta->imagen) ?></p>
        </div>
        <div class="large-2 columns numbers end">

            <h1 class="subheader"><?= __('Descuento Producto') ?></h1>
            <p><?= $this->Number->format($oferta->descuento_producto) ?></p>
            <h1 class="subheader"><?= __('Unidades Minimas') ?></h1>
            <p><?= $this->Number->format($oferta->unidades_minimas) ?></p>
            <h1 class="subheader"><?= __('Oferta Tipo Id') ?></h1>
            <p><?= $this->Number->format($oferta->oferta_tipo_id) ?></p>
            <h1 class="subheader"><?= __('Unidades Maximas') ?></h1>
            <p><?= $this->Number->format($oferta->unidades_maximas) ?></p>
            <h1 class="subheader"><?= __('Activo') ?></h1>
            <p><?= $this->Number->format($oferta->activo) ?></p>
            <h1 class="subheader"><?= __('Habilitada') ?></h1>
            <p><?= $this->Number->format($oferta->habilitada) ?></p>
        </div>
        <div class="large-2 columns dates end">
            <h1 class="subheader"><?= __('Fecha Desde') ?></h1>
            <p><?= h($oferta->fecha_desde) ?></p>
            <h1 class="subheader"><?= __('Fecha Hasta') ?></h1>
            <p><?= h($oferta->fecha_hasta) ?></p>
        </div>
    </div>
    <div class="row texts">
        <div class="columns large-9">
            <h1 class="subheader"><?= __('Descripcion') ?></h1>
            <?= $this->Text->autoParagraph(h($oferta->descripcion)) ?>
        </div>
    </div>
    <div class="row texts">
        <div class="columns large-9">
            <h1 class="subheader"><?= __('Plazos') ?></h1>
            <?= $this->Text->autoParagraph(h($oferta->plazos)) ?>
        </div>
    </div>
</div>
</div><!-- end of .tab_container -->
</article><!-- end of content manager article -->
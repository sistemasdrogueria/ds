<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\TransfersProveedor $transfersProveedor
 */
?>
<!-- div class="transfersProveedors form large-9 medium-8 columns content">
    <?= $this->Form->create($transfersProveedor) ?>
    <fieldset>
        <legend><?= __('Add Transfers Proveedor') ?></legend -->
        <?php
            /*
            echo $this->Form->control('numero_pedido_proveedor');
            echo $this->Form->control('status');
            echo $this->Form->control('fecha_factura', ['empty' => true]);
            echo $this->Form->control('drogueria');
            echo $this->Form->control('lab');
            echo $this->Form->control('numero_pedido');
            echo $this->Form->control('fecha_transfer', ['empty' => true]);
            echo $this->Form->control('cliente');
            echo $this->Form->control('nombre');
            echo $this->Form->control('ean');
            echo $this->Form->control('descripcion');
            echo $this->Form->control('unidades');
            echo $this->Form->control('descuento');
            echo $this->Form->control('contacto');
            echo $this->Form->control('telefono');
            echo $this->Form->control('cuit');
            echo $this->Form->control('domicilio');
            echo $this->Form->control('codigo_postal');
            echo $this->Form->control('localidad');
            echo $this->Form->control('provincia');
            echo $this->Form->control('creado', ['empty' => true]);
            echo $this->Form->control('proveedor_id', ['options' => $proveedors, 'empty' => true]);
            */
            
        ?>
    <!-- /fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div -->


<article class="module width_4_quarter">
<header><h3 class="tabs_involved"><?= $titulo ?></h3></header>
<div class="tab_container">

<div class="search-form">
    <?= $this->Form->create('TransfersProveedors',['type' => 'file','url'=>['controller'=>'TransfersProveedors','action'=>'importresultexcel'],'id'=>'searchform4']); ?>
				
	<?php
			
			echo $this->Form->input('filetext', ['id'=>'uploadBtn','type' => 'file','class'=>'upload','label'=>'Buscar Archivo','name'=>'filetext']);
			echo '<br>';
			echo $this->Form->input('nsheet', ['label'=>'Nombre Hoja']);
			echo $this->Form->input('fini', ['label'=>'Fila inicio']);
			echo $this->Form->input('fend', ['label'=>'Fila ultima']);
			
			echo $this->Form->input('cini', ['label'=>'Columna Inicio']);
			echo $this->Form->input('cend', ['label'=>'Columna Ultima']);
			//echo $this->Form->input('cdesc', ['label'=>'Columna Descripcion']);


			echo $this->Form->submit('Procesar',['class'=>'mainBtn']);
			echo $this->Form->end() 
	?>
</div> <!-- /.search-form -->
</div><!-- end of .tab_container -->
</article><!-- end of content manager article -->	


<script>
	document.getElementById("uploadBtn").onchange = function () {
		document.getElementById("uploadFile").value = this.value;
	};
</script>

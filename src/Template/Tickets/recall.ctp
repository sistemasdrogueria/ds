<style>
	.recall{background: #eaeaea; height: 100vh; }
	.recall_descarga{ background: #fff; float: left;  border-radius: 5px;border: 1px solid #ddd; margin: 10px; padding: 15px;}
	.recall_old { background: #fff;   border-radius: 5px;border: 1px solid #ddd; margin: 5px; padding: 15px;}
	.recall_descarga_titulo{ font-weight: bold; float: left}
	.recall_descarga_fecha{float: right; }
	.recall_descarga_items{width: 100%; float: left;}
	.recall_descarga_item{width: 100%; float: left; margin-top: 5px;} 
	.recall_descarga_item_titulo{float: left}
	.recall_descarga_item_link{ float: right;}
	.recall_titulo_principal{ font-size: 18px; font-weight: bold; text-align: center; margin-bottom: 15px; padding-top: 15px;}
	.recall_nota{ background: #eaeaea;   border-radius: 5px;border: 1px solid #eaeaea; margin: 5px; padding: 15px; margin-bottom:25px;}
	.recall_nota_detalle { width: 100%; margin-top: 10px;}
	.recall_nota_titulo{ font-weight: bold; width: 100%;  text-align: center; font-size: 16px; margin-bottom: 20px;}
	.recall_nota_fecha{ }
</style>

<div class="col-md-4">
<div class="product-item-8"> 
<div class="product-content">
<div class="recall">
<div class=recall_titulo_principal>RECALL</div>

<?php foreach ($recalls as $recall): ?>
<div class=recall_descarga >
	<div class=recall_descarga_titulo><?php echo $recall['titulo'];?>
</div>
	<div class =recall_descarga_fecha><?php echo date_format($recall['fecha'],'d-m-Y'); ?></div>
	<div class=recall_descarga_items>
	<?php foreach ($recall['recalls_files'] as $recall_item): ?>	
		<div class=recall_descarga_item>
			
			<div class=recall_descarga_item_titulo>
				<?php echo $recall_item['name'];?>			
			</div>
			<div class=recall_descarga_item_link>
				<?php	echo $this->Html->image('pdf.png',['title' => 'Descargar pdf','url'=>['controller' => 'Descargas','action' => 'descargar',$recall_item['file'],$recall_item['tipo']]]);?>
			</div>
		</div>
		<?php endforeach; ?>
	</div>
</div>
<?php endforeach; ?>

</div>
</div> 
</div>   
</div> 

<div class="col-md-8">
<div class="product-item-3">
<div class="product-content">
<?php foreach ($recalls as $recall): ?>
<div class=recall_nota >
	<div class=recall_nota_titulo><?php echo $recall['titulo'];?> </div>
	<div class=recall_nota_fecha><?php echo 'FECHA: '.  date_format($recall['fecha'],'d-m-Y'); ?></div>
	<div class=recall_nota_detalle> <?php echo nl2br($recall['detalle']);?></div>
</div>
<?php endforeach; ?>
</div> 
</div> 
</div> 
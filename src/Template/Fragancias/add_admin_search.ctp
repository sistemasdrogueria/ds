<article class="module width_3_quarter">
<header><h3 class="tabs_involved"><?= $titulo ?></h3>
	<div class="tabs_bt_nuevo">

<?= $this->Html->image("admin/icn-nuevo.png", ["alt" => "Nuevo",'url' => ['controller' => 'Fragancias', 'action' => 'add_admin']]);?>
</div></header>


	<div class="ofertas form large-10 medium-9 columns">
		
		
		<table class="tablesorter"> 
		<thead> 
        <tr>
            <th>Descripción</th>
			<th>Marca</th>
            <th>Genero</th>
			<th></th>
        </tr>
    </thead>
    <tbody>
        <tr>
			<td>
			
				<?php echo $fragancia['nombre'];?>
			</td>
			<td>
		<?php 
		$marca=$marcas->toArray();
		echo $marca[$fragancia['marca_id']];?>
			</td>
			<td>
		<?php 
		$genero=$generos->toArray();
		echo $genero[$fragancia['genero_id']];?>
			</td>
			<td>
		
			</td>
		</tr>
	 </tbody>	
</table>

	</div>
		<div class="ofertas form large-10 medium-9 columns">
		<?php if ($fraganciaspresentaciones!=null)
				echo $this->element('searchresultfraganciapresentacion'); 
		?>
	</div>
	<div class="ofertas form large-10 medium-9 columns">
		<?php echo $this->element('searchfraganciaproducto'); ?>
	</div>
	<div class="ofertas form large-10 medium-9 columns">
		<?php if ($articulos!=null)
				echo $this->element('searchresultfraganciaproductoadd'); 
		?>
	
	</div>

 </article> 
 
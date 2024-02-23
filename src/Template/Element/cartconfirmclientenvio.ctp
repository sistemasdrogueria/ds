<div class="cliente_info_envio">
	
<span class='cliente_info_span'>
	
Datos de Envio
<?php echo $this->Html->image('ubicacion.png', ['alt' => 'ubicacion','style="margin: 0px 0px 0px 20px;"']);?> 

</span>
		<?php $dom = $cliente->domicilio.' - ' ?>
		<?php $dom2 = $cliente->has('localidad') ? h($cliente->localidad->nombre) : '' ?>
		<?php 
			$opciones = array();
			array_push( $opciones , ['value' => 0, 'text' => $dom.$dom2, 'checked'=>'true']);
			foreach ($sucursales as $sucursal): 
             $indice = $sucursal->numero ;
			 $dom = $sucursal->domicilio.' - ' ;
			 $dom2 = $sucursal->has('localidad') ? h($sucursal->localidad->nombre) : '' ;
			array_push( $opciones , ['value' => $indice, 'text' => $dom.$dom2]);
			endforeach;
			if ($cliente->codigo_postal == 8000)
			array_push( $opciones , ['value' => 99, 'text' => 'Retira Cadete']);
			echo $this->Form->radio(
				'enviodomicilio', $opciones,
				['id'=>'radioenvio']
			);
			echo $this->Form->input('observaciones',['type'=>'textarea','onkeypress'=>'return pulsar(event)']);
			echo $this->Form->input('compra', ['value'=>$totalcarrito,'type'=>'hidden',]);
		?>	
</div>
<script>
function pulsar(e) {
  tecla = (document.all) ? e.keyCode :e.which;
  return (tecla!=13);
}
</script>
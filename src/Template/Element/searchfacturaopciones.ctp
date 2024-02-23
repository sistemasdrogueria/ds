<div class="col-md-12 col-sm-12">
				<div  class="listadofc">
					<div class="listadofcspan">
						<span>IMPOSITIVO.</span>
					</div>
					<div class="listadofclink">
						
						<?=
						$this->Html->image("excel.png", array(
						"alt" => "Excel",
						'url' => ['controller' => 'Facturas', 'action' => 'excel']
						));?>
				
					</div> 
				</div>		
				<div  class="listadofc">
					<div class="listadofcspan">
						<span>CON DCTO.</span>
					</div>
					<div class="listadofclink">
						
						<?=
						$this->Html->image("excel.png", array(
						"alt" => "Excel",
						'url' => ['controller' => 'Facturas', 'action' => 'excelpm']
						));?>
				
					</div> 
				</div>	

				<div  class="listadofc">
					<div class="listadofcspan">
						<span>CON Y SIN DCTO.</span>
					</div>
					<div class="listadofclink">
						
						<?=
						$this->Html->image("excel.png", array(
						"alt" => "Excel",
						'url' => ['controller' => 'Facturas', 'action' => 'excelcompleto']
						));?>
				
					</div> 
				</div>
				
				<div  class="listadofc">
					<div class="listadofcspan">
						<span>DETALLADA.</span>
					</div>
					<div class="listadofclink">
						
						<?=
						$this->Html->image("excel.png", array(
						"alt" => "Excel",
						'url' => ['controller' => 'Facturas', 'action' => 'exceldetalle']
						));?>
						<?=
						$this->Html->image("txt.png", array(
						"alt" => "Excel",
						'url' => ['controller' => 'Facturas', 'action' => 'exportar']
						));?>
				
					</div> 
				</div>
				
			
				<div>
				</br>
					<p>NOTA: </br>
					<a href="/ds/webroot/file/Formato_factura_detalle.pdf"><b>Formato del archivo de descarga.</b></a>
					</P>
				</div>
</div> <!-- /.col-md-12 -->
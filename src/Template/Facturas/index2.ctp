<div class="col-md-3">
    <div class="product-item-3"> 
		<!--div class="product-content">
			<div class="row">
				
				<div class="col-md-12 col-sm-12">
				<span class='cliente_info_span'>Facturas</span>
					<?php //echo $this->element('searchfactura'); ?>
					
				</div> 
			</div> 
		</div>
		<div class="product-content">	
			<div class="row">
				
				<div class="col-md-12 col-sm-12">
				<span class='cliente_info_span'>Descargar Detalle de Facturas</span>
					</br>
				</br>	
					<div class="button-holder4">
						<?php //$this->Html->link(__('Descargar'), ['class'=>'red-btn','controller' => 'Facturas', 'action' => 'exportar']) ?>
					</div>
				<div>
				</br>
					<p>NOTA: </br>
					<a href="/ds/webroot/file/Formato_factura_detalle.pdf"><b>Formato del archivo de descarga.</b></a>
					</P>
				</div>
				</div> 
				
			</div> 
		</div -->    
		
	</div>  
</div> 
<!-- col-md-4 -->
<!-- div class="col-md-9">
    <div class="product-item-3">
  		<?php //if ($this->request->session()->read('Auth.User.perfile_id')==1): ?>
		<div class="product-content">
		<div class="row">
		<span class='cliente_info_span'>Listado de Facturas</span>
		<br>
			<?php 
			//echo $this->element('facturasearch');
			?>
		</div>
		</div>
		
		<?php //endif; ?>
    </div> <!-- /.product-item 
</div> <!-- /.col-md-3 -->

<!-- div class="facturasCabeceras index large-10 medium-9 columns">
 

</div -->

<div class="col-md-9">
    <div class="product-item-3"> 
		<div class="product-content3">
		<h3 id="titulo_oferta" align="center"></h3>
			
			<div class="row" align="center">
			  <div id="link_oferta">
			  </div>
			  <div id="cuerpo_oferta">
			  <br>
			<?php // Listados de Facturas echo $this->element('ctasearchresultcompras'); ?>
			<?php echo $this->Html->image('actualizando.png');?>
</br>			<a href="http://old.drogueriasur.com">Visite la pagina anterior para poder visualizar esta sección</a>

			  </div>
			  
			</div>
		</div>
	</div>	
</div>

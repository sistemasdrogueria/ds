<div class="col-md-3">
    <div class="product-item-3"> 
		<div class="product-content3">	
			<h4><?php echo 'Catalogos';?></h4>
			<div class="row">	
				<div class="menu-ofertas">
					<div class="list-menu">			
					<div id='cssmenu'>
					<ul>	
					  <?php $archivoptm= 'http://200.117.237.178/ds/webroot/descargas/'. $consolidadoptm['name']; 
							$tituloptm = ''.$consolidadoptm['descripcion'];
							?>
					  <?php $archivoder= 'http://200.117.237.178/ds/webroot/descargas/'. $consolidadodermo['name'];
							$tituloder = ''.$consolidadodermo['descripcion'];
							?>
					   <li  onclick="javascript:cambia_contenido(1,'<?php echo $archivoptm;?>','<?php echo $tituloptm;?>');" ><a href='#'><span> <?php echo $tituloptm;?></span></a></li>  
					   <li  onclick="javascript:cambia_contenido(2,'<?php echo $archivoder;?>','<?php echo $tituloder;?>');" ><a href='#'><span> <?php echo $tituloder;?></span></a></li>  
					</ul>
					</div>

					</div>	
				</div>
			</div>	
		</div>		

	</div>		
</div>	
<div class="col-md-9">
    <div class="product-item-3"> 
		<div class="product-content3">
		<h3 id="titulo_oferta" align="center"></h3>
			
			<div class="row" align="center">
			  <div id="cuerpo_oferta">
					<?php //echo $this->Html->image('logo-patagonia-med.png',['title' => 'Vale Oficial']);  ?>
			  </div>
			   <div id="link_oferta">
			  
			  </div>
			</div>
		</div>
	</div>	
</div>
<script>
				function cambia_contenido(opcion,archivo,titulo){
					var cuerpo = "<iframe src='http://docs.google.com/gview?url="+ archivo.toString()+ "&embedded=true' style='width:600px; height:700px;' frameborder='0'></iframe>";
					var link = "<a href='"+archivo.toString()+"'>Descargar Archivos Aqui</a>";
				
				switch(opcion) {
					case 1:
						
						$("#cuerpo_oferta").html(cuerpo);
						$("#titulo_oferta").html(titulo);
						$("#link_oferta").html(link);
						
						break;
					case 2:
						$("#cuerpo_oferta").html(cuerpo);
						$("#titulo_oferta").html(titulo);
						$("#link_oferta").html(link);
					
						break;

					}
				}
</script>
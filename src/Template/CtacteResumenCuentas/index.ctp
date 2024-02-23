<div class="col-md-3">
    <div class="product-item-3"> 
		<div class="product-content3">	
			<h4><?php echo 'Resumen Cuentas a Pagar';?></h4>
			<script>
			function getSelectedText(elementId) {
				var elt = document.getElementById(elementId);

				if (elt.selectedIndex == -1)
					return null;

				return elt.options[elt.selectedIndex].text;
			}
			//document.getElementById("selectsemana").onchange = function() {myFunction()};
			function repeat(str, i) {
				   if (isNaN(i) || i <= 0) return "";
				   return str + repeat(str, i-1);
				}
			function pad(x) {
				   var zeros = repeat("0", 8);
				   return String(zeros + x).slice(-1 * 8);
				}		
				function pad2(x) {
				   var zeros = repeat("0", 6);
				   return String(zeros + x).slice(-1 * 6);
				}
				function selectsemana() {
				var x = document.getElementById("selectsemananro").value;
				var xy = document.getElementById("selectsemananro").name;
				var xyz = document.getElementById("selectcuenta").value;
				var location = window.location.href;
				var nombre = "RCTA"+pad2(xyz)+pad(x)+".pdf";
						$.ajax({
							data: {

								"nombre": nombre,

							},
							url: '<?php echo \Cake\Routing\Router::url(array('controller' => 'Ctacte_pagos', 'action' => 'validararchivos')); ?>',
							type: "post",
							success: function(data) {
									if (data ==1) {
							$("#cuerpo_pdf").html('<iframe src="https://docs.google.com/gview?url=https://drogueriasur.com.ar/ds/webroot/temp/Comprobantes/'+ nombre + '&embedded=true" style="width:90%; height:400px;" frameborder="0"></iframe>');
							var text = getSelectedText('selectsemananro');
							$("#titulo_oferta").html(text);
							$("#link_descarga_pdf").html('<a href="' + location + '/downloadfile/' + x + '/' + xyz + '"><img src="/ds3/img/pdf.png" title="Descargar PDF" alt="PDF"></a>');
							$("#link_descarga_label").html("Descargar");

									}else{
														$("#cuerpo_pdf").html('<iframe src="" frameborder="0"></iframe>');
							var text = getSelectedText('selectsemananro');
							$("#titulo_oferta").html(text);
							//$("#link_descarga_pdf").html('<a href="' + location + '/downloadfile/' + x + '/' + xyz + '"><img src="/ds3/img/pdf.png" title="Descargar PDF" alt="PDF"></a>');
							$("#link_descarga_label").html("Archivo no disponible. Proximamente podrás descargarlo.");


									}


							}

						});
				
				
			
				}
			</script>
			<div class="row">	
				<table>
				<tr>
					<td>Seleccione cuenta:</td>
				</tr>
				<tr>
					<td>
						<div id="selectsemanaresumen">
						<?php
						//,'label'=>'Selecione la semana'
							echo $this->Form->input('cuenta',['id'=>'selectcuenta','options'=> $clientes]);
							
						?>
						</div>
					
					</td>
				</tr>
				<tr>
					<td>Seleccione la semana:</td>
				</tr>
				<tr>
					<td>
						<div id="selectsemanaresumen">
						<?php
						//,'label'=>'Selecione la semana'
													
							echo $this->Form->input('nro_sistema', ['id'=>'selectsemananro','options' => $ctacteResumenCuentas, 'onchange'=>'selectsemana(this);']);
						?>
						</div>
					
					</td>
				</tr>
				<tr>
					<td>
					<p>
					Nota: para poder visualizar correctamente el resumen de deuda deberá tener instalado un lector de archivo pdf.
					</p>
					</td>
				</tr>
				<tr>
					<td>
					<p>	
					Si no cuenta con dicho lector, puede elegir entre los siguientes para descargar: </p>
					</td>
				</tr>
				<tr>
					<td>
					
					</td>
				</tr>
				<tr>
					<td>
					Nitro Reader
					<?php echo $this->Html->image('nitroreader.png', ['alt' => 'Nitro PDF READER','url'=>'https://www.gonitro.com/es/pdf-reader']);?>
					
					</td>
				</tr>
				<tr>
					<td>
					Acrobat Reader
					<?php echo $this->Html->image('acrobatreader.png', ['alt' => 'Acrobat PDF READER','url'=>'https://get.adobe.com/es/reader/']);?>
					
					</td>
				</tr>
				<tr>
					<td>
					Foxit Reader
					<?php echo $this->Html->image('foxitreader.png', ['alt' => 'Acrobat PDF READER','url'=>'https://www.foxitsoftware.com/spanish/downloads/']);?>
					
					</td>
				</tr>
			
				</table>
			</div>	
		</div>		

	</div>		
</div>	
<div class="col-md-9">
<?php echo $this->element('metodos_de_pago'); ?>
    <div class="product-item-3"> 
		<div class="product-content3">
		<h3 id="titulo_oferta" align="center"></h3>
			
			<div class="row" align="center">
			<div class="row" align="center" style="display:inline-block; text-align:center">
			  <div id="link_descarga_label" style="float: left; margin:10px;"> </div>
			  <div id="link_descarga_pdf"  style="float: left; margin:10px;">  </div>
			 
			</div>
			<div id="cuerpo_pdf"></div>
			</div>
		</div>
	</div>	
</div>
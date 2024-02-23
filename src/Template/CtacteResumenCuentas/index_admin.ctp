<?php //><script type="text/javascript">
$previous = "javascript:history.go(-1)";
if(isset($_SERVER['HTTP_REFERER'])) {
    $previous = $_SERVER['HTTP_REFERER'];
}
?>
<script>
			function getSelectedText(elementId) {
				var elt = document.getElementById(elementId);

				if (elt.selectedIndex == -1)
					return null;

				return elt.options[elt.selectedIndex].text;
			}

			function existeUrl(url) {
			   var http = new XMLHttpRequest();
			   http.open('HEAD', url, false);
			   http.send();
			   return http.status!=404;
			}
			//document.getElementById("selectsemana").onchange = function() {myFunction()};
			function repeat(str, i) {
				   if (isNaN(i) || i <= 0) return "";
				   return str + repeat(str, i-1);
				}
			function pad(x,z) {
				   var zeros = repeat("0", z);
				   return String(zeros + x).slice(-1 * z);
				}
				function selectsemana() {
				var x = document.getElementById("selectsemananro").value;
				var xy = document.getElementById("cliente_id").value;
				
				var nombre = "RESU"+pad(xy,6)+pad(x,8)+".pdf";
						$("#cuerpo_oferta").html('<iframe src="http://docs.google.com/gview?url=http://200.117.237.178/ds/webroot/temp/Comprobantes/'+nombre+'&embedded=true" style="width:90%; height:500px;" frameborder="0"></iframe>');
						var text = getSelectedText('selectsemananro');
						$("#titulo_oferta").html(text);
						var url = 'http://www.drogueriasur.com.ar/ds/webroot/temp/Comprobantes/'+nombre;
						if (existeUrl(url))
						{
							$("#link_oferta").html('<a href="'+url+'">Descargar Archivos Aqui</a>');	
						}
						
				}
</script>
<article class="module width_3_quarter">
	<header><h3 class="tabs_involved"><?= $titulo ?></h3>
		<div class="volveratras">
		<a href="<?= $previous ?>">Volver atras</a>
		</div>
	</header>
	<div> 
	<?= $this->Form->create('CtacteResumenSemanales',['url'=>['controller'=>'CtacteResumenSemanales','action'=>'view_admin'],'id'=>'searchform4']); ?>
		<div class="input_date_search">
			<div class="input_date_input_search">
				<?php echo $this->Form->select('cliente_id', $clientes,['id'=>'cliente_id']);	?>			 
			</div>
		</div>
		<div class="input_date_search">
			<div class="input_date_input_search">
				<?php  echo $this->Form->input('nro_sistema', ['id'=>'selectsemananro','label'=>'','options' => $ctacteResumenSemanales, 'onchange'=>'selectsemana(this);']);?>		
			</div>
		</div>
		<div>
			<?= $this->Form->submit('Buscar',['class'=>'submit_link','id'=>'button_search']); ?>
		</div>
		
	<?= $this->Form->end() ?>
	</div>
	<div id="titulo_resumen"><h4 id="titulo_oferta" align="center"></h4></div>	
	<div id="link_oferta" align="center"></div>
	<div id="cuerpo_oferta" align="center"></div>
	<div><br><br></div>
	
</article><!-- end of content manager article -->
<?php //><script type="text/javascript">
$previous = "javascript:history.go(-1)";
if(isset($_SERVER['HTTP_REFERER'])) {
    $previous = $_SERVER['HTTP_REFERER'];
}
?>



<article class="module width_4_quarter">
		<header><h3 class="tabs_involved"><?= $titulo ?>
	</h3>
		<div class="volveratras">
		<a href="<?= $previous ?>"><?php echo $this->Html->image('icn_volver.png');?></a>
	
		</div>
		</header>
		<div> 
		<?php 
			switch ($comprobante['comprobante_tipo_id']) {
				
				case 1:
					$nombreArchivo= 'FACT01';
					break;
				case 2:
					$nombreArchivo= 'COMP02';
					break;
				case 3:
					$nombreArchivo= 'COMP03';
					break;
				case 4:
					$nombreArchivo= 'COMP04';
					break;
				case 5:
					$nombreArchivo= 'FACT01';
					break;
			}
			$fecha = date_format($comprobante['fecha'], 'Ymd');
			$nota = str_pad($comprobante['nota'], 6, '0', STR_PAD_LEFT);
			if ($fecha>20170423)
				$nota = $nota.$fecha;
				
				
			
				$nombre_fichero = 'temp'. DS .'Comprobantes'. DS .$nombreArchivo.$nota.'.pdf';
				if (file_exists($nombre_fichero)) {
					echo '<div class=div_comprobante_pdf><iframe src="https://docs.google.com/gview?url=https://www.drogueriasur.com.ar/ds/webroot/'.$nombre_fichero.'&embedded=true" style="width:95%; min-height:550px;" frameborder="0"></iframe></div>';
				} else {
					// El archivo no existe en el directorio webroot
				}

			
			?>
		</div> 
</article><!-- end of content manager article -->


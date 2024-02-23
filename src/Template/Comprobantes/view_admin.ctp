<?php //><script type="text/javascript">
$previous = "javascript:history.go(-1)";
if(isset($_SERVER['HTTP_REFERER'])) {
    $previous = $_SERVER['HTTP_REFERER'];
}
?>



<article class="module width_3_quarter">
		<header><h3 class="tabs_involved"><?= $titulo ?></h3>
		<div class="volveratras">
		<a href="<?= $previous ?>">Volver atras</a>
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
			
			$nota = str_pad($comprobante['nota'], 6, '0', STR_PAD_LEFT);
			if ($fecha>20170423)
				$nota = $nota.$fecha;
			
			$nombre_fichero = 'temp'. DS .'Comprobantes'. DS .$nombreArchivo.$nota.'.pdf';
		    echo '<iframe src="http://docs.google.com/gview?url=http://200.117.237.178/ds/webroot/'.$nombre_fichero.'&embedded=true" style="width:95%; min-height:550px;" frameborder="0"></iframe>';

			
			?>
		</div> 
</article><!-- end of content manager article -->


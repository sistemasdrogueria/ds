<div class=" index large-10 medium-9 columns">
	<table class='tablasearch' cellpadding="0" cellspacing="0">
	     <tr>	
			<th>Cant. actual</th>
			<th>C. Barras</th>
            <th>Descripción</th>
			<th>Cant. Anterior</th>
        </tr>
	<tbody>
      <?php 
	  if(isset($_SESSION['destarray'])){
		if(!empty($_SESSION['destarray'])){
	  foreach ($_SESSION['destarray'] as  $art) {
			if(isset($art['articulo'])){
			if($art['articulo']['cantidad'] < $art['articulo']['cantback']){
		echo '
		    <tr>
		  <td>'.$art['articulo']['cantidad'].'</td>
			<td>'.$art['articulo']['codigo_barras'].'</td>
            <td>'.$art['articulo']['descripcion'].'</td>
			<td>'.$art['articulo']['cantback'].'</td>
			</tr>';
	}
			}
	  }
	  }
	  }
	  ?>

	</tbody>
	</table>
	
</div>
    <script type="text/javascript">
	$("tr").not(':first').hover(
	function () {
		$(this).css("background","#8FA800");
		$(this).css("color","#000");
		$(this).css("font-weight","");
		}, 
	function () {
		$(this).css("background","");
		$(this).css("color","#464646");
		$(this).css("font-weight","");
		}
	);
	</script>
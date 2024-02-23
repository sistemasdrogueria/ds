<div class=" index large-10 medium-9 columns">
	<table class='tablasearch' cellpadding="0" cellspacing="0">
	<tr>	
			<th>Cant.</th>
			<th>C. Barras</th>
            <th>Descripción</th>
			<th>Linea Completa</th>
        </tr>
	<?php 
		$error = $this->request->session()->read('errorimport');	
		echo $error;
		?>
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
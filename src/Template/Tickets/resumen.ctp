<div class="col-md-4">
<div class="product-item-3"> 
<div class="product-content">
<div class="row">
<div class="col-md-12 col-sm-12">
<div class="cliente_info">
<span class='cliente_info_span'>
<?php
if ($reclamo['tipo']==0)
	echo 'Vista de la Devolución';	
	else
	echo 'Vista del Reclamo';		
?>
</span>
</br>
<table cellpadding="0" cellspacing="0">
<tr> 
<td><?php
if ($reclamo['tipo']==0)
	echo 'Devolución Número';	
	else
	echo 'Reclamo Número';		
?>
</td>
<td>    
<?= $this->Number->format($reclamo->id) ?>
</td>
</tr>	
<tr>
<td>
<?= __('Factura Número') ?>
</td>
<td>
<?php echo str_pad($reclamo['factura_seccion'], 4, '0', STR_PAD_LEFT).'-'.str_pad($reclamo['factura_numero'], 8, '0', STR_PAD_LEFT); ?>
</td>
</tr>
<tr>
<td>
<?= __('Factura Fecha') ?>
</td>
<td>
<?php echo date_format($reclamo['fecha_recepcion'],'d-m-Y'); ?>
</td>
</tr>
<tr>
<td>
<?= __('Motivo') ?>
</td>
<td>
<?= $reclamo->has('reclamos_tipo') ? h($reclamo->reclamos_tipo->nombre) : '' ?>
</td>
</tr>
<tr>	
<td>	
<?= __('Estado') ?>
</td>
<td>
<?= $reclamo->has('reclamos_estado') ? h($reclamo->reclamos_estado->nombre) : '' ?>
</td>
</tr>
<tr>	
<td>	
<?= __('Creado el ') ?>
</td>
<td>
<?php echo date_format($reclamo['creado'],'d-m-Y'); ?>
</td>
</tr>
</table>   
</br>				
</div>
</div>
</div> <!-- /.row -->
</div> <!-- /.product-content -->
</div> <!--.product-item-1 -->  
<?php 
if ($reclamo['tipo']==0)
	echo 'Descargar comprobante Obligatorio de Devolución ';	
	else
	echo 'Descargar comprobante Obligatorio de Reclamo ';		


	echo $this->Html->image("pdf.png", [
    "alt" => "pdf",
    'url' => ['controller' => 'Tickets', 'action' => 'ticketpdf',  $reclamo['id'],'_ext' => 'pdf','_full'=>true]
]);?>
</div> <!-- /.col-md-4 -->
<div class="col-md-8">
<div class="product-item-3">

<div class="product-content">

<span class='cliente_info_span'>Producto/s </span>		
</br>		
<?php 
if ($reclamositemstemps!=null )
{ echo $this->element('ticket_search_item_temp_result');}		
?>
</br>
</div> <!-- /.product-content -->
</div> <!-- /.product-item -->
</div> <!-- /.col-md-3 -->

<style>
body {font-family: Arial, Helvetica, sans-serif;}

/* The Modal (background) */
.modal {
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 1; /* Sit on top */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgb(0,0,0); /* Fallback color */
    background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
    -webkit-animation-name: fadeIn; /* Fade in the background */
    -webkit-animation-duration: 0.4s;
    animation-name: fadeIn;
    animation-duration: 0.4s
}

/* Modal Content */
.modal-content {
    position: fixed;
	font: 15px/21px "Open Sans", Arial, sans-serif;
    bottom: 0;
    background-color: #fefefe;
    width: 100%;
    -webkit-animation-name: slideIn;
    -webkit-animation-duration: 0.4s;
    animation-name: slideIn;
    animation-duration: 0.4s
}

/* The Close Button */
.close {
    color: white;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: #000;
    text-decoration: none;
    cursor: pointer;
}

.modal-header {
    padding: 2px 16px;
    background-color: #5cb85c;
    color: white;
}

.modal-body {padding: 2px 16px;}

.modal-footer {
    padding: 2px 16px;
    background-color: #5cb85c;
    color: white;
	text-align: center; 
}

/* Add Animation */
@-webkit-keyframes slideIn {
    from {bottom: -300px; opacity: 0} 
    to {bottom: 0; opacity: 1}
}

@keyframes slideIn {
    from {bottom: -300px; opacity: 0}
    to {bottom: 0; opacity: 1}
}

@-webkit-keyframes fadeIn {
    from {opacity: 0} 
    to {opacity: 1}
}

@keyframes fadeIn {
    from {opacity: 0} 
    to {opacity: 1}
}
</style>

<!-- The Modal -->
<div id="myModal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <div class="modal-header">
      <span class="close">&times;</span>
      <h2>IMPORTANTE</h2>
    </div>
    <div class="modal-body">
      <p>Estimado cliente: <br>
	  
				
				<?php 
if ($reclamo['tipo']==0)
	echo '           Recuerde imprimir el comprobante Obligatorio de Devolución y enviarlo con la mercaderia ';	
	else
	echo '           Recuerde adjuntar comprobante Obligatorio de Reclamo y enviarlo por mail a reclamos@drogueriasur.com.ar';	
?><br>
	 <?php echo '           El comprobante es requisito excluyente para dar curso a la operación.'?><br>
	
	<?php 
	
	if ($reclamo['tipo']==0)
	echo' La mercadería a devolver debe coincidir con la informada en el comprobante obligatorio de devolución. Caso contrario, la devolución se anula. ';?><br>
		<br>
		<?php echo 	'           Gracias.' ?><br>
	  <br>
	  
	 
    </div>
    <div class="modal-footer">
      <h4>
	  <?php 
if ($reclamo['tipo']==0)
	echo 'Descargar comprobante Obligatorio de Devolución ';	
	else
	echo 'Descargar comprobante Obligatorio de Reclamo ';		


	echo $this->Html->image("pdf.png", [
    "alt" => "pdf",
    'url' => ['controller' => 'Tickets', 'action' => 'ticketpdf',  $reclamo['id'],'_ext' => 'pdf','_full'=>true]
]);?>
</h4>
    </div>
  </div>

</div>

<script>
// Get the modal
var modal = document.getElementById('myModal');

// Get the button that opens the modal
var btn = document.getElementById("myBtn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

modal.style.display = "block";


// When the user clicks on <span> (x), close the modal
span.onclick = function() {
    modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
</script>

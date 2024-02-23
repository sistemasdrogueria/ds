  <style>
    body { font-size: 120%;height: 150px; }

    .ui-dialog .ui-state-error { padding: .3em; }
    #ui-dialog-content ui-widget-content { min-height: 300px;}
 
  </style>
  <script>
$(function() {
 


 
   var dialog = $( "#dialog-form" ).dialog({
      open: function(event, ui) { $(".ui-dialog-titlebar", ui.dialog).hide(); } ,
      height:400,
	  width:500,
	  position: { my: "center center+10%", at: "center", of: window, collision: "none"},
	  modal: true,
       buttons: {
		 
		 'Continuar': function() {
		  //var valid = editar();
		 
			document.getElementById("editaremail").submit();
			$( this ).dialog( "close" );
		  
        }
      }
	});
 
 
      form = dialog.find( "form" ).on( "submit", function( event ) {
      event.preventDefault();
  });
  
    });
  </script>


<div class="col-md-5">
    <div class="product-item-3"> 

		<div class="product-content">
		<div class="row">    
    
    
  <div id="dialog-form" title="agregar email">
  <p class="validateTips">IMPORTANTE!</p>
  	<div class="col-md-12 col-sm-12">	
	<div class="cliente_info">
  <?= $this->Form->create('Clientes',['url'=>['controller'=>'Carritos','action'=>'index'],'id'=>'editaremail']); ?>		
  <?php echo '<p style = "height: 150px"> Su GLN no se encuentra vigente según los registros de ANMAT, solicitamos que lo regularice a la brevedad, para que pueda seguir comprando productos trazables.
Por consultas comunicarse a directortecnico@drogueriasur.com.ar </p>'?>
  </div></div>
  
<?= $this->Form->end() ?>
  <?php //echo $this->Html->link('Continuar',['url'=>['controller'=>'Carritos','action'=>'index'],'id'=>'editaremail']); ?>
  </div>
    


		</div> <!-- /.row -->
    </div> <!-- /.product-content -->


	</div> <!--.product-item-1 -->  
</div> <!-- /.col-md-4 -->
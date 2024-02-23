  <style>
    body { font-size: 62.5%; }
    label, input { display:block; }
    input.text { margin-bottom:12px; width:95%; padding: .4em; }
    fieldset { padding:0; border:0; margin-top:25px; }
    h1 { font-size: 1.2em; margin: .6em 0; }
    div#users-contain { width: 350px; margin: 20px 0; }
    div#users-contain table { margin: 1em 0; border-collapse: collapse; width: 100%; }
    div#users-contain table td, div#users-contain table th { border: 1px solid #eee; padding: .6em 10px; text-align: left; }
    .ui-dialog .ui-state-error { padding: .3em; }
    .validateTips { border: 1px solid transparent; padding: 0.3em; }
  </style>
  <script>
  $(function() {
    var dialog, form,
 
      // From http://www.whatwg.org/specs/web-apps/current-work/multipage/states-of-the-type-attribute.html#e-mail-state-%28type=email%29
      emailRegex = /^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-.!#$%&'*+\/=?^_`{|}~-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/,
      

	  email = $( "#email" ),
      email_alternativo = $( "#email-alternativo" ),
      allFields = $( [] ).add( email ).add( email_alternativo ),
      tips = $( ".validateTips" );
 
    function updateTips( t ) {
      tips
        .text( t )
        .addClass( "ui-state-highlight" );
      setTimeout(function() {
        tips.removeClass( "ui-state-highlight", 1500 );
      }, 500 );
    }
 
    function checkLength( o, n, min, max ) {
      if ( o.val().length > max || o.val().length < min ) {
        o.addClass( "ui-state-error" );
        updateTips( "Este campo es obligatorio, Ingrese su correo electronico.");
        return false;
      } else {
        return true;
      }
    }
 
    function checkRegexp( o, regexp, n ) {
		
		
      if ( !( regexp.test( o.val().trim() ) ) ) {
        o.addClass( "ui-state-error" );
        updateTips( n );
        return false;
      } else {
        return true;
      }
    }
	function editar() {
      var valid = true;
      allFields.removeClass( "ui-state-error" );
 
      valid = valid && checkLength( email, "email", 6, 90 );
	  //valid = valid && checkLength( email_alternativo, "email_alternativo", 6, 80 );
      valid = valid && checkRegexp( email, emailRegex, "ej. contacto@gmail.com" );

 
      if ( valid ) {
		  //document.getElementById("editaremail").submit();
		  //dialog.dialog( "close" );
      }
      return valid;
    }
 
 
    dialog = $( "#dialog-form" ).dialog({
      open: function(event, ui) { $(".ui-dialog-titlebar", ui.dialog).hide(); } ,
      height:300,
	  width:500,
	  position: { my: "center center+10%", at: "center", of: window, collision: "none"},
	  modal: true,
       buttons: {
		 
		 'Guardar': function() {
		  var valid = editar();
		  if (valid)
		  {
			document.getElementById("editaremail").submit();
			$( this ).dialog( "close" );
		  }
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
			<?php echo $this->element('emailchequeo');?>
		</div> <!-- /.row -->
		</div> <!-- /.product-content -->
	</div> <!--.product-item-1 -->  
</div> <!-- /.col-md-4 -->
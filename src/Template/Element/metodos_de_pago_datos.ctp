<script>
$( function() {
$( "#dialog1" ).dialog({width: 400, autoOpen: false, show: {effect: "blind", duration: 1000  }, hide: {effect: "blind",duration: 1000}});
$( "#dialog2" ).dialog({width: 400,autoOpen: false, show: {effect: "blind", duration: 1000  }, hide: {effect: "blind",duration: 1000}});
$( "#dialog3" ).dialog({width: 400,autoOpen: false, show: {effect: "blind", duration: 1000  }, hide: {effect: "blind",duration: 1000}});
$( "#dialog4" ).dialog({width: 400,autoOpen: false, show: {effect: "blind", duration: 1000  }, hide: {effect: "blind",duration: 1000}});
$( "#vermas1" ).on( "click", function() {$( "#dialog1" ).dialog( "open" ); });
$( "#vermas2" ).on( "click", function() {$( "#dialog2" ).dialog( "open" ); });
$( "#vermas3" ).on( "click", function() {$( "#dialog3" ).dialog( "open" ); });
$( "#vermas4" ).on( "click", function() {$( "#dialog4" ).dialog( "open" ); });
} );
</script>
<div id="dialog1" title="Obras Sociales">
<p>Acreditamos en tu cuenta las liquidaciones de la obra social que elijas y las utilizas para pagar tu resumen de droguería. </p>
</div>
<div id="dialog2" title="Transferencias y  depósitos">
<p>Acreditamos rápidamente las transferencias que realices para pagar tu resumen de drogueria. Es muy simple. Solo precisamos que nos envíes una foto del comprobante por whatsapp. Ágil y seguro! <br><br>
Contamos con una amplia cobertura bancaria. Credicoop, Nación, Provincia de Chubut, Provincia de Buenos Aires, Galicia, Patagonia y Macro. 
Contamos con tarjetas de deposito y cuentas convenio para que puedas realizar tus pagos en sucursal fácilmente. </p>
</div>
<div id="dialog3" title="Cheques">
<p>Depositando cheques propios o de terceros en fecha en cualquiera de nuestros bancos, te los acreditamos inmediatamente. Depositando cheques con fecha diferida en nuestra cuenta de Patagonia o Macro, bancos en los cuales tenemos el convenio que los acepta, te los acreditamos en el transcurso de las 48/72hs. </p>
</div>
<div id="dialog4" title="Tarjetas de débito/crédito">
<p>Te colocamos una terminal de LAPOS/POSNET para que todas las ventas que realices con tarjetas de débito y crédito se acrediten inmediatamente en tu cuenta de droguería.  
Practico, económico*, y seguro! <br><br>
*Evitas el impuesto al crédito/débito, ya que el dinero se acredita directamente en tu cuenta droguería. </p>
</div>
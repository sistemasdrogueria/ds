<div class="col-md-12 col-sm-12">	
<div class="cliente_info">
<span class='cliente_info_span'>Compras Semanales</span>
<div>
<table>
<?= $this->Form->create('CtacteComprasSemanales',['url'=>['controller'=>'CtacteComprasSemanales','action'=>'index'],'id'=>'searchform5']); ?>
<tr><td>Seleccioná la cuenta:</td></tr>
<tr><td>
<div id="selectsemanaresumen">
<?php echo $this->Form->input('cliente_id',['id'=>'selectcuenta','options'=> $clientes,'onChange'=>'document.getElementById("searchform5").submit();']); ?>
</div>
</td>
</tr>
<tr><td>Seleccioná la semana:</td></tr>
<tr><td><div id="selectsemanaresumen">
<?php echo $this->Form->input('nro_sistema', ['id'=>'selectsemananro','options' => $ctacteResumenSemanales, 'onChange'=>'document.getElementById("searchform5").submit();']); ?>
</div>
</td>
</tr>
</table>		
<?= $this->Form->end() ?>
</div>
<br>
<div class="compra_semanal_fecha"> <?php echo 'Desde el '. date_format($row['desde'],'d-m-Y').' al '.date_format($row['hasta'],'d-m-Y');?></div>
<br>
<table cellpadding="0" cellspacing="0">
<tr>
<td colspan="2">COMPRAS CON PLAZO HABITUAL </td>
</tr>
<tr> 
<td class="ctadescripcion">Factura Medicamentos</td>
<td class="carrito_importe"><?php  echo '$ '. number_format($totalmedicamento,2,',','.');?></td>
</tr>	
<tr>
<td class="ctadescripcion">Factura Perf. y Acces.</td>
<td class="carrito_importe"><?php echo '$ '.  number_format($totalperfumeria,2,',','.');?></td>
</tr>
<tr>	
<td class="ctadescripcion">Factura Transfers</td>
<td class="carrito_importe"><?php echo '$ '.  number_format($totaltransfer,2,',','.');?>
</td>	
</tr>
<tr class="ctadescripciontotal">
<td class="ctadescripcion"><?= __('Total Plazo Habitual') ?></td>
<td class="carrito_importe"><?php echo '$ '. number_format($totalmedicamento+$totalperfumeria+$totaltransfer,2,',','.');?><?php ?></td>
</tr>
<tr>
<td colspan="2"> </td>
</tr>
<tr>
<td colspan="2">COMPRAS CON PLAZO ESPECIAL </td>
</tr>
<tr>
<td class="ctadescripcion">Factura a Plazo</td>
<td class="carrito_importe"><?php echo '$ '. number_format($totaloferta,2,',','.');?></td>
</tr>
<tr>	
<td></td>
<td>
<?php 			?>
</td>
</tr>
<tr class="ctadescripciontotal">
<td class="ctadescripcion"><?= __('Total Compras') ?></td>
<td class="carrito_importe"><?php echo '$ '. number_format($totalmedicamento+$totaloferta+$totalperfumeria+$totaltransfer,2,',','.');?><?php ?></td>
</tr>
<tr>	
<td></td>
<td>
</td>
</tr>
</table>
</div> 
<div class="product-content">	
<div class="row">
<div class="col-md-12 col-sm-12">
<span class='cliente_info_span'>Descargar excel compra semanal.</span>
</br>
<div class="button-holder4">
<a href="#"  onsubmit="return false ;" onclick="excelctactesemanal();" >Excel</a>
</div> <!-- /.button-holder -->
</div> <!-- /.col-md-12 -->
</div> <!-- /.row -->
</div>
</div> <!-- /.col-md-12 -->
<div class="modal fade" id="myModal" role="dialog">
<div class="modal-dialog">
<!-- Modal content-->
<div class="modal-content">
<div class="modal-header">
</div>
<div class="modal-body"style="display: flex; flex-direction: column; flex-wrap: wrap; align-content: center; justify-content: center; align-items: center;">
<?php
echo $this->Html->image('loading-waiting.gif',['title' => 'cargando por favor, espere.','alt'=>'','style'=>'width:40px;height:40px;']);
echo"<p>Estamos preparando su archivo, por favor, espere.</p>";
?>
</div>
<div class="modal-footer">
</div>
</div>
</div>
</div>
<script>
function excelctactesemanal() {
var ctacteComprasSemanales ='<?php echo json_encode($ctacteComprasSemanale,JSON_FORCE_OBJECT);?>';
var desde = $('.compra_semanal_fecha').text().replace("Desde","").replace("el","");
$('#myModal').modal({
backdrop: 'static',
keyboard: false
})
$('#myModal').modal({
show: true
});
$('#myModal').addClass('show');
$.ajax({
data: {'ctacteComprasSemanales': ctacteComprasSemanales}, 
dataType: "json",
url: "<?php echo \Cake\Routing\Router::url(array('controller' => 'CtacteEstados', 'action' => 'comprasexcel')); ?>",
type: "post",
}).done(function(data) {
$('#myModal').modal('toggle');
$('#myModal').removeClass('show');
var $a = $("<a>");
$a.attr("href", data.file);
$("body").append($a);
console.log(data.file);
$a.attr("download", "Listado_Facturas_"+<?php echo $_SESSION['Auth']['User']['codigo']; ?>+desde+".xlsx");
$a[0].click();
$a.remove();
$('#imagencargando').addClass('hide');
});

}
</script>
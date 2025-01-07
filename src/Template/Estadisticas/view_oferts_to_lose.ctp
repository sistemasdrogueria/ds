<?php echo $this->Html->script('https://www.google.com/recaptcha/api.js?render=6LfgfTkoAAAAADIs76s1DbguGb9c4A8CTlx9zGqB'); ?>
<div class="col-md-3">
<div class="product-item-3"> 
<div class="product-content">
<div class="row">
<div class="col-md-12 col-sm-12">
<span class=''>Busqueda Listado</span>
<?php $indice=0;   echo $this->element('search_table_oferta_medicamentos'); ?>
</div> <!-- /.col-md-12 -->
</div> <!-- /.row -->
</div> <!-- /.product-content -->	   
<div class="product-content">
<div class="row">	
<div class="col-md-12 col-sm-12 text-center">
<span class='cliente_info_span'>Descargar listado Productos oferta perdida </span>
<div>
<?php 
echo 'DESCARGAR '. $this->Html->image('excel.png',['title'=>'Descargar Excel','style'=>'cursor:pointer;', 'onsubmit'=>'return false','onclick'=>'descargarexcel();']);

?>
</div>
<?php   //echo $this->element('search_table_oferta_medicamentos');
//aqui se descarga ?>
</div> <!-- /.col-md-12 -->
</div> <!-- /.row -->
</div> <!-- /.product-content -->	
</div> <!--.product-item-1 -->  
</div> <!-- /.col-md-4 -->
<div class="col-md-9">
<div class="product-item-3">
<div class="product-content">
<div class="row">
<span class='cliente_info_span'>Listado de productos con ofertas adquiridas y perdidas</span>
<br>
<?php echo $this->element('table_ofertas_medicamentos'); ?>
</div>
</div>
<div class="paginator">
<ul class="pagination">
<?= $this->Paginator->prev('< Anterior') ?>
<?= $this->Paginator->numbers() ?>
<?= $this->Paginator->next('Siguiente'.' >',['tabindex'=>$indice]) ?>
<div class="pagination_count"><span><?= $this->Paginator->counter('{{count}} Articulos') ?> </span></div>
</ul>
<!-- div class="importconfirm2">	
<div class="button-holder5"><?php //echo $this->Form->submit('Agregar Seleccionados',['class'=>'btn_agregarvarios']);?></div>	
</div -->
<?= $this->Form->end() ?>	
</div>
</div> <!-- /.product-item -->
</div> <!-- /.col-md-3 -->
<div class="modal fade" id="myModal" role="dialog">
<div class="modal-dialog">
<!-- Modal content-->
<div class="modal-content">
<div class="modal-header">
</div>
<div class="modal-body" style="display: flex; flex-direction: column; flex-wrap: wrap; align-content: center; justify-content: center; align-items: center;">
<?php 
echo $this->Html->image('loading-waiting.gif', ['title'=>'cargando por favor, espere.', 'alt'=>'', 'style'=>'width:40px;height:40px;']);
echo "<p>Estamos preparando su archivo, por favor, espere.</p>";
?>
</div>
<div class="modal-footer">
</div>
</div>
</div>

</div>
<script>


  function descargarexcel(){
    var ahora = new Date();
    var dia = String(ahora.getDate()).padStart(2, '0');
    var mes = String(ahora.getMonth() + 1).padStart(2, '0'); // Los meses comienzan en 0
    var anio = ahora.getFullYear();

    // Formatear la fecha en el formato deseado, por ejemplo, YYYY-MM-DD
    var fechaActual = anio + '-' + mes + '-' + dia;
    $('.product-content3').addClass('color');
$('#myModal').modal({backdrop: 'static',keyboard: false})
$('#myModal').modal({show:true});
$('#myModal').addClass('show');
grecaptcha.ready(function() {
grecaptcha.execute('6LfgfTkoAAAAADIs76s1DbguGb9c4A8CTlx9zGqB', {
action: 'submit'
}).then(function(token) {
$.ajax({
data: {
recaptcha:token
},
dataType:"json",
url: "<?php echo \Cake\Routing\Router::url(array('controller'=>'Estadisticas', 'action'=>'excelToDownload')); ?>",
type: "post",
}).done(function(data){
$('#myModal').modal('toggle');
$('#myModal').removeClass('show');
var $a = $("<a>");
$a.attr("href",data.file);
$("body").append($a);
 $a.attr("download", "productosOfertaPerdida_"+fechaActual+".xlsx");
$a[0].click();
$a.remove();
$('#imagencargando').addClass('hide');
$('.product-content3').removeClass('color');
});
});
});
}
</script>
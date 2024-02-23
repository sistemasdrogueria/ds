<style>
.botonesdescarga{ height: 140px; padding: 10px;  }
.botondescarga{ width: 70%;float: left  }
.descargaboton{width: 100px;float: right;    position: relative;}
.descargatexto{ float: left; padding-top: 5px;   position: relative;}
</style>
<div class="col-md-9">
<div class="product-item-3">
<div class="product-content">
<span class="cliente_info_span">PRODUCTOS IMPORTADOS</span>
<?php if ($articulos!=null )
echo $this->element('searchimportresulttempo'); 
else
echo $this->element('searchsinresult'); 
?>
<?php if(isset($_SESSION['destarray'])){
  if(!empty($_SESSION['destarray'])){
echo'<span class="cliente_info_span">PRODUCTOS MODIFICADOS POR RESTRICIONES DE UNIDADES</span>';
echo $this->element('searchimportresultmodcant'); 
  }
} ?>
</div> <!-- /.product-content -->
<div class="product-content" style="min-height: 300px;">
<span class="cliente_info_span">PRODUCTOS NO IMPORTADOS</span>
<?php echo $this->element('searchimportresultnotfind');  ?>	
</div>
<div class="product-content">
<div class=botonesdescarga>
<div class=botondescarga>
<div class=descargatexto>ARCHIVO CON EAN NO ENCONTRADOS</div>
<div class=descargaboton><div class=button-holder3><?= $this->Html->link('Descargar ',['controller' => 'Carritos', 'action' => 'downloadfile',1] )?></div></div>
</div>
<div class=botondescarga>
<div class=descargatexto>ARCHIVO CON EAN NO ENCONTRADOS Y CON FALTAS</div>
<div class=descargaboton><div class=button-holder3><?= $this->Html->link('Descargar ',['controller' => 'Carritos', 'action' => 'downloadfile',2] )?></div></div>
</div>
<?php
if ($this->request->session()->read('clientesConfiguracione')!=null)
{
  $sistema = $this->request->session()->read('clientesConfiguracione')['sistema_id'];
  if ($sistema ==12 || $sistema == 13)
  {
    echo '<div class=botondescarga>
    <div class=descargatexto>ARCHIVO DE RESPUESTA TOUCH&SALE</div>
    <div class=descargaboton><div class=button-holder3>'.$this->Html->link('Descargar ',['controller' => 'Carritos', 'action' => 'downloadfile',3] ).'</div></div>
    </div>';
  }
  

}

?>
<div class=botondescarga>
<div class=descargatexto>ARCHIVO DE EXCEL</div>
<div class=descargaboton><div class=button-holder3><?= $this->Html->link('Descargar ',['controller' => 'Carritos', 'action' => 'excel'] )?></div></div>
</div>
</div>

</div>
</div> <!-- /.product-content -->
</div> <!-- /.product-item -->


<div class="col-md-3 carrito-view-import">
<div class="product-item-5"> 
<div class="product-content">
<div class="row"> <?php echo $this->element('cartresumbodyimport'); ?></div>
</div>
</div>
<div class="product-item-5">		
<div class="product-content">
<div class='cliente_info_class3'><?php echo $this->Html->image('confirmacion-import.png'); ?></div>
<div class='cliente_info_class2'>Productos Importados</div>
<div class="row"> <?php echo $this->element('botonescarroimport'); ?>

</div>
</div> 
</div>  
</div>
<div class="col-md-3 carrito-view-finish hide">
<div class="product-item-5"> 
<div class="product-content">
<div class="row"> <?php echo $this->element('cartresumbody'); ?></div>
</div>
</div>
<div class="product-item-5">		
<div class="product-content">
<div class='cliente_info_class3'><?php echo $this->Html->image('ofertaagregarcarro.png'); ?></div>
<div class='cliente_info_class2'>Carro de Compras</div>
<div class="row"> <?php echo $this->element('botonescarro'); ?>
<div class="cartresul"><?php echo $this->element('cartresultbody'); ?>
</div>
</div> 
</div>  
</div>
</div> <!-- /.col-md-3 -->
<script>

$('.page_cart1').remove();
$('#formaddcart').each(function() {

var numero = <?php echo $totalcarritotemp ?>;
const noTruncarDecimales = {
maximumFractionDigits: 2,
minimumFractionDigits: 2
};
ptos = numero.toLocaleString('es', noTruncarDecimales)
var currentPage = 0;
var numPerPage = 200;
var $table = $(this);
var rowCount = $('tbody.import tr').length;
$table.bind('repaginate', function() {
$table.find('tr').hide().slice(currentPage * numPerPage, (currentPage + 1) * numPerPage).show();
});
$table.trigger('repaginate');
var numRows = $table.find('tbody tr').length;
var numPages = Math.ceil(numRows / numPerPage);
var $pager = $('<div class="page_cart1"></div>');
var $anterior = $('<li class="prev disabled anterior"><a disabled "href="#"onclick="anterior();">Anterior</a></li>');
var $case = $('<li class="prev"></li>');
var $siguiente = $('<li class="prev siguiente"><a onclick="siguiente();" onsubmit="return false;">Siguiente></a></li>');
var $total = $('<li class="pagination_count"><span id="totalitemss">' + <?php echo $totalitemstemp ?> + ' Articulos</span></li><li class="pagination_count"><span id="totalunidadess"> <?php echo $totalunidadestemp ?>Unid.</span></li><li class="pagination_count"><span id="totaltall">Total $ '+ ptos+'</span></li>');
var $ul = $('<ul id="uli" style="display: inline-flex;" class="pagination"></ul>');
$anterior.appendTo($ul);

for (var page = 0; page < numPages; page++) {
var $linum = $('<div class="page-number" id=pag' + (page + 1) + '><a></a></div>').text(page + 1).bind('click', {
newPage: page
}, function(event) {
currentPage = event.data['newPage'];
$table.trigger('repaginate');

$(this).addClass('active').siblings().removeClass('active');
}).appendTo($ul).addClass('clickeable');
}
$siguiente.appendTo($ul);

$total.appendTo($ul);
$ul.appendTo($pager);
$pager.insertAfter($table).find('div.page-number:first').addClass('active');
});



</script>
<script>
window.onload=vaciartableimport();

function vaciartableimport(){

var result = [];
var parts = [];

location.search
.substr(1)
.split("&")
.forEach(function (item) {
parts = item.split("=");
if(parts[0]!=""){     
result.push(parts);
}
});

return result;


}

params = vaciartableimport();

for(var i in params){      

if(params[i][1] ==1){

$(".articulos").html("");
$(".carrito-view-finish").removeClass("hide");
$(".carrito-view-import").addClass("hide");

}
}

$(document).ready(function(){ irArriba(); }); //Hacia arriba

function irArriba(){
  $('.ir-arriba').click(function(){ $('body,html').animate({ scrollTop:'0px' },10); });
  $(window).scroll(function(){
    if($(this).scrollTop() > 0){ $('.ir-arriba').slideDown(10); }else{ $('.ir-arriba').slideUp(10); }
  });
  $('.ir-abajo').click(function(){ $('body,html').animate({ scrollTop:'10px' },10); });
}
</script>
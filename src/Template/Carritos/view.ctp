<style>
.modal-content{width:inherit!important;max-width:inherit!important;height:inherit!important;margin:0 auto!important;pointer-events:all!important}
</style>
<div class="col-md-10">
<div class="product-item-3">
<div class="product-content">
<span class='cliente_info_span'>Carro de Compras</span>
</br>
<?php echo $this->element('carrito_view_result');
echo 'DESCARGAR '. $this->Html->image('excel.png',['url'=>['controller'=>'Carritos','action'=>'excel_contenido']],['style'=>'cursor:pointer;']);

?>
</div> <!-- /.product-content -->
</div> <!-- /.product-item -->
</div> <!-- /.col-md-3 -->
<div class="modal fade"  style="background:repeating-linear-gradient(135deg, rgb(151 151 151 / 44%), rgb(151 151 151 / 19%) 1%, rgba(151, 151, 151, 0.32) 1%);display: flex;flex-direction: row;flex-wrap: nowrap;align-content: center;justify-content: center;align-items: center;"data-keyboard="false" data-backdrop="static" 
id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog"  style="width:100%;max-width:1100px;" role="document">
<div class="modal-content">
<!-- Modal heading -->
<div class="modal-header-intro">
<button type="button" class="close-intro" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">×</span>
</button>
</div>

<!-- Modal body with image -->
<div class="modal-body-intro">
<?php if(!is_null($view1))
{
if ($view1['url_campo']!='' && $view1['url_campo2']!='')
echo $this->Html->image('publicaciones/'.$view1['imagen'],['url'=>['controller'=>$view1['url_controlador'],'action'=>$view1['url_metodo'],$view1['url_campo'],$view1['url_campo2']],'id'=>'conf_img1','alt'=>'Drogueria Sur S.A.','width'=>'100%']);
else
if ($view1['url_campo']!='')
echo $this->Html->image('publicaciones/'.$view1['imagen'],['url'=>['controller'=>$view1['url_controlador'],'action'=>$view1['url_metodo'],$view1['url_campo']],'id'=>'conf_img1','alt'=>'Drogueria Sur S.A.','width'=>'100%']);
else
echo $this->Html->image('publicaciones/'.$view1['imagen'],['url'=>['controller'=>$view1['url_controlador'],'action'=>$view1['url_metodo']],'id'=>'conf_img1','alt'=>'Drogueria Sur S.A.','width'=>'100%']);
}
?>
</div>

<div class="moda-footer-intro">
<button class="btn-continuar"onclick="closedivbutton(1)"  >Continuar</button>
</div>
</div>
</div>
</div>
<div class="modal fade" style="background:repeating-linear-gradient(135deg, rgb(151 151 151 / 44%), rgb(151 151 151 / 19%) 1%, rgba(151, 151, 151, 0.32) 1%);display: flex;flex-direction: row;flex-wrap: nowrap;align-content: center;justify-content: center;align-items: center;" data-keyboard="false" data-backdrop="static"
id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"  aria-hidden="true">
<div class="modal-dialog"  style="width:100%;max-width:1100px;" role="document">
<div class="modal-content">
<!-- Modal heading -->
<div class="modal-header-intro">
<button type="button" class="close-intro" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">×</span>
</button>
</div>

<!-- Modal body with image -->
<div class="modal-body-intro" onclick="closediv()">
<?php if(!is_null($view2))
{ 
if ($view2['url_campo']!='' && $view2['url_campo2']!='')
echo $this->Html->image('publicaciones/'.$view2['imagen'],['url'=>['controller'=>$view2['url_controlador'],'action'=>$view2['url_metodo'],$view2['url_campo'],$view2['url_campo2']],'id'=>'conf_img2','alt'=>'Drogueria Sur S.A.','width'=>'100%']);

else
if ($view2['url_campo']!='')
echo $this->Html->image('publicaciones/'.$view2['imagen'],['url'=>['controller'=>$view2['url_controlador'],'action'=>$view2['url_metodo'],$view2['url_campo']],'id'=>'conf_img2','alt'=>'Drogueria Sur S.A.','width'=>'100%']);
else
echo $this->Html->image('publicaciones/'.$view2['imagen'],['url'=>['controller'=>$view2['url_controlador'],'action'=>$view2['url_metodo']],'id'=>'conf_img2','alt'=>'Drogueria Sur S.A.','width'=>'100%']);
}
?>
</div>

<div class="moda-footer-intro">
<button class="btn-continuar"onclick="closedivbutton(2)"  >Continuar</button>
</div>
</div>
</div>
</div>

<div class="col-md-2">
<div class="product-item-5"> 
<div class="product-content">
<div class="row">
<?php echo $this->element('carrito_view_resum'); ?>
</div> <!-- /.row -->
</div> <!-- /.product-content -->
</div>
<div class="product-item-3">	
<div class="product-content">
<div class="row">   
<?php echo $this->element('carrito_view_button'); ?>
<div class="cartresul">			
<?php //echo $this->element('cartresult'); ?>
</div>
</div> <!-- /.row -->
</div> <!-- /.product-content -->
</div> <!--.product-item-1 -->  
</div> <!-- /.col-md-4 -->
<script>
var $view1=0;
var $view2=0;

var $view1=<?php if(!empty($view1)){if(empty($this->request->session()->read('view1'))){echo '0';}else echo '1';}else echo '1';?>;
var $view2=<?php if(!empty($view2)){if(empty($this->request->session()->read('view2'))){echo '0';}else echo '1';}else echo '1';?>;
if($view1>0){document.getElementById("exampleModal").style.display="none";<?php //echo $this->request->session()->write('view1',1)?>window.scrollTo(0,0)}
if($view2>0){document.getElementById("exampleModal2").style.display="none";<?php //echo $this->request->session()->write('view1',1)?>window.scrollTo(0,0)}
$(document).ready(function(){
if($view1<1) {  $('#exampleModal').modal(
{backdrop: false 
},'show');
<?php echo $this->request->session()->write('view1',1);?>
}


if($view2<1){
$('#exampleModal2').modal({
backdrop: false
},'show');
<?php echo $this->request->session()->write('view2',1);?>
}
});


</script>

<script>
$('table.tablasearch').each(function () {


var currentPage = 0;
var numPerPage = 50;
var $table = $(this);
var rowCount = $('table.tablasearch tbody tr td.formcartcanttd1').length;
$table.bind('repaginate', function () {
$table.find('tbody tr').hide().slice(currentPage * numPerPage, (currentPage + 1) * numPerPage).show();
});
$table.trigger('repaginate');
var numRows = $table.find('tbody tr').length;
var numPages = Math.ceil(numRows / numPerPage);
var $pager = $('<div class="page_cart2" style="text-align: center;"></div>');


var $anterior = $('<li class="prev disabled anterior" style="border: 0px solid #ddd!important;display: inline!important;"><a disabled "href="#"onclick="anterior();">	<?php echo $this->Html->image("pag_ant.png", ["alt" => "Anterior"]); ?></a></li>');
var $case = $('<li class="prev"></li>');
var $siguiente = $('<li class="prev siguiente" style="border: 0px solid #ddd!important;display: inline!important;"><a onclick="siguiente();" onsubmit="return false;"><?php echo $this->Html->image("pag_sig.png", ["alt" => "Siguiente"]); ?></a></li>');
// var $total = $('<li class="pagination_count"><span>' + rowCount + ' Articulos</span></li>');
var $ul = $('<ul id="uli" style="display: inline-flex;flex-direction: row;flex-wrap: nowrap;align-content: center;justify-content: center;align-items: center;"class=""></ul>');
$anterior.appendTo($ul);


for (var page = 0; page < numPages; page++) {
var $linum = $('<div class="page-number" style="height: 35px;border: 0px solid #ddd!important;font-weight: 700;display: inline-flex;flex-direction: row;flex-wrap: nowrap;align-content: center;justify-content: center;align-items: center;border-radius: 4px;" id=pag' + (page + 1) + '><a></a></div>').text(page + 1).bind('click', {
newPage: page
}, function (event) {
currentPage = event.data['newPage'];
$table.trigger('repaginate');

$(this).addClass('active').siblings().removeClass('active');

$(this).addClass('colorgris').siblings().removeClass('colorgris');

}).appendTo($ul).addClass('clickeable');
}




$siguiente.appendTo($ul);

//$total.appendTo($ul);
$ul.appendTo($pager);
$pager.insertAfter($table).find('div.page-number:first').addClass('active colorgris');



});

function closediv(){
$('#exampleModal').modal('hide');  
$('#exampleModal2').modal('hide');
$('#exampleModal3').modal('hide');      	
}


function closedivbutton(i){

if(i>1){
$('#exampleModal'+i).modal('hide');   


}else{
$('#exampleModal').modal('hide');  
}
}


</script>
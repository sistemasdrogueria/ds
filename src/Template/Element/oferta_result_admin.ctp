<style>
#scrollToTopBtn { display: none; position: fixed; bottom: 20px; right: 20px; font-size: 24px; padding: 10px 15px; text-align: center; cursor: pointer; z-index: 1000; text-decoration: none; }
</style>
<div>	
<div id="tab1" class="tab_content">
<div class="paginationtop">
        <ul>
		<?php
		echo $this->Paginator->prev(__('Ant'), array('tag' => 'li'), null, array('tag' => 'li','disabledTag' => 'a'));
		echo $this->Paginator->numbers(array('separator' => '','currentTag' => 'a', 'currentClass' => 'active','tag' => 'li','first' => 1));
		echo $this->Paginator->next(__('Sig'), array('tag' => 'li','currentClass' => 'disabled'), null, array('tag' => 'li','disabledTag' => 'a'));?>
        </ul>
        <div class="total">
		<?php echo $this->Paginator->counter('{{count}} Total');?>
		</div>
		</div>
<?= $this->Form->create('Ofertas',['url'=>['controller'=>'Ofertas','action'=>'edit_oferta'],'name'=>'f1','id'=>'f1']); ?>
<table class="tablesorter"> 
<thead> 
<tr>
<th><?= $this->Paginator->sort('id','Imagen') ?></th>
<th><?= $this->Paginator->sort('id','INFO') ?></th>
<th><?= $this->Paginator->sort('articulo_id','Descripción') ?></th>
<th><?= $this->Paginator->sort('descuento_producto','Desc.') ?></th>
<th><?= $this->Paginator->sort('unidades_minimas','U.Min') ?></th>
<th><?= $this->Paginator->sort('plazos','Plazos') ?></th>
<th><?= $this->Paginator->sort('fecha_desde', 'F. Desde') ?></th>
<th><?= $this->Paginator->sort('fecha_hasta','F. Hasta')?></th>
<th><?= $this->Paginator->sort('oferta_tipo_id') ?></th>
<th><?= $this->Paginator->sort('habilitada','Activa') ?></th>
<th><input type="checkbox" id="selectall"></th>
<th><?= $this->Paginator->sort('orden','ORD') ?></th>
<th class="actions"><?= __('') ?></th>
</tr>
</thead>
<tbody>

<?php $i=0; 
function formatoTamano($bytes) {
  $unidades = ['B', 'KB', 'MB', 'GB', 'TB'];
  $potencia = floor(($bytes ? log($bytes) : 0) / log(1024));
  $potencia = min($potencia, count($unidades) - 1);
  $bytes /= pow(1024, $potencia);

  return round($bytes, 2) . ' ' . $unidades[$potencia];
}
?>
<?php foreach ($ofertas as $oferta): ?>

<?php echo '<tr id="trBody' . $oferta['id'] . '">';?>    

<?php 
$i=$i+1;
$encabezado = $i.".";
if ($oferta->oferta_tipo_id<2)
{
   $uploadPath = 'productos//' ;
   $filename = WWW_ROOT . 'img' . DS .$uploadPath.$oferta['articulo']['imagen'] ;
}
else
{
   $uploadPath = 'ofertas//' ;
   $filename = WWW_ROOT . 'img' . DS .$uploadPath.$oferta['imagen'] ;						
}
if (file_exists($filename))
{
  echo '<td>';
   $tamanoArchivo = filesize($filename);
   if ($oferta->oferta_tipo_id<2)
   {
      echo $this->Html->image($uploadPath.$oferta['articulo']['imagen'], ['class'=>'imgFoto2','alt' => str_replace('"', '', $oferta['descripcion']),'height' =>100]);
   }
   else
   {
     echo $this->Html->image($uploadPath.$oferta['imagen'], ['class'=>'imgFoto','alt' => str_replace('"', '', $oferta['descripcion']),'height' => 100]);
  
   }
   echo '</td>';
   $informacionImagen = getimagesize($filename);
   echo '<td class=colcenter>'.formatoTamano($tamanoArchivo);
   if ($informacionImagen) {
     $ancho = $informacionImagen[0];
     $alto = $informacionImagen[1];
     echo '<br>'; 
     echo "{$ancho} x {$alto} PX";
   }
   
   echo '</td>';
}

?>       

<td>
<?= $oferta->descripcion ?>
</td>
<td><?php echo $oferta->descuento_producto.' %' ?></td>
<td><?= $oferta->unidades_minimas ?></td>
<td><?= $oferta->plazos ?></td>
<td><?php echo date_format($oferta->fecha_desde,'d-m-Y');?></td>
<td><?php echo date_format($oferta->fecha_hasta,'d-m-Y');?></td>

<td><?= $oferta['ofertas_tipo']['nombre'] ?></td>
<td><?php if($oferta->habilitada==1)
echo "SI";
else
echo "NO"
?>
</td>
<td>
<?php 
echo $this->Form->input($encabezado.'id',['type'=>'hidden','value'=>$oferta->id]);
$habilitada = $oferta->habilitada;
echo $this->Form->input($encabezado.'habilitada', ['tabindex'=>$i,'label'=>'','type'=>'checkbox','checked'=>$habilitada],['class'=>'case[]']); ?>
</td>
<td>
<?php echo $oferta->orden;?>
</td>
<td class="actions">

<?php
echo $this->Html->image("admin/admin_edit.png", ["alt" => "Edit",'url' => ['controller' => 'ofertas', 'action' => 'edit_admin',  $oferta->id],
'data-static'=>'../img/admin/admin_edit.png','data-hover'=>'../img/admin/admin_edit.gif','class'=>'hover-gif','style'=>'width=50px']);
echo $this->Html->image("admin/admin_view.png", ["alt" => "View",'url'=>['controller' => 'ofertas', 'action' => 'view_admin',  $oferta['id']],'escape' => false,'target'=>'_blank',
'data-static'=>'../img/admin/admin_view.png','data-hover'=>'../img/admin/admin_view_i.gif','class'=>'hover-gif','style'=>'width=50px']);
?>
  <a href="#" onclick="preguntarSiNo(<?php echo $oferta->id ?>)"><?php 
 
  echo $this->Html->image("admin/admin_delete.png", ["alt" => "imagen_reset",'data-static'=>'../img/admin/admin_delete.png','data-hover'=>'../img/admin/admin_delete.gif','class'=>'hover-gif','style'=>'width=50px']);
  ?>
</a>


</td>
</tr>
<?php endforeach; ?>
</tbody> 
</table>
<?= $this->Form->submit('Habilitar Seleccionados',['name'=>'btn1']); ?>
<?= $this->Form->submit('Borrar Selecionados',['name'=>'btn2', 'confirm' => __('Esta seguro de eliminar')]); ?>
<?= $this->Form->end() ?>
</div><!-- end of .tab_container -->
<div class="pagination">
<ul>
<?php
echo $this->Paginator->prev(__('Ant'), array('tag' => 'li'), null, array('tag' => 'li','disabledTag' => 'a'));
echo $this->Paginator->numbers(array('separator' => '','currentTag' => 'a', 'currentClass' => 'active','tag' => 'li','first' => 1));
echo $this->Paginator->next(__('Sig'), array('tag' => 'li','currentClass' => 'disabled'), null, array('tag' => 'li','disabledTag' => 'a'));
?>
</ul>
<div class="total">
<?php
echo $this->Paginator->counter('{{count}} Total');
?>
</div>
</div>
</div>	
<div class="modal fade" id="enlargeImageModal2" tabindex="-1" role="dialog" aria-labelledby="enlargeImageModal2" aria-hidden="true">
<div class="modal-dialog modal-lg" role="document">
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
</div>
<div class="modal-body">       
<img src="" class="enlargeImageModalSource2" style="width: 90%;">       
</div>
</div>
</div>
</div>
<div class="modal fade" id="enlargeImageModal" tabindex="-1" role="dialog" aria-labelledby="enlargeImageModal" aria-hidden="true">
<div class="modal-dialog modal-lg" role="document">
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
</div>
<div class="modal-body">       
<img src="" class="enlargeImageModalSource" style="width: 50%;">       
</div>
</div>
</div>
</div>
<?php 
echo $this->Html->image("admin/admin_up.png", ["alt" => "Edit",'id'=>'scrollToTopBtn',/*'class'=>'scroll-to-top',*/
'data-static'=>'../img/admin/admin_up.png','data-hover'=>'../img/admin/admin_up.gif','class'=>'hover-gif','style'=>'width=50px']);
?>

<script>
let scrollToTopBtn = document.getElementById("scrollToTopBtn");

// Muestra el botón cuando el usuario se desplaza hacia abajo
window.onscroll = function() {
    if (document.body.scrollTop > 100 || document.documentElement.scrollTop > 100) {
        scrollToTopBtn.style.display = "block";
    } else {
        scrollToTopBtn.style.display = "none";
    }
};

// Cuando el usuario hace clic en el botón, lo lleva a la parte superior
scrollToTopBtn.addEventListener("click", function(event) {
    event.preventDefault();
    window.scrollTo({
        top: 0,
        behavior: "smooth"
    });
});
</script>

<script>
   function seleccionar_todo(valor){

   for (i=0;i<document.f1.elements.length;i++)
      if(document.f1.elements[i].type == "checkbox")
         document.f1.elements[i].checked=valor;
} 

$("#selectall").on("click", function() {
   var x = document.getElementById("selectall").checked;
   seleccionar_todo(x);
});



var myBaseUrlsdelete = '<?php echo \Cake\Routing\Router::url(array('controller' => 'Ofertas', 'action' => 'delete_admin')); ?>';
function eliminarDatos(id) {
  
	  
  $.ajax({
    type: "post",
    url: myBaseUrlsdelete,
    data: "id=" + id,
    dataType: "json",
    success: function (data, response) {
		if ((response = "ok")) {

		//$("input[data-id=" + arti + "]").val("");
        $("tr[id=trBody" + id + "]").remove();


		alertify.message("").dismissOthers();
        alertify.success("Eliminado con exito!");
		}
	}
  });
}

function preguntarSiNo(id) {
  alertify.confirm(
    "Eliminar",
    "¿Esta seguro de eliminar esta oferta?",
    function () {
      eliminarDatos(id);
    },
    function () {
      alertify.error("Se cancelo la operación");
    }
  );
}
$(function() {
$('.imgFoto').on('click', function() {
var str = $(this).attr('src');
var res = str;
var a = new XMLHttpRequest;
a.open("GET", res, false);
a.send(null);
if (a.status === 404){
var res = $(this).attr('src');
//var res = res.replace("foto.png", "productos/"+$(this).data("id"));
}			
//var res =  $(this).attr('src');
$('.enlargeImageModalSource').attr('src',res);
$('#enlargeImageModal').modal('show');
});
});
$(function() {
$('.imgFoto2').on('click', function() {
var str = $(this).attr('src');
var res = str.replace("productos/", "productos/big_");
var a = new XMLHttpRequest;
a.open("GET", res, false);
a.send(null);
if (a.status === 404){
var res = $(this).attr('src');
//var res = res.replace("foto.png", "productos/"+$(this).data("id"));
}			
//var res =  $(this).attr('src');
$('.enlargeImageModalSource2').attr('src',res);
$('#enlargeImageModal2').modal('show');
});
});
</script>
<?php
//echo $this->Html->css('bootstrap.min');
echo $this->Html->script('bootstrap'); 
?>


<style>
.header{ text-align: center;}
.colcenter{ text-align: center;}
</style>


<script>
$(document).ready(function() {
$(".formpublicationactive").change(function() {
var id=$(this).attr("data-id");
ajaxactive(id);
});
var inputs = document.querySelectorAll("input,select");
for (var i = 0; i < inputs.length; i++) {
inputs[i].addEventListener("keypress", function(e) {
if (e.which == 13 || e.keyCode == 40 || e.keyCode == 38 || e.keyCode == 18 || e.keyCode == 9) {
e.preventDefault();
var nextInput = document.querySelectorAll('[tabIndex="' + (this.tabIndex + 1) + '"]');
if (nextInput.length === 0) {
nextInput = document.querySelectorAll('[tabIndex="1"]');
}
nextInput[0].focus();
}
})
}
function ajaxactive(id) {
$.ajax({
type: "POST",
url: "<?php echo \Cake\Routing\Router::url(array('controller' => 'Publications', 'action' => 'update_admin')); ?>",
data: {
id: id,
},
dataType: "json",
success: function(data, textStatus) {
//alertify.message("").dismissOthers();
//	alertify.success("Cantidad Agregada Con Exito!");
},
error: function(textStatus) {
//console.log(textStatus);
//window.location.replace("/products/clear");
}
});
}
});
</script> 

<div id="tab1" class="tab_content">
<div class="paginationtop">
        <ul>
		<?php
		echo $this->Paginator->prev(__('Anterior'), array('tag' => 'li'), null, array('tag' => 'li','disabledTag' => 'a'));
		echo $this->Paginator->numbers(array('separator' => '','currentTag' => 'a', 'currentClass' => 'active','tag' => 'li','first' => 1));
		echo $this->Paginator->next(__('Siguiente'), array('tag' => 'li','currentClass' => 'disabled'), null, array('tag' => 'li','disabledTag' => 'a'));?>
        </ul>
        <div class="total">
		<?php echo $this->Paginator->counter('{{count}} Total');?>
		</div>
		</div>

<?= $this->Form->create('Publications',['url'=>['controller'=>'Publications','action'=>'edit_publication_admin']]); ?>
<table class="tablesorter"> 
<thead> 
<tr>
<th class="header"><?= $this->Paginator->sort('id','Imagen') ?></th>
<th class="header"><?= $this->Paginator->sort('id','INFO') ?></th>
<th class="header"><?= $this->Paginator->sort('id','Nro') ?></th>
<th class="header"><?= $this->Paginator->sort('descripcion','Descripción') ?></th>
<th class="header"><?= $this->Paginator->sort('fecha_desde') ?></th>
<th class="header"><?= $this->Paginator->sort('fecha_hasta') ?></th>
<th class="header"><?= $this->Paginator->sort('ubicacion','Ubicación') ?></th>
<th class="header"><?= $this->Paginator->sort('orden', 'Orden') ?></th>
<th class="header"><?= $this->Paginator->sort('habilitada','Activa') ?></th>
<th class="actions"><?= __('') ?></th>
</tr>
</thead>
<tbody>

<?php 
function formatoTamano($bytes) {
  $unidades = ['B', 'KB', 'MB', 'GB', 'TB'];
  $potencia = floor(($bytes ? log($bytes) : 0) / log(1024));
  $potencia = min($potencia, count($unidades) - 1);
  $bytes /= pow(1024, $potencia);

  return round($bytes, 2) . ' ' . $unidades[$potencia];
}
?>
<?php $indice=0; foreach ($publications as $publication): ?>
<?php echo '<tr id="trBody' . $publication['id'] . '">';?> 

<?php 
if ($publication['ubicacion']!=1 && $publication['ubicacion']!=9) $uploadPath = 'publicaciones/';
else $uploadPath = 'inicio/';
$filename = WWW_ROOT . 'img' . DS .$uploadPath.$publication['imagen'] ;						

if (file_exists($filename))
{
echo "<td class=colcenter>";
echo $this->Html->image($uploadPath.$publication['imagen'], ['alt' => str_replace('"', '', $publication['descripcion']),'class'=>'imgFoto','style'=>"height:100px; max-width:300px;"]);
echo '</td>';
$tamanoArchivo = filesize($filename);
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
else
{
  echo "<td class=colcenter></td><td></td>"; 
}

?> 

<td class="colcenter"><?= $this->Number->format($publication->id) ?></td>
<td><?= $publication->descripcion ?></td>
<td class="colcenter"><?php echo date_format($publication->fecha_desde,'d-m-Y');?></td>
<td class="colcenter"><?php echo date_format($publication->fecha_hasta,'d-m-Y');?></td>
<td class="colcenter"><?php 
//$ubicacion= [0=>'A determinar',1=>'SLIDER',2=>'INICIO PP',3=>'CONFIRMAR PEDIDO UP',4=>'VER CARRO PP',5=>'IMPORTAR PEDIDO PP',6=>'UNDER THE CART I',7=>'UNDER THE CART S',8=>'CUENTA CORRIENTE',9=>'EXPOSUR SLIDER',10=>'UNDER THE CART N',12=>'SUR FS'];
echo $publicationsTipos[$publication['ubicacion']];
?></td>
<td class="colcenter"><?php echo $publication['orden'];?></td>
<td class="colcenter">
<?php 
$indice+=1;
$encabezado = $indice.'.';
echo $this->Form->input($encabezado.'id',['type'=>'hidden','value'=> $publication->id]);
$habilitada = $publication->habilitada;
echo $this->Form->input($encabezado.'habilitada', ['tabindex'=>$indice,'label'=>'','type'=>'checkbox','checked'=>$habilitada, 'class'=>'formpublicationactive','data-id' =>$publication->id]); ?>
</td>
<td class="actions">
<?php
echo $this->Html->image("admin/admin_edit.png", ["alt" => "Edit",'url' => ['controller' => 'publications', 'action' => 'edit_admin',  $publication->id],
'data-static'=>'../img/admin/admin_edit.png','data-hover'=>'../img/admin/admin_edit.gif','class'=>'hover-gif','style'=>'width=50px']); 
?>
<a href="#" onclick="preguntarSiNo(<?php echo $publication->id ?>)">
<?php echo $this->Html->image("admin/admin_delete.png", ["alt" => "imagen_reset",'data-static'=>'../img/admin/admin_delete.png','data-hover'=>'../img/admin/admin_delete.gif','class'=>'hover-gif','style'=>'width=50px']); ?>
</a>

</td>
</tr>
<?php endforeach; ?>
</tbody> 
</table>
<?php // $this->Form->submit('Guardar Cambios',['id'=>'buttonsearch']);  $this->Form->end() ?>
</div><!-- end of .tab_container -->
<div class="pagination">
<ul>
<?php
echo $this->Paginator->prev(__('Anterior'), array('tag' => 'li'), null, array('tag' => 'li','disabledTag' => 'a'));
echo $this->Paginator->numbers(array('separator' => '','currentTag' => 'a', 'currentClass' => 'active','tag' => 'li','first' => 1));
echo $this->Paginator->next(__('Siguiente'), array('tag' => 'li','currentClass' => 'disabled'), null, array('tag' => 'li','disabledTag' => 'a'));
?>
</ul>
<div class="total">
<?php echo $this->Paginator->counter('{{count}} Total'); ?>
</div>
</div>

<div class="modal fade" id="enlargeImageModal" tabindex="-1" role="dialog" aria-labelledby="enlargeImageModal" aria-hidden="true">
<div class="modal-dialog modal-lg" role="document">
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
</div>
<div class="modal-body">       
<img src="" class="enlargeImageModalSource2" style="width: 100%;">       
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
var myBaseUrlsdelete = '<?php echo \Cake\Routing\Router::url(array('controller' => 'Publications', 'action' => 'delete_admin')); ?>';
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
    "¿Esta seguro de eliminar esta publicación?",
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
$('.enlargeImageModalSource2').attr('src',res);
$('#enlargeImageModal').modal('show');
});
});
</script>
<?php
//echo $this->Html->css('bootstrap.min');
echo $this->Html->script('bootstrap'); 
?>
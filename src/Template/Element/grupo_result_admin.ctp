<style>
.grupo_img{
    width: 150px;
  height: 75px;
  object-fit: contain;
}
</style>

<div>	
<div id="tab1" class="tab_content">
<table class="tablesorter"> 
<thead> 
<tr>
<th class=colcenter><?= $this->Paginator->sort('id','Imagen') ?></th>
<th class=colcenter><?= $this->Paginator->sort('id','Nro') ?></th>
<th><?= $this->Paginator->sort('nombre','Nombre') ?></th>
<th class=colcenter><?= $this->Paginator->sort('grupos_tipos_id','Tipo') ?></th>
<th class=colcenter><?= $this->Paginator->sort('orden','Orden') ?></th>
<th class="actions"><?= __('') ?></th>
</tr>
</thead>
<tbody>
<?php $indice=0; foreach ($grupos as $grupo): ?>
<?php echo '<tr id="trBody' . $grupo['id'] . '">'; ?>
  
<td class=colcenter>
<?php 
  if ($grupo['grupos_tipos_id']!=11 && $grupo['grupos_tipos_id']!=12)
  $uploadPath = 'grupos/';
else
  $uploadPath = 'logos/';
 
if ($grupo['imagen'] !=null)
{
  $filename = WWW_ROOT . 'img' . DS .$uploadPath.$grupo['imagen'] ;						
  if (file_exists($filename))
  echo $this->Html->image($uploadPath.$grupo['imagen'], ['alt' => str_replace('"', '','NO TIENE'),'class' => 'grupo_img']); 
}
else
   echo $this->Html->image('sin_logo_marca.png',['class' => 'grupo_img']); 
?> 
</td>
<td class=colcenter><?= $this->Number->format($grupo->id) ?></td>
<td><?= $grupo->nombre ?></td>
<td class=colcenter>
<?php echo $grupostipos[$grupo->grupos_tipos_id];?>
</td>
<td class=colcenter>
<?php echo $grupo->orden?>
</td>
<td class="actions">
<?php
echo $this->Html->image("admin/admin_edit.png", ["alt" => "Edit",'url' => ['controller' => 'grupos', 'action' => 'edit_admin',  $grupo->id],
'data-static'=>'../img/admin/admin_edit.png','data-hover'=>'../img/admin/admin_edit.gif','class'=>'hover-gif','style'=>'width=50px']); 
?>
<a href="#" onclick="preguntarSiNo(<?php echo $grupo->id ?>)">
<?php echo $this->Html->image("admin/admin_delete.png", ["alt" => "imagen_reset",'data-static'=>'../img/admin/admin_delete.png','data-hover'=>'../img/admin/admin_delete.gif','class'=>'hover-gif','style'=>'width=50px']); ?>
</a>

</td>
</tr>
<?php endforeach; ?>
</tbody> 
</table>


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
</div>	
<?php 
echo $this->Html->image("admin/admin_up.png", ["alt" => "Edit",'id'=>'scrollToTopBtn',/*'class'=>'scroll-to-top',*/
'data-static'=>'../webroot/img/admin/admin_up.png','data-hover'=>'../webroot/img/admin/admin_up.gif','class'=>'hover-gif','style'=>'width=50px']);
?>
<script>
  var myBaseUrlsdelete = '<?php echo \Cake\Routing\Router::url(array('controller' => 'Grupos', 'action' => 'delete_admin')); ?>';

  function eliminarDatos(id) {


    $.ajax({
      type: "post",
      url: myBaseUrlsdelete,
      data: "id=" + id,
      dataType: "json",
      success: function(data, response) {
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
      "¿Esta seguro de eliminar esta noticia/comunicado?",
      function() {
        eliminarDatos(id);
      },
      function() {
        alertify.error("Se cancelo la operación");
      }
    );
  }

$(function() {
$('.imgFoto').on('click', function() {
var str = $(this).attr('src');

var a = new XMLHttpRequest;
a.open("GET", str, false);
a.send(null);
if (a.status === 404){
var str = $(this).attr('src');
//var res = res.replace("foto.png", "productos/"+$(this).data("id"));
}			
//var res =  $(this).attr('src');
$('.enlargeImageModalSource').attr('src',str);
$('#enlargeImageModal').modal('show');
});
});


</script>

<?php echo $this->Html->script('bootstrap'); ?>



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
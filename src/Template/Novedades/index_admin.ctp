<style>
.input_date_input_search_i{ padding: 5px;}
.form_search {    display: flex;    justify-content: center;    align-items: center;    margin: 0 auto;     padding-top: 20px;   padding-bottom: 20px;    flex-wrap: wrap; }
.input_date_search,.input_text_search,.submit_link_2 {    display: flex;    flex-direction: row;    align-items: center;    /* Espacio entre los elementos */}
.input_date_input_search_i {    width: 120px;padding: 10px;}
.submit_link_2 {    margin-left: 10px; padding:0;}
#fechadesde, #fechahasta {     padding: 10px;}
#button_search{    height: 39px;}
.tablesorter td { border-left: 1px dotted #ccc;}
.header{ text-align: center;}
.colcenter{ text-align: center;}
</style>
<article class="module width_4_quarter">
  <header>
    <h3 class="tabs_involved"><?= $titulo ?></h3>
    <div class="tabs_bt_nuevo">
      <?= $this->Html->image("admin/icn-nuevo.png", ["alt" => "Nuevo", 'url' => ['controller' => 'Novedades', 'action' => 'add_admin']]); ?>
    </div>
  </header>

<div class="form_search">
<?= $this->Form->create('', ['url' => ['controller' => 'Novedades', 'action' => 'index_admin'], 'id' => 'searchform4']); ?>
<div class="input_date_search">
<div class="input_date_input_search">
<?= $this->Form->input('fechadesde', ['label' => '', 'id' => 'fechadesde','class'=>'input_date_input_search_i', 'name' => 'fechadesde', 'type' => 'text', 'placeholder' => 'Fecha Desde:']); ?>
</div>
<div class="input_date_input_search">
<?= $this->Form->input('fechahasta', ['label' => '', 'id' => 'fechahasta','class'=>'input_date_input_search_i', 'name' => 'fechahasta', 'type' => 'text', 'placeholder' => 'Fecha Hasta:']) ?>
</div>
</div>
<div class="input_text_search">
<div class="input_date_input_search">
<?= $this->Form->input('termino', ['class'=>'input_date_input_search_i', 'label' => '', 'type' => 'text', 'placeholder' => 'Buscar Producto']); ?>
</div>
</div>
<div class="input_text_search">
<div class="input_date_input_search">
<select name="categoria" class="input_date_input_search_i" >
<?php foreach ($categorias as $id => $nombre): ?>
<option value="<?= h($id) ?>"><?= h($nombre) ?></option>
<?php endforeach; ?>
</select>
</div>
</div>
<div class=submit_link_2>
<?= $this->Form->submit('Buscar', ['class' => 'submit_link', 'id' => 'button_search']); ?>
</div>
<?= $this->Form->end() ?>
</div>

  <div class="tab_container">
    <div class="paginationtop">
      <ul>
        <?php
        echo $this->Paginator->prev(__('Ant'), array('tag' => 'li'), null, array('tag' => 'li', 'disabledTag' => 'a'));
        echo $this->Paginator->numbers(array('separator' => '', 'currentTag' => 'a', 'currentClass' => 'active', 'tag' => 'li', 'first' => 1));
        echo $this->Paginator->next(__('Sig'), array('tag' => 'li', 'currentClass' => 'disabled'), null, array('tag' => 'li', 'disabledTag' => 'a')); ?>
      </ul>
    </div>
    <div id="tab1" class="tab_content">
      <table class="tablesorter" cellspacing="0">
        <thead>
          <tr>
            <th><?= $this->Paginator->sort('id', 'Imagen') ?> </th>
            <th><?= $this->Paginator->sort('id', 'Info') ?> </th>
            <th class="header"><?= $this->Paginator->sort('titulo') ?></th>
            <th class="center"><?= $this->Paginator->sort('categorias_novedades_id','Categoria') ?></th>
            <th class="header"><?= $this->Paginator->sort('tipo') ?></th>
            <th class="header"><?= $this->Paginator->sort('fecha') ?></th>
            <th class="header"><?= $this->Paginator->sort('activo') ?></th>
            <th class="header"><?= $this->Paginator->sort('interno', 'Interna') ?></th>
            <th class="header"><?= __('Acciones') ?></th>
          </tr>
        </thead>
        <tbody>
        <?php
              
              // Función para formatear el tamaño del archivo en KB, MB, etc.
              function formatoTamano($bytes) {
                  $unidades = ['B', 'KB', 'MB', 'GB', 'TB'];
                  $potencia = floor(($bytes ? log($bytes) : 0) / log(1024));
                  $potencia = min($potencia, count($unidades) - 1);
                  $bytes /= pow(1024, $potencia);

                  return round($bytes, 2) . ' ' . $unidades[$potencia];
              }
              ?>
          <?php foreach ($novedades as $novedade): ?>
            <?php echo '<tr id="trBody' . $novedade['id'] . '">'; ?>
            
              <?php $uploadPath = 'novedades/';
              if ($novedade['img_file'] != "" and $novedade['img_file'] != null)
                if ($novedade['archivopdf'] > 0) {
                  $filename = $uploadPath . 'imagen_pdf.png';
                } else {
                  $filename = $uploadPath . $novedade['img_file'];
                  $fileurl = WWW_ROOT . 'img' . DS .  $filename;
                }
              else {
                $filename = $uploadPath . 'sinimagen.png';
                $fileurl = WWW_ROOT . 'img' . DS .  $filename;
              }
              if (file_exists($fileurl))
              {
                $tamanoArchivo = filesize($fileurl);
                echo '<td class=colcenter>'.$this->Html->image($filename, ['class'=>'imgFoto','alt' => str_replace('"', '', $novedade['titulo']), 'height' => 80]).'</td>';
                $informacionImagen = getimagesize($fileurl);

                

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
                echo '<td class=colcenter>'.$this->Html->image($uploadPath . 'sinimagen.png').'</td><td></td>'; ?>


            <td><?= h($novedade->titulo) ?></td>
            <td class=colcenter style="width: 100px;"><?php echo $categorias[$novedade->categorias_novedades_id] ?></td>
            <td class=colcenter style="width: 70px;"><?= h($novedade->tipo) ?></td>
            <td class=colcenter style="width: 70px;"><?= h($novedade->fecha) ?></td>
            <td class=colcenter><?php if ($novedade->activo > 0)  echo 'SI';
                else echo 'NO'; ?></td>
            <td class=colcenter><?php if ($novedade->interno > 0) echo 'SI';
                else echo 'NO'; ?></td>
            <td class=colcenter style="width: 170px;">


            <?php

            echo $this->Html->image("admin/admin_view.png", ["alt" => "View",'url'=>['controller' => 'novedades', 'action' => 'view_admin',  $novedade['id']],'escape' => false,'target'=>'_blank',
            'data-static'=>'../img/admin/admin_view.png','data-hover'=>'../img/admin/admin_view_i.gif','class'=>'hover-gif','style'=>'width=50px']);
            
            echo $this->Html->image("admin/admin_edit.png", ["alt" => "Edit",'url' => ['controller' => 'novedades', 'action' => 'edit_admin',  $novedade->id],
            'data-static'=>'../img/admin/admin_edit.png','data-hover'=>'../img/admin/admin_edit.gif','class'=>'hover-gif','style'=>'width=50px']);
            /*echo $this->Html->image("admin/admin_delete.png", ["alt" => "imagen_reset",'url' => ['controller' => 'Articulos', 'action' => 'imagenreset',  $novedade->id],'data-static'=>'../img/admin/admin_delete.png','data-hover'=>'../img/admin/admin_delete.gif','class'=>'hover-gif','style'=>'width=50px']);
            $downloadUrl= '/img/productos/big_'.$novedade->imagen;*/
            
            ?>
              <a href="#" onclick="preguntarSiNo(<?php echo $novedade->id ?>)"><?php 
             
              echo $this->Html->image("admin/admin_delete.png", ["alt" => "imagen_reset",'data-static'=>'../img/admin/admin_delete.png','data-hover'=>'../img/admin/admin_delete.gif','class'=>'hover-gif','style'=>'width=50px']);
              ?>
            </a>
            </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div><!-- end of #tab1 -->
  </div><!-- end of .tab_container -->
  <div class="pagination">
    <ul>
      <?php
      echo $this->Paginator->prev(__('Ant'), array('tag' => 'li'), null, array('tag' => 'li', 'disabledTag' => 'a'));
      echo $this->Paginator->numbers(array('separator' => '', 'currentTag' => 'a', 'currentClass' => 'active', 'tag' => 'li', 'first' => 1));
      echo $this->Paginator->next(__('Sig'), array('tag' => 'li', 'currentClass' => 'disabled'), null, array('tag' => 'li', 'disabledTag' => 'a'));
      ?>
    </ul>
    <div class="total">
      <?php
      echo $this->Paginator->counter('{{count}} Total');
      ?>
    </div>
  </div>

</article><!-- end of content manager article -->
<div class="modal fade" id="enlargeImageModal" tabindex="-1" role="dialog" aria-labelledby="enlargeImageModal" aria-hidden="true">
<div class="modal-dialog modal-lg" role="document">
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
</div>
<div class="modal-body">       
<img src="" class="enlargeImageModalSource" style="width: 100%;">       
</div>
</div>
</div>
</div>
<?php 
echo $this->Html->image("admin/admin_up.png", ["alt" => "Edit",'id'=>'scrollToTopBtn',/*'class'=>'scroll-to-top',*/
'data-static'=>'../img/admin/admin_up.png','data-hover'=>'../img/admin/admin_up.gif','class'=>'hover-gif','style'=>'width=50px']);
?>
<script>
  var myBaseUrlsdelete = '<?php echo \Cake\Routing\Router::url(array('controller' => 'Novedades', 'action' => 'delete_admin')); ?>';

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
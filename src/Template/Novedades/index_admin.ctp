<article class="module width_3_quarter">
<header><h3 class="tabs_involved"><?= $titulo ?></h3>
<div class="tabs_bt_nuevo">
		<?= $this->Html->image("admin/icn-nuevo.png", ["alt" => "Nuevo",'url' => ['controller' => 'Novedades', 'action' => 'add_admin']]);?>
		</div>
</header>
<div class="form_search">
<?= $this->Form->create('',['url'=>['controller'=>'Novedades','action'=>'index_admin'],'id'=>'searchform4']); ?>
<div class="input_date_search">
<div class="input_date_input_search">
<?= $this->Form->input('fechadesde', ['label'=>'','id'=>'fechadesde','name'=>'fechadesde', 'type'=>'text','placeholder'=>'Fecha Desde:']);?>
</div>
<div class="input_date_input_search">
<?=	$this->Form->input('fechahasta', ['label'=>'','id'=>'fechahasta','name'=>'fechahasta', 'type'=>'text','placeholder'=>'Fecha Hasta:'])?>
</div>
</div>
<div class="input_text_search">
<?= $this->Form->input('termino', ['class'=>'terminobusqueda','label'=>'','type'=>'text' ,'placeholder'=>'Buscar Producto']); ?>
</div>

<div>
<?= $this->Form->submit('Buscar',['class'=>'submit_link','id'=>'button_search']); ?>
</div>
<?= $this->Form->end() ?>
</div>

<div class="tab_container">
<div class="paginationtop">
        <ul>
		<?php
		echo $this->Paginator->prev(__('Anterior'), array('tag' => 'li'), null, array('tag' => 'li','disabledTag' => 'a'));
		echo $this->Paginator->numbers(array('separator' => '','currentTag' => 'a', 'currentClass' => 'active','tag' => 'li','first' => 1));
		echo $this->Paginator->next(__('Siguiente'), array('tag' => 'li','currentClass' => 'disabled'), null, array('tag' => 'li','disabledTag' => 'a'));?>
        </ul>
		</div>
<div id="tab1" class="tab_content">
<table class="tablesorter" cellspacing="0"> 
<thead> 
<tr>
<th><?= $this->Paginator->sort('id','Imagen') ?> </th>
<th class="header"><?= $this->Paginator->sort('titulo') ?></th>
<th class="header"><?= $this->Paginator->sort('tipo') ?></th>
<th class="header"><?= $this->Paginator->sort('fecha') ?></th>
<th class="header"><?= $this->Paginator->sort('activo') ?></th>
<th class="header"><?= $this->Paginator->sort('interno','Interna') ?></th>
<th class="actions"><?= __('Acciones') ?></th>
</tr>
</thead>
<tbody>
<?php foreach ($novedades as $novedade): ?>
<?php echo '<tr id="trBody' . $novedade['id'] . '">';?> 
<td>
<?php $uploadPath = 'novedades/';
if ($novedade['img_file']!="" and $novedade['img_file']!=null)
if ($novedade['archivopdf']>0) { $filename = $uploadPath.'imagen_pdf.png'; }	
else {
$filename = $uploadPath.$novedade['img_file'] ;
$fileurl = WWW_ROOT . 'img' . DS .	$filename;
}
else {
$filename = $uploadPath.'sinimagen.png';
$fileurl = WWW_ROOT . 'img' . DS .	$filename;		
}
if (file_exists($fileurl))
echo $this->Html->image($filename, ['alt' => str_replace('"', '', $novedade['titulo']),'height' => 70]);
else
echo $this->Html->image($uploadPath.'sinimagen.png'); ?>	
</td>
<td><?= h($novedade->titulo) ?></td>
<td><?= h($novedade->tipo) ?></td>
<td><?= h($novedade->fecha) ?></td>
<td><?php if ($novedade->activo>0)  echo 'SI'; else echo 'NO';?></td>
<td><?php if ($novedade->interno>0) echo 'SI'; else echo 'NO';?></td>
<td class="actions">
<?= $this->Html->image("admin/icn_edit.png", ["alt" => "Edit",'url' => ['controller' => 'novedades', 'action' => 'edit_admin',  $novedade->id]]);?>
<?= $this->Html->image("admin/icn_view.png", ["alt" => "Ver",'url' => ['controller' => 'novedades', 'action' => 'view_admin',  $novedade->id]]);?>
<a href="#" onclick="preguntarSiNo(<?php echo $novedade->id ?>)"><?php echo $this->Html->image('admin/icn_trash.png');?></a>
</td>
</tr>
<?php endforeach; ?>
</tbody> 
</table>
</div><!-- end of #tab1 -->
</div><!-- end of .tab_container -->
<div class="pagination">
<ul >
<?php
echo $this->Paginator->prev(__('Anterior'), array('tag' => 'li'), null, array('tag' => 'li','disabledTag' => 'a'));
echo $this->Paginator->numbers(array('separator' => '','currentTag' => 'a', 'currentClass' => 'active','tag' => 'li','first' => 1));
echo $this->Paginator->next(__('Siguiente'), array('tag' => 'li','currentClass' => 'disabled'), null, array('tag' => 'li','disabledTag' => 'a'));
?>
</ul>
<div class="total">
<?php
echo $this->Paginator->counter('{{count}} Total');
?>
</div>
</div>
</article><!-- end of content manager article -->

<script>		
var myBaseUrlsdelete = '<?php echo \Cake\Routing\Router::url(array('controller' => 'Novedades', 'action' => 'delete_admin')); ?>';
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
    "¿Esta seguro de eliminar esta noticia/comunicado?",
    function () {
      eliminarDatos(id);
    },
    function () {
      alertify.error("Se cancelo la operación");
    }
  );
}</script>
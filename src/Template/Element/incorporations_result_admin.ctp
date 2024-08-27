<div>	
<div id="tab1" class="tab_content">
<?= $this->Form->create('Incorporations',['url'=>['controller'=>'Incorporations','action'=>'edit_incorporation_admin']]); ?>
<table class="tablesorter"> 
<thead> 
<tr>
<th><?= $this->Paginator->sort('id','Imagen') ?></th>
<th><?= $this->Paginator->sort('id','Nro') ?></th>
<th><?= $this->Paginator->sort('descripcion','Descripción') ?></th>
<th><?= $this->Paginator->sort('fecha_desde') ?></th>
<th><?= $this->Paginator->sort('fecha_hasta') ?></th>
<th><?= $this->Paginator->sort('incorporations_tipos_id') ?></th>
<th><?= $this->Paginator->sort('habilitada','Activa') ?></th>
<th class="actions"><?= __('') ?></th>
</tr>
</thead>
<tbody>
<?php $indice=0; foreach ($incorporations as $incorporation): ?>
<?php echo '<tr id="trBody' . $incorporation['id'] . '">';?> 
<td>
<?php 
$uploadPath = 'incorporations/';
switch ($incorporation['incorporations_tipos_id']) {

	case 1:
        $uploadPath = $uploadPath.'selectivas/' ;
        break;
    case 2:
        $uploadPath = $uploadPath.'semiselectivas/' ;
        break;
    case 3:
        $uploadPath = $uploadPath.'dermo/' ;
        break;
    case 4:
        $uploadPath = $uploadPath.'makeup/' ;
        break;
    case 5:
        $uploadPath = $uploadPath.'solares/' ;
        break;
    case 6:
        $uploadPath = $uploadPath.'perfumerias/' ;
        break;
    case 7:
        $uploadPath = $uploadPath.'patagonia/' ;
        break;
    case 8:
            $uploadPath = $uploadPath.'nutricion/' ;
            break;
    case 9:
                $uploadPath = $uploadPath.'expovirtual/' ;
                break;
}
$filename = WWW_ROOT . 'img' . DS .$uploadPath.$incorporation['imagen'] ;						
if (file_exists($filename))
echo $this->Html->image($uploadPath.$incorporation['imagen'], ['alt' => str_replace('"', '', $incorporation['descripcion']),'height' => 120]);
//else
//echo $uploadPath.$incorporation['imagen'];	
?> 
</td>
<td><?= $this->Number->format($incorporation->id) ?></td>
<td><?= $incorporation->descripcion ?></td>
<td><?php echo date_format($incorporation->fecha_desde,'d-m-Y');?></td>
<td><?php echo date_format($incorporation->fecha_hasta,'d-m-Y');?></td>
<td><?= $incorporationstipos[$incorporation->incorporations_tipos_id-1]['nombre'] ?></td>
<td><?php /*if($incorporation->habilitada==1)
echo "SI";
else
echo "NO"*/
?>
<?php 
$indice+=1;
$encabezado = $indice.'.';
echo $this->Form->input($encabezado.'id',['type'=>'hidden','value'=> $incorporation->id]);
$habilitada = $incorporation->habilitada;
echo $this->Form->input($encabezado.'habilitada', ['tabindex'=>$indice,'label'=>'','type'=>'checkbox','checked'=>$habilitada]); ?>
</td>
<td class="actions">
<?=	$this->Html->image("admin/icn_edit.png", ["alt" => "Edit",'url' => ['controller' => 'incorporations', 'action' => 'edit_admin',  $incorporation->id]]);?>
<a href="#" onclick="preguntarSiNo(<?php echo $incorporation->id ?>)"><?php echo $this->Html->image('admin/icn_trash.png');?></a>
</td>
</tr>

<?php endforeach; ?>
</tbody> 
</table>

<?= $this->Form->submit('Guardar Cambios',['id'=>'buttonsearch']); ?>
<?= $this->Form->end() ?>

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
<script>		
var myBaseUrlsdelete = '<?php echo \Cake\Routing\Router::url(array('controller' => 'Incorporations', 'action' => 'delete_admin')); ?>';
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
    "¿Esta seguro de eliminar esta Incorporación?",
    function () {
      eliminarDatos(id);
    },
    function () {
      alertify.error("Se cancelo la operación");
    }
  );
}</script>
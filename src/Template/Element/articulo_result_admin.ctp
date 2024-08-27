<div>
<div>
<!--?= $this->Form->create('Articulos',['url'=>['controller'=>'Articulos','action'=>'imagenesreset']]); ?-->
<table class="tablesorter">    
<thead>
<tr>	
<th class=centrado>Img</th>
<th class=centrado><?= $this->Paginator->sort('descripcion_pag','Descripción') ?></th>
<th class=centrado><?= $this->Paginator->sort('categoria_id') ?></th>
<th class=centrado><?= $this->Paginator->sort('codigo_barras') ?></th>
<th class=centrado><?= $this->Paginator->sort('troquel') ?></th>
<th class=centrado><?= $this->Paginator->sort('clave_amp') ?></th>
<th class=centrado><?= $this->Paginator->sort('precio_publico','P.Farmacia') ?></th>
<th class=centrado><?= $this->Paginator->sort('precio_publico','P.Publico') ?></th>
<th class=centrado><?= $this->Paginator->sort('stock_fisico','Stock Unid') ?></th>
<th class=centrado><?= $this->Paginator->sort('posicion','Posición') ?></th>
<th class=centrado><?= $this->Paginator->sort('fecha_alta','F.ALTA') ?></th>
<th class=centrado></th>
</tr>
</thead>
<tbody>
<?php $i=1; ?>
<?php foreach ($articulos as $articulo): ?>
<?php  $encabezado = $i."."; 

$codigo_barras = $articulo->codigo_barras;

$url_producto = "https://www.drogueriasur.com.ar/ds/carritos/search_i/" . urlencode($codigo_barras);

// Generar la URL de WhatsApp con el mensaje y la URL del producto
$url_producto_whatsapp = "https://web.whatsapp.com/send?text=" . urlencode("¡Echa un vistazo a este producto! " . $url_producto);
?>
<tr>
<td class=col_img>
<?php
echo $this->Html->image('productos/'.$articulo['imagen'], ['alt' => str_replace('"', '', $articulo['descripcion']),'height' => 100, 'class'=>'imgFoto']);
//echo $this->Form->input('id',['type'=>'hidden','value'=>$articulo->id]);
?>
</td>
<td><?php 
echo '<div class=descripcionpag>'.$articulo->descripcion_pag .'</div>';
if ($articulo->descripcion_pag != $articulo->descripcion_sist)
echo '<br>'.$articulo->descripcion_sist;

?></td>
<td class=centrado>
<?php echo '<div class=descripcionpag>'.$articulo['categoria']['nombre'].'</div>';
if ($articulo['subcategoria']!=null){ 
echo '<br><div>'.$articulo['subcategoria']['nombre'].'</div>';
}
?>
</td>
<td class=centrado><?= h($articulo->codigo_barras) ?></td>
<td class=centrado><?= h($articulo->troquel) ?></td>
<td class=centrado><?= h($articulo->clave_amp) ?></td>
<td class='colprecio'><?php echo '$ '.number_format(round(h($articulo->precio_publico) * 0.807, 3), 2,',','.'); ?></td>
<td class='colprecio'><?php echo '$ '.number_format(h($articulo->precio_publico) , 2,',','.');?></td>
<td class=centrado><?php
switch ($articulo['stock']) {
case 'B': echo $this->Html->image('bajo.png',['title' => 'Stock Bajo, Consultar Operadora'] );	break;
case 'F': echo $this->Html->image('falta.png',['title' => 'Producto en Falta']);				break;
case 'S': echo $this->Html->image('alto.png',['title' => 'Stock Habitual']);					break;
case 'R': echo $this->Html->image('restrin.png',['title' => 'Producto sujeto a stock']);		break;
case 'D': echo $this->Html->image('descont.png',['title' => 'Producto Discontinuo']);			break;
}
?>
<div class =col_stock_fisico><?php  echo '<br>'.$articulo->stock_fisico; ?></div>
</td>
<td class=centrado><?php echo $articulo->posicion ?></td>
<td class=centrado><?php 
if ($articulo->fecha_alta!=null) 
echo date_format($articulo->fecha_alta ,'d-m-Y');
?></td>

<!-- td class=centrado>
<?php 
//echo $this->Form->input($encabezado.'id',['type'=>'hidden','value'=>$articulo->id]);
//echo $this->Form->input($encabezado.'eliminado', ['tabindex'=>$i+1,'label'=>'','type'=>'checkbox','checked'=>0]); 
?>
</td -->
<td class=col_actions>    
<?php
echo $this->Html->image("admin/admin_edit.png", ["alt" => "Edit",'url' => ['controller' => 'Articulos', 'action' => 'edit_admin',  $articulo->id],
'data-static'=>'../img/admin/admin_edit.png','data-hover'=>'../img/admin/admin_edit.gif','class'=>'hover-gif','style'=>'width=50px']);
echo $this->Html->image("admin/admin_delete.png", ["alt" => "imagen_reset",'url' => ['controller' => 'Articulos', 'action' => 'imagenreset',  $articulo->id],'data-static'=>'../img/admin/admin_delete.png','data-hover'=>'../img/admin/admin_delete.gif','class'=>'hover-gif','style'=>'width=50px']);
$downloadUrl= '/img/productos/big_'.$articulo->imagen;

echo $this->Html->link(
    $this->Html->image("admin/admin_down.png", [
        "alt" => "DOWNLOAD",
        "class" => "hover-gif",'data-static'=>'../img/admin/admin_down.png','data-hover'=>'../img/admin/admin_down.gif',
        "style" => "width:50px;"
    ]),
    $downloadUrl,
    [
        'escape' => false,
        'download' => 'big_'.$articulo->imagen // Especifica el nombre de la imagen para la descarga
    ]
    //['escape' => false, 'download' => true] // 'escape' => false para permitir HTML dentro del enlace
);

?>
<a href="https://web.whatsapp.com/send?text=<?php echo urlencode('https://drogueriasur.com.ar/dsx/compartir/index/'.$articulo->codigo_barras.'/'.urlencode($articulo->descripcion_pag).'') ;?>"  target="_blank"> 
<?php echo $this->Html->image('admin/admin_compartir.png',['title' => 'Comaprtir','data-static'=>'../img/admin/admin_compartir.png','data-hover'=>'../img/admin/admin_compartir.gif','class'=>'hover-gif',]); ?>	</a> 
</td>
</tr>
<?php $i=$i+1; endforeach; ?>
</tbody>
</table>
</div>
<!--?= $this->Form->submit('Resetear Imagenes',['id'=>'buttonsearch']); ?-->
<!--?= $this->Form->end() ? -->
<div class="pagination">
<ul>
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
</div>
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
<script type="text/javascript">
$("tr").not(':first').hover(
function() {
$(this).css("background","#8FA800");
}, 
function() {
$(this).css("background","");
}
);
</script>
<script>
$(function() {
$('.imgFoto').on('click', function() {
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
$('.enlargeImageModalSource').attr('src',res);
$('#enlargeImageModal').modal('show');
});
});
document.addEventListener('DOMContentLoaded', function() {
    const gifs = document.querySelectorAll('.hover-gif');
    
    gifs.forEach(function(gif) {
        gif.addEventListener('mouseover', function() {
            this.src = this.getAttribute('data-hover');
        });
        
        gif.addEventListener('mouseout', function() {
            this.src = this.getAttribute('data-static');
        });
    });
});
</script>
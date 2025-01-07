<?php //><script type="text/javascript">
$previous = "javascript:history.go(-1)";
if(isset($_SERVER['HTTP_REFERER'])) {
$previous = $_SERVER['HTTP_REFERER'];
}
?>
<div class="col-md-3">
<div class="product-item-3"> 
<div class="product-content">
<div class="row">

<div class="col-md-12 col-sm-12">
<div class= div_cliente_info>
<div class='cliente_info_titulo'>
<span class=cliente_info_span>Buscar Factura</span>

</div> <div><a href="<?= $previous ?>"><?php echo $this->Html->image('icn_volver.png');?></a></div>
</div>
<?php echo $this->element('searchfactura'); ?>
</div> <!-- /.col-md-12 -->
</div> <!-- /.row -->
</div> <!-- /.product-content -->	

</div> <!--.product-item-1 -->  

<div class="product-item-3"> 
<div class="product-content">
<div class="row">
<div class="col-md-12 col-sm-12">
<?php 
if (!empty($facturasCabecera))
{
echo '<span class=cliente_info_span>FACTURA</span>';
echo $this->element('comprobante_view_encabezado'); 
}	
?>
</div> <!-- /.col-md-12 -->
</div> <!-- /.row -->
</div> <!-- /.product-content -->	
<div class="product-content">
<div class="row">

<div class="col-md-12 col-sm-12">
<?php 
echo '<span class=cliente_info_span>DESCARGAS</span>';

echo '<div class=div_descarga>';
echo '<div class=div_descarga_line>';
echo '<div class=div_descarga_label>Comprobante PDF</div>';
echo '<div class=div_descarga_icon>'.$this->Html->image('icon_down_pdf2.png',['title' => 'Descargar PDF','url'=>['controller'=>'Comprobantes','action' => 'downloadfile', $facturasCabecera->pedido_ds, 1,date_format($facturasCabecera->fecha,'Ymd')]]).'</div>'; 
echo '</div>';

echo '<div class=div_descarga_line>';
echo '<div class=div_descarga_label>Archivo TXT V1</div>';
echo '<div class=div_descarga_icon>'.$this->Html->image('icon_down_txt2_v1.png',['title' => 'Descargar TXT v1','url'=>['controller'=>'Comprobantes','action' => 'downloadfiletxt', $facturasCabecera->pedido_ds,date_format($facturasCabecera->fecha,'Y-m-d')]]).'</div>';
echo '</div>';

echo '<div class=div_descarga_line>';
echo '<div class=div_descarga_label>Archivo TXT V2/vctos</div>';
echo '<div class=div_descarga_icon>'.$this->Html->image('icon_down_txt2_v2.png',['title' => 'Descargar TXT v2','url'=>['controller'=>'Comprobantes','action' => 'downloadfiletxt2', $facturasCabecera->pedido_ds,date_format($facturasCabecera->fecha,'Y-m-d')]]).'</div>'; 

echo '</div>';
echo '</div>';
?>

</div> <!-- /.col-md-12 -->
</div> <!-- /.row -->
</div> <!-- /.product-content -->	
</div> <!--.product-item-1 -->  
</div> <!-- /.col-md-3 -->

<div class="col-md-9">
<div class="product-item-3">
<?php //if ($this->request->session()->read('Auth.User.perfile_id')==1): ?>
<div class="product-content">
<div class="row">
<?php 
if (!empty($facturasCuerposItems))
{
echo '<span class=cliente_info_span>Cuerpo de la Factura</span></br>';
echo $this->element('comprobante_view_items');
echo '<br>';
}	
?>
</div> <!-- /.product-item -->
</div> <!-- /.col-md-3 -->
</div>
</div>



<div class="col-md-9">
<div class="product-item-3">
<div class="product-content">
<div class="row">

<?php 
$nombreArchivo= 'FACT01';
$nota = str_pad($facturasCabecera['pedido_ds'], 6, '0', STR_PAD_LEFT);
$fecha = date_format($facturasCabecera->fecha,'Ymd');
if ($fecha>20170423)
$nota = $nota.$fecha;

$nombre_fichero = 'temp'. DS .'Comprobantes'. DS .$nombreArchivo.$nota.'.pdf';
if (file_exists($nombre_fichero)) {
    echo '<div class=div_comprobante_pdf><iframe src="https://docs.google.com/gview?url=https://www.drogueriasur.com.ar/ds/webroot/'.$nombre_fichero.'&embedded=true" style="width:95%; min-height:550px;" frameborder="0"></iframe></div>';
} else {
    echo '<div class=div_comprobante_pdf><iframe style="width:95%; min-height:550px;" frameborder="0"></iframe></div>';
}
?>
</div>
</div>
<?php //endif; ?>
</div> <!-- /.product-item -->
</div> <!-- /.col-md-9 -->


<style>
.div_descarga{width: 100%;display:table-row; }
.div_descarga_line{width: 100%; display: inline-flex; align-items: center; height: 40px; }
.div_descarga_label{width: 70%}
.div_descarga_icon{ width: 30%; text-align: center;}
.div_cliente_info{width: 100%; display: inline-flex;}
.cliente_info_titulo{width: 90%;}
.cliente_info_volver{width: 10%; }
.div_comprobante_pdf{display: flex;  justify-content: center;  align-items: center;}
</style>
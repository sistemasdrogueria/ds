<style>
.header_icon{
	float: right;	
	margin-right: 10px;
	margin-top: 5px;
}
.header_icon_delete{
float: left;
margin-top: 5px;
margin-left: 5px;
margin-right: 5px;
}
.header_icon_return{ 
	float: left;
}
#busqueda_sect{
   width: 400px;
}
</style>
<?php //><script type="text/javascript">
$previous = "javascript:history.go(-1)";
if(isset($_SERVER['HTTP_REFERER'])) {
    $previous = $_SERVER['HTTP_REFERER'];
}
?>
<div class="ofertas form large-10 medium-9 columns">
<article class="module width_3_quarter">
<header><h3 class="tabs_involved"><?= $titulo ?></h3>
<div class = header_icon> 
<div class="header_icon_delete">
<?php 
echo $this->Form->postLink(
$this->Html->image('admin/icn_trash.png',
["alt" => __('Delete'), "title" => __('Delete')]), 
['action' => 'delete_admin', $oferta->id], 
['escape' => false, 'confirm' => __('Esta seguro de eliminar a # {0}?', $oferta->id)]
);
?>
</div>
<div class="header_icon_return">
<?php echo $this->Html->image('admin/icn_volver.png', ['url' => $previous]);?>	</div>
</div>
</header>
<?= $this->Form->create($oferta, ['url'=>['controller'=>'Ofertas','action'=>'edit_admin'],'type' => 'file']) ?>
<fieldset>	
<div class=ofertainputdescripcion>
<?php echo $this->Form->input('descripcion'); ?>
</div>
</fieldset>	
<fieldset>				
<div class="ofertainputopcion">
<?php echo $this->Form->input('oferta_tipo_id', ['options' =>$ofertastipos, 'label'=>'TIPO DE OFERTA','style'=> 'padding: 2px;height:25px']);  ?>
</div>
<?php 
$oti= $oferta['oferta_tipo_id'];
if (($oti >1 && $oti<5) || $oti==11 ||$oti==7)
{
	echo "<div class=ofertainputopcion id=laboratorio_id >";
}
else
	echo "<div class=ofertainputopcion id=laboratorio_id style= 'display:none;'>";
?>
<?= $this->Form->input('laboratorio_id', ['label'=>'Laboratorio','options' => $laboratorios,'empty'=>'LABORATORIOS','style'=> 'padding: 2px;height:25px']);	?>	
</div>

<?php 
$oti= $oferta['oferta_tipo_id'];
if (($oti >1 && $oti<5) || $oti==11 ||$oti==7)
{
	echo "<div class=ofertainputopcion id=marca_id >";
}
else
	echo "<div class=ofertainputopcion id=marca_id style= 'display:none;'>";
?>
<?= $this->Form->input('marca_id', ['label'=>'Marca','options' => $marcas,'empty'=>'MARCAS','style'=> 'padding: 2px;height:25px']);	?>	
</div>



<?php 
if ($oti>3 &&  $oti<11)
{
	echo "<div class=ofertainputopcion id=busqueda_sect >";
}   
else
{
 echo "<div class=ofertainputopcion id=busqueda_sect style= 'display:none'>";
}
  

?>
<?= $this->Form->input('busqueda_sect', ['label'=>'Busqueda']);	?>
</div>
<div class="ofertainputopcion" style="width: 100px ; margin-right: 20px;">
<?= $this->Form->input('orden', ['label'=>'Orden', 'type'=>'text']);	?>	
</div>	
</fieldset>
<fieldset>	
<div class="ofertainputdescuento">
<?php	
echo $this->Form->input('articulo_id',['type'=>'hidden']);
echo $this->Form->input('codigo_barras',['type'=>'hidden']);
echo $this->Form->input('descuento_producto',['label'=>'DESCUENTO', 'type'=>'text']); ?>
</div>
<div class="ofertainputdescuento">
<?php echo $this->Form->input('unidades_minimas',['label'=>'Unid. Minimas', 'type'=>'text']);	?>
</div>
<div class="ofertainputdescuento">
<?php echo $this->Form->input('unidades_maximas',['label'=>'Unid. Maximas', 'type'=>'text']); ?>
</div>
<div class="ofertainputaplica">
<?php echo $this->Form->input('aplicaen',['value'=>1,'label'=>'APLICA EN', 'type'=>'text']); ?>
</div>
<div class="ofertainputfecha">
<?= $this->Form->input('fecha_desde', ['label'=>'Desde:','id'=>'fecha_desde','value'=>date_format($oferta['fecha_desde'],'d/m/Y') ,'name'=>'fecha_desde', 'type'=>'text','placeholder'=>'Fecha Desde:']);?>
</div>
<div class="ofertainputfecha">
<?=	$this->Form->input('fecha_hasta', ['label'=>'Hasta:','id'=>'fecha_hasta','value'=>date_format($oferta['fecha_hasta'],'d/m/Y'),'name'=>'fecha_hasta', 'type'=>'text','placeholder'=>'Fecha Hasta:']);?>
</div>
<div class="ofertainputaplica">
<?php	echo $this->Form->input('plazos');?>
</div>
</fieldset>		
<fieldset>	
	<div class="ofertainputfile">
<?php echo $this->Form->input('file',['type' => 'file','label'=>'Imagen']);  ?>

</div>
<div>Tamaño de la imagen 200px x 200px. Tipo .jpg </div>
</fieldset>		
<fieldset>	
<div class="ofertainputcheck">
<label for="activo" >Activo</label>	
<?php	echo $this->Form->checkbox('activo', ['hiddenField' => true,'checked'=>true]);?>
</div>	
<div class="ofertainputcheck">
<label for="activo" >Habilitada</label>	
<?php	echo $this->Form->checkbox('habilitada', ['hiddenField' => true,'checked'=>true]);?>
</div>	
</fieldset>
</div><div class="clear"></div>
<footer>

<div class="ofertainputbotton">
<?= $this->Form->button(__('GUARDAR')) ?>
</div>
<?= $this->Form->end() ?>
</footer>
</article> 

<script>
   document.getElementById("oferta-tipo-id").onchange = function(e) {
    if ((this.value >1 && this.value<5) || this.value==11 || this.value==7  ) 
    {
      var x = document.getElementById("laboratorio_id");

      var z = document.getElementById("marca_id");

      if (x.style.display === "none") {
         x.style.display = "block";
      } 
      if (z.style.display === "none") {
         z.style.display = "block";
      } 

      
    }
    if (this.value>3  && this.value<11)
     {
      var y = document.getElementById("busqueda_sect");
      if (y.style.display === "none") {
         y.style.display = "block";
      } 
   }

};

   </script>

<style>
.header_icon{ float: right; margin-right: 10px;	margin-top: 5px;}
.header_icon_delete{float: left;margin-top: 5px;margin-left: 5px;margin-right: 5px;}
.header_icon_return{ float: left;}
</style>
<?php //><script type="text/javascript">
$previous = "javascript:history.go(-1)";
if(isset($_SERVER['HTTP_REFERER'])) {
    $previous = $_SERVER['HTTP_REFERER'];
}
?>
<article class="module width_4_quarter">
<header><h3 class="tabs_involved"><?= $titulo ?></h3><div class = header_icon><div class="header_icon_return"><?php echo $this->Html->image('admin/icn_volver.png', ['url' => $previous]);?></div></div>    
</header>
<?= $this->Form->create('Publications', ['url'=>['controller'=>'Publications','action'=>'add_admin'],'type' => 'file']) ?>
<fieldset>	
<?php echo $this->Form->input('descripcion'); ?>
</fieldset>	
<fieldset>	
<div class="ofertainputfecha" style="margin-right: 20px;">
<?= $this->Form->input('fecha_desde', ['label'=>'Desde:','id'=>'fecha_desde','name'=>'fecha_desde', 'type'=>'text','placeholder'=>'Fecha Desde:']);?>
</div>
<div class="ofertainputfecha">
<?=	$this->Form->input('fecha_hasta', ['label'=>'Hasta:','id'=>'fecha_hasta','name'=>'fecha_hasta', 'type'=>'text','placeholder'=>'Fecha Hasta:','onchange'=>'javascript:document.confirmInput.submit();']);?>
</div>
</fieldset>		
<fieldset>				
<div style="width: 30% ; float: left;  margin-right: 20px;" >
<?php echo $this->Form->input('url_controlador'); ?>
<?php echo $this->Form->input('url_metodo'); ?>
<?php echo $this->Form->input('url_campo'); ?>
<?php echo $this->Form->input('url_campo2'); ?>
<?php echo $this->Form->input('localidad'); ?> 
<?php echo $this->Form->input('provincia_id',['options' =>$provincias,'value'=>0]); ?> 
</div>
<div style="width: 60% ; float: left">
<h1>INFO</h1>
<table>
<tr>
<td style="width: 50% ">Agregar producto al carro</td>
<td style="width: 50%">carritos => searchadd => EAN</td>
</tr>
<tr><td>Mostrar resultado de productos </td><td>carritos => search -> parámetro de búsqueda</td></tr>
<tr><td>Sur Sale  </td><td>carritos => sale</td></tr>
<tr><td>Preventas</td><td>carritos => enviarsolicitud => preventa</td></tr>
<tr><td>Para dirigir a una sección</td><td>nombre de sección -> método <br>EJ: ortopedias -> index</td></tr>
<tr><td>Localidad - Código postal</td><td>Solo se vera para esa CP</td></tr>

</table>
</div>
</fieldset>	
<fieldset style="text-align: center;"><div style="width: 45%; display: inline-block;"><?php echo $this->Form->control('laboratorio_id', ['options' => $laboratorios,'label'=>'', 'empty' => 'LABORATORIOS',]);?></div>
<div style="width: 45% ;display: inline-block;"><?php echo $this->Form->control('marca_id', ['options' => $marcas, 'empty'=>'MARCAS','label'=>'']);?></div> </fieldset>
<fieldset>				
<div style="width: 30%; float: left; margin-right: 20px;"><?php echo $this->Form->input('orden'); ?></div>
<div style="width: 30%; float: left"><?php //$ubicacion = array(); $ubicacion= [0=>'A determinar',1=>'AFUERA SLIDER',2=>'ADENTRO POP UP',3=>'CONFIRMAR PEDIDO POP UP',4=>'VER CARRO POP UP',5=>'IMPORTAR PEDIDO POP UP',6=>'BAJO EL CARRO INDEX',7=>'BAJO EL CARRO SEARCH',8=>'CUENTA CORRIENTE',9=>'EXPOSUR SLIDER',10=>'BAJO EL CARRO NUTRICION',11=>"PARTNER",12=>"SUR FRIDAY SALE"];
echo $this->Form->input('ubicacion', ['options' =>$publicationsTipos, 'value'=>2]);  ?> </div>
</fieldset>	
<fieldset>	
<div style="width: 60% ; float: left;  margin-right: 20px;">	
<?php echo $this->Form->input('file',['type' => 'file','accept' => '.jpg, .png, .jpeg, .mp3, .mp4']);?>
<div>Tamaño de la imagen tiene debe ser 1000 x 765. El tipo debe ser .jpg </div>
</div>

<div class="ofertainputcheck" style="width: 30%; float: left;">
<label for="activo" >Habilitada</label>	
<?php	echo $this->Form->checkbox('habilitada', ['hiddenField' => true,'checked'=>true]);?>
</div>	


</fieldset>
<fieldset>
<div class="ofertainputbotton">
<?= $this->Form->button(__('GUARDAR')) ?>
</div>
<?= $this->Form->end() ?>
</fieldset>
</article> 
<script>
    document.getElementById('file').addEventListener('change', function (event) {
        const file = event.target.files[0];
        if (file) {
            const validExtensions = ['jpg', 'jpeg', 'png', 'mp3', 'mp4'];
            const fileExtension = file.name.split('.').pop().toLowerCase();

            // Validar extensión
            if (!validExtensions.includes(fileExtension)) {
                 alertify.alert('Alerta archivo Incorrecto','<span style="color: orange;">El archivo debe ser una imagen (.jpg, .jpeg, .png) o un audio/video (.mp3, .mp4).</span>');
                event.target.value = ''; // Restablecer el valor del input
                return;
            }

            // Validar tamaño
            if (file.size > 1048576) { // 1 MB en bytes
            alertify.alert('Alerta Imagen pesada','<span style="color: red;">El archivo no debe pesar más de 1 MB.</span>', function(){ //alertify.success('Ok');
              }
             );
             
                event.target.value = ''; // Restablecer el valor del input
            }
        }
    });
</script>
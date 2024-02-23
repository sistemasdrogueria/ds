<article class="module width_3_quarter">
<header><h3 class="tabs_involved"><?= $titulo ?></h3></header>
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
<?php echo $this->Form->input('file',['type' => 'file']);?>
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
<div class="search-form">
<?= $this->Form->create('Carritos',['type' => 'file','url'=>['controller'=>'Carritos','action'=>'importresult'],'id'=>'searchform3']); ?>

<?php echo $this->Form->input('namefile', ['id'=>'uploadFile','label'=>'Nombre Archivo','placeholder'=>'Nombre Archivo','disabled'=>'disabled']);?>
<div class="fileUpload btn btn-primary">
<span>Buscar Archivo</span>
<?php echo $this->Form->input('filetext', ['id'=>'uploadBtn','type' => 'file','class'=>'upload','label'=>'Buscar Archivo','name'=>'filetext']);?>	
</div>
<?php
$opciones = [
'011344041430B'=>'DROGUERIA SUR',
'011344051430B'=> 'ACOFAR',
'011314050000B'=> 'AVENIDA',
'651307212342B'=> 'COLFARLP',
'651320032342B'=> 'COLFARLP2',
'531337060130B'=>'COMPUFAR',
'011344030000B1'=> 'DATAFARMA',
'011314041840B'=> 'DOKA',
'011314060000B'=> 'FARMACLICK',
'011314041848B1'=> 'FARMASUR',
'571342040130B'=> 'FARMATRONIC',
'571342040130B2'=> 'TOUCH&SALE',
'011344031430B1'=> 'FARMIV',
'011314030000B'=> 'FD SOFT',
'091301043030B'=> 'GEMA',
'011324061430B1'=> 'FARMV',
'011344031430B2'=> 'NET MEDICA PLUS',
'471340071030B'=>'NOVA',
'031317062460B'=> 'OBSERVER',
'011344030000B'=> 'ONIX',
'021315050000B'=> 'ONIX2',
'101324063130B'=> 'PHARMACO',
'011344031430B3'=> 'SIAF',
'011349031730B'=> 'SIRF',
'011344031430B4'=> 'SICOFA',
'011314031730B'=> 'SIFACO',
'011315062230B'=> 'WINFARMA V1',
'041301031740B'=> 'WINFARMA V2',
'101324063130B'=> 'WINFARMA V3'
];
echo $this->Form->select('sistfarm',$opciones,['empty' => 'Seleccione Sistema']);
echo $this->Form->submit('Procesar',['class'=>'mainBtn']);
echo $this->Form->end() 
?>
</div> <!-- /.search-form -->
<script>
document.getElementById("uploadBtn").onchange = function () {
document.getElementById("uploadFile").value = this.value; };
</script>
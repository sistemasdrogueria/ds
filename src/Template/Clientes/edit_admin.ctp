<?php //><script type="text/javascript">
$previous = "javascript:history.go(-1)";
if(isset($_SERVER['HTTP_REFERER'])) {
    $previous = $_SERVER['HTTP_REFERER'];
}
?>

<div class="clear"></div>
<article class="module width_4_quarter">
<?= $this->Form->create($clientesCredito, ['url'=>['controller'=>'Clientes','action'=>'edit_credito_admin',$cliente_id],'type' => 'file']) ?>
<header>
<legend><h3><?= __('Editar Credito del Cliente') ?></h3>
<div class="volveratras">

<a href="<?= $previous ?>"><?php echo $this->Html->image('icn_volver.png');?></a>
</div>
</legend>
</header>
<div class="module_content">
<fieldset>
<?php echo $this->Form->input('cliente_id', ['value'=>$cliente_id,'hidden' => true]);?>
<?php echo $cliente['razon_social'].' ( '.$cliente['codigo'].' )'; ?>
</fieldset>

<fieldset >
<div style="width: 49%; float:left;"> <?php	echo $this->Form->input('credito_maximo');?> </div>
<div style="width: 49%; float:left;"><?php	echo $this->Form->input('credito_consumo');?></div>
</fieldset>
<fieldset >
<div style="width: 49%; float:left;">  <?php	echo $this->Form->input('credito_tipo',['style'=>'width:200px']);?></div>

<div style="width: 49%; float:left;"> <?php	echo $this->Form->input('compra_minima');?></div></fieldset>
</div><div class="clear"></div>
<footer>
<div class="submit_link">
<?= $this->Form->button(__('Guardar')) ?>
<?= $this->Form->end() ?>
</div>
</footer>
</article><!-- end of post new article -->
<article class="module width_4_quarter">
<?= $this->Form->create($cliente, ['url'=>['controller'=>'Clientes','action'=>'edit_cliente_admin',$cliente_id],'type' => 'file']) ?>
<header>
<legend><h3><?= __('Editar datos del Cliente') ?></h3></legend>
</header>
<div class="module_content">
<fieldset>
<?php echo $this->Form->input('cliente_id', ['value'=>$cliente_id,'hidden' => true]);?>
<?php echo $cliente['razon_social'].' ( '.$cliente['codigo'].' )'; ?>
</fieldset>
<fieldset >
<div style="width: 49%; float:left;"> <?php	echo $this->Form->input('email',['value' =>$cliente['email']]);?></div>
<div style="width: 49%; float:left;"><?php	echo $this->Form->input('email_alternativo',['value' =>$cliente['email_alternativo']]);?></div>
</fieldset>
<fieldset ><?php	
echo $this->Form->radio('habilitado',[
['value' => '1', 'text' => 'Habilitado', 'style' => 'color:red;'],
['value' => '0', 'text' => 'Suspendido', 'style' => 'color:blue;']],['value' =>$cliente['habilitado']]);?>
</fieldset>
<fieldset >
<?php echo $this->Form->radio('actualizo_gln',[
['value' => '1', 'text' => 'Actualizo GLN', 'style' => 'color:red;'],
['value' => '0', 'text' => 'No Actualizo', 'style' => 'color:blue;']],['value' =>$cliente['actualizo_gln']]);?>
</fieldset>
<fieldset >
<?php echo $this->Form->radio('comunidadsur',[
['value' => '1', 'text' => 'Pagina www.comunidadsur.com.ar', 'style' => 'color:red;'],
['value' => '0', 'text' => 'No participa', 'style' => 'color:blue;']],['value' =>$cliente['comunidadsur']]);?>
</fieldset>
<fieldset >
<?php echo $this->Form->radio('beneficio_comunidadsur',[
['value' => '1', 'text' => 'Beneficio Comunidad Sur', 'style' => 'color:red;'],
['value' => '0', 'text' => 'No participa', 'style' => 'color:blue;']],['value' =>$cliente['beneficio_comunidadsur']]);?>
</fieldset>
<fieldset >
<?php	
echo $this->Form->radio('farmapoint',[
['value' => '1', 'text' => 'Dctos en Tu Farmapoint', 'style' => 'color:red;'],['value' => '0', 'text' => 'No participa', 'style' => 'color:blue;']],['value' =>$cliente['farmapoint']]);?>
</fieldset>
<fieldset >
<?php	
echo $this->Form->radio(
'selectos',

[

['value' => '1', 'text' => 'En Selectos', 'style' => 'color:red;'],
['value' => '0', 'text' => 'No participa', 'style' => 'color:blue;'],

],
['value' =>$cliente['selectos']]);?>

</fieldset>

<fieldset >
<div style="width: 49%; float:left;">
<?php	echo $this->Form->input('grupo_id',['hidden' => true]);?>
<?php 
if ($cliente['grupo_id']==0)
echo 'No pertenece a ninguno.';
else
echo $cliente['grupo_id']; ?>

</div>
<div style="width: 49%; float:left;">
<?php	
echo $this->Form->radio(
'cuentaprincipal',

[

['value' => '1', 'text' => 'Es cuenta principal', 'style' => 'color:red;'],
['value' => '0', 'text' => 'No es cuenta principal', 'style' => 'color:blue;'],

],
['value' =>$cliente['cuentaprincipal']]);?>
<div>
</fieldset>
</div><div class="clear"></div>
<footer>
<div class="submit_link">


<?= $this->Form->button(__('Guardar')) ?>
<?= $this->Form->end() ?>
</div>
</footer>
</article><!-- end of post new article -->
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
		
<?= $this->Form->create($user); ?>


<div class="module_content">
<fieldset>
<?php	echo $this->Form->input('username',['label'=> 'Usuario']);?>
</fieldset>
<fieldset style="width:50%; float:left; margin-right: 3%;">
<?php
$opciones = ['admin' =>'admin', 'client'=>'client','provider'=>'provider'];
echo $this->Form->select('role', $opciones);?>
</fieldset>
<fieldset style="width:50%; float:left; ">
<?php  echo $this->Form->input('cliente_id', ['options' => $clientes]);?>
</fieldset>
<fieldset style="width:70%;float:left;">	
<div class="input select">
<label for="clave" >Contraseña</label>			
<?php	echo $this->Form->password('password',['id'=>'clave','value'=>'']);?>
</div>
</fieldset>
<fieldset style="width:70%;float:left;">
<div class="input select">
<label for="clave" >Confirme Contraseña</label>			
<?php	echo $this->Form->password('password_confirm',['id'=>'clave_confirmar','value'=>'']);?>
</div>
</fieldset>
</div><div class="clear"></div>
<footer>
<div class="submit_link">
<?= $this->Form->button(__('Guardar')) ?>
<?= $this->Form->end() ?>
</div>
</footer>
</article><!-- end of post new article -->
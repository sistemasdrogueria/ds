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
<fieldset >
<?php echo $this->Form->select('cliente_id', $clientes);	?>
</fieldset>
<fieldset>
<?php	echo $this->Form->input('username');?>
</fieldset>
<?php echo $this->Form->input('role', ['value'=>'client','type'=>'hidden']);	?>
<fieldset >
<?php echo $this->Form->select('perfile_id', $perfiles);	?>
</fieldset>
<fieldset >
<label for="activo" >Password</label>	
<?php echo $this->Form->password('password');?>
</fieldset>
<fieldset >
<label for="activo" >Confirme Password</label>	
<?php echo $this->Form->password('password_confirm');?>
</fieldset>
<fieldset>
<div class="input select">
<label for="activo" >Super Usuario</label>			
<?php	echo $this->Form->checkbox('super', ['hiddenField' => true]);?>
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


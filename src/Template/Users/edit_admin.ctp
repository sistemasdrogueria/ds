<?php //><script type="text/javascript">
$previous = "javascript:history.go(-1)";
if(isset($_SERVER['HTTP_REFERER'])) {
    $previous = $_SERVER['HTTP_REFERER'];
}
?>

<div class="clear"></div>
<article class="module width_full">
	
		<header><h3 class="tabs_involved" id="titulobarra"><?= $titulo ?></h3>
		<div class="volveratras">
		
		<a href="<?= $previous ?>"><?php echo $this->Html->image('icn_volver.png');?></a>
		</div>
		
		<?= $this->Form->create($user); ?>
		</header>

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
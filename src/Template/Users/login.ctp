
<div class="col-lg-12 wow fadeInLeft delay-06s">
	<?= $this->Flash->render('auth') ?>
	<?= $this->Form->create() ?>
    <legend><?= __('Por Favor ingrese su usuario y contraseña') ?></legend>
		<?= $this->Form->input('username',['label'=>'Usuario','class'=>'input-text','placeholder'=>'Nombre *']) ?>
		<?= $this->Form->input('password',['label'=>'Contraseña','class'=>'input-text','placeholder'=>'Contraseña *']) ?>

        <?= $this->Form->button(__('Ingresar'),['class'=>'input-btn']) ?>
		<?= $this->Form->end() ?>
</div>
<style>
.input_date_input_search_i{ 
	padding: 5px;
}

</style>

<div class="form_search">
    <?= $this->Form->create('TransfersProveedors',['url'=>['controller'=>'TransfersProveedors','action'=>'index_admin'],'id'=>'searchform4']); ?>
		<div class="input_date_search">
			<div class="input_date_input_search">
				<?= $this->Form->input('fechadesde', ['label'=>'','id'=>'fechadesde','class'=>'input_date_input_search_i','name'=>'fechadesde', 'type'=>'text','placeholder'=>'Fecha Desde:']);?>
	
			</div>
			
			<div class="input_date_input_search">
				<?=	$this->Form->input('fechahasta', ['label'=>'','id'=>'fechahasta','class'=>'input_date_input_search_i','name'=>'fechahasta', 'type'=>'text','placeholder'=>'Fecha Hasta:','onchange'=>'javascript:document.confirmInput.submit();']);?>
	
			</div>
		</div>
		
		<div class="input_text_search">
			<div class="input_date_input_search">
				<?php echo $this->Form->input('tfl_id', ['label'=>'','options' => $tfl,'class'=>'input_date_input_search_i','empty'=>'Todos los Laboratorios','style'=>'width: 180px; ']); ?>
			</div>
		</div>
			<div class="input_text_search">
			<div class="input_date_input_search">
			  <?= $this->Form->input('termino', ['label'=>'','type'=>'text' ,'class'=>'input_date_input_search_i','placeholder'=>'Buscar x Numero']); ?>
			</div>
			</div>

		<div>
		<?= $this->Form->submit('Buscar',['class'=>'submit_link','id'=>'button_search']); ?>
		</div>
	<?= $this->Form->end() ?>
</div>
<div class="form_search">
    <?= $this->Form->create('Users',['url'=>['controller'=>'Users','action'=>'index_search_admin'],'id'=>'searchform4']); ?>
		
		<div class="input_text_search">
			
			  <?= $this->Form->input('termino', ['class'=>'terminobusqueda','label'=>'','type'=>'text' ,'placeholder'=>'Buscar ']); ?>
			
		</div>
		

		<div>
		<?= $this->Form->submit('Buscar',['class'=>'submit_link','id'=>'button_search']); ?>
		</div>
		
	
	
		
	<?= $this->Form->end() ?>
</div>
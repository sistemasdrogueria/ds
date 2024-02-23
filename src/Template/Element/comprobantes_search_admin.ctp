<div class="form_search">
	<?= $this->Form->create('Comprobantes',['url'=>['controller'=>'Comprobantes','action'=>'search_admin'],'id'=>'searchform4','onsubmit'=>'return validar()']); ?>
	

		<div class="input_date_search">
			<div class="input_date_input_search">
				<?= $this->Form->input('fechadesde', ['label'=>'Desde:','id'=>'fechadesde','name'=>'fechadesde', 'type'=>'text','placeholder'=>'Fecha Desde:']);?>
			</div>
			<div class="input_date_input_search">
				<?=	$this->Form->input('fechahasta', ['label'=>'Hasta:','id'=>'fechahasta','name'=>'fechahasta', 'type'=>'text','placeholder'=>'Fecha Hasta:','onchange'=>'javascript:document.confirmInput.submit();']);?>
			</div>
		</div>
		<div class="input_text_search">
			
			  <?= $this->Form->input('terminobuscarn', ['class'=>'terminobusqueda','label'=>'','type'=>'text' ,'placeholder'=>'N° Nota','onchange'=>'javascript:document.confirmInput.submit();']); ?>
			
		</div>
		<div class="input_text_search">
			
			  <?= $this->Form->input('terminobuscarf', ['class'=>'terminobusqueda','label'=>'','type'=>'text' ,'placeholder'=>'N° Factura','onchange'=>'javascript:document.confirmInput.submit();']); ?>
			
		</div>

		<div class="input_text_search">
			
			  <?= $this->Form->input('terminocliente', ['class'=>'terminobusqueda','label'=>'','type'=>'text' ,'placeholder'=>'Buscar Cliente','onchange'=>'javascript:document.confirmInput.submit();']); ?>
			
		</div>
		<div class="input_select_search">
		
			<?php echo $this->Form->input('factura', ['label'=>'Factura','type'=>'checkbox','value'=>1,'checked'=>1]); ?>
			<?php echo $this->Form->input('notacredito', ['label'=>'Nota de Credito','type'=>'checkbox','value'=>1,'checked'=>1]);?>
			<?php echo $this->Form->input('notadebito', ['label'=>'Nota de Debito','type'=>'checkbox','value'=>1,'checked'=>1]);?>
			<?php echo $this->Form->input('recibo',['label'=>'Recibo Oficial','type'=>'checkbox','value'=>1,'checked'=>1]);	//,'checked'?>
		
		</div>
		<div>
		<?= $this->Form->submit('Buscar',['class'=>'submit_link','id'=>'button_search']); ?>
		</div>
	<?= $this->Form->end() ?>
</div>
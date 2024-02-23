<div class="form_search">
<?= $this->Form->create('',['url'=>['controller'=>'Articulos','action'=>'index'],'id'=>'searchform4']); ?>

<div class="input_text_search">
<?= $this->Form->input('terminobuscar', ['class'=>'terminobusqueda','label'=>'','type'=>'text' ,'placeholder'=>'Buscar Producto','onchange'=>'javascript:document.confirmInput.submit();']); ?>
</div>
<div class="input_select_search">
<?= $this->Form->input('laboratorio_id',['class'=>'terminobusquedaselect','label'=>'','options' => $laboratorios,'onchange'=>'this.form.submit();','empty'=>'Laboratorios']);	?>	
</div>
<div class="input_select_search">
<?= $this->Form->input('categoria_id', ['class'=>'terminobusquedaselect','label'=>'','options' => $categorias,'onchange'=>'this.form.submit();','empty'=>'Categorias']);	?>	
</div>
<div class="input_select_search">
<?= $this->Form->input('subcategoria_id', ['class'=>'terminobusquedaselect','label'=>'','options' => $subcategorias,'onchange'=>'this.form.submit();','empty'=>'Subcategorias']);	?>	
</div>
<div class="input_select_search">
<?= $this->Form->input('marca_id', ['class'=>'terminobusquedaselect','label'=>'','options' => $marcas,'onchange'=>'this.form.submit();','empty'=>'Marcas']);	?>	
</div>
<div>
<?= $this->Form->submit('Buscar',['class'=>'submit_link','id'=>'button_search']); ?>
</div>
<?= $this->Form->end() ?>
</div>
<div class="form_search">
<?= $this->Form->create('',['url'=>['controller'=>'marcas','action'=>'index_admin'],'id'=>'searchform4']); ?>

<div class="input_text_search">
<?= $this->Form->input('termino', ['class'=>'terminobusqueda','label'=>'','type'=>'text' ,'placeholder'=>'Buscar Producto']); ?>
</div>

<div class="input_select_search">
<select clas="terminobusquedaselect" style="height:26px"> 
    <option value="">Selecione un estado</option>
    <option value="0">Sin restriciones</option>
    <option value="1">Con restriciones</option>
</select>
</div>
<div>
<?= $this->Form->submit('Buscar',['class'=>'submit_link','id'=>'button_search']); ?>
</div>
<?= $this->Form->end() ?>

</div>
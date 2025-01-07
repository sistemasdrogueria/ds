<style>
    .border-red {
        border: 1px solid red;
    }
     .border-black {
        border: 1px solid ;
        margin-top: 5px;
    }
</style>
<div class="form_search">


    <div class="input_date_search">
        <div class="input_date_input_search">
            <?= $this->Form->input('fechadesde', ['label' => '', 'id' => 'fechadesde', 'name' => 'fechadesde', 'type' => 'text', 'placeholder' => 'Fecha Desde:']); ?>
        </div>
        <div class="input_date_input_search">
            <?= $this->Form->input('fechahasta', ['label' => '', 'id' => 'fechahasta', 'name' => 'fechahasta', 'type' => 'text', 'placeholder' => 'Fecha Hasta:']) ?>
        </div>
    </div>

    <div class="input_text_search">
        <?= $this->Form->input('terminobuscarfp', ['class' => 'terminobusqueda', 'label' => '', 'type' => 'text', 'placeholder' => 'Buscar pedido fp', 'onchange' => 'javascript:document.confirmInput.submit();']); ?>
    </div>

    <div class="input_text_search">
        <?= $this->Form->input('terminobuscards', ['class' => 'terminobusqueda', 'label' => '', 'type' => 'text', 'placeholder' => 'Buscar pedido ds', 'onchange' => 'javascript:document.confirmInput.submit();']); ?>

    </div>
    <div class="input_text_search">
        <?= $this->Form->input('terminobuscarcodigods', ['class' => 'terminobusqueda', 'label' => '', 'type' => 'text', 'placeholder' => 'Buscar por cliente', 'onchange' => 'javascript:document.confirmInput.submit();']); ?>

    </div>
    <div>
        <?= $this->Form->submit('Buscar', ['class' => 'submit_link', 'id' => 'button_search', 'onclick' => 'search();']); ?>
    </div>

</div>


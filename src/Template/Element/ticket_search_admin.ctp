<div class="form_search" style="height:auto;">
    <div class="card">
        <?= $this->Form->create('Tickets', ['url' => ['controller' => 'Tickets', 'action' => 'index_admin_search'], 'id' => 'searchform4', 'autocomplete' => 'off']); ?>
        <div class="date-inputs">
            <div class="date-input form-group">
                <?= $this->Form->input('fechadesde', ['class' => 'select-tipo-reclamo', 'label' => 'Fecha Desde:', 'id' => 'fechadesde', 'name' => 'fechadesde', 'type' => 'text', 'placeholder' => 'Fecha Desde:']); ?>
            </div>
            <div class="date-input form-group">
                <?= $this->Form->input('fechahasta', ['class' => 'select-tipo-reclamo', 'label' => 'Fecha Hasta:', 'id' => 'fechahasta', 'name' => 'fechahasta', 'type' => 'text', 'placeholder' => 'Fecha Hasta:', 'onchange' => 'javascript:document.confirmInput.submit();']); ?>
            </div>
            <div class="search-input form-group">
                <?= $this->Form->input('termino', ['class' => 'input-reclamo', 'label' => 'N° Ticket', 'type' => 'text', 'placeholder' => 'N° Ticket']); ?>
            </div>
            <div class="search-input form-group">
                <?= $this->Form->input('termino2', ['class' => 'input-reclamo', 'label' => 'Cliente:', 'type' => 'text', 'placeholder' => 'Buscar por Cliente']); ?>
            </div>
            <div class="search-input form-group">
                <?= $this->Form->input('termino3', ['class' => 'input-reclamo', 'label' => 'Producto:', 'type' => 'text', 'placeholder' => 'Buscar por Producto']); ?>
            </div>
            <div class="form-group">
                <?php echo $this->Form->input('reclamos_tipo_id', ['label' => 'Tipo de Reclamo:', 'class' => 'select-tipo-reclamo', 'options' => $ReclamosTipos, 'empty' => 'Seleccione Tipo']); ?>
            </div>
            <div class="buttons">
                <?= $this->Form->submit('Buscar', ['class' => 'submit_link', 'class' => 'btn btn-primary']); ?>
                <?= $this->Form->submit('Excel', ['class' => 'btn btn-secondary']); ?>
            </div>
        </div>
        <?= $this->Form->end() ?>
    </div>
</div>
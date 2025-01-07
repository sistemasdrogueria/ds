<?= $this->Html->css('tickets/tickets_index_user') ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<div class="col-md-3">
    <div class="product-item-3">
        <div class="product-content">
            <h2 class="title-sugger"><i class="fas fa-search icon-ticket"></i>Buscar</h2>
            <hr>
            <div class="row">
                <?php echo $this->element('ticket_index_search'); ?>
            </div> 
        </div>
        <div class="product-content">
            <span class='cliente_info_span'>Manual de Procedimiento</span>
            </br>
            <div class="row">
                <?php echo $this->element('ticket_opcion_descarga'); ?>
            </div> <!-- /.row -->
        </div>
    </div> 
</div>
<div class="col-md-9">
    <div class="product-item-3">
        <div class="product-content" style="padding: 0px;">
            <?php echo $this->element('ticket_index_result'); ?>
        </div> 
    </div> 
</div>
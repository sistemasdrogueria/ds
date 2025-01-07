<main class="ticket-body">
    <div class="info-grid">
        <div class="info-item">
            <span class="info-label">Número</span>
            <span class="info-value"><?= $this->Number->format($reclamo->id) ?></span>
        </div>
        <div class="info-item">
            <span class="info-label">Factura Número</span>
            <span class="info-value"><?= sprintf('%04d-%08d', $reclamo['factura_seccion'], $reclamo['factura_numero']) ?></span>
        </div>
        <div class="info-item">
            <span class="info-label">Factura Fecha</span>
            <span class="info-value"><?= $reclamo['fecha_recepcion']->format('d-m-Y') ?></span>
        </div>
        <div class="info-item">
            <span class="info-label">Motivo</span>
            <span class="info-value"><?= $reclamo->has('reclamos_tipo') ? h($reclamo->reclamos_tipo->nombre) : '' ?></span>
        </div>
        <div class="info-item">
            <span class="info-label">Estado</span>
            <span class="info-value"><?= $reclamo->has('reclamos_estado') ? h($reclamo->reclamos_estado->nombre) : '' ?></span>
        </div>
        <div class="info-item">
            <span class="info-label">Creado el</span>
            <span class="info-value"><?= $reclamo['creado']->format('d/m/Y') ?></span>
        </div>
        <div style="display:flex;position: absolute;top: 20px;right: 50px;align-items: center;">
        <span class="span-download" >Descargar ticket</span>
            <?= $this->Html->link(
                '<i class="fa-regular fa-file-pdf" style="color:white;font-size: 30px;"></i>',
                ['controller' => 'Tickets', 'action' => 'ticketpdf', $reclamo['id'], '_ext' => 'pdf'],
                ['escape' => false] 
            ); ?>
        </div>
    </div>
</main>
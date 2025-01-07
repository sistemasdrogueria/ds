<div class="reclamos index large-10 medium-9 columns">
    <div class="conteiner-tickets">
        <div class="dashboard">
            <div class="tickets">
                <h2 class="title-sugger"><i class="fas fa-list icon-ticket"></i>Tus Tickets</h2>
                <hr>
                <div id="ticketList">
                    <?php foreach ($reclamos as $reclamo): ?>
                        <div class="ticket">
                            <div class="ticket-header">
                                <div>
                                    <h4 style="margin: 1px;"> <?= $reclamo->creado->i18nFormat('d \'de\' MMMM \'de\' yyyy'); ?></h4>
                                </div>

                                <div>
                                    <?php if ($reclamo->cantidad_notificaciones > 0): ?>
                                        <div class="contador-notificaciones">
                                            <span style="color: white;"><?= $reclamo->cantidad_notificaciones ?></span>
                                        </div>
                                    <?php endif; ?>

                                    <?php if (in_array($reclamo->estado_id, [0, 1, 2])): ?>
                                        <span class="status status-open">
                                            <i class="fas fa-spinner fa-spin icon-ticket"></i><?= $reclamo->reclamos_estado->nombre ?>
                                        </span>
                                    <?php elseif ($reclamo->estado_id == 3): ?>
                                        <span class="status status-aprobado">
                                            <i class="fas fa-check icon-ticket"></i><?= $reclamo->reclamos_estado->nombre ?>
                                        </span>
                                    <?php elseif (($reclamo->estado_id == 4) || ($reclamo->estado_id == 5)): ?>
                                        <span class="status status-cancelado">
                                            <i class="fas fa-xmark icon-ticket"></i><?= $reclamo->reclamos_estado->nombre ?>
                                        </span>
                                    <?php elseif ($reclamo->estado_id == 6): ?>
                                        <span class="status status-aprobado">
                                            <i class="fas fa-arrow-rotate-left icon-ticket"></i><?= $reclamo->reclamos_estado->nombre ?>
                                        </span>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <hr>
                            <div style="position: relative;margin-top:15px">
                                <a href="<?= $this->Url->build(['controller' => 'Tickets', 'action' => 'view', $reclamo->id]) ?>">
                                    <h3><i class="fas fa-circle-info icon-ticket"></i>
                                        <?= '#' . $reclamo->id . ' - ' . $reclamo->reclamos_tipo->nombre ?>
                                    </h3>
                                </a>
                                <p class="date"><i class="fa-solid fa-ticket-alt icon-ticket"></i> Número:<?= $this->Number->format($reclamo->id) ?></p>
                                <p class="date"><i class="fa-solid fa-file-invoice-dollar icon-ticket"></i> Número de Factura:<?= str_pad($reclamo['factura_seccion'], 4, '0', STR_PAD_LEFT) . '-' . str_pad($reclamo['factura_numero'], 8, '0', STR_PAD_LEFT) ?></p>
                                <p class="date"><i class="far fa-calendar icon-ticket"></i> Fecha de Factura:<?= date_format($reclamo['fecha_recepcion'], 'd/m/Y'); ?></p>

                                <div class="ticket-interior-botones">

                                    <a href="<?= $this->Url->build(['controller' => 'Tickets', 'action' => 'ticketpdf',  $reclamo['id'], '_ext' => 'pdf', '_full' => true]) ?>">
                                        <span class="status status-pdf">
                                            <i class="fas fa-file-pdf icon-ticket"></i>PDF
                                        </span>
                                    </a>
                                    <a href="<?= $this->Url->build(['controller' => 'Tickets', 'action' => 'view',  $reclamo->id]) ?>">
                                        <span class="status status-pdf">
                                            <i class="fas fa-circle-info icon-ticket"></i>Ver Info
                                        </span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        var currentPage = 0;
        var numPerPage = 3;
        var $container = $('#ticketList');
        var $items = $container.find('.ticket');

        function repaginate() {
            $items.hide().slice(currentPage * numPerPage, (currentPage + 1) * numPerPage).show();
        }

        repaginate();

        var numItems = $items.length;
        var numPages = Math.ceil(numItems / numPerPage);

        var $pager = $('<div class="paginator-table"></div>');
        for (var page = 0; page < numPages; page++) {
            $('<div class="page-number"></div>')
                .text(page + 1)
                .addClass('clickable')
                .on('click', {
                    newPage: page
                }, function(event) {
                    currentPage = event.data.newPage;
                    repaginate();
                    $(this).addClass('active').siblings().removeClass('active');
                })
                .appendTo($pager);
        }

        $pager.insertAfter($container).find('div.page-number:first').addClass('active');
    });
</script>
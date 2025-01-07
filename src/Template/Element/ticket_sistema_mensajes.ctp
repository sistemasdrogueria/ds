<div class="messages">
    <section class="message-box new user-ticket">
        <h2><?= $reclamo->cliente->razon_social ?></h2>
        <div class="message-info">
            <p class="asunto-mensaje"><strong>Asunto:</strong> <?= $reclamo->reclamos_tipo->nombre ?></p>
        </div>
        <p style="color: #a9a9a9;font-weight: bold;"><?= $reclamo->observaciones ?></p>
        <p style="text-align: right;color: #b3b3b3;"><?= $reclamo->creado ?></p>
    </section>

    <?php foreach ($reclamo->reclamos_mensajes as $mensaje): ?>
        <div id="mensaje-<?= $mensaje->id ?>" class="message-box <?= $mensaje->tipo == 'system' ? 'system-message' : ($mensaje->cliente_id == 34525 ? 'admin' : 'user-ticket') ?>">
            <?php if ($mensaje->tipo == 'system'): ?>
                <p style="color:rgb(255, 255, 255); font-weight: bold;"><?= $mensaje->mensaje ?></p>
            <?php else: ?>
                <h2><?= $mensaje->cliente->razon_social ?></h2>
                <?= $mensaje->mensaje ?>
                <?php if (!empty($mensaje->imagen)): ?>
                    <?php
                    echo $this->Html->image('/reclamos/' . $reclamo->id . '/imagen/' . $mensaje->imagen, [
                        'alt' => $mensaje->imagen,
                        'style' => 'max-width: 400px;max-height: 200px;cursor:pointer;',
                        'id' => 'imagenMensaje-' . $mensaje->id
                    ]);
                    ?>
                <?php endif; ?>
            <?php endif; ?>
            <?php if ($mensaje->tipo != 'system'): ?>
                <p style="text-align: right;color: #b3b3b3;"><?= $mensaje->creado ?></p>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
</div>
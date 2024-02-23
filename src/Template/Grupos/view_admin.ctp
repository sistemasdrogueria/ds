<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Marca'), ['action' => 'edit', $marca->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Marca'), ['action' => 'delete', $marca->id], ['confirm' => __('Are you sure you want to delete # {0}?', $marca->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Marcas'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Marca'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Fragancias'), ['controller' => 'Fragancias', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Fragancia'), ['controller' => 'Fragancias', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="marcas view large-9 medium-8 columns content">
    <h3><?= h($marca->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Nombre') ?></th>
            <td><?= h($marca->nombre) ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($marca->id) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Fragancias') ?></h4>
        <?php if (!empty($marca->fragancias)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th><?= __('Id') ?></th>
                <th><?= __('Nombre') ?></th>
                <th><?= __('Imagen') ?></th>
                <th><?= __('Marca Id') ?></th>
                <th><?= __('Genero Id') ?></th>
                <th><?= __('Eliminado') ?></th>
                <th><?= __('Creado') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($marca->fragancias as $fragancias): ?>
            <tr>
                <td><?= h($fragancias->id) ?></td>
                <td><?= h($fragancias->nombre) ?></td>
                <td><?= h($fragancias->imagen) ?></td>
                <td><?= h($fragancias->marca_id) ?></td>
                <td><?= h($fragancias->genero_id) ?></td>
                <td><?= h($fragancias->eliminado) ?></td>
                <td><?= h($fragancias->creado) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Fragancias', 'action' => 'view', $fragancias->id]) ?>

                    <?= $this->Html->link(__('Edit'), ['controller' => 'Fragancias', 'action' => 'edit', $fragancias->id]) ?>

                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Fragancias', 'action' => 'delete', $fragancias->id], ['confirm' => __('Are you sure you want to delete # {0}?', $fragancias->id)]) ?>

                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
    </div>
</div>

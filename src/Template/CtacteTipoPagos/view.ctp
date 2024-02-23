<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Ctacte Tipo Pago'), ['action' => 'edit', $ctacteTipoPago->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Ctacte Tipo Pago'), ['action' => 'delete', $ctacteTipoPago->id], ['confirm' => __('Are you sure you want to delete # {0}?', $ctacteTipoPago->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Ctacte Tipo Pagos'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Ctacte Tipo Pago'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="ctacteTipoPagos view large-9 medium-8 columns content">
    <h3><?= h($ctacteTipoPago->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Nombre') ?></th>
            <td><?= h($ctacteTipoPago->nombre) ?></td>
        </tr>
        <tr>
            <th><?= __('Terminobusqueda') ?></th>
            <td><?= h($ctacteTipoPago->terminobusqueda) ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($ctacteTipoPago->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Grupo') ?></th>
            <td><?= $this->Number->format($ctacteTipoPago->grupo) ?></td>
        </tr>
    </table>
</div>

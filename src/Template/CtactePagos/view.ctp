<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Ctacte Pago'), ['action' => 'edit', $ctactePago->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Ctacte Pago'), ['action' => 'delete', $ctactePago->id], ['confirm' => __('Are you sure you want to delete # {0}?', $ctactePago->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Ctacte Pagos'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Ctacte Pago'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Clientes'), ['controller' => 'Clientes', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Cliente'), ['controller' => 'Clientes', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="ctactePagos view large-9 medium-8 columns content">
    <h3><?= h($ctactePago->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Cliente') ?></th>
            <td><?= $ctactePago->has('cliente') ? $this->Html->link($ctactePago->cliente->id, ['controller' => 'Clientes', 'action' => 'view', $ctactePago->cliente->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Detalle') ?></th>
            <td><?= h($ctactePago->detalle) ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($ctactePago->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Nota') ?></th>
            <td><?= $this->Number->format($ctactePago->nota) ?></td>
        </tr>
        <tr>
            <th><?= __('Signo') ?></th>
            <td><?= $this->Number->format($ctactePago->signo) ?></td>
        </tr>
        <tr>
            <th><?= __('Importe') ?></th>
            <td><?= $this->Number->format($ctactePago->importe) ?></td>
        </tr>
        <tr>
            <th><?= __('Fecha Ingreso') ?></th>
            <td><?= h($ctactePago->fecha_ingreso) ?></td>
        </tr>
        <tr>
            <th><?= __('Fecha Aplicacion') ?></th>
            <td><?= h($ctactePago->fecha_aplicacion) ?></td>
        </tr>
        <tr>
            <th><?= __('Chequeo') ?></th>
            <td><?= $ctactePago->chequeo ? __('Yes') : __('No'); ?></td>
         </tr>
    </table>
</div>

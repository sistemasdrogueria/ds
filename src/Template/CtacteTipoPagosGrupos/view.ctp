<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Ctacte Tipo Pagos Grupo'), ['action' => 'edit', $ctacteTipoPagosGrupo->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Ctacte Tipo Pagos Grupo'), ['action' => 'delete', $ctacteTipoPagosGrupo->id], ['confirm' => __('Are you sure you want to delete # {0}?', $ctacteTipoPagosGrupo->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Ctacte Tipo Pagos Grupos'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Ctacte Tipo Pagos Grupo'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="ctacteTipoPagosGrupos view large-9 medium-8 columns content">
    <h3><?= h($ctacteTipoPagosGrupo->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Nombre') ?></th>
            <td><?= h($ctacteTipoPagosGrupo->nombre) ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($ctacteTipoPagosGrupo->id) ?></td>
        </tr>
    </table>
</div>

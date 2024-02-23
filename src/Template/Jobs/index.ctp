<?php foreach ($jobs as $job): ?>
<article class="clear" style="border-top: 2px solid #F1F1F1; padding-top:30px">
<div>
<div class="index_titulo"><?= h($job->titulo) ?> </div></br>
<div class="index_ap">
<div class="index_ap_nombre"> <?= $job->has('sector') ? $job->sector->nombre : '' ?> - <?= $job->has('puesto') ? $job->puesto->nombre : '' ?>
</br>Publicado: <?= h($job->fecha) ?>
</div>
<div class="index_dip"> <?= h($job->disponibilidad) ?></div></div></br>
<div class="index_ap_nombre"></div>
</div>
<div>
<footer style="float: right;  margin-right: 15px; margin-top: -15px; z-index: 5;">
<?php  echo $this->Html->link('Mas información',['controller' => 'jobs', 'action' => 'view',  $job['id']],['escape' => false,'class'=>"button small  gradient green rnd5"]);?>
</footer>
</div>
</article>
<?php endforeach; ?>
<div class="clear"></div>
<div class="paginator">
<ul class="pagination">
<?= $this->Paginator->first('<< ' . __('primero')) ?>
<?= $this->Paginator->prev('< ' . __('anterior')) ?>
<?= $this->Paginator->numbers() ?>
<?= $this->Paginator->next(__('siguiente') . ' >') ?>
<?= $this->Paginator->last(__('ultimo') . ' >>') ?>
</ul>
<!--p><?php // $this->Paginator->counter(['format' => __('Pagina {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p -->
</div>
<div class="search-form">
<?= $this->Form->create('CtactePagos',['url'=>['controller'=>'CtactePagos','action'=>'search'],'id'=>'searchform5']); ?>
<?= $this->Form->input('cliente_id',['id'=>'selectcuenta','default'=>$this->request->session()->read('cliente_id'),'options'=> $clientes,'label'=>'Cuenta:','onChange'=>'document.getElementById("searchform5").submit();']); ?>
<?= $this->Form->input('fechadesde', ['label'=>'','id'=>'fechadesde','name'=>'fechadesde', 'type'=>'text','placeholder'=>'F. Desde:' ,'style'=>'width: 150px; height: 42px; margin-top:10px; ']);?>
<?=	$this->Form->input('fechahasta', ['label'=>'','id'=>'fechahasta','name'=>'fechahasta', 'type'=>'text','placeholder'=>'F. Hasta:', 'style'=>'width: 150px; height: 42px; margin-top:10px;']);?>
<?= $this->Form->input('tipo_pago_id', ['label'=>'','options' => $TipoPagosGrupos,'empty'=>'Todos los Conceptos', 'style'=>' margin-top:10px;']); ?>
<?= $this->Form->submit('Buscar',['class'=>'mainBtn', 'style'=>'width: 150px; margin-top:10px;']); ?>
<?= $this->Form->end() ?>
<br>
</div>
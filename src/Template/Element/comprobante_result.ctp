<style> .dflxcenter{ display: inline-flex;justify-content: space-evenly;flex-direction: row;width: 100%;align-items: center;}
</style>
<div class="ctacteComprasSemanales index large-10 medium-9 columns">
<table class='tablacompsearch' cellpadding="0" cellspacing="0">
<thead>
<tr>	
<th><?= $this->Paginator->sort('fecha','FECHA') ?></th>
<th><?= $this->Paginator->sort('tipo','DETALLE') ?></th>
<th><?= $this->Paginator->sort('nota','N° INTERNO') ?></th>
<th><?= $this->Paginator->sort('numero','N° COMPROBANTE') ?></th>
<th><?= $this->Paginator->sort('importe','IMPORTE') ?></th>
<th>PDF</th>
<th>TXT V1</th>
<th class="dflxcenter">TXT V2 <?php echo $this->Form->input('seleccionar', ['label'=>'','type'=>'checkbox','checked'=>0,'class'=>"inputall",'style'=>" margin-right: 16px;"]);  ?></th>
<th>TRAZA</th>
</tr>
</thead>
<tbody>
<div id="flotante"></div>
<?php $indice=0;?>
<?php echo $this->Form->create('Comprobantes',['url'=>['controller'=>'Comprobantes','action'=>'downloadfiletxtselect']]); ?>
<?php foreach ($comprobantes as $comprobante): ?>
<?php $indice+=1;?>       
<tr>
<td class="colcenter"><?php echo date_format($comprobante->fecha,'d-m-Y');?></td>
<td class="colcenter">  <?php echo $comprobante->comprobantes_tipo->nombre ?>    
<!--?= $comprobante->has('comprobantes_tipo') ? $comprobante->comprobantes_tipo->nombre : '' ? -->
<?php if ($comprobante['comprobantes_tipo_id']>1 && $comprobante['os']>0) echo ' OS';?>
</td>
<td class="colcenter"><?= $this->Number->format($comprobante->nota) ?></td>
<td class="colcenter">
<?php 
echo $this->Html->link(str_pad($comprobante->seccion, 4, "0", STR_PAD_LEFT).'-'.str_pad($comprobante->numero, 8, "0", STR_PAD_LEFT),
['controller' => 'Comprobantes', 'action' => 'view', $comprobante->id,date_format($comprobante->fecha,'Ymd')]			);
?></td>
<td class='colprecio2'> <?php echo '$ '.number_format(round($comprobante->importe, 3),2,',','.'); ?>
</td>
<td class="colcenter">
<?php echo $this->Html->image('icon_view_pdf2.png',['title' => 'Ver PDF','url'=>['controller'=>'Comprobantes','action' => 'view',  $comprobante->id,date_format($comprobante->fecha,'Ymd')]]); ?>    
<?php echo $this->Html->image('icon_down_pdf2.png',['title' => 'Descargar PDF','url'=>['controller'=>'Comprobantes','action' => 'downloadfile', $comprobante->nota, $comprobante->comprobante_tipo_id,date_format($comprobante->fecha,'Ymd')]]); ?>    
</td>
<td class="colcenter">
<?php 
if ($comprobante['comprobante_tipo_id']==1  && $comprobante['anulado']==0)
echo $this->Html->image('icon_down_txt2_v1.png',['title' => 'Descargar TXT v1','url'=>['controller'=>'Comprobantes','action' => 'downloadfiletxt', $comprobante->nota,date_format($comprobante->fecha,'Y-m-d')]]); ?>    
</td>
<td class="colcenter dflxcenter">
<div>
<?php 
if ($comprobante['comprobante_tipo_id']==1  && $comprobante['anulado']==0)
echo $this->Html->image('icon_down_txt2_v2.png',['title' => 'Descargar TXT v2','url'=>['controller'=>'Comprobantes','action' => 'downloadfiletxt2', $comprobante->nota,date_format($comprobante->fecha,'Y-m-d')]]);
if (($comprobante['comprobante_tipo_id']==2 || $comprobante['comprobante_tipo_id']==3 )  && $comprobante['anulado']==0)
echo $this->Html->image('icon_down_txt_ndnc.png',['title' => 'Descargar TXT NDNC','url'=>['controller'=>'Comprobantes','action' => 'downloadfiletxt3', $comprobante->nota,date_format($comprobante->fecha,'Y-m-d')]]); ?>     
</div>
<div>
    <?php 
if ($comprobante['comprobante_tipo_id']==1  && $comprobante['anulado']==0)
{		
$encabezado = 'Comprobantes'.$indice.'.';			
echo $this->Form->input($encabezado.'id',['type'=>'hidden','value'=> $comprobante->id]);
echo $this->Form->input($encabezado.'seleccionar', ['tabindex'=>$indice,'label'=>'','type'=>'checkbox','checked'=>0,'class'=>"inputone"]); 
}			
?>    
</div>
</td>
<td class="colcenter">			
<?php  
if ($comprobante->con_trazable !=0  && $comprobante['anulado']==0)
{
echo $this->Html->image('trazable.png', ['alt' => 'Traza de Medicamento','url'=>['controller'=>'Comprobantes','action' => 'traza', $comprobante->id]]);
echo $this->Html->image('icon_down_txt_traza.png',['alt'=> 'Descargar Traza de Medicamento','title' => 'Descargar TXT','url'=>['controller'=>'Comprobantes','action' => 'downloadfiletrazatxt', $comprobante->id]]); 
echo $this->Html->image('icon_down_pdf_traza.png', ['alt' => 'Traza de Medicamento','url'=>['controller'=>'Comprobantes','action' => 'trazapdf', $comprobante->id,'_ext' => 'pdf','_full'=>true]]);
} 
else
if ($comprobante['anulado']==1) echo 'Anulada';
?>        
</td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
<div class="paginatorimport" >
<ul class="pagination">
<?= $this->Paginator->prev('< ' . __('Anterior')) ?>
<?= $this->Paginator->numbers() ?>
<?= $this->Paginator->next(__('Siguiente') . ' >',['tabindex'=>$indice]) ?>
<div class="pagination_count"><span><?= $this->Paginator->counter('{{count}} Registros') ?> </span></div>
</ul>
<div class="importconfirm3">	
<div class="button-holder4">	
<?php echo $this->Form->submit('Exportar Seleccionados',['class'=>'btn_agregarvarios']); ?>
</div>	
</div>	
<?= $this->Form->end() ?>	
</div>
</div>

<script>
    $('.inputall').on('change', function(){
        if( $('.inputall').prop('checked') ) {
        $('.inputone').prop('checked',true) ;
        }else{
        $('.inputone').prop('checked',false);
        }
    });
</script>
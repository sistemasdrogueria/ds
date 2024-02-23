<div class="ctacteComprasSemanales index large-10 medium-9 columns">
    <table class='tablasearch' cellpadding="0" cellspacing="0">
    <thead>
        <tr>	
			<th><?= $this->Paginator->sort('fecha') ?></th>
            <th><?= $this->Paginator->sort('tipo','Detalle') ?></th>
			<th><?= $this->Paginator->sort('nota','Nro Interno') ?></th>
			<th><?= $this->Paginator->sort('numero','Comprobantes') ?></th>
			<th><?= $this->Paginator->sort('importe') ?></th>
			<th>PDF</th>
			<th>TXT v1</th>
			<th>TXT v2</th>
			<th>TXT v2</th>
			<th>traza</th>
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
			<td class="colcenter">  <?= $comprobante->has('comprobantes_tipo') ? $comprobante->comprobantes_tipo->nombre : '' ?></p>
       </td>
            <td class="colcenter"><?= $this->Number->format($comprobante->nota) ?></td>
            <td class="colcenter">
            <?php 
			echo $this->Html->link(
				str_pad($comprobante->seccion, 4, "0", STR_PAD_LEFT).'-'.str_pad($comprobante->numero, 8, "0", STR_PAD_LEFT),
				['controller' => 'Comprobantes', 'action' => 'view', $comprobante->id,date_format($comprobante->fecha,'Ymd')]			);
			
			?></td>
			<td class='colprecio2'> <?php echo '$ '.number_format(round($comprobante->importe, 3),2,',','.'); ?>
			</td>
            <td class="colcenter">
				     <?php echo $this->Html->image('pdf_view.png',['title' => 'Ver PDF','url'=>['controller'=>'Comprobantes','action' => 'view',  $comprobante->id,date_format($comprobante->fecha,'Ymd')]]); ?>    
					 <?php echo $this->Html->image('pdf.png',['title' => 'Descargar PDF','url'=>['controller'=>'Comprobantes','action' => 'downloadfile', $comprobante->nota, $comprobante->comprobante_tipo_id,date_format($comprobante->fecha,'Ymd')]]); ?>    
			</td>
			<td class="colcenter">
		    <?php 
					if ($comprobante['comprobante_tipo_id']==1  && $comprobante['anulado']==0)
						echo $this->Html->image('txt.png',['title' => 'Descargar TXT v1','url'=>['controller'=>'Comprobantes','action' => 'downloadfiletxt', $comprobante->nota]]); ?>    
			</td>
			<td class="colcenter">
			<?php 
					 if ($comprobante['comprobante_tipo_id']==1  && $comprobante['anulado']==0)
						echo $this->Html->image('txtv2.png',['title' => 'Descargar TXT v2','url'=>['controller'=>'Comprobantes','action' => 'downloadfiletxt2', $comprobante->nota]]); ?>    
			</td>
				<td class="colcenter">
		    <?php 
					 if ($comprobante['comprobante_tipo_id']==1  && $comprobante['anulado']==0)
					 {		
							$encabezado = 'Comprobantes'.$indice.'.';			
							echo $this->Form->input($encabezado.'id',['type'=>'hidden','value'=> $comprobante->id]);
							//$habilitada = $oferta->habilitada;
							echo $this->Form->input($encabezado.'seleccionar', ['tabindex'=>$indice,'label'=>'','type'=>'checkbox','checked'=>0]); 
					 }			
			?>    
			</td>
			<td class="colcenter">			
                <?php  
				if ($comprobante->con_trazable !=0  && $comprobante['anulado']==0)
				{
					echo $this->Html->image('trazable.png', ['alt' => 'Traza de Medicamento','url'=>['controller'=>'Comprobantes','action' => 'traza', $comprobante->id]]);
					echo $this->Html->image('txt2.png',['alt'=> 'Descargar Traza de Medicamento','title' => 'Descargar TXT','url'=>['controller'=>'Comprobantes','action' => 'downloadfiletrazatxt', $comprobante->id]]); 
					echo $this->Html->image('pdf_traza.png', ['alt' => 'Traza de Medicamento','url'=>['controller'=>'Comprobantes','action' => 'trazapdf', $comprobante->id,'_ext' => 'pdf']]);
					
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
			<div class="pagination_count"><span><?= $this->Paginator->counter('{{count}} Registros') ?> </span></div
        </ul>
	<div class="importconfirm3">	
		<div class="button-holder3">	
		<?php echo $this->Form->submit('Exportar Seleccionados',['class'=>'btn_agregarvarios']); ?>
		 </div>	
	   </div>	
	    <?= $this->Form->end() ?>	
	</div>
</div>
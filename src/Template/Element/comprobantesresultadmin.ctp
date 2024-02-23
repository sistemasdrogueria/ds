<div>		
		<div id="tab1" class="tab_content">
		<table class="tablesorter" cellspacing="0"> 
		<thead> 
        <tr>
			<th><?= $this->Paginator->sort('fecha') ?></th>
			<th class="header"><?= $this->Paginator->sort('cliente_id','Codigo') ?></th>
			<th class="header"><?= $this->Paginator->sort('cliente_id','Razón Social') ?></th>
            <th><?= $this->Paginator->sort('tipo','Detalle') ?></th>
			<th><?= $this->Paginator->sort('nota','Nro Interno') ?></th>
			<th><?= $this->Paginator->sort('numero','Comprobantes') ?></th>
			<th><?= $this->Paginator->sort('importe') ?></th>
			<th>PDF</th>
			<th></th>
			
		</tr>
    </thead>
    <tbody>
	
    <?php $indice=0;?>

	
	<?php foreach ($comprobantes as $comprobante): ?>
	<?php $indice+=1;?>       
	   <tr>
            <td class="colcenter"><?php echo date_format($comprobante->fecha,'d-m-Y');?></td>
			
          
			
			<td class="colcenter">  
			 <?php echo $comprobante['cliente']['codigo']; ?> </td>
			
			<td class="colcenter">  <?php echo  $comprobante['cliente']['razon_social'];?> 
		
       </td>
	   
	   <td class="colcenter">  
			<?= $comprobante->has('comprobantes_tipo') ? $comprobante->comprobantes_tipo->nombre : '' ?>
       </td>
	   
            <td class="colcenter"><?= $this->Number->format($comprobante->nota) ?></td>
            <td class="colcenter"><?php echo str_pad($comprobante->seccion, 4, "0", STR_PAD_LEFT).'-'.$comprobante->numero;?></td>
            <td class='colprecio2'> <?php echo '$ '.number_format(round($comprobante->importe, 3),2,',','.'); ?>
			</td>
			<td class="colcenter">
                 <?php echo $this->Html->image('pdf.png',['title' => 'Descargar PDF','url'=>['controller'=>'Comprobantes','action' => 'downloadfile', $comprobante->nota, $comprobante->comprobante_tipo_id,date_format($comprobante->fecha,'Ymd')]]); ?>    
				
			</td>
			<td class="colcenter">			
                <?php  
				if ($comprobante->con_trazable !=0)
					echo $this->Html->image('trazable.png', ['alt' => 'Traza de Medicamento','url'=>['controller'=>'Comprobantes','action' => 'traza', $comprobante->id]]);?>
                     <?php echo $this->Html->image('pdf_view.png',['title' => 'Visualizar PDF','url'=>['controller'=>'Comprobantes','action' => 'view_admin', $comprobante->id,date_format($comprobante->fecha,'Ymd')]]); ?>    
				      
				            
            </td>
        </tr>

    <?php endforeach; $indice+=2;?>
    </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->prev('< ' . __('Anterior')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('Siguiente') . ' >',['tabindex'=>$indice]) ?>
			<div class="pagination_count"><span><?= $this->Paginator->counter('{{count}} Registros') ?> </span></div>
        </ul>
    </div>
</div>

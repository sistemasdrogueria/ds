<script>
	$(document).ready(function() {
		/*
		$('.formcartcant').on('keydown', function(event) {

			var quantity = Math.round($(this).val());
			if ((event.keyCode == 40 || event.keyCode == 38 || event.keyCode == 18||event.keyCode == 9 ||event.keyCode == 13 )) {
				ajaxcart($(this).attr("data-id"), quantity,$(this).attr("data-pv-id"));

			}
			

		}); */

		$(".formcartcodigo").change(function() {
            var id=$(this).attr("data-id");
			var codigo = Math.round($(this).val());
            var ean = $(this).attr("data-ean");
            var dcto = $(this).attr("data-dcto");
			ajaxcart(id,codigo , ean,dcto);


		});

		$(".formcartean").change(function() {
            var id=$(this).attr("data-id");
			var ean = $(this).val();
            var codigo = $(this).attr("data-codigo");
            var dcto = $(this).attr("data-dcto");
			ajaxcart(id,codigo , ean,dcto);

		});

		$(".formcartdcto").change(function() {
            var id=$(this).attr("data-id");
			var ean = $(this).attr("data-ean");
            var codigo = $(this).attr("data-codigo");
            var dcto =  $(this).val();
			ajaxcart(id,codigo , ean,dcto);

		});

		var inputs = document.querySelectorAll("input,select");
		for (var i = 0; i < inputs.length; i++) {
			inputs[i].addEventListener("keypress", function(e) {
				if (e.which == 13 || e.keyCode == 40 || e.keyCode == 38 || e.keyCode == 18 || e.keyCode == 9) {
					e.preventDefault();
					var nextInput = document.querySelectorAll('[tabIndex="' + (this.tabIndex + 1) + '"]');
					if (nextInput.length === 0) {
						nextInput = document.querySelectorAll('[tabIndex="1"]');
					}
					nextInput[0].focus();
				}
			})
		}



		function ajaxcart(id, codigo, ean,dcto) {

			$.ajax({
				type: "POST",
				url: "<?php echo \Cake\Routing\Router::url(array('controller' => 'TransfersProveedors', 'action' => 'itemupdateimport')); ?>",
				data: {
					id: id,
					codigo: codigo,
					ean: ean,
                    dcto : dcto,
				},
				dataType: "json",
				success: function(data, textStatus) {

                    //alertify.message("").dismissOthers();
				//	alertify.success("Cantidad Agregada Con Exito!");
				
				},
				error: function(textStatus) {
	                //console.log(textStatus);
					//window.location.replace("/products/clear");
				}
			});
		}

	});



	

</script> 

<style>
.tablesorter td{
    padding-left: 5px; 
    border-right: 1px solid #ccc !important;
}
.header{text-align: center; }
.cell_center{text-align: center; }
</style>

<?php //><script type="text/javascript">
$previous = "javascript:history.go(-1)";
if(isset($_SERVER['HTTP_REFERER'])) {
    $previous = $_SERVER['HTTP_REFERER'];
}
?>

<article class="module width_4_quarter">
<header><h3 class="tabs_involved"><?= $titulo ?></h3>
<div style="float: right; padding-top:2px"><?php echo $this->Html->image('admin/icon_transfer_proveedor.png',["alt" => "Transfer",'url' =>['controller' => 'TransfersProveedors', 'action' => 'index_admin']]);    ?></div>
<div class="volveratras"><a href="<?= $previous ?>"><?php echo $this->Html->image('icn_volver.png');?></a></div>
</header>
<div class="tab_container">
<div id="tab1" class="tab_content">
    <table class="tablesorter" cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th class="header"><?= $this->Paginator->sort('numero_pedido_proveedor','N° Ped Prov.') ?></th>
                <th class="header"><?= $this->Paginator->sort('status') ?></th>
                <th class="header"><?= $this->Paginator->sort('lab') ?></th>
                <th class="header"><?= $this->Paginator->sort('numero_pedido','N.PED.') ?></th>
                <th class="header"><?= $this->Paginator->sort('fecha_transfer','F.Trans') ?></th>
                <th class="header"><?= $this->Paginator->sort('cliente') ?></th>
                <th class="header"><?= $this->Paginator->sort('nombre') ?></th>
                <th class="header"><?= $this->Paginator->sort('ean') ?></th>
                <th class="header"><?= $this->Paginator->sort('descripcion') ?></th>
                <th class="header"><?= $this->Paginator->sort('unidades','Unid.') ?></th>
                <th class="header"><?= $this->Paginator->sort('descuento', '%') ?></th>
                <th class="header"><?= $this->Paginator->sort('cuit') ?></th>
                <th class="header"><?= $this->Paginator->sort('domicilio') ?></th>
                <th class="header"><?= $this->Paginator->sort('plazo', 'Plazo') ?></th>
               
                <th class="header" class="actions"></th>
            </tr>
        </thead>
        <tbody>
            
            <?php   $indice=0;
                    foreach ($transfersProveedors as $transfersProveedor): ?>
                    <?php
                     $colorfondo = '#ffffff';
                    switch ($transfersProveedor->status) {
                        case 0: 
                            $colorfondo = '#ffffff';;break;   
                            case 1: 
                                $colorfondo = '#ffffff';;break;  
                    case 21: 
                    $colorfondo = '#e4f6f0';;break;
                    case 22: 
                    $colorfondo = '#d1efe5';;break;
                    case 23: 
                    $colorfondo = '#98DBC6';;break;
                    case 24: 
                    $colorfondo = '#5BC8AC';break;
                    case 52: 
                    $colorfondo = '#E6D72A';break;

                    case 41: 
                    $colorfondo = '#F18D9E'; break;
                    case 8: 
                        $colorfondo = '#ffffff'; break; 
                    }
                    echo '<tr bgcolor='.$colorfondo.'>';
                    $indice+=1; $encabezado = $indice.'.'; ?>
                <td><?= $transfersProveedor->numero_pedido_proveedor ?></td>
                <td><?= $this->Number->format($transfersProveedor->status) ?></td>  
                <td><?= $this->Number->format($transfersProveedor->lab) ?></td>
                <td><?= $this->Number->format($transfersProveedor->numero_pedido) ?></td>
                <td><?php if ($transfersProveedor->fecha_transfer !=null) 
                                echo date_format($transfersProveedor->fecha_transfer,'d-m-Y');?></td>
                </td>
                <td class=cell_center>
                <?php echo $this->Form->input($encabezado.'cliente', ['label'=>'','tabindex' => $indice, 'value' => $transfersProveedor->cliente, 'class' => 'formcartcodigo', 'data-id' => $transfersProveedor->id, 'data-ean' => $transfersProveedor->ean, 'data-dcto' => $transfersProveedor->descuento,'target' => '_blank', 'autocomplete' => 'off', 'style' => 'padding: 1px 1px; width:50px;']); ?></td>
                <td><?= h($transfersProveedor->nombre) ?></td>
                <td class=cell_center>
                <?php echo $this->Form->input($encabezado.'ean', ['label'=>'','tabindex' => $indice, 'value' => $transfersProveedor->ean, 'class' => 'formcartean', 'data-id' => $transfersProveedor->id, 'data-codigo' => $transfersProveedor->cliente,'data-dcto' => $transfersProveedor->descuento, 'target' => '_blank', 'autocomplete' => 'off', 'style' => ' padding: 1px 1px; width:110px;']); ?></td>
                </td>
                <td><?= h($transfersProveedor->descripcion) ?></td>
                <td class=cell_center><?= h($transfersProveedor->unidades) ?></td>
                <td class=cell_center>
                <?php echo $this->Form->input($encabezado.'descuento', ['label'=>'','tabindex' => $indice, 'value' => $transfersProveedor->descuento, 'class' => 'formcartdcto', 'data-id' => $transfersProveedor->id,'data-ean' => $transfersProveedor->ean, 'data-codigo' => $transfersProveedor->cliente, 'target' => '_blank', 'autocomplete' => 'off', 'style' => ' padding: 1px 1px; width:50px;']); ?></td>
                    
                
                <?php //round($transfersProveedor->descuento, 2).' %'  ?></td>
                <td class=cell_center><?= h($transfersProveedor->cuit) ?></td>
                <td><?= h($transfersProveedor->domicilio) ?></td>
                <td><?= h($transfersProveedor->plazo) ?></td> 
                          
                <td class="actions">
                <?php 
                echo $this->Form->postLink(
                $this->Html->image('admin/icn_trash.png',
                array("alt" => __('Delete'), "title" => __('Delete'))), 
                array('action' => 'delete_item_admin', $transfersProveedor->id,$transfersProveedor->transfers_import_id ), 
                array('escape' => false, 'confirm' => __('Esta seguro de eliminar a # {0}?', $transfersProveedor->id))
                );?>
                </td>                
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    </div>
</div><!-- end of .tab_container -->
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <div class="total"><?php echo $this->Paginator->counter('{{count}} Total');?>
    </div>
    </div>
</article><!-- end of content manager article -->	

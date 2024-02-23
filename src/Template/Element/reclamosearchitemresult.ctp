  <script type="text/javascript">
$(function() {
    $('#form_reclamo_fv1,#form_reclamo_fv2,#form_reclamo_fv3,#form_reclamo_fv4').datepicker( {
        changeMonth: true,
        changeYear: true,
        showButtonPanel: true,
        dateFormat: 'mm/yy',
		currentText: "Hoy",
		closeText : 'Cerrar',
		//monthNames: [ "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Deciembre" ],
		monthNamesShort: [ "Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dec" ],
		
		
		onClose: function(dateText, inst) { 
            $(this).datepicker('setDate', new Date(inst.selectedYear, inst.selectedMonth, 1));
        }
    });
	});
	</script>

<div class="articulos index large-10 medium-9 columns">
    <table class='tablasearch2' cellpadding="0" cellspacing="0">
    <thead>
        <tr>	
			<th>Cant.</th>
            <th><?= $this->Paginator->sort('descripcion_pag','Descripción') ?></th>
            <th>Laboratorio</th>
			<th>Fecha Venc.</th>
            <th>Lote</th>
			<th>Serie</th>
			<th></th>
			
        </tr>
    </thead>
    <tbody>
	<div id="flotante"></div>
    <?php $indice=0;?>
	<?php 			
				 $cat = $categorias->toArray();
				 $lab = $laboratorios->toArray(); 
			$x=1;
	?>
	<?php foreach ($articulos as $articulo): ?>
        <tr>
		<?php $indice+=1;?>
		<?= $this->Form->create('Reclamos',['url'=>['controller'=>'Reclamos','action'=>'add_item']]); ?>
			<td class='form_reclamo_cant_td'>
				<?php
				echo $this->Form->input('cantidad',['tabindex'=>$indice,'class'=>'formcartcant']);
				echo $this->Form->input('articulo_id',['type'=>'hidden','value'=>$articulo['id']]);
				echo $this->Form->input('descripcion',['type'=>'hidden','value'=>$articulo['descripcion_pag']]);
				?>
			</td>
            <td class='masinfoband'>

				<div 
					onmouseover="showdiv(event,'<?php 
					echo $articulo['descripcion_pag'].'</br>'; 
					echo 'Laboratorio: '.$lab[$articulo['laboratorio_id']].'</br>';
					echo 'Categoría: '.$cat[$articulo['categoria_id']].'</br>';
					echo 'Troquel: '.$articulo['troquel'].'</br>';
					echo 'EAN: '.$articulo['codigo_barras'].'</br>';
					?>
					','<?php echo $articulo['iva'];?>'
					,'<?php echo $articulo['trazable'];?>'
					,'<?php echo $articulo['cadena_frio'];?>'
					,'<?php echo $articulo['categoria_id'];?>'
					,'<?php echo $articulo['pack'];?>
					');" onMouseOut='hiddenDiv()' 
					style='display:table;'>
					<?php echo $articulo['descripcion_pag']; 
					if ($articulo['pack'] !=null){
					echo ' <font color="red">PACK</font>';
					}
					?>	
				</div>				

			</td>
			<td> <?php echo $lab[$articulo['laboratorio_id']];?>
			</td>
			<td class="form_reclamo_fv_td">
			<?php
			
				echo $this->Form->input('fecha_vencimiento',['class'=>'form_reclamo_fv','id'=>'form_reclamo_fv'.$x, 
					'pattern'=>'\d{2}/\d{4}', 'placeholder'=> "mm/yyyy"
					]);
			?>		
			</td>
			<td class="form_reclamo_lote_td">
			<?php
					echo $this->Form->input('lote',['label'=>'','class'=>'form_reclamo_lote']);
			?>
			</td>
			<td class="form_reclamo_serie_td">
			<?php
					echo $this->Form->input('serie',['label'=>'','class'=>'form_reclamo_serie']);
					$x++;
			?>
			</td>
			<td>
			<?php
				echo $this->Form->submit('Cargar');
			?>
			
			</td>
		 <?= $this->Form->end() ?>	
        </tr>
	
    <?php endforeach; $indice+=2; ?>
    </tbody>
    </table>
    
</div>

<style>
.ui-datepicker-calendar {
    display: none;
    }
</style>
  <script type="text/javascript">
	$("tr").not(':first').hover(
	function () {
		$(this).css("background","#8FA800");
		$(this).css("color","#000");
		$(this).css("font-weight","");
		}, 
	function () {
		$(this).css("background","");
		$(this).css("color","");
		$(this).css("font-weight","");
		}
	);

	/**
	* Funcion que muestra el div en la posicion del mouse
	*/
	function showdiv(event,text,iva,traza,frio,categ,pack)
	{
					
		//determina un margen de pixels del div al raton
		margin=0;
		//La variable IE determina si estamos utilizando IE
		var IE = document.all?true:false;
		var tempX = 0;
		var tempY = 0;
		//document.body.clientHeight = devuelve la altura del body
		if(IE)
		{ //para IE
			IE6=navigator.userAgent.toLowerCase().indexOf('msie 6');
			IE7=navigator.userAgent.toLowerCase().indexOf('msie 7');
			//event.y|event.clientY = devuelve la posicion en relacion a la parte superior visible del navegador
			//event.screenY = devuelve la posicion del cursor en relaciona la parte superior de la pantalla
			//event.offsetY = devuelve la posicion del mouse en relacion a la posicion superior de la caja donde se ha pulsado
			if(IE6>0 || IE7>0)
			{
				tempX = event.x
				tempY = event.y
				if(window.pageYOffset){
					tempY=(tempY+window.pageYOffset);
					tempX=(tempX+window.pageXOffset);
				}else{
					tempY=(tempY+Math.max(document.body.scrollTop,document.documentElement.scrollTop));
					tempX=(tempX+Math.max(document.body.scrollLeft,document.documentElement.scrollLeft));
				}
			}else{
				//IE8
				tempX = event.x
				tempY = event.y
			}
		}else{ //para netscape
			//window.pageYOffset = devuelve el tamaño en pixels de la parte superior no visible (scroll) de la pagina
			//document.captureEvents(Event);
			tempX = event.pageX;
			tempY = event.pageY;
		}
		if (tempX < 0){tempX = 0;}
		if (tempY < 0){tempY = 0;}
		// Modificamos el contenido de la capa  
		var trazaimg='';
		var cadenaimg='';
		var psiimg='';
		var valeoficialimg='';
		var ivaimg='';
		if (iva==1)
		{
			 ivaimg = '<?php echo $this->Html->image('iva.png',['title' => 'IVA']);?>';
		}
		if (traza==1)
		{
			 trazaimg = '<?php echo $this->Html->image('trazable.png',['title' => 'Trazable']);?>';
		}
		if (frio==1)
		{
			 cadenaimg = '<?php echo $this->Html->image('cadenafrio.png',['title' => 'Cadena de Frio']);?>';
		}
		if (categ==7)
		{
			 valeoficialimg = '<?php echo $this->Html->image('valeoficial.png',['title' => 'Vale Oficial']);?>';
		}	 
		if (categ==6)
		{
			 psiimg = '<?php echo $this->Html->image('psi.png',['title' => 'Psicotropicos']);?>';
		}	 
		if (pack==1) 
		{
			 psiimg = '<?php echo $this->Html->image('pack.png',['title' => 'Pack']);?>';
		}	
						
		document.getElementById('flotante').innerHTML=text+ivaimg+trazaimg+cadenaimg+psiimg+valeoficialimg;
		// Posicionamos la capa flotante

		document.getElementById('flotante').style.top = (tempY-120)+"px";
		document.getElementById('flotante').style.left = (tempX-10)+"px";
		
		document.getElementById('flotante').style.display='block';
		return;
	}
	/**
	* Funcion para esconder el div
	*/
	function hiddenDiv()
	{
		document.getElementById('flotante').style.display='none';
	}
</script>

<script>
		$('table.tablasearch2').each(function() {
			var currentPage = 0;
			var numPerPage = 8;
			var $table = $(this);
			$table.bind('repaginate', function() {
				$table.find('tbody tr').hide().slice(currentPage * numPerPage, (currentPage + 1) * numPerPage).show();
			});
			$table.trigger('repaginate');
			var numRows = $table.find('tbody tr').length;
			var numPages = Math.ceil(numRows / numPerPage);
	        var $pager = $('<div class="page_cart"></div>');
			for (var page = 0; page < numPages; page++) {
				$('<div class="page-number"></div>').text(page + 1).bind('click', {
				  newPage: page
				}, function(event) {
				  currentPage = event.data['newPage'];
				  $table.trigger('repaginate');
				  $(this).addClass('active').siblings().removeClass('active');
				}).appendTo($pager).addClass('clickable');
			}
			$pager.insertAfter($table).find('div.page-number:first').addClass('active');
		});
</script>
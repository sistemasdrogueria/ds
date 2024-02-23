<?php 
		echo $this->Html->css('stylesgalery');
		echo $this->Html->css('jquery.lightbox-0.5'); 
?>
<span class='cliente_info_span'>Ofertas</span>
<div id="flotante"></div>
  <div id="w">
    <div id="content">
       
      <div id="thumbnails">
        <ul class="clearfix">
		<?php foreach ($ofertas as $oferta): ?>
			<li>
				<div>
						<?= $this->Form->create('Carritos',['url'=>['controller'=>'Carritos','action'=>'carritoaddoferta']]); ?>
						
						<?php echo $this->Form->input('cantidad',['type'=>'hidden','value'=>$oferta['uni_min']]);
				
							echo $this->Form->input('articulo_id',['type'=>'hidden','value'=>$oferta['articulo_id']]);
							echo $this->Form->input('precio_publico',['type'=>'hidden','value'=>$oferta['precio_publico']]);
							echo $this->Form->input('descripcion',['type'=>'hidden','value'=>$oferta['descripcion']]);
							if ($oferta['tipo_venta']=='D')
							{
								echo $this->Form->input('descuento',['type'=>'hidden','value'=>$oferta['dto_drogueria']]); 	
								echo $this->Form->input('plazoley_dcto',['type'=>'hidden','value'=>$oferta['plazo']]); 	
								echo $this->Form->input('unidad_minima',['type'=>'hidden','value'=>$oferta['uni_min']]); 	
								echo $this->Form->input('tipo_oferta',['type'=>'hidden','value'=>$oferta['tipo_oferta']]); 
								echo $this->Form->input('tipo_venta',['type'=>'hidden','value'=>$oferta['tipo_venta']]); 
								echo $this->Form->input('tipo_precio',['type'=>'hidden','value'=>$oferta['tipo_precio']]); 
							}
						?>	
					<div 
						onmouseover="showdiv(event,'<?php 
						echo str_replace('"', '', $oferta['descripcion']).'</br>'; 
						echo 'Oferta: '.$oferta['dto_drogueria'].'% por '.$oferta['uni_min'].'unidad(es)</br>';
						echo 'Plazo: '. $oferta['plazo'].'</br>';
						echo 'Tipo de oferta: '. $oferta['tipo_oferta'].'</br>';?>
						');" onMouseOut='hiddenDiv()' style='display:div;'>
						
						<?php  $options=array('type'=>'Make secure payment', 'type'=>'image', 'style'=>'width:120px; display:block;');
							echo $this->Form->submit('productos//thumb_'.$oferta['imagen'], $options);
						
						?>
					</div>				
					<?= $this->Form->end() ?>	
				</div>
			</li>
		<?php endforeach; ?>
        </ul>
      </div>
    </div><!-- @end #content -->
  </div><!-- @end #w -->
  <script type="text/javascript">
	/**
	* Funcion que muestra el div en la posicion del mouse
	*/
	function showdiv(event,text)
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
		
						
		document.getElementById('flotante').innerHTML=text;
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
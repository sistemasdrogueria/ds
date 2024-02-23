<style>
#search-backf{ /*background-color:#f96732 */}
#fondobf{	width: 100%;	background-color:#fff;}
.contadorbf{ box-sizing: border-box;  margin: 0;  padding: 0;  height: 90px;  }
.contadorbf h1 {  font-weight: normal;}
.contadorbf li {  display: inline-block;  font-size: 1.5em;  list-style-type: none;  padding: 1em;  text-transform: uppercase;}
.contadorbf li span {  display: block; font-size: 4.5rem;}
.contadorbf li span2 {  margin-top:20px;     display: block;}
.my-fixed-item {position: fixed; height: 100%;width: 100%;text-align: right;word-wrap: break-word;z-index:99;top:88%; }
.my-fixed-item  img{/*position:absolute;*/margin-right: 15px;}
</style>
<div class=my-fixed-item align="center">
<?php 
echo $this->Html->image('icon_whatsapp.png',['url'=>'https://api.whatsapp.com/send?phone=5492914254968'],['target' => '_blank','_full'=> true,'escape' => true,'alt'=>'WHATSAPP']);
?></div>
<div class="col-md-9">
<?php echo $this->element('metodos_de_pago'); ?>
<div class="product-item-3">
<div class="product-thumb" id="search-backf">
<?php echo $this->element('search'); ?>
</div> <!-- /.product-thumb -->
<!--div class="product-thumb" id="fondobf" >
<div>
<?php //echo $this->Html->image('bfriday.jpg',['alt'=>'BLACKFRIDAY LLEGO.','url'=>['controller'=>'carritos','action'=>'blackfriday']]);?>
</div>
<div class=contadorbf align=center style="position: absolute; left: 0px; top: 150px; z-index: 3; color: #FFFFFF">
<ul>
<li><span id="days"></span><span2>Dias</span2></li>
<li><span id="hours"></span><span2>Horas</span2></li>
<li><span id="minutes"></span><span2>Minutos</span2></li>
<li><span id="seconds"></span><span2>Segundos</span2></li>
</ul>
</div>
</div -->
<div class="product-content">
<?php if ($articulos!=null ){echo $this->element('carrito_search_result'); } else {
	//echo '<h3>OFERTAS QUE NO TE PODÉS PERDER </h3>';
	echo $this->element('carrito_search_sin_result');
	}?>
</div> <!-- /.product-content -->
<?php echo $this->element('metodos_de_pago_datos'); ?>
</div> <!-- /.product-item -->
</div> <!-- /.col-md-3 -->
<div class="col-md-3">
<div class="product-item-5"> 
<div class="product-content">
<div class="row"><?php echo $this->element('cartresum'); ?></div> <!-- /.row -->
</div> <!-- /.product-content -->
</div>
<div class="product-item-5">	
<div class="product-content">
<div class='cliente_info_class3'><?php echo $this->Html->image('ofertaagregarcarro.png');?></div>
<div class='cliente_info_class2'>Carro de Compras</div>
<div class="row">  <?php echo $this->element('botonescarro'); ?>
<div class="cartresul">	<?php echo $this->element('cartresult'); ?> </div>
</div> <!-- /.row -->
</div> <!-- /.product-content -->
</div> <!--.product-item-5 -->  
<div>
<?php
if(!is_null($promo1)) {
if ($promo1['url_metodo']!='') {
if ($promo1['url_campo']!='')
echo $this->Html->image('publicaciones/'.$promo1['imagen'],['url'=>['controller'=>$promo1['url_controlador'],'action'=>$promo1['url_metodo'],$promo1['url_campo']],'alt'=>'Drogueria Sur S.A.','width'=>'100%']);
else echo $this->Html->image('publicaciones/'.$promo1['imagen'],['url'=>['controller'=>$promo1['url_controlador'],'action'=>$promo1['url_metodo']],'alt'=>'Drogueria Sur S.A.','width'=>'100%']);
}
else echo $this->Html->image('publicaciones/'.$promo1['imagen'],['width'=>'100%']);
}
if(!is_null($promo2)) {
if ($promo2['url_metodo']!='')
{
if ($promo2['url_campo']!='') echo $this->Html->image('publicaciones/'.$promo2['imagen'],['url'=>['controller'=>$promo2['url_controlador'],'action'=>$promo2['url_metodo'],$promo2['url_campo']],'alt'=>'Drogueria Sur S.A.','width'=>'100%']);
else echo $this->Html->image('publicaciones/'.$promo2['imagen'],['url'=>['controller'=>$promo2['url_controlador'],'action'=>$promo2['url_metodo']],'alt'=>'Drogueria Sur S.A.','width'=>'100%']);
}
else echo $this->Html->image('publicaciones/'.$promo2['imagen'],['width'=>'100%']);  
}
?>
</div>
</div> <!-- /.col-md-4 -->
<div class="col-md-12">
<div class="product-item-3">
<div class="product-thumb">
<?php echo $this->element('seccion_productos_promocion');?>
</div>
</div>
</div>
<div id=dialog-message>
<?php if(!is_null($sursale))
{
if ($sursale['url_campo']!='' && $sursale['url_campo2']!='')
{
if ($sursale['url_campo']!='preventa')
echo $this->Html->image('publicaciones/'.$sursale['imagen'],['url'=>['controller'=>$sursale['url_controlador'],'action'=>$sursale['url_metodo'],$sursale['url_campo'],$sursale['url_campo2']],'id'=>'conf_img1','alt'=>'Drogueria Sur S.A.','width'=>'95%']);
else
{
echo $this->Html->link('linkoculto',['controller'=>$sursale['url_controlador'],'action'=>$sursale['url_metodo'],$sursale['descripcion']],['style'=>'display: none','id'=>'conf_img1','alt'=>'Drogueria Sur S.A.','width'=>'95%']);
echo $this->Html->image('publicaciones/'.$sursale['imagen'],['alt'=>'Drogueria Sur S.A.','width'=>'95%']);
//echo $this->Html->image('publicaciones/'.$sursale['imagen'],['url'=>['controller'=>$sursale['url_controlador'],'action'=>$sursale['url_metodo'],$sursale['descripcion']],'id'=>'conf_img1','alt'=>'Drogueria Sur S.A.','width'=>'95%']);
}
}
else
if ($sursale['url_campo']!='')
{
if ($sursale['url_campo']!='preventa')
echo $this->Html->image('publicaciones/'.$sursale['imagen'],['url'=>['controller'=>$sursale['url_controlador'],'action'=>$sursale['url_metodo'],$sursale['url_campo']],'id'=>'conf_img1','alt'=>'Drogueria Sur S.A.','width'=>'95%']);
else
{
echo $this->Html->link('linkoculto',['controller'=>$sursale['url_controlador'],'action'=>$sursale['url_metodo'],$sursale['descripcion']],['style'=>'display: none','id'=>'conf_img1','alt'=>'Drogueria Sur S.A.','width'=>'95%']);
echo $this->Html->image('publicaciones/'.$sursale['imagen'],['alt'=>'Drogueria Sur S.A.','width'=>'95%']);
//echo $this->Html->image('publicaciones/'.$sursale['imagen'],['url'=>['controller'=>$sursale['url_controlador'],'action'=>$sursale['url_metodo'],$sursale['descripcion']],'id'=>'conf_img1','alt'=>'Drogueria Sur S.A.','width'=>'95%']);
}
}
else
echo $this->Html->image('publicaciones/'.$sursale['imagen'],['url'=>['controller'=>$sursale['url_controlador'],'action'=>$sursale['url_metodo']],'id'=>'conf_img1','alt'=>'Drogueria Sur S.A.','width'=>'95%']);
}
?>
</div>
<div id=dialog-message2>
<?php if(!is_null($sursale2))
{ 
if ($sursale2['url_campo']!='' && $sursale2['url_campo2']!='')
{
if ($sursale2['url_campo']!='preventa')
echo $this->Html->image('publicaciones/'.$sursale2['imagen'],['url'=>['controller'=>$sursale2['url_controlador'],'action'=>$sursale2['url_metodo'],$sursale2['url_campo'],$sursale2['url_campo2']],'id'=>'conf_img2','alt'=>'Drogueria Sur S.A.','width'=>'95%']);
else
{
echo $this->Html->link('linkoculto',['controller'=>$sursale2['url_controlador'],'action'=>$sursale2['url_metodo'],$sursale2['descripcion']],['style'=>'display: none','id'=>'conf_img2','alt'=>'Drogueria Sur S.A.','width'=>'95%']);
echo $this->Html->image('publicaciones/'.$sursale2['imagen'],['alt'=>'Drogueria Sur S.A.','width'=>'95%']);
}
//echo $this->Html->image('publicaciones/'.$sursale2['imagen'],['url'=>['controller'=>$sursale2['url_controlador'],'action'=>$sursale2['url_metodo'],$sursale2['descripcion']],'id'=>'conf_img2','alt'=>'Drogueria Sur S.A.','width'=>'95%']);
}
else
if ($sursale2['url_campo']!='')
{
if ($sursale2['url_campo']!='preventa')           
echo $this->Html->image('publicaciones/'.$sursale2['imagen'],['url'=>['controller'=>$sursale2['url_controlador'],'action'=>$sursale2['url_metodo'],$sursale2['url_campo']],'id'=>'conf_img2','alt'=>'Drogueria Sur S.A.','width'=>'95%']);
else
{
echo $this->Html->link('linkoculto',['controller'=>$sursale2['url_controlador'],'action'=>$sursale2['url_metodo'],$sursale2['descripcion']],['style'=>'display: none','id'=>'conf_img2','alt'=>'Drogueria Sur S.A.','width'=>'95%']);
echo $this->Html->image('publicaciones/'.$sursale2['imagen'],['alt'=>'Drogueria Sur S.A.','width'=>'95%']);
//echo $this->Html->image('publicaciones/'.$sursale2['imagen'],['url'=>['controller'=>$sursale2['url_controlador'],'action'=>$sursale2['url_metodo'],$sursale2['descripcion']],'id'=>'conf_img2','alt'=>'Drogueria Sur S.A.','width'=>'95%']);
}
}
else
echo $this->Html->image('publicaciones/'.$sursale2['imagen'],['url'=>['controller'=>$sursale2['url_controlador'],'action'=>$sursale2['url_metodo']],'id'=>'conf_img2','alt'=>'Drogueria Sur S.A.','width'=>'95%']);
}
?>
</div>

<div id=dialog-message3>
<?php if(!is_null($noticiaimportante)){?>
<div>
<?php foreach($novedades as $novedade):?>
<?php if(!is_null($noticiaimportante)&&($novedade['img_file']!="")) 
{
	if ($novedade['archivopdf']>0)
	{
	echo '<iframe src="http://docs.google.com/gview?url=http://200.117.237.178/ds/webroot/img/novedades/'.$novedade['img_file'].'&embedded=true" style="width:95%; min-height:550px;" frameborder="0"></iframe>';						
	}														
	else
		echo $this->Html->image('novedades/'.$novedade['img_file'], ["alt" => "COMUNIDADO", 'style'=>"width:95%;"]);
}
//echo $this->Html->image('novedades/'.$novedade['img_file'],['url'=>['controller'=>'Novedades','action'=>'comunicado'],'alt'=>'Drogueria Sur S.A.','width'=>'80%']);
?>
<div class="member wow bounceInUp animated">
<div class=member-container data-wow-delay=.1s>
<div class=inner-container>
<div class=member-details>

<?php if(!is_null($noticiaimportante)&&($novedade['img_file']=="")) 
{
echo '<div class=member-top>';
echo '<h4 class=name style=color:#C00>'.$novedade->titulo.'</h4>';
echo '<span class=designation>'.$novedade->tipo.'</span>';
echo '</div>';
echo '<p class=texto>'.$this->Text->autoParagraph(h($novedade->descripcion)).'</p>';
echo '<p class=texto>'.$this->Text->autoParagraph(h($novedade->descripcion_completa)).'</p>';
echo '<h6>Bahia Blanca, '.date_format($novedade['fecha'],'d-m-Y').'</h6>';
}
?>
</div>
</div>
</div>
</div>
<?php endforeach;?>
</div>
<?php }?>
</div>
<script>
var futuro = new Date(2019, 11, 09, 00, 10).getTime();
//actualiza el contador cada 4 segundos ( = 4000 milisegundos)
var actualiza = 1000;
// función que calcula y escribe el tiempo en días, horas, minutos y segundos
// que faltan para la variable futuro
//alert(futuro);
function faltan() {
    var ahora = new Date().getTime();
    var faltan = futuro - ahora;
	
    // si todavís no es futuro
    if (faltan > 0) {
        var segundos = Math.round(faltan / 1000);
        var minutos = Math.floor(segundos / 60);
        var segundos_s = segundos % 60;
        var horas = Math.floor(minutos / 60);
        var minutos_s = minutos % 60;
        var dias = Math.floor(horas / 24) -31;
        var horas_s = horas % 24;
        // escribe los resultados
        (segundos_s < 10) ? segundos_s = "0" + segundos_s : segundos_s = segundos_s;
        (minutos_s < 10) ? minutos_s = "0" + minutos_s : minutos_s = minutos_s;
        (horas_s < 10) ? horas_s = "0" + horas_s : horas_s = horas_s;
        (dias < 10) ? dias = "0" + dias : dias = dias;
        
		//var resultado = dias + " dias : " + horas_s + " horas : " + minutos_s + " minutos : " + segundos_s + " segundos";
        //document.formulario.reloj.value = resultado;
		
		document.getElementById('days').innerText = dias,
        document.getElementById('hours').innerText = horas_s,
        document.getElementById('minutes').innerText = minutos_s,
        document.getElementById('seconds').innerText = segundos_s;
             


	   //actualiza el contador
        setTimeout("faltan()", actualiza);
    }
    // estamos en el futuro
    else {
        //document.formulario.reloj.value = "00 dias : 00 horas : 00 minutos : 00 segundos";
    }
}
//faltan();

var $ingreso=0;
var $ingreso2=0;
var $ingreso3=0;
var $ingreso=<?php if(!empty($sursale)){if(empty($this->request->session()->read('ingreso'))){echo '0';}else echo '1';}else echo '1';?>;
var $ingreso2=<?php if(!empty($sursale2)){if(empty($this->request->session()->read('ingreso2'))){echo '0';}else echo '1';}else echo '1';?>;
var $ingreso3=<?php if(!empty($noticiaimportante)){if(empty($this->request->session()->read('ingreso3'))){echo '0';}else echo '1';}else echo '1';?>;

var $confirmX=<?php if(!empty($sursale)){if($sursale['url_campo']!='preventa')echo '0';else echo '1';}else echo '0';?>;
var $confirmY=<?php if(!empty($sursale2)){if($sursale2['url_campo']!='preventa')echo '0';else echo '1';}else echo '0';?>;

if($ingreso>0){document.getElementById("dialog-message").style.display="none";<?php echo $this->request->session()->write('ingreso',1)?>window.scrollTo(0,0)}
if($ingreso2>0){document.getElementById("dialog-message2").style.display="none";<?php echo $this->request->session()->write('ingreso2',1)?>window.scrollTo(0,0)}
if($ingreso3>0){document.getElementById("dialog-message3").style.display="none";<?php echo $this->request->session()->write('ingreso3',1)?>window.scrollTo(0,0)}
$(document).ready(function(){
	
   
    //if($ingreso<1){$("#dialog-message").dialog({open:function(c,d){$(".ui-dialog-titlebar",d.dialog).hide()},height:$(window).height()*1,width:$(window).width()*0.7,closeOnEscape:false,position:{my:"center top",at:"center top",of:window,collision:"none"},modal:true,buttons:{Continuar:function(){$(this).dialog("close")}}});<?php echo $this->request->session()->write('ingreso',1);?>window.scrollTo(0,0)}
	
  /*  if($ingreso<1 && $confirmX<1){$("#dialog-message").dialog({open:function(c,d){$(".ui-dialog-titlebar",d.dialog).hide()},height:$(window).height()*1,width:$(window).width()*0.7,closeOnEscape:false,position:{my:"center top",at:"center top",of:window,collision:"none"},modal:true,
	
	buttons:	{
				'Continuar'			: function(){$(this).dialog("close")},
				'Agregar al Carrito': function(){
					
					var conf1 = document.getElementById('conf_img1');
					if (conf1 instanceof HTMLImageElement)
						{
							// Using parentNode to get the image element parent - the anchor element.
							//alert(conf1.parentNode.getAttribute('href'));
							//console.log(el.parentNode.getAttribute('href'));
						}
					
					location.href = conf1.parentNode.getAttribute('href');  $(this).dialog("close")}
					}
	});
	window.scrollTo(0,0)}
    else*/
	if($ingreso<1 && $confirmX>0){$("#dialog-message").dialog({open:function(c,d){$(".ui-dialog-titlebar",d.dialog).hide()},height:$(window).height()*1,width:$(window).width()*0.7,closeOnEscape:false,position:{my:"center top",at:"center top",of:window,collision:"none"},modal:true,
	
	buttons:	{
				'Continuar'			: function(){$(this).dialog("close")},
				'Comprar preventa': function(){
                    var conf1 = document.getElementById("conf_img1");
					location.href = conf1.href;
                    $(this).dialog("close")}
					}
	});
	window.scrollTo(0,0)}
    else
    if($ingreso<1 && $confirmX<1)
    {$("#dialog-message").dialog({open:function(c,d){$(".ui-dialog-titlebar",d.dialog).hide()},height:$(window).height()*1,width:$(window).width()*0.7,closeOnEscape:false,position:{my:"center top",at:"center top",of:window,collision:"none"},modal:true,buttons:{Continuar:function(){$(this).dialog("close")}}});<?php echo $this->request->session()->write('ingreso',1);?>window.scrollTo(0,0)}

    if($ingreso2<1 && $confirmY>0){$("#dialog-message2").dialog({open:function(c,d){$(".ui-dialog-titlebar",d.dialog).hide()},height:$(window).height()*1,width:$(window).width()*0.7,closeOnEscape:false,position:{my:"center top",at:"center top",of:window,collision:"none"},modal:true,
	
	buttons:	{
				'Continuar'			: function(){$(this).dialog("close")},
				'Comprar preventa': function(){
                    var conf2 = document.getElementById("conf_img2");
					location.href = conf2.href;
                    $(this).dialog("close")}
					}
	});
	window.scrollTo(0,0)}
    else
    if($ingreso2<1 && $confirmY<1)
    {$("#dialog-message2").dialog({open:function(c,d){$(".ui-dialog-titlebar",d.dialog).hide()},height:$(window).height()*1,width:$(window).width()*0.7,closeOnEscape:false,position:{my:"center top",at:"center top",of:window,collision:"none"},modal:true,buttons:{Continuar:function(){$(this).dialog("close")}}});<?php echo $this->request->session()->write('ingreso2',1);?>window.scrollTo(0,0)}
	    
      
    
    //if($ingreso2<1){$("#dialog-message2").dialog({open:function(c,d){$(".ui-dialog-titlebar",d.dialog).hide()},height:$(window).height()*1,width:$(window).width()*0.7,closeOnEscape:false,position:{my:"center top",at:"center top",of:window,collision:"none"},modal:true,buttons:{Continuar:function(){$(this).dialog("close")}}});<?php echo $this->request->session()->write('ingreso2',1);?>window.scrollTo(0,0)}
	
    
    if($ingreso3<1){$("#dialog-message3").dialog({open:function(c,d){$(".ui-dialog-titlebar",d.dialog).hide()},height:$(window).height()*1,width:$(window).width()*0.7,closeOnEscape:false,position:{my:"center top",at:"center top",of:window,collision:"none"},modal:true,buttons:{Continuar:function(){$(this).dialog("close")}}});<?php echo $this->request->session()->write('ingreso3',1);?>window.scrollTo(0,0)}
	});
</script>



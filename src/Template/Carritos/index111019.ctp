<div class="col-md-9">
<div class="product-item-3">
<div class="product-thumb">
<?php echo $this->element('search'); ?>
</div> <!-- /.product-thumb -->
<div class="product-content">
<?php if ($articulos!=null ){echo $this->element('carrito_search_result'); } else {
	echo '<h3>OFERTAS QUE NO TE PODÉS PERDER </h3>';
	echo $this->element('carrito_search_sin_result');
	}?>
</div> <!-- /.product-content -->
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
</div> <!--.product-item-1 -->  
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
	if ($sursale['url_campo']!='')
		echo $this->Html->image('publicaciones/'.$sursale['imagen'],['url'=>['controller'=>$sursale['url_controlador'],'action'=>$sursale['url_metodo'],$sursale['url_campo']],'alt'=>'Drogueria Sur S.A.','width'=>'95%']);
	else
		echo $this->Html->image('publicaciones/'.$sursale['imagen'],['url'=>['controller'=>$sursale['url_controlador'],'action'=>$sursale['url_metodo']],'alt'=>'Drogueria Sur S.A.','width'=>'95%']);
}
	?>
</div>
<div id=dialog-message2>
<?php if(!is_null($sursale2))
{ 
	if ($sursale2['url_campo']!='')
		echo $this->Html->image('publicaciones/'.$sursale2['imagen'],['url'=>['controller'=>$sursale2['url_controlador'],'action'=>$sursale2['url_metodo'],$sursale2['url_campo']],'alt'=>'Drogueria Sur S.A.','width'=>'95%']);
	else
		echo $this->Html->image('publicaciones/'.$sursale2['imagen'],['url'=>['controller'=>$sursale2['url_controlador'],'action'=>$sursale2['url_metodo']],'alt'=>'Drogueria Sur S.A.','width'=>'95%']);
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
var $ingreso=0;
var $ingreso2=0;
var $ingreso3=0;
var $ingreso=<?php if(!empty($sursale)){if(empty($this->request->session()->read('ingreso'))){echo '0';}else echo '1';}else echo '1';?>;
var $ingreso2=<?php if(!empty($sursale2)){if(empty($this->request->session()->read('ingreso2'))){echo '0';}else echo '1';}else echo '1';?>;
var $ingreso3=<?php if(!empty($noticiaimportante)){if(empty($this->request->session()->read('ingreso3'))){echo '0';}else echo '1';}else echo '1';?>;
if($ingreso>0){document.getElementById("dialog-message").style.display="none";<?php echo $this->request->session()->write('ingreso',1)?>window.scrollTo(0,0)}
if($ingreso2>0){document.getElementById("dialog-message2").style.display="none";<?php echo $this->request->session()->write('ingreso2',1)?>window.scrollTo(0,0)}
if($ingreso3>0){document.getElementById("dialog-message3").style.display="none";<?php echo $this->request->session()->write('ingreso3',1)?>window.scrollTo(0,0)}
$(document).ready(function(){
	if($ingreso<1){$("#dialog-message").dialog({open:function(c,d){$(".ui-dialog-titlebar",d.dialog).hide()},height:$(window).height()*1,width:$(window).width()*0.7,closeOnEscape:false,position:{my:"center top",at:"center top",of:window,collision:"none"},modal:true,buttons:{Continuar:function(){$(this).dialog("close")}}});<?php echo $this->request->session()->write('ingreso',1);?>window.scrollTo(0,0)}
	if($ingreso2<1){$("#dialog-message2").dialog({open:function(c,d){$(".ui-dialog-titlebar",d.dialog).hide()},height:$(window).height()*1,width:$(window).width()*0.7,closeOnEscape:false,position:{my:"center top",at:"center top",of:window,collision:"none"},modal:true,buttons:{Continuar:function(){$(this).dialog("close")}}});<?php echo $this->request->session()->write('ingreso2',1);?>window.scrollTo(0,0)}
	if($ingreso3<1){$("#dialog-message3").dialog({open:function(c,d){$(".ui-dialog-titlebar",d.dialog).hide()},height:$(window).height()*1,width:$(window).width()*0.7,closeOnEscape:false,position:{my:"center top",at:"center top",of:window,collision:"none"},modal:true,buttons:{Continuar:function(){$(this).dialog("close")}}});<?php echo $this->request->session()->write('ingreso3',1);?>window.scrollTo(0,0)}
	});
</script>



<style>
#la div { hyphens: auto;text-align: justify;margin: 0;white-space: pre-wrap;text-align: justify;}
#la .title-conditions {text-decoration: underline;margin: 0;}
.custom-style-title {text-decoration: underline;margin: 0;font-weight: 800;}
#la p {hyphens: auto;text-align: justify;white-space: pre-wrap;margin-top: 0cm;margin-right: 0cm;margin-bottom: 0cm;margin-left: 17.85pt;text-align: justify;text-indent: -17.85pt;line-height: 115%;}
#la h5 {margin: 0;}
.button-enabled {background-color: #3498db;color: #ffffff;opacity: 1;transform: scale(1);border-radius: 5px;}
.custom-style { background-color: #f2f2f2; color: #999999; opacity: 0.5; cursor: not-allowed;transform: scale(0.9);border-radius: 5px;}
#contador{	 width: 100%;    padding-bottom: 30px;}
.contador_fondo{ width: 100%; overflow: hidden; }
.contador_num{ box-sizing: border-box; margin: 0;  padding: 0;  text-align:center ; width: 60%; color: #000; float:right ;} 
.contador_num_logo { box-sizing: border-box; z-index: 100 !important; margin: 0;  padding: 0;  text-align:center ; width: 40%; color: #000 ; float: left; }
.contador_num h1 {  font-weight: normal;}
.contador_num li {  display: inline-block;  font-size: 1.4em;  list-style-type: none;  padding: 1.1em;  text-transform: uppercase;}
.contador_num li span {  display: block; font-size: 4.5rem;}
.contador_num li span2 {  margin-top:20px;     display: block;}
.my-fixed-item {position: fixed; z-index:99;top:88%;left: 95%; }
.my-fixed-item  img{/*position:absolute;*/margin-right: 15px;}
.dialog-message2{overflow: hidden  !important; padding: 0; }
.eliminarbordes{border:0!important;background:#f8f9fc00!important;color:#f8f9fc0f!important}
.eliminarbordesbar{border:0!important;background:#f8f9fc00!important;color:#f8f9fc0f!important;top:35px!important;z-index:300}
.eliminarbordesbar .ui-dialog-title{display:none}
.eliminarbordesbar .ui-dialog-titlebar-close{background-color:#fff;color:#fff}
.btn-cancelar{height:20px;float:right;position:relative;top:-98%;margin-right:-119px;font-size:12px!important;font-weight:600;background-color:#005ca8;color:#fff;border-radius:5px;border-color:#005ca8;border-width:1px;text-decoration:none}
.ui-widget-overlay{background:#f8f9fc91;opacity:.2;filter:Alpha(Opacity=.3)}
.botonx{background-image:none!important}
.ui-widget-content a:hover{color:inherit}
.ui-widget-content img:hover{color:inherit}
.eliminarbordes .ui-dialog-buttonset button{display:none}
#container {  width: 100%;}
.header { display: flex;  flex-direction: row;  justify-content: space-between; background-color: white; margin-top: -130px;}
.background-image { width: 100%;  height: 100%; overflow: hidden;}
@media (max-width: 1300px) {.contador_num{  width: 60%;} .contador_num_logo { width: 40%; }.header{   margin-top: -110px;}}
@media (max-width: 1100px) {.contador_num{  width: 60%;} .contador_num_logo { width: 40%; }.contador_num li {  font-size: 1em; padding: 0.9em; }.contador_num li span {  font-size: 3rem;}.header{   margin-top: -90px;}.contador_num li span2 {  margin-top:10px;}}
@media (max-width: 1000px) {.contador_num{  width: 70%;} .contador_num_logo { width: 30%; }.contador_num li {  font-size: 0.9em;  }.contador_num li span {  font-size: 2.5rem;}.contador_num li span2 {  margin-top:10px;}.header{   margin-top: -80px;}}
</style>
<div class=my-fixed-item align="center">
<?php echo $this->Html->image('icon_whatsapp.png',['url'=>'https://api.whatsapp.com/send?phone=5492914254968'],['target' => '_blank','_full'=> true,'escape' => true,'alt'=>'WHATSAPP']);?></div>
<div class="col-md-12">
<?php echo $this->element('banner_slider'); ?>
<div class="product-thumb" id="search-backf">
<?php echo $this->element('search'); ?>
</div> 
<!--div  class="product-thumb" id="container">
<div class="background-image">
  <?php //echo $this->Html->image('EXPO11_FONDO-CUENTA-REGRESIVA.jpg',['alt'=>'EXPOVIRTUAL 11.','url'=>'https://www.exposurvirtual.com.ar',['target' => '_blank','_full'=> true,'escape' => true]]); ?>
</div>
<div class="header">
<div class="contador_num_logo"></div>
<div class=contador_num align=center>
<ul>
<li><span id="days"></span><span2>Dias</span2></li>
<li><span id="hours"></span><span2>Horas</span2></li>
<li><span id="minutes"></span><span2>Minutos</span2></li>
<li><span id="seconds"></span><span2>Segundos</span2></li>
</ul>
</div>
</div>
</div-->
<div class="product-item-3">
<div class="product-content">
<?php if ($articulos!=null ){echo $this->element('carrito_search_result'); } else { echo $this->element('carrito_search_sin_result');}?>
</div> <!-- /.product-content -->
</div> <!-- /.product-item -->
</div> <!-- /.col-md-3 -->
<?php $seccioninit =1?>
<?php foreach($secciones as $seccion):?>
<div class="col-md-12" id=seccionpp<?php echo $seccion['orden']?> style="background-color:#f4f4f4 ;margin-top:15px;">
<?php echo $this->element('seccion_productos_promocion_div2',['titulo_seccion'=>$seccion['nombre'],'ofertasProms'=>$ofertasX,'ofertasArts'=>$ofertasY,'tipo_off'=>$seccion['id'],'autoplay'=>$seccioninit]);
if ($seccioninit==1) $seccioninit=0; ?>
</div>
<?php endforeach;?>
<div class="modal fade"  style="background:repeating-linear-gradient(135deg, rgb(151 151 151 / 44%), rgb(151 151 151 / 19%) 1%, rgba(151, 151, 151, 0.32) 1%);display: flex;flex-direction: row;flex-wrap: nowrap;align-content: center;justify-content: center;align-items: center;"data-keyboard="false" data-backdrop="static" 
id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog"  style="width:100%;max-width:1100px;" role="document">
<div class="modal-content">
<!-- Modal heading -->
<div class="modal-header-intro"> <button type="button" class="close-intro" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
</button>
</div>
<!-- Modal body with image -->
<div class="modal-body-intro">                      
<?php if(!is_null($sursale))
{
if ($sursale['url_campo']!='' && $sursale['url_campo2']!='')
{
if ($sursale['url_campo']!='preventa')
{
if ($sursale['url_controlador']=="URL")
{
echo '<a href="'.$sursale['url_campo'].'" target ="_blank">'.$this->Html->image('publicaciones/'.$sursale['imagen'], ['alt' => 'LINK','width'=>'100%']) .'</a>';
}
else
echo $this->Html->image('publicaciones/'.$sursale['imagen'],['url'=>['controller'=>$sursale['url_controlador'],'action'=>$sursale['url_metodo'],$sursale['url_campo'],$sursale['url_campo2']],'id'=>'conf_img1','alt'=>'Drogueria Sur S.A.','width'=>'100%']);
}
else
{
echo $this->Html->link('linkoculto',['controller'=>$sursale['url_controlador'],'action'=>$sursale['url_metodo'],$sursale['descripcion']],['style'=>'display: none','id'=>'conf_img1','alt'=>'Drogueria Sur S.A.','width'=>'100%']);
echo $this->Html->image('publicaciones/'.$sursale['imagen'],['alt'=>'Drogueria Sur S.A.','width'=>'100%']);
}
}
else{
if ($sursale['url_campo']!=''  && empty($sursale['laboratorio_id']) )
{
if ($sursale['url_campo']!='preventa')
echo $this->Html->image('publicaciones/'.$sursale['imagen'],['url'=>['controller'=>$sursale['url_controlador'],'action'=>$sursale['url_metodo'],$sursale['url_campo']],'id'=>'conf_img1','alt'=>'Drogueria Sur S.A.','width'=>'100%']);
else
{
echo $this->Html->link('linkoculto',['controller'=>$sursale['url_controlador'],'action'=>$sursale['url_metodo'],$sursale['descripcion']],['style'=>'display: none','id'=>'conf_img1','alt'=>'Drogueria Sur S.A.','width'=>'100%']);
echo $this->Html->image('publicaciones/'.$sursale['imagen'],['alt'=>'Drogueria Sur S.A.','width'=>'100%']);
}
}
else{
if (!empty($sursale['laboratorio_id'])){
	 if(!empty($sursale["url_campo"])){
        $urlcampo = $sursale["url_campo"];
      }else{
        $urlcampo =' ';
      }
echo $this->Html->image('publicaciones/'.$sursale['imagen'],['url'=>['controller'=>$sursale['url_controlador'],'action'=>$sursale['url_metodo'],$urlcampo,$sursale['laboratorio_id']],'id'=>'conf_img1','alt'=>'Drogueria Sur S.A.','width'=>'100%']);
}else{
echo $this->Html->image('publicaciones/'.$sursale['imagen'],['url'=>['controller'=>$sursale['url_controlador'],'action'=>$sursale['url_metodo']],'id'=>'conf_img1','alt'=>'Drogueria Sur S.A.','width'=>'100%']);
}
}
}
}
?>
 </div>

<div class="moda-footer-intro">
<button class="btn-continuar"onclick="closedivbutton(1)"  >Continuar</button>
</div>
</div>
</div>
</div>
<div class="modal fade" style="background:repeating-linear-gradient(135deg, rgb(151 151 151 / 44%), rgb(151 151 151 / 19%) 1%, rgba(151, 151, 151, 0.32) 1%);display: flex;flex-direction: row;flex-wrap: nowrap;align-content: center;justify-content: center;align-items: center;" data-keyboard="false" data-backdrop="static" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"  aria-hidden="true">
<div class="modal-dialog"  style="width:100%;max-width:1100px;" role="document">
<div class="modal-content">
<!-- Modal heading -->
<div class="modal-header-intro">
<button type="button" class="close-intro" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true"> × </span>
</button>
</div>
<!-- Modal body with image -->
<div class="modal-body-intro" onclick="closediv()">
<?php if(!is_null($sursale2))
{ 
if ($sursale2['url_campo']!='' && $sursale2['url_campo2']!='')
{
if ($sursale2['url_campo']!='preventa')
if ($sursale2['url_controlador']=="URL")
{
echo '<a href="'.$sursale2['url_campo'].'" target ="_blank">'.$this->Html->image('publicaciones/'.$sursale2['imagen'], ['alt' => 'LINK','width'=>'100%']) .'</a>';
}
else
echo $this->Html->image('publicaciones/'.$sursale2['imagen'],['url'=>['controller'=>$sursale2['url_controlador'],'action'=>$sursale2['url_metodo'],$sursale2['url_campo'],$sursale2['url_campo2']],'id'=>'conf_img2','alt'=>'Drogueria Sur S.A.','width'=>'100%']);
else
{
echo $this->Html->link('linkoculto',['controller'=>$sursale2['url_controlador'],'action'=>$sursale2['url_metodo'],$sursale2['descripcion']],['style'=>'display: none','id'=>'conf_img2','alt'=>'Drogueria Sur S.A.','width'=>'100%']);
echo $this->Html->image('publicaciones/'.$sursale2['imagen'],['alt'=>'Drogueria Sur S.A.','width'=>'100%']);
}
}else{
if ($sursale2['url_campo']!='' && empty($sursale2['laboratorio_id']))
{
if ($sursale2['url_campo']!='preventa')           
echo $this->Html->image('publicaciones/'.$sursale2['imagen'],['url'=>['controller'=>$sursale2['url_controlador'],'action'=>$sursale2['url_metodo'],$sursale2['url_campo']],'id'=>'conf_img2','alt'=>'Drogueria Sur S.A.','width'=>'100%']);
else
{
echo $this->Html->link('linkoculto',['controller'=>$sursale2['url_controlador'],'action'=>$sursale2['url_metodo'],$sursale2['descripcion']],['style'=>'display: none','id'=>'conf_img2','alt'=>'Drogueria Sur S.A.','width'=>'100%']);
echo $this->Html->image('publicaciones/'.$sursale2['imagen'],['alt'=>'Drogueria Sur S.A.','width'=>'100%']);
}
}
else{
if (!empty($sursale2['laboratorio_id'])){
	   if(!empty($sursale2["url_campo"])){
        $urlcampo = $sursale2["url_campo"];
      }else{
         $urlcampo =' ';
      }
echo $this->Html->image('publicaciones/'.$sursale2['imagen'],['url'=>['controller'=>$sursale2['url_controlador'],'action'=>$sursale2['url_metodo'],$urlcampo,$sursale2['laboratorio_id']],'id'=>'conf_img2','alt'=>'Drogueria Sur S.A.','width'=>'100%']);
}else{
echo $this->Html->image('publicaciones/'.$sursale2['imagen'],['url'=>['controller'=>$sursale2['url_controlador'],'action'=>$sursale2['url_metodo']],'id'=>'conf_img2','alt'=>'Drogueria Sur S.A.','width'=>'100%']);

}
}
}
}
?>
</div>
<div class="moda-footer-intro">
<button class="btn-continuar"onclick="closedivbutton(2)"  >Continuar</button>
</div>
</div>
</div>
</div>

<div class="modal fade" style="background:repeating-linear-gradient(135deg, rgb(151 151 151 / 44%), rgb(151 151 151 / 19%) 1%, rgba(151, 151, 151, 0.32) 1%);display: flex;flex-direction: row;flex-wrap: nowrap;align-content: center;justify-content: center;align-items: center;" data-keyboard="false" data-backdrop="static" id="exampleModal3" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog"  style="width:100%;max-width:1100px;" role="document">
<div class="modal-content">
<!-- Modal heading -->
<div class="modal-header-intro">
<button type="button" class="close-intro" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">×</span>
</button>
</div>
<!-- Modal body with image -->
<div class="modal-body-intro">
<?php if(!is_null($noticiaimportante)){?>
<div>
<?php foreach($novedades as $novedade):?>
<?php if(!is_null($noticiaimportante)&&($novedade['img_file']!="")) 
{
	if ($novedade['archivopdf']>0)
	{
	echo '<iframe  onclick="closediv()" src="https://docs.google.com/gview?url=https://200.117.237.178/ds/webroot/img/novedades/'.$novedade['img_file'].'&embedded=true" style="width:100%; min-height:550px;" frameborder="0"></iframe>';						
	}														
	else
		echo $this->Html->image('novedades/'.$novedade['img_file'], ["alt" => "COMUNIDADO", 'style'=>"width:100%;"]);
}
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
<div class="moda-footer-intro">
<button class="btn-continuar" onclick="closedivbutton(3)"> Continuar</button>
</div>
</div>
</div>
</div>
<script>
var $ingreso=0;
var $ingreso2=0;
var $ingreso3=0;
var $ingreso=<?php if(!empty($sursale)){if(empty($this->request->session()->read('ingreso'))){echo '0';}else echo '1';}else echo '1';?>;
var $ingreso2=<?php if(!empty($sursale2)){if(empty($this->request->session()->read('ingreso2'))){echo '0';}else echo '1';}else echo '1';?>;
var $ingreso3=<?php if(!empty($noticiaimportante)){if(empty($this->request->session()->read('ingreso3'))){echo '0';}else echo '1';}else echo '1';?>;
var $confirmX=<?php if(!empty($sursale)){if($sursale['url_campo']!='preventa')echo '0';else echo '1';}else echo '0';?>;
var $confirmY=<?php if(!empty($sursale2)){if($sursale2['url_campo']!='preventa')echo '0';else echo '1';}else echo '0';?>;
var conditions = <?php if ($this->request->session()->read('Auth.User.conditions')) {
							if ($this->request->session()->read('Auth.User.conditions')) echo '1';
							else echo '0';
						} else echo '0'; ?>;
	if (conditions == 0) {
		var pre = document.createElement('pre');
		var content = `<div id="la" class=""><h5>VERSION VIGENTE: 1 de enero de 2024.</h5>
<div><h5 class="title-conditions">1. El Sitio:</h5>
<p>1.1 Drogueria Sur SA – Ciudad Bahia Blanca Buenos Aires, es una empresa que entre otras actividades realiza la venta al por mayor de  medicamentos a través de la cadena legal de abastecimiento y dentro de los establecimientos habilitados para tal 
fin, productos médicos de venta libre, artículos de higiene personal, bucal y de tocador, cosmética y perfumes (los “Productos”).
</p>
<p>1.2 Drogueria Sur SA es propietaria y administra un sitio web que corre sobre la URL www.drogueriasur.com.ar, www.drogueriasur.com y www.drogueriasur.ar (el “Sitio”), exclusivo para la realización de compras de los Productos, destinado a farmacias, ubicadas 
en la República Argentina 
</p>
<p>1.3 El Sitio tiene como objetivo proporcionar una plataforma en línea para que los Usuarios (según se los define más adelante) puedan realizar la reserva y/o compra de los Productos.
</p>
</div>
<div><h5  class="title-conditions">2. Condiciones Generales:</h5>

<p>2.1 Estos términos y condiciones (en adelante los "Términos y Condiciones”) establecen las condiciones para operar el Sitio y tienen por objeto regular el uso y acceso al mismo.  
</p> 
<p>2.2 Podrán acceder y utilizar el Sitio todas las personas humanas y jurídicas que tengan capacidad legal para contratar. Las personas jurídicas actuarán a través de las personas humanas que tengan facultades suficientes para representarlas.  
</p>
<div ><h5  class="title-conditions">3. Usuarios - Credenciales:</h5>

<p>3.1 Son usuarios del Sitio (el “Usuario” o los “Usuarios” en forma indistinta según corresponda), todas aquellas personas humanas o jurídicas que accedan y utilicen el Sitio.  
</p>
<p>3.2 Aquellos Usuarios que accedan al Sitio podrán navegar en el mismo para realizar búsqueda y reserva o compra de los Productos.  
</p>
<p>3.3 Para generar las Credenciales (según se define seguidamente) necesarias para utilizar el Sitio, los Usuarios deberán registrarse a través de los mecanismos establecidos por Drogueria Sur SA, y conforme la información y/o documentación que le sea 
requerida. Toda la información proporcionada al momento de registrarse  debe ser precisa, veraz y válida y deberá ser debidamente actualizada cuando corresponda. Drogueria Sur SA no es responsable de los errores o consecuencias derivadas de la información proporcionada de manera incorrecta o incompleta.  
Los Usuarios podrán solicitar en cualquier momento la cancelación del registro que hayan efectuado, como así también Drogueria Sur SA podrá notificar al Usuario el cese de la prestación de los servicios prestados en el Sitio y/o su baja como Usuario, sin que ello genere derecho a reclamo por parte del Usuario.
</p> 
<p>3.4 Una vez realizado el registro, para acceder al Sitio los Usuarios deberán   identificarse  ingresando su nombre de usuario (la “Cuenta”) y una clave personal, secreta, confidencial e intransferible de su exclusivo conocimiento (la “Contraseña” y junto con la Cuenta las “Credenciales”).
</p> 
<p>3.5 Queda expresamente establecido que las Credenciales son de uso personal, y el Usuario no podrá informarlas, cederlas, transferirlas y/o venderlas a terceros, asumiendo toda responsabilidad por el incumplimiento de ello. El Usuario se compromete a extremar las medidas que resulten necesarias a fin de resguardar la confidencialidad, seguridad y confiabilidad de las mismas.
Los Usuarios serán los únicos y exclusivos responsables por las operaciones y/o ingresos que se realicen en el Sitio mediante el uso de sus Credenciales, ya sea por sí y/o por terceros, por cuanto el acceso al Sitio se encuentra circunscripto al uso de las 
Credenciales que de su exclusivo conocimiento de los Usuarios. 
</p> 
<p>3.6 El Usuario declara conocer y aceptar que:
 a) las Credenciales son de uso personal, personal e intransferible, y en virtud de ello, el Usuario será el único y exclusivo responsable por todas las acciones efectuadas con sus Credenciales.
 b) el acceso otorgado es únicamente para su uso por parte del Usuario, y que en ninguna circunstancia podrá ceder el acceso a ningún tercero. 
 c) el acceso al Sitio es concedido es única y exclusivamente para la realización de reservas o compras de los Productos, y no debe utilizarse para ningún otro fin. 
</p> 
<p>3.7 Se encuentra expresamente prohibido al Usuario ya sea por sí o por terceros: 
 a) Extraer contenidos del Sitio, acceder ilegalmente al Sitio, o realizar ingeniería inversa.
 b) Ceder a terceros la Información (según se define en la cláusula 4.1) o permitirle tomar conocimiento de la misma.
 c) Utilizar bots, rastreadores, scripts, virus, gusanos o cualquier otro código informático, archivos, programas o procesos automatizados, extractores de contenido u otros medios automatizados para acceder o recopilar datos u otro contenido del Sitio o interactuar de otro modo con él.
 d) Acceder ilegalmente, evitar, eliminar, menoscabar, eludir cualquier medida tecnológica o de seguridad utilizada para proteger el Sitio o su contenido.
 e) Copiar, mostrar o reflejar el Sitio, ni su contenido, marca, diseño o disposición del mismo.
 f) Utilizar el nombre, el logotipo, la marca registrada o las marcas comerciales del Sitio.
 g) Utilizar, registrar ningún dominio, nombre de usuario de redes sociales, nombre comercial, marca comercial, marca, logotipo u otro identificador de origen que pueda confundirse con la marca del Sitio.
La enumeración anterior tiene carácter meramente enunciativo y sin perjuicio de los recursos legales que correspondan, en caso de infracción, Drogueria Sur SA se reserva el derecho de cancelar el registro y dar de baja a cualquier Usuario, como así también en caso de incumplimiento de obligaciones a cargo del Usuario bajo los Términos y Condiciones y/o cualquier norma legal aplicable. En cualquiera los supuestos, el Usuario no tendrá derecho a realizar reclamo indemnizatorio.  
</p> 
</div>
<div> <h5  class="title-conditions">4. Responsabilidad del Usuario:</h5>
<p>4.1 El Sitio contiene datos y/o información comercial de los Productos, tales como (a modo de ejemplo sin limitación): stock, precios y condiciones de venta (la “Información”). El Usuario reconoce y acepta que el Sitio es de uso exclusivo para los Usuarios y que la Información es confidencial y de propiedad exclusiva de Drogueria Sur SA
</p> 
<p>4.2 El Usuario se obliga a:
 a) Guardar la más estricta confidencialidad respecto a la Información;
 b) No ceder a terceros la Información;
 c) No permitir a terceros el acceso a la Información;
 d) Utilizar el Sitio y/o la Información única y exclusivamente en forma personal y para realizar la compra o reserva de los Productos.
 </p>
<p>4.3 El Usuario reconoce y acepta que es único y exclusivo responsable de todos aquellos datos y/o información que haya suministrado o suministre al Sitio.  Para proteger los datos y/o la información provista por el Usuario, el Sitio cuenta con los más altos estándares de seguridad, y por tanto el Usuario será el único y exclusivo responsable en caso que terceros accedan en forma ilegitima al Sitio mediante el uso de las Credenciales que son de exclusivo conocimiento del Usuario.
</p> 
<p>4.4 El Usuario no intentará acceder al Sitio bajo ninguna forma o mecanismo distinto al establecido por Drogueria Sur SA, ni podrá utilizar medios automáticos de acceso.  
</p>
<p>4.5 El Usuario no podrá ceder, vender o transferir a ningún tercero las Credenciales, ni facilitarle en forma alguna el acceso al Sitio y/o la Información.
</p>
<p>4.6 El Usuario no podrá vender, ceder o transferir a terceros la Información.
</p>
<p>4.7 El Usuario deberá notificar en forma inmediata y por un medio fehaciente a Drogueria Sur SA, cualquier uso no autorizado de sus Credenciales, como así también el ingreso por terceros no autorizados en el Sitio.
</p>
<p>4.8 Queda expresamente establecido que todo uso y acceso no autorizado al Sitio, implica una violación directa de los presentes Términos y Condiciones, y a la legislación aplicable en la materia.  
</p> 
<p>4.9 En caso que el Usuario incurra en conductas dolosas o fraudulentes, y/o ante el incumplimiento a cualquiera de las obligaciones precedentes, y/o de los presentes Términos y Condiciones y/o cualquier normativa aplicable por parte de los Usuarios, Drogueria Sur SA se reserva la facultad de cancelar el registro y dar de baja al Usuario responsable, sin perjuicio del ejercicio de las acciones legales que correspondan, todo ello sin que pueda generarle derecho a reclamo alguno a los Usuarios. Drogueria Sur SA podrá incluso remover todos los perfiles, historiales, registros y demás datos de tales Usuarios, sin que ello pueda generar derecho a reclamo alguno por parte de los mismos. 
</p> 
</div> 
<div> <h5  class="title-conditions">5. Uso del Sitio:</h5>
<p>
El Sitio  permite a los Usuarios, buscar Productos, a través de un motor de búsqueda.  Una vez realizada la búsqueda, el Sitio ofrecerá al Usuario la información de aquellos Productos que cumplan con los criterios de búsqueda definidos, y permitirá realizar 
la compra de los mismos.  Las tarifas serán expresadas en Pesos (moneda de curso legal en la República Argentina).</p></div>
 
<div><h5  class="title-conditions">6. Privacidad de datos:</h5>
<p>6.1 El Sitio hace un uso responsable de la información personal que le hubiera sido proporcionada por el Usuario, protegiendo la privacidad de los Usuarios y, por consiguiente, velará por el cumplimiento de la normativa correspondiente en 
	materia de protección de datos.  
</p>
<p>6.2 Al aceptar los presentes Términos y Condiciones, el Usuario presta su consentimiento expreso para que el Sitio recopile, trate y utilice sus Datos Personales. El Sitio se limitará a recopilar, procesar y utilizar aquellos datos que resulten necesarios para la prestación de sus servicios. 
</p> 
<p>6.3 Si el Usuario acepta recibir comunicaciones del Sitio, prestará su consentimiento expreso para que el Sitio pueda contactarse con fines publicitarios y/o promocionales a través de distintos canales, a modo de ejemplo y sin limitación 
	(correo electrónico, WhatsApp, mensajes push, mensajes de texto, etc.)
</p> 
<p>6.4 Sin perjuicio de lo anterior, el Usuario podrá ejercer los derechos de acceso, rectificación y supresión de la información, conforme las normas de Protección de Datos Personales.
</p> 
</div> 
<div ><h5 class="title-conditions">7. Propiedad intelectual:</h5>
<p>7.1 El Sitio, sus logotipos y todo el material que aparece en los mismos, son marcas, nombres de dominio, avisos comerciales y nombres comerciales propiedad de sus respectivos titulares y están protegidos por los tratados internacionales de derecho de 
	autor, marcas, patentes, modelos y diseños industriales y las leyes aplicables en materia de propiedad industrial, Ley 11.723. 
</p> 
<p>7.2 Los derechos de autor sobre el contenido, organización, recopilación, compilación, información, logotipos, fotografías, imágenes, programas, aplicaciones, y en general cualquier información contenida o publicada en el Sitio se encuentran debidamente protegidos a favor de sus respectivos propietarios y correctamente licenciados, de conformidad con la legislación aplicable en materia de propiedad intelectual e industrial. 
</p> 
<p>7.3 Se prohíbe expresamente modificar, alterar o suprimir, ya sea en forma total o parcial, los avisos, marcas, nombres comerciales, señas, anuncios, logotipos o en general cualquier indicación que se refiera a la propiedad de la información contenida en el 
	Sitio.  Asimismo el uso indebido y la reproducción total o parcial de dichos contenidos quedan prohibidos. 
</p> 
</div> 
<div><h5 class="title-conditions">8. Exclusión de responsabilidad del Sitio:</h5>
<p>8.1 Los Usuarios conocen  y aceptan que el uso de Internet  implica la asunción de riesgos de daños al software y al hardware. Por ello, es obligación y responsabilidad de los Usuarios contar con antivirus adecuados, antispyware y en general con todos 
	los mecanismos necesarios para proteger los datos e información. El Sitio no será responsable por la seguridad técnica, calidad y funcionamiento de los antivirus/antispyware y fiabilidad de las comunicaciones efectuadas a través de aparatos, redes, terminales o 
	equipos.
</p> 
<p>8.2 Ni Drogueria Sur SA ni el Sitio serán responsables de ningún daño especial, directo, indirecto, punitivo, incidental, derivado o de ningún otro tipo (incluidos, entre otros, daños por lucro cesante, interrupción de negocios o pérdida de información), o cualquier otro perjuicio como resultado de cualquiera de los siguientes supuestos:
 a) el uso o la imposibilidad de usar el Sitio.
 b) el acceso no autorizado por parte de terceros a los datos o la información de cualquier Usuario.</p> 
 </div> 
<div ><h5 class="title-conditions" >9. Disponibilidad del Sitio:</h5>
<p>9.1 El Sitio realiza sus mejores esfuerzos por mantener y mejorar la calidad de sus servicios, sin embargo no garantiza el acceso y uso continuado e ininterrumpido del Sitio.
</p>
<p>9.2 El Usuario acepta y reconoce que el Sitio puede ser discontinuado en los siguientes casos: (i) en razón de la necesidad de realizar tareas de reparación y/o mantenimiento de todo o parte de los elementos que integran el Sitio que no pudieran evitarse, (ii) en caso que por cualquier circunstancia derivada de medidas o resoluciones que dicte cualquier autoridad pública, el Sitio vea afectado en su normal operatoria, (iii) fallo del sistema e incapacidad para desempeñar sus funciones debido a acontecimientos de fuerza mayor, incluidos, entre otros, tifones, terremotos, tsunamis, inundaciones, cortes de electricidad, incendios, tormentas, guerras, disturbios políticos, huelgas laborales, escasez de mano de obra o materiales, (iv) la incapacidad de transmitir datos debido a averías en los terminales de comunicaciones o en el equipo de telecomunicaciones; disturbios, insurrecciones, disturbios civiles, atentados terroristas, explosiones, casos fortuitos, acciones gubernamentales, órdenes de juzgados o tribunales nacionales o extranjeros, incumplimiento de terceros; o (v) suspensión o retraso de los servicios o averías de los sistemas por razones que escapan al control razonable de Suizo  tales como ataques de hackers o cibernéticos, ajustes técnicos o fallos del departamento de telecomunicaciones, actualizaciones de sitios web, problemas de terceros o cualquier suspensión o perturbación del transporte o del funcionamiento de las empresas (incluidos, entre otros, los retrasos o la perturbación de la reanudación del trabajo o del funcionamiento ordenados por cualquier organismo gubernamental) en caso de propagación nacional o regional de una epidemia o pandemia.
En tales casos se procurará restablecerlo con la mayor celeridad posible. En cualquiera de los supuestos anteriores, ni Suizo ni el Sitio serán responsables ni estarán obligados a pagar indemnización alguna por cualquier tipo de pérdida derivada de la falta de disponibilidad, los inconvenientes o los fallos de los servicios o sistemas.
La lista anterior es a modo enunciativo, pudiendo ser discontinuada por otros motivos.
</p>
<p>9.3 Asimismo, el Usuario acepta y reconoce que el Sitio puede no siempre estar disponible debido a fallas de Internet o fallas de conectividad. En tales casos, el Sitio no se hace responsable de las interrupciones del servicio de internet o de la infraestructura de telecomunicaciones que están fuera de su control y que pueden impedir la disponibilidad del mismo. 
</p> 
</div> 
<div><h5 class="title-conditions">10. Modificaciones de los Términos y Condiciones:</h5><p>
Drogueria Sur SA, se reserva la facultad de actualizar o modificar  los presentes Términos y Condiciones, en cualquier momento, sin necesidad de aviso previo, los que estarán vigentes a partir de publicación en el Sitio. En tales supuestos, previo a realizar cualquier interacción como Usuario registrado bajo los nuevos Términos y Condiciones, el Usuario deberá proceder a su lectura y aceptación. 
 </p></div>
<div><h5  class="title-conditions">11. Domicilio - Ley Aplicable y Jurisdicción:</h5>
<p>11.1 A todos los efectos legales Drogueria Sur SA constituye domicilio en Villarino 52, CP 8000 - Bahia Blanca - Buenos Aires - Argentina, a donde se tendrán por válidas -todas las notificaciones.
</p> 
<p>11.2 Los presentes Términos y Condiciones se rigen por las leyes de la República Argentina. Toda controversia derivada de su aplicación, interpretación, ejecución o validez será sometida a la jurisdicción de los Tribunales Nacionales Ordinarios con asiento en la Ciudad de Buenos Aires.
</p></div>  </div>`;
		<?php  $this->request->session()->write('Auth.User.conditions',1) 
		?>
		pre.innerHTML = content;
		//show as confirm
		alertify.confirm('Terminos y Condiciones', pre, function() {
			saveconditions(true);
		}, function() {
			alertify.error('Declined');
		}).set({
			labels: {
				ok: 'Aceptar',
			},
			padding: false,
			cssClass: 'custom-style'
		}).maximize();
		$(".ajs-modal .ajs-button.ajs-ok").addClass("custom-style");
		$(".ajs-header").addClass("custom-style-title");

		$(".ajs-ok").prop('disabled', true);
		$(".ajs-content").on('scroll', function() {
			checkScroll();
		});


		function checkScroll() {
			var contentHeight = $('.ajs-content')[0].scrollHeight;
			var dialogHeight = $('.ajs-modal').outerHeight();
			var scrollTop = $('.ajs-content').scrollTop();

			if (scrollTop + dialogHeight >= contentHeight) {
				$(".ajs-ok").prop('disabled', false);
				$(".ajs-modal .ajs-button.ajs-ok").removeClass("custom-style");
				$(".ajs-header").removeClass("custom-style-title");
				$(".ajs-modal .ajs-button.ajs-ok").addClass("button-enabled");
			}
		}



	}
if($ingreso>0){document.getElementById("exampleModal").style.display="none";<?php echo $this->request->session()->write('ingreso',1)?>window.scrollTo(0,0)}
if($ingreso2>0){document.getElementById("exampleModal2").style.display="none";<?php echo $this->request->session()->write('ingreso2',1)?>window.scrollTo(0,0)}
if($ingreso3>0){document.getElementById("exampleModal3").style.display="none";<?php echo $this->request->session()->write('ingreso3',1)?>window.scrollTo(0,0)}
$(document).ready(function(){
if($ingreso<1 && $confirmX>0){  $('#exampleModal').modal(
{backdrop: false 
},'show');}
else
if($ingreso<1 && $confirmX<1)
{  $('#exampleModal').modal({
backdrop: false
},'show');}

if($ingreso2<1 && $confirmY>0){
$('#exampleModal2').modal({
backdrop: false
},'show');

}
else
if($ingreso2<1 && $confirmY<1)
{$('#exampleModal2').modal({
backdrop: false
},'show');}

if($ingreso3<1){$('#exampleModal3').modal({
backdrop: false
},'show');
}
});
</script>
<?php echo $this->Html->script('jssor.slider.min');?>
<script> jQuery(document).ready(function ($) {
var options = {
$FillMode: 2,$AutoPlay: 1,$Idle: 1500,$PauseOnHover: 1,$ArrowKeyNavigation: 1,$SlideEasing: $Jease$.$OutQuint,$SlideDuration: 1500,$MinDragOffsetToSlide: 20,$SlideSpacing: 0,
$UISearchMode: 1,$PlayOrientation: 1,$DragOrientation: 1,$BulletNavigatorOptions: {$Class: $JssorBulletNavigator$,$ChanceToShow: 2,$SpacingX: 8,$Orientation: 1},
$ArrowNavigatorOptions: {$Class: $JssorArrowNavigator$,$ChanceToShow: 2}
};
var jssor_sliderZ = new $JssorSlider$("slider2_container", options);

function ScaleSliderZocalo() {
var bodyWidth = document.body.clientWidth;
jssor_sliderZ.$scale
jssor_sliderZ.$ScaleWidth($("#slider_contenedor").width());
}
ScaleSliderZocalo();
$(window).bind("load", ScaleSliderZocalo);
$(window).bind("resize", ScaleSliderZocalo);
$(window).bind("orientationchange", ScaleSliderZocalo);
});
function closediv(){
$('#exampleModal').modal('hide');  
$('#exampleModal2').modal('hide');
$('#exampleModal3').modal('hide');      	
}
function closedivbutton(i){
if(i>1){
$('#exampleModal'+i).modal('hide');   
}else{
$('#exampleModal').modal('hide');  
}
}
var futuro = new Date(2023, 11, 10, 10, 00).getTime();
//actualiza el contador cada 4 segundos ( = 4000 milisegundos)
var actualiza = 1000;
function faltan() {
var ahora = new Date().getTime();
var faltan = futuro - ahora;
if (faltan > 0) {
var segundos = Math.round(faltan / 1000);
var minutos = Math.floor(segundos / 60);
var segundos_s = segundos % 60;
var horas = Math.floor(minutos / 60);
var minutos_s = minutos % 60;
var dias = Math.floor(horas / 24) -31;
var horas_s = horas % 24;
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
</script>
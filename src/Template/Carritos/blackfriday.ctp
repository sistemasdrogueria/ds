<style>
#search-backf{ /*background-color:#f96732 */}
#fondobf{	width: 100%;	background-color:#000;}
.contadorbf{ box-sizing: border-box;  margin: 0;  padding: 0;  height: 90px;  }
.contadorbf h1 {  font-weight: normal;}
.contadorbf li {  display: inline-block;  font-size: 1.5em;  list-style-type: none;  padding: 1em;  text-transform: uppercase;}
.contadorbf li span {  display: block; font-size: 4.5rem;}
.contadorbf li span2 {  margin-top:20px;     display: block;}
</style>

<div class="col-md-9">
<div class="product-item-3">
<div class="product-thumb" id="search-backf">
<?php //echo $this->element('search'); ?>
</div> <!-- /.product-thumb -->
<div class="product-thumb" id="fondobf">
<div >
<?php echo $this->Html->image('llego.jpg',['alt'=>'Black friday','url'=>['controller'=>'Carritos','action'=>'blackfriday']]);?>
</div>
<!-- div class=contadorbf align=center>
<ul>
<li><span id="days"></span><span2>Dias</span2></li>
<li><span id="hours"></span><span2>Horas</span2></li>
<li><span id="minutes"></span><span2>Minutos</span2></li>
<li><span id="seconds"></span><span2>Segundos</span2></li>
</ul>
</div -->
</div>
<div class="product-content">
<?php if ($articulos!=null ){echo $this->element('carrito_search_result'); } else {
	echo $this->element('carrito_sinresult_hs'); 
	}?>
</div> <!-- /.product-content -->
</div> <!-- /.product-item -->
</div> <!-- /.col-md-3 -->
<div class="col-md-3">
<div class="product-item-5"> 
<div class="product-content">
<div class="row"><?php //echo $this->element('cartresum'); ?></div> <!-- /.row -->
</div> <!-- /.product-content -->
</div>
<div class="product-item-5">	
<div class="product-content">
<div class='cliente_info_class3'><?php echo $this->Html->image('ofertaagregarcarro2.png');?></div>
<div class='cliente_info_class2'>Carro de Compras</div>
<div class="row">  <?php //echo $this->element('botonescarro'); ?>
<div class="cartresul">	<?php //echo $this->element('cartresult'); ?> </div>
</div> <!-- /.row -->
</div> <!-- /.product-content -->
</div> <!--.product-item-1 -->  
</div> <!-- /.col-md-4 -->




<script>
var futuro = new Date(2019, 05, 16, 00, 10).getTime();
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

</script>
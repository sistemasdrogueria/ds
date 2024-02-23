<div class="col-md-12">
        <div class="product-content" style="background-color: #ddd;">

 <?php foreach ($clim as $clima) : ?>


<?php

$file = @file_get_contents('http://api.meteored.com.ar/index.php?api_lang=ar&localidad='.$clima->localidad_id_api.'&affiliate_id=up7kekq351gn&v=3.0');
$items = json_decode($file, true);
echo '<div style="text-align: center; margin-top:10px;"><table id="webwid" class="widget new32"> 
 <tbody>
  <tr> ';
echo '<td><a id="wlink" class="wlink" href="' . $items['url'] . '" target="_blank"> <span class="slink">'.preg_replace("/\[(.*?)\]/i", "", $items['location']).'</span> 
<table class="fondo"> 
<tbody>
<tr> ';


echo '<td> <span class="nomDay">' . $items['day'][1]['name'] . '</span> 
 <span class="simbDay"> ' . $this->Html->image('simbolo/weather/' . $items['day'][1]['symbol_value'] . '.png', ['alt' => '' . $items['day'][1]['symbol_description'] . '', 'title' => '' . $items['day'][1]['symbol_description'] . '']) . '
</span>
  <span class="temps"> <span class="TMax">' . $items['day'][1]['tempmax'] . '°</span> <span class="TMin">' . $items['day'][1]['tempmin'] . '°</span> </span> </td> ';


echo '<td> <span class="nomDay">' . $items['day'][2]['name'] . '</span> 
 <span class="simbDay"> ' . $this->Html->image('simbolo/weather/' . $items['day'][2]['symbol_value'] . '.png', ['alt' => '' . $items['day'][2]['symbol_description'] . '', 'title' => '' . $items['day'][2]['symbol_description'] . '']) . '
</span>
  <span class="temps"> <span class="TMax">' . $items['day'][2]['tempmax'] . '°</span> <span class="TMin">' . $items['day'][2]['tempmin'] . '°</span> </span> </td> ';



echo '<td> <span class="nomDay">' . $items['day'][3]['name'] . '</span> 
 <span class="simbDay"> ' . $this->Html->image('simbolo/weather/' . $items['day'][3]['symbol_value'] . '.png', ['alt' => '' . $items['day'][3]['symbol_description'] . '', 'title' => '' . $items['day'][3]['symbol_description'] . '']) . '
</span>
  <span class="temps"> <span class="TMax">' . $items['day'][3]['tempmax'] . '°</span> <span class="TMin">' . $items['day'][3]['tempmin'] . '°</span> </span> </td> ';


echo '</tr>
</tbody>
</table>
</a>
</td>
</tr>
</tbody>
</table>';


?>

 <?php endforeach; ?>

       <input name="transporte" class="hide" id="transporte" value="">
    <input name="localidadid" class="hide" id="localidadid" value="">
    <input name="nombre" class="hide" id="nombre" value="">
    <input name="localidadidapi" class="hide" id="localidadidapi" value="">
    <input name="provinciaidapi" class="hide" id="provinciaidapi" value="">

        </div><!-- /.product-content -->





    </div> <!-- /.col-md-3 -->



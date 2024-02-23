
<?php 
$localidadidapi = $_SESSION['localidadidapi'];
$file = @file_get_contents('http://api.meteored.com.ar/index.php?api_lang=ar&localidad='.$localidadidapi.'&affiliate_id=up7kekq351gn&v=3.0');
$items = json_decode($file, true);
echo '<div style="display:inline-block;"><table id="webwid" style="text-align: center;"class="widget new32 "> 
 <tbody>
  <tr> ';
echo '<td  id="wlink" class="wlink" ><a href="' . $items['url'] . '" target="_blank"> <span class="slink">'.preg_replace("/\[(.*?)\]/i", "", $items['location']).'</span></a><div class="principal"><button class="text-center button button5" id="mas-btn"> + </button></div> 
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
</td>
</tr>
</tbody>
</table></div>';


?>
        <!-- /.product-content -->
</div>  
<script>
	$("#mas-btn").click(function() {
  agregarclimalocalidad();

  });</script>
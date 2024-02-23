<div>	<!-- -->
<?php
function url_exists2($url = NULL) {
if( empty( $url ) ){
return false;
}
// get_headers() realiza una petición GET por defecto,
// cambiar el método predeterminadao a HEAD
// Ver http://php.net/manual/es/function.get-headers.php
stream_context_set_default(
array(
'http' => array(
'method' => 'HEAD'
)
)
);
$headers = @get_headers($url);
sscanf( $headers[0], 'HTTP/%*d.%*d %d', $httpcode );
// Aceptar solo respuesta 200 (Ok), 301 (redirección permanente) o 302 (redirección temporal)
$accepted_response = array( 200, 301, 302 );
if( in_array( $httpcode, $accepted_response ) ) {
return true;
} else {
return false;
}
}
?>

<div id="tab1" class="tab_content"> <!--tab_content -->
<table class="tablesorter"> 
<thead> 
<tr>

<th scope="col"><?= $this->Paginator->sort('id') ?></th>
<th scope="col"><?= $this->Paginator->sort('modelo') ?></th>
<th scope="col"><?= $this->Paginator->sort('marca') ?></th>
<th scope="col"><?= $this->Paginator->sort('ip') ?></th>
<th scope="col"><?= $this->Paginator->sort('sector') ?></th>
<th scope="col"><?= $this->Paginator->sort('modificado') ?></th>
<th scope="col"><?= $this->Paginator->sort('INSUMOS') ?></th>
<th class="actions"><?= __('') ?></th>
</tr>
</thead>
<tbody>

<?php foreach ($impresoras as $impresora): ?>
<tr>
<td><?= $this->Number->format($impresora->id) ?></td>
<td><?= h($impresora->modelo) ?></td>
<td><?= h($impresora->marca) ?></td>
<td><?= h($impresora->ip) ?></td>
<td><?php echo $impresora->sector;?></td>
<td><?php echo date_format($impresora->modificado,'d-m-Y');?></td>
<td class="actions">
<?php
try {
$pagina =true;
if (($impresora->modelo  != 'MX521') && ($impresora->modelo  != 'MS521') && ($impresora->modelo  != 'MS621') && ($impresora->modelo  != 'MS826'))
$url = 'http://'.$impresora->ip.'/cgi-bin/dynamic/printer/PrinterStatus.html';
else
$url = 'http://'.$impresora->ip;

$ctx = stream_context_create(array('http' => array('timeout' => 100)));
$pagina = file_get_contents($url, 0, $ctx); 
$arrContextOptions=array(
"ssl"=>array("verify_peer"=>false,"verify_peer_name"=>false,'timeout' => 100 ),
);  

if (($impresora->modelo  == 'MX521') || ($impresora->modelo  == 'MS521') || ($impresora->modelo  == 'MS621') || ($impresora->modelo  == 'MS826')  )
{
$url = 'http://'.$impresora->ip.'/webglue/content?c=%2FStatus&lang=es';

// Create a stream
$opts = array(
'http'=>array('method'=>"GET",'header'=>"Accept-language: es\r\n" , "Cookie: foo=bar\r\n")
);

$context = stream_context_create($opts);
// Open the file using the HTTP headers set above
$file = file_get_contents($url, false, $context);
preg_match_all('#<span class="dataText"[^>]*>(.*?)</span[^>]*>#is', $file, $titulo2, PREG_PATTERN_ORDER);

}

} catch (Exception $e) {

}

if ($pagina !=false)
{ 
$patron = '/<table>[\s\w\/<>=\\\"]*<\/table>/';
//$pagina = file_get_contents($url, false, $context);
preg_match_all('#<tr[^>]*>(.*?)</tr[^>]*>#is', $pagina, $titulo, PREG_PATTERN_ORDER);
}

?>

<div ><table> <?php 
if ($pagina !=false)
{
if ($impresora->modelo == 'T652' || $impresora->modelo == 'T654')
echo $titulo[0][2];
if ($impresora->modelo == 'MS812')
{
preg_match_all('#<td[^>]*><B>(.*?)</B></td[^>]*>#is', $titulo[1][3], $tituloT, PREG_PATTERN_ORDER);
$toner=  $tituloT[1][0];
preg_match_all('#<td[^>]*>(.*?)</td[^>]*>#is', $titulo[1][17], $tituloD, PREG_PATTERN_ORDER);
$draw = $tituloD[1][1];
preg_match_all('#<td[^>]*>(.*?)</td[^>]*>#is', $titulo[1][15], $tituloF, PREG_PATTERN_ORDER);
$fusor = $tituloF[1][1];
echo 'TONER: '.  str_ireplace('~','',str_ireplace('Cartucho negro','' ,$toner)) . ' - DRAW: ' . $draw. ' - FUSOR: ' . $fusor;
}
if (($impresora->modelo  == 'MX521') || ($impresora->modelo == 'MS521') || ($impresora->modelo  == 'MS621') || ($impresora->modelo  == 'MS826')  )
echo 'TONER: '.  $titulo2[1][0] . '% - DRAW: ' . $titulo2[1][1].'% - FUSOR: ' . $titulo2[1][2].'%';

if ($impresora->modelo == 'MS610de' || $impresora->modelo  == 'M3150dn')
{
//    $this->request->session()->write('titulo'.$impresora->ip,$titulo);
preg_match_all('#<td[^>]*><B>(.*?)</B></td[^>]*>#is', $titulo[1][2], $tituloT, PREG_PATTERN_ORDER);
$toner=  $tituloT[1][0];
preg_match_all('#<td[^>]*>(.*?)</td[^>]*>#is', $titulo[1][15], $tituloD, PREG_PATTERN_ORDER);
$draw = $tituloD[1][1];
preg_match_all('#<td[^>]*>(.*?)</td[^>]*>#is', $titulo[1][14], $tituloF, PREG_PATTERN_ORDER);
$fusor = $tituloF[1][1]; 
//  $this->request->session()->write('tituloT'.$impresora->ip,$tituloT);
//  $this->request->session()->write('tituloD'.$impresora->ip,$tituloD);
//  $this->request->session()->write('tituloF'.$impresora->ip,$tituloF);
echo 'TONER: '.  str_ireplace('~','',str_ireplace('Cartucho negro','' ,$toner)) . ' - DRAW: ' . $draw. ' - FUSOR: ' . $fusor; 
}

if ($impresora->modelo  == 'MX611dhe')
{
preg_match_all('#<td[^>]*><B>(.*?)</B></td[^>]*>#is', $titulo[1][2], $tituloT, PREG_PATTERN_ORDER);
$toner=  $tituloT[1][0];
preg_match_all('#<td[^>]*>(.*?)</td[^>]*>#is', $titulo[1][14], $tituloD, PREG_PATTERN_ORDER);
$draw = $tituloD[1][1];
preg_match_all('#<td[^>]*>(.*?)</td[^>]*>#is', $titulo[1][13], $tituloF, PREG_PATTERN_ORDER);
$fusor = $tituloF[1][1]; 
echo 'TONER: '.  str_ireplace('~','',str_ireplace('Cartucho negro','' ,$toner)) . ' - DRAW: ' . $draw. ' - FUSOR: ' . $fusor; 
}
}
?> </table></div></td>
<td>
<?php echo $this->Html->link($this->Html->image("admin/cups-icon.png", ["alt" => "Ver"]),'http://168.85.96.2:631/printers/l'.$impresora->sistema,['escape' => false,'target'=>'_blank']);?>
<?php echo $this->Html->link($this->Html->image("admin/icon-print.png", ["alt" => "Ver"]),'http://'.$impresora->ip,['escape' => false,'target'=>'_blank']);?>
</td>
</tr>
<?php endforeach; ?>
</tbody> 
</table>
</div><!-- end of .tab_container -->
<div class="pagination">
<ul>
<?php
echo $this->Paginator->prev(__('Anterior'), array('tag' => 'li'), null, array('tag' => 'li','disabledTag' => 'a'));
echo $this->Paginator->numbers(array('separator' => '','currentTag' => 'a', 'currentClass' => 'active','tag' => 'li','first' => 1));
echo $this->Paginator->next(__('Siguiente'), array('tag' => 'li','currentClass' => 'disabled'), null, array('tag' => 'li','disabledTag' => 'a'));
?>
</ul>
<div class="total"><?php echo $this->Paginator->counter('{{count}} Total'); ?></div>
</div>
</div> <!-- -->
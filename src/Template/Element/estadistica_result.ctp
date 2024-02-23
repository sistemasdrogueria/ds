<style>
.tabla_col {text-align: center;}
table tr {
text-align: center;
}
table th {
text-align: center;
}
</style>

<div class="col-md-12 col-sm-12 col-xs-12">
<div class="x_panel">
<div class="x_title">
<h2>UNIDADES</h2>
<ul class="nav navbar-right panel_toolbox">
<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
</li>
<li class="dropdown">
<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
</li>
<li><a class="close-link"><i class="fa fa-close"></i></a></li>
</ul>
<div class="clearfix"></div>
</div> <!-- x_title -->
<div class="x_content">
<div id="mainb" style="height: 345px"></div>

<div class="clearfix"></div>
</div> <!-- x_content -->
</div> <!-- x_panel -->
</div> <!-- col-md-12 col-sm-12 col-xs-12 -->
<div class="col-md-12 col-sm-12 col-xs-12">
<div class="x_panel">
<div class="x_title">
<h2>IMPORTES</h2>
<ul class="nav navbar-right panel_toolbox">
<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
</li>
<li><a class="close-link"><i class="fa fa-close"></i></a></li>
</ul>
<div class="clearfix"></div>
</div> <!-- x_title -->
<div class="x_content">
<div id="mainbi" style="height: 345px"></div>
<div class="clearfix"></div>
</div> <!-- x_content -->
</div> <!-- x_panel -->
</div> <!-- col-md-12 col-sm-12 col-xs-12 -->

<div class="col-md-12 col-sm-12 col-xs-12">
<div class="x_panel">
<div class="x_title">
<h2>DATOS DE UNIDADES</h2>
<ul class="nav navbar-right panel_toolbox">
<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
</li>
<li class="dropdown">
<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
</li>
<li><a class="close-link"><i class="fa fa-close"></i></a></li>
</ul>
<div class="clearfix"></div>
</div> <!-- x_title -->
<div class="x_content">
<table class="table table-striped">
<thead><tr>
<th scope="col"><?= $this->Paginator->sort('mes','Mes') ?></th>
<th scope="col"><?= $this->Paginator->sort('anio','Año') ?></th>
<th scope="col"><?= $this->Paginator->sort('total_u','Total') ?></th>
<th scope="col"><?= $this->Paginator->sort('total_m','Medicamento') ?></th>
<th scope="col"><?= $this->Paginator->sort('total_pya','Perfumeria') ?></th>
<th scope="col"><?= $this->Paginator->sort('total_transf','Transfer') ?></th>
</tr></thead>
<tbody>
<?php 
$arrayindice = array();
$mes = array();
$mes = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
$total_u = array();
$total_m = array();
$total_pya = array();
$total_transf = array();?>
<?php foreach ($resultventas as $resultventa): ?>
<tr>
<td><?php echo $mes[$resultventa->mes -1 ]; ?></td>
<td><?= $this->Number->format($resultventa->anio) ?></td>
<td><?= $this->Number->format($resultventa->total_u) ?></td>
<td><?= $this->Number->format($resultventa->total_m) ?></td>
<td><?= $this->Number->format($resultventa->total_pya) ?></td>
<td><?= $this->Number->format($resultventa->total_transf) ?></td>
</tr>
<?php 
array_push ( $arrayindice , str_pad($resultventa['mes'].'-'.$resultventa['anio'], 2, "0", STR_PAD_LEFT) );
array_push ( $total_u , $resultventa['total_u'] );
array_push ( $total_m , $resultventa['total_m'] );
array_push ( $total_pya , $resultventa['total_pya']);
array_push ( $total_transf , $resultventa['total_transf'] );?> 
<?php endforeach; ?>
</tbody>
</table>

</div> <!-- x_content -->
</div> <!-- x_panel -->
</div> <!-- col-md-12 col-sm-12 col-xs-12 -->

<div class="clearfix"></div>
<div class="col-md-12 col-sm-12 col-xs-12">
<div class="x_panel">
<div class="x_title">
<h2>DATOS DE IMPORTES</h2>
<ul class="nav navbar-right panel_toolbox">
<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
</li>
<li class="dropdown">
<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
</li>
<li><a class="close-link"><i class="fa fa-close"></i></a></li>
</ul>
<div class="clearfix"></div>
</div> <!-- x_title -->
<div class="x_content">
<table class="table table-striped">
<thead><tr>
<th scope="col"><?= $this->Paginator->sort('mes','Mes') ?></th>
<th scope="col"><?= $this->Paginator->sort('anio','Año') ?></th>
<th scope="col"><?= $this->Paginator->sort('total_u','Total') ?></th>
<th scope="col"><?= $this->Paginator->sort('total_m','Medicamento') ?></th>
<th scope="col"><?= $this->Paginator->sort('total_pya','Perfumeria') ?></th>
<th scope="col"><?= $this->Paginator->sort('total_transf','Transfer') ?></th>
</tr></thead>
<tbody>
<?php 
$arrayindicei = array();
$total_ui = array();
$total_mi = array();
$total_pyai = array();
$total_transfi = array();?>
<?php foreach ($resultventas2 as $resultventa): ?>
<tr>
<td><?php echo $mes[$resultventa->mes -1 ]; ?></td>
<td><?= $this->Number->format($resultventa->anio) ?></td>
<td><?php echo '$ '.$this->Number->format($resultventa->total_u) ?></td>
<td><?php echo '$ '.$this->Number->format($resultventa->total_m) ?></td>
<td><?php echo '$ '.$this->Number->format($resultventa->total_pya) ?></td>
<td><?php echo '$ '.$this->Number->format($resultventa->total_transf) ?></td>
</tr>
<?php 
array_push ( $arrayindicei , str_pad($resultventa['mes'].'-'.$resultventa['anio'], 2, "0", STR_PAD_LEFT) );
array_push ( $total_ui , $resultventa['total_u'] );
array_push ( $total_mi , $resultventa['total_m'] );
array_push ( $total_pyai , $resultventa['total_pya']);
array_push ( $total_transfi , $resultventa['total_transf'] );?> 
<?php endforeach; ?>
</tbody>
</table>

</div> <!-- x_content -->
</div> <!-- x_panel -->
</div> <!-- col-md-12 col-sm-12 col-xs-12 -->
<script>
function displayLineChart() {
// obtenemos el array de valores mediante la conversion a json del
// array de php
var $arrayindice = <?php echo json_encode($arrayindice);?>;
var $total_u = <?php echo json_encode($total_u);?>;
var $total_m = <?php echo json_encode($total_m);?>;
var $total_pya = <?php echo json_encode($total_pya);?>;
var $total_transf = <?php echo json_encode($total_transf);?>;

var $arrayindicei = <?php echo json_encode($arrayindicei);?>;
var $total_ui = <?php echo json_encode($total_ui);?>;
var $total_mi = <?php echo json_encode($total_mi);?>;
var $total_pyai = <?php echo json_encode($total_pyai);?>;
var $total_transfi = <?php echo json_encode($total_transfi);?>;

var chartdatai=[
{
name:'MEDICAMENTOS',
type:'bar',
data: $total_mi,
/*markPoint : {
data : [
{type : 'max',name : 'Maximo'},
{type : 'min',name : 'Minimo'}
]
}*/
},{
name:'PERFUMERIA',
type:'bar',
data: $total_pyai,
/*markPoint : {
data : [
{type : 'max',name : 'Maximo'},
{type : 'min',name : 'Minimo'}
]
}*/
},
{
name:'TRANSFER',
type:'bar',
data: $total_transfi,
/*markPoint : {
data : [
{type : 'max',name : 'Maximo'},
{type : 'min',name : 'Minimo'}
]
}*/
},
{
name:'TOTAL',
type:'bar',
data: $total_ui,
/*markPoint : {
data : [
{type : 'max',name : 'Maximo'},
{type : 'min',name : 'Minimo'}
]
}*/
}
];

var chartdata=[
{
name:'MEDICAMENTOS',
type:'bar',
data: $total_m,
/*markPoint : {
data : [
{type : 'max',name : 'Maximo'},
{type : 'min',name : 'Minimo'}
]
}*/
},{
name:'PERFUMERIA',
type:'bar',
data: $total_pya,
/*markPoint : {
data : [
{type : 'max',name : 'Maximo'},
{type : 'min',name : 'Minimo'}
]
}*/
},
{
name:'TRANSFER',
type:'bar',
data: $total_transf,
/*markPoint : {
data : [
{type : 'max',name : 'Maximo'},
{type : 'min',name : 'Minimo'}
]
}*/
},
{
name:'TOTAL',
type:'bar',
data: $total_u,
/*markPoint : {
data : [
{type : 'max',name : 'Maximo'},
{type : 'min',name : 'Minimo'}
]
}*/
}
];

var legendData = chartdata.map(function(d){return d.name;});
var legendDatai = chartdatai.map(function(d){return d.name;});

var chart = document.getElementById('mainb');
var charti = document.getElementById('mainbi');

var myChart = echarts.init(chart);
var myCharti = echarts.init(charti);
var option = {
title: { 
text: 'COMPRAS',
subtext: 'UNIDADES',
textStyle:{
color:'#fff'
}
},
toolbox: {
show : true,
feature : {
dataView : {show: true, title:'Mostrar Datos', readOnly: false, lang: ['Datos', 'Cerrar', 'Actualizar']},            
magicType : {show: true, title:['Linea','Barra'],type: ['line', 'bar']},            
restore : {show: true, title:'Restaurar'},            
saveAsImage : {show: true, title:"Guardar Imagen"}   
}
},
tooltip: { 
borderWidth:1,
//backgroundColor:'rgba(250,250,250,0.7)',
backgroundColor:'#fff',
textStyle:{
color:'#000'
}                
},
legend: { //orient:'vertical',
textStyle:{
color:'#000'
},
/*left:'30',
top:'100',*/
data: legendData
},
xAxis: { data: $arrayindice },
yAxis: { },
series: chartdata,
//backgroundColor:'rgba(0, 0, 0, 1)',
textStyle:{
color:'#fff'
},
color:[ '#FF9800', '#ef5350','#F48FB1','#81C784','#c4ccd3','#c23531','#2f4554','#61a0a8','#d48265','#91c7ae','#749f83']
};

var optioni = {
title: { 
text: 'COMPRAS',
subtext: 'IMPORTES',
textStyle:{
color:'#fff'
}
},
toolbox: {
show : true,
feature : {
dataView : {show: true, title:'Mostrar Datos', readOnly: false, lang: ['Datos', 'Cerrar', 'Actualizar']},            
magicType : {show: true, title:['Linea','Barra'],type: ['line', 'bar']},            
restore : {show: true, title:'Restaurar'},            
saveAsImage : {show: true, title:"Guardar Imagen"}   
}
},
tooltip: { 
borderWidth:1,
//backgroundColor:'rgba(250,250,250,0.7)',
backgroundColor:'#fff',
textStyle:{
color:'#000'
}
},
legend: { //orient:'vertical',
textStyle:{
color:'#000'
},
/*left:'30',
top:'100',*/
data: legendDatai
},
xAxis: { data: $arrayindicei },
yAxis: { },
series: chartdatai,
//backgroundColor:'rgba(0, 0, 0, 1)',
textStyle:{
color:'#000'
},
// color:[ '#FF9800', '#ef5350','#F48FB1','#81C784','#c4ccd3','#c23531','#2f4554','#61a0a8','#d48265','#91c7ae','#749f83']
};
myChart.setOption(option);
myCharti.setOption(optioni);
}
</script>
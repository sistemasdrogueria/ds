
<style>
.disponible_text {
  
  color:#71d90b;
  text-transform:uppercase;
 color:#658e04; 
 font-weight: 800;
 font-size: 16px;
}
</style>
<?php 
$creditodisponible = $_SESSION['creditodisponible'];
$totalitems =$_SESSION['totalitems'];
$totalunidades=$_SESSION['totalunidades'];
$totalcarrito=$_SESSION['totalcarrito'];

?>
<div class="carrito_resumen">
<table cellpadding="0" cellspacing="0"> 
<tr>
<td colspan="2">
<div style="float: left;font-size: 15px;padding-top: 3px;">
<?php if ($this->request->session()->read('Auth.User.perfile_id')!=2 && $this->request->session()->read('Auth.User.perfile_id')!=3) echo "Crédito semanal";
$logoimgc= $this->Html->image('ojocerrado.png', ['title' => 'abrir','id'=>'flat' ,'class'=> 'hide','style'=>'padding-bottom: 3px;','width'=> '22','height'=> '22']); 
$logoimga=$this->Html->image('ojoabierto.png', ['title' => 'cerrar','id'=>'clickme','class'=> 'hide','style'=>'padding-bottom: 3px;','width'=> '22', 'height'=> '22']); 
$logoimgc1= $this->Html->image('ojocerrado.png', ['title' => 'abrir','id'=>'flat' ,'class'=> '','style'=>'padding-bottom: 3px;','width'=> '22','height'=> '22',]); 
$logoimga1=$this->Html->image('ojoabierto.png', ['title' => 'cerrar','id'=>'clickme','class'=> '', 'style'=>'padding-bottom: 3px;','width'=> '22', 'height'=> '22']);

?>
</div>

<div style="float: right;"> 

<?php if ($this->request->session()->read('Auth.User.perfile_id')!=2 && $this->request->session()->read('Auth.User.perfile_id')!=3){$valor = "$ ".number_format($this->request->session()->read('creditodisponible'),2,',','.');}else{$valor = "$  0";}	?>

<?php if($this->request->session()->read('creditovisualizar')==2 ){echo "
<div><input  class='disponible_text parpadea text-right' id='creditd' disabled  size='15' style='border:0;background-color:#fff'type='text' value='$valor'>
$logoimgc1
$logoimga
</div>

  ";}else{echo"
    <div><input  class='disponible_text parpadea text-right' id='creditd' disabled  size='15' style='border:0;background-color:#fff'type='password' value='$valor'>
    $logoimgc
    $logoimga1
    </div>";}?>
</div>  
</td>
</tr>
<tr>
<td class="carrito_descripcion"><div>Importe Total</div></td>
<td id="carrito_importe1"class="carrito_importe"> $ <?php echo number_format($totalcarrito,2,',','.');?></td>
</tr>
<tr>
<td class="carrito_descripcion"><div> Items/Unid Total </div></td>
<td class="carrito_importe">

<div class="" id="modalitems1" value='<?php echo $totalitems;?>'>
<?php echo $totalitems;?>/<?php echo $totalunidades;?>
</div>


</td>
</tr>
<tr>
<td class="carrito_descripcion">
<div> Horario de corte</div> <!-- /.col-md-6 -->
</td>
<td class="carrito_importe">
<div><?php 

if ($this->request->session()->read('Auth.User.codigo')!=66079 )
echo $this->request->session()->read('Auth.User.cierre');
else
echo $this->request->session()->read('Auth.User.cierre')->i18nFormat('dd/MM/yy'). ' 21:00';
//if ($this->request->session()->read('Auth.User.codigo_postal')!= 9420 &&  $this->request->session()->read('Auth.User.codigo_postal')!= 9410)
    //echo $this->request->session()->read('Auth.User.cierre')?>
</div>
</td>
</tr>
</table>
</div>
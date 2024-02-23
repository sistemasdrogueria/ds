
<style>
.disponible_text {
  
  color:#71d90b;
  text-transform:uppercase;
 color:#658e04; 
 font-weight: 800;
 font-size: 16px;
}
</style>
<div class="carrito_resumen">
<table cellpadding="0" cellspacing="0"> 
<tr>
<td colspan="2">
<div style="float: left;font-size: 15px;">
<?php if ($this->request->session()->read('Auth.User.perfile_id')!=2 && $this->request->session()->read('Auth.User.perfile_id')!=3) echo "Crédito semanal";
$logoimgc= $this->Html->image('ojocerrado.png', ['title' => 'abrir','id'=>'flat1' ,'class'=> 'hide','style'=>'padding-bottom: 3px;','width'=> '22','height'=> '22']); 
$logoimga=$this->Html->image('ojoabierto.png', ['title' => 'cerrar','id'=>'clickme1','class'=> 'hide','style'=>'padding-bottom: 3px;','width'=> '22', 'height'=> '22']); 
$logoimgc1= $this->Html->image('ojocerrado.png', ['title' => 'abrir','id'=>'flat1' ,'class'=> '','style'=>'padding-bottom: 3px;','width'=> '22','height'=> '22']); 
$logoimga1=$this->Html->image('ojoabierto.png', ['title' => 'cerrar','id'=>'clickme1','class'=> '','style'=>'padding-bottom: 3px;','width'=> '22', 'height'=> '22']);

?>
</div>

<div style="float: right;"> 

<?php if ($this->request->session()->read('Auth.User.perfile_id')!=2 && $this->request->session()->read('Auth.User.perfile_id')!=3){$valor = "$ ".number_format($this->request->session()->read('creditodisponible'),2,',','.');}else{$valor = "$  0";}	?>
<?php 

 if(isset($_SESSION['creditovisualizar'])){

 }else{
  $_SESSION['creditovisualizar'] = 1;
  
 }

if($this->request->session()->read('creditovisualizar')==2){echo "
<div><input  class='disponible_text parpadea text-right' id='creditd1' disabled  size='15' style='border:0;background-color:#eee;'type='text' value='$valor'>
$logoimgc1
$logoimga
</div>

  ";}else{echo"
    <div><input  class='disponible_text parpadea text-right' id='creditd1' disabled  size='15' style='border:0;background-color:#eee'type='password' value='$valor'>
    $logoimgc
    $logoimga1
    </div>";}?>
</div> 
  </td>
</tr>
<tr>
<td class="carrito_descripcion"><div>Importe Total</div></td>
<td id="carrito_importe"class="carrito_importe"> $ <?php echo number_format($this->request->session()->read('totalcarrito'),2,',','.');?></td>
</tr>
<tr>
<td class="carrito_descripcion"><div> Items/Unid Total </div></td>
<td class="carrito_importe">

<div class="" id="modalitems" value='<?php echo $this->request->session()->read('totalitems');?>'>
<?php echo $this->request->session()->read('totalitems');?>/<?php echo $this->request->session()->read('totalunidades');?>
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
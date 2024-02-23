<div class="carrito_resumen">
<table cellpadding="0" cellspacing="0" > 
<tr>
<td class="carrito_descripcion">
<div>
SALDO  
</div> <!-- /.col-md-6 -->
</td>
</tr>
<tr>
<td class="carrito_importe"> 
<div style="float: right;"> 

<?php if ($this->request->session()->read('Auth.User.perfile_id')!=2 && $this->request->session()->read('Auth.User.perfile_id')!=3){$valor = "$ ".number_format($this->request->session()->read('creditodisponible'),2,',','.');}else{$valor = "$  0";}	
$logoimgc= $this->Html->image('ojocerrado.png', ['title' => 'abrir','id'=>'flat' ,'class'=> 'hide','style'=>'padding-bottom: 3px;','width'=> '22','height'=> '22']); 
$logoimga=$this->Html->image('ojoabierto.png', ['title' => 'cerrar','id'=>'clickme','class'=> 'hide','style'=>'padding-bottom: 3px;','width'=> '22', 'height'=> '22']); 
$logoimgc1= $this->Html->image('ojocerrado.png', ['title' => 'abrir','id'=>'flat' ,'class'=> '','style'=>'padding-bottom: 3px;','width'=> '22','height'=> '22',]); 
$logoimga1=$this->Html->image('ojoabierto.png', ['title' => 'cerrar','id'=>'clickme','class'=> '', 'style'=>'padding-bottom: 3px;','width'=> '22', 'height'=> '22']);
if(isset($_SESSION['creditovisualizar'])){

}else{
 $_SESSION['creditovisualizar'] = 1;
 
}
?>

<?php if($this->request->session()->read('creditovisualizar')==2 ){echo "
<div><input  class=' text-right' id='creditd' disabled  size='12' style='border:0;background-color:#fff'type='text' value='$valor'>
$logoimgc1
$logoimga
</div>

  ";}else{echo"
    <div><input  class='text-right' id='creditd' disabled  size='12' style='border:0;background-color:#fff'type='password' value='$valor'>
    $logoimgc
    $logoimga1
    </div>";}?>
</td>
</tr>
<tr>
<td class="carrito_descripcion">
<div>
Importe Total  
</div> <!-- /.col-md-6 -->
</td>
</tr>
<tr>
<td id="carrito_importe_view" class="carrito_importe">
$ <?php echo number_format($totalcarrito,2,',','.');?>
</td>
</tr>
<tr>
<td class="carrito_descripcion">
<div>
Items/Unid Total 
</div> <!-- /.col-md-6 -->
</td>
</tr>
<tr>
<td class="carrito_importe_s carrito_importe">
<div id="unidades" >
<?php echo $totalitems;?>/<?php echo $totalunidades;?>
</div>
</td>
</tr>
</table>
</div>
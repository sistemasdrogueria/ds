
<style>
.disponible_text {
  
  color:#71d90b;
  text-transform:uppercase;
 color:#658e04; 
 font-weight: 800;
 font-size: 18px;
}
.parpadea {
  
  animation-name: parpadeo;
  animation-duration: 1s;
  animation-timing-function: linear;
  animation-iteration-count: infinite;

  -webkit-animation-name:parpadeo;
  -webkit-animation-duration: 1s;
  -webkit-animation-timing-function: linear;
  -webkit-animation-iteration-count: infinite;
}

@-moz-keyframes parpadeo{  
  0% { opacity: 1.0; }
  50% { opacity: 0.0; }
  100% { opacity: 1.0; }
}

@-webkit-keyframes parpadeo {  
  0% { opacity: 1.0; }
  25% { opacity: 0.5; }
   50% { opacity: 0.0; }
   75% { opacity: 0.5; }
   100% { opacity: 1.0; }
}

@keyframes parpadeo {  
  0% { opacity: 1.0; }
  25% { opacity: 0.5; }
   50% { opacity: 0.0; }
   75% { opacity: 0.5; }
  100% { opacity: 1.0; }
}
</style>
<div class="carrito_resumen">
<table cellpadding="0" cellspacing="0"> 
<tr>
<td class="carrito_descripcion">
<div><?php if ($this->request->session()->read('Auth.User.perfile_id')!=2 && $this->request->session()->read('Auth.User.perfile_id')!=3) echo "Crédito";?>
</div>
</td>
<td class="carrito_importe " > 
<div  class="disponible_text parpadea"><?php if ($this->request->session()->read('Auth.User.perfile_id')!=2 && $this->request->session()->read('Auth.User.perfile_id')!=3)	echo "$ ".number_format($creditodisponible,2,',','.');?>
</div>
</td>
</tr>
<tr>
<td class="carrito_descripcion"><div>Importe Total</div></td>
<td class="carrito_importe"> $ <?php echo number_format($totalcarrito,2,',','.');?></td>
</tr>
<tr>
<td class="carrito_descripcion"><div> Items/Unid Total </div> </td>
<td class="carrito_importe">
<div><?php echo $totalitems;?>/<?php echo $totalunidades;?></div>
</td>
</tr>
<tr>
<td class="carrito_descripcion">
<div> Horario de corte</div> <!-- /.col-md-6 -->
</td>
<td class="carrito_importe">
<div><?php 
//if ($this->request->session()->read('Auth.User.codigo_postal')!= 9420 &&  $this->request->session()->read('Auth.User.codigo_postal')!= 9410)
    echo $this->request->session()->read('Auth.User.cierre')?>
</div>
</td>
</tr>
</table>
</div>
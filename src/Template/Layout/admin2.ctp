<!doctype html>
<html lang=es-ES>
<head>
<meta name=viewport content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
<meta charset="utf-8"/>
<title>Admin Drogueria Sur</title>
<?php echo $this->Html->meta('icon');
echo $this->Html->meta('favicon.ico','/favicon.ico', ['type' => 'icon']);
echo $this->fetch('meta'); ?>
<!--[if lt IE 9]>
<?php echo $this->Html->css('adminie',['media'=>'screen']); ?>
<?php echo $this->Html->script('html15'); ?>
<![endif]-->
<?php 
echo $this->Html->css('admin'); 	
echo $this->Html->css('jquery-ui'); 
echo $this->Html->script('jquery-1.11.3'); 
echo $this->Html->css('alertify/alertify');
echo $this->Html->script('alertify/alertify');
echo $this->Html->script('jquery-ui-1.10.4.custom.min'); 	
echo $this->Html->script('jquery.tablesorter.min',['plugin' => false]); 
echo $this->Html->script('jquery.equalHeight.min',['plugin' => false]); 
echo $this->Html->css('jquery.notifyBar.min');
echo $this->Html->script('jquery.notifyBar.min');
?>
<script type=text/javascript>$(document).ready(function(){$(".tab_content").hide();$("ul.tabs li:first").addClass("active").show();$(".tab_content:first").show();$("ul.tabs li").click(function(){$("ul.tabs li").removeClass("active");$(this).addClass("active");$(".tab_content").hide();var a=$(this).find("a").attr("href");$(a).fadeIn();return false})});$(function(){$("#fechahasta, #fechadesde, #fecha_desde,#fecha_hasta, #fecha_recepcion, #form_reclamo_fv1,#form_reclamo_fv2,#form_reclamo_fv3,#form_reclamo_fv4").datepicker({dateFormat:"dd/mm/yy",dayNames:["Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sabado"],dayNamesMin:["Do","Lu","Ma","Mi","Ju","Vi","Sa"],firstDay:1,gotoCurrent:true,monthNames:["Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Deciembre"]});$(".main-menu ul.menu li a").click(function(){$(this).addClass("active")})});</script>
</head>
<style>
#sidebar{position:fixed;left:-255px;top:0;width:250px;height:100%;background-color:#f4f4f4;transition:left .3s ease-in-out;z-index:1000;color:#1b2340;padding-top:70px;border:#56c6f4 2px solid; overflow-y: auto}
#sidebar.active{left:0}
#menu-toggle{position:fixed;left:5px;width:50px;padding:5px;border:none;color:#1b2340;font-size:16px;font-weight:700;cursor:pointer;z-index:1001;text-align:center}
#menu-toggle2{position:fixed;left:120px;width:100px;color:#1b2340;font-weight:700;background-color:#56c6f4;padding:10px;border:none;cursor:pointer;z-index:1001;font-size:16px;text-align:center}
#menu-logout{float:right;width:25%;height:50px}
#menu-exit{float:right;padding:5px}
</style>
<body>
<section id=secondary_bar>
<div class=breadcrumbs_container>
<?php 
/*echo $this->Html->image("admin/menu_admin.png", ["alt" => "Edit",'id'=>'menu-toggle',
'data-static'=>$this->Html->url('/img/admin/menu_admin.png') ,'data-hover'=>$this->Html->url('/img/admin/menu_admin.gif'),'class'=>'hover-gif','style'=>'width=50px']);
*/
echo $this->Html->image("admin/menu_admin.png", [
    "alt" => "Edit",
    "id" => "menu-toggle",
    "data-static" => $this->Url->build('/img/admin/menu_admin.png', ['fullBase' => true]),
    "data-hover" => $this->Url->build('/img/admin/menu_admin.gif', ['fullBase' => true]),
    "class" => "hover-gif",
    "style" => "width:50px;"
]);
?>
</div>
<div class=section_title>Control Panel DS</div>
<div id=menu-logout> 
<?php 
echo $this->Html->image("admin/admin_exit.png", ["alt" => "Edit",'id'=>'menu-exit', 'url' => ['controller' => 'Users', 'action' => 'logout'],
"data-static" => $this->Url->build('/img/admin/admin_exit.png', ['fullBase' => true]),
"data-hover" => $this->Url->build('/img/admin/admin_exit.gif', ['fullBase' => true]),
'class'=>'hover-gif','style'=>'width=40px']);
?>
</div>
</section>
<aside id=sidebar class=column>
<h3><?= $this->Html->link(__('Articulos'), ['controller' => 'Articulos', 'action' => 'index_admin']) ?></h3>
<h3><?= $this->Html->link(__('Clientes'), ['controller' => 'Clientes', 'action' => 'index_admin']) ?></h3>
<h3><?= $this->Html->link(__('Comprobantes'), ['controller' => 'Comprobantes', 'action' => 'index_admin']) ?></h3>
<h3><?= $this->Html->link(__('Descargas'), ['controller' => 'Descargas', 'action' => 'index_admin']) ?></h3>
<!-- h3><?= $this->Html->link(__('HOT SUR SALE'), ['controller' => 'Descuentos', 'action' => 'index_hss_admin']) ?></h3 -->
<h3><?= $this->Html->link(__('Fragancias'), ['controller' => 'Fragancias', 'action' => 'index_admin']) ?></h3>
<h3><?= $this->Html->link(__('Incorporaciones'), ['controller' => 'Incorporations', 'action' => 'index_admin']) ?></h3>
<h3><?= $this->Html->link(__('Horario de Cortes'), ['controller' => 'Cortes', 'action' => 'index_admin']) ?></h3>
<h3><?= $this->Html->link(__('Logos - Marcas'), ['controller' => 'Marcas', 'action' => 'index_admin']) ?></h3>
<h3><?= $this->Html->link(__('Categoria - Grupos'), ['controller' => 'Grupos', 'action' => 'index_admin']) ?></h3>
<h3><?= $this->Html->link(__('Novedades'), ['controller' => 'Novedades', 'action' => 'index_admin']) ?></h3>
<h3><?= $this->Html->link(__('Ofertas'), ['controller' => 'Ofertas', 'action' => 'index_admin']) ?></h3>
<h3><?= $this->Html->link(__('Ofertas Tipos'), ['controller' => 'OfertasTipos', 'action' => 'index_admin']) ?></h3>
<h3><?= $this->Html->link(__('Pañales Pami'), ['controller' => 'Pedidos', 'action' => 'pami_admin']) ?></h3>
<h3><?= $this->Html->link(__('Pedidos'), ['controller' => 'Pedidos', 'action' => 'index_admin']) ?></h3>
<h3><?= $this->Html->link(__('Pedidos Farmapoint'), ['controller' => 'PedidosFp', 'action' => 'index_admin']) ?></h3>
<h3><?= $this->Html->link(__('Pedidos NEW'), ['controller' => 'Pedidos', 'action' => 'index_admin_new']) ?></h3>
<h3><?= $this->Html->link(__('Reclamos'), ['controller' => 'Tickets', 'action' => 'index_admin']) ?></h3>
<h3><?= $this->Html->link(__('Resumenes'), ['controller' => 'CtacteResumenSemanales', 'action' => 'index_admin']) ?></h3>
<h3><?= $this->Html->link(__('Publicaciones'), ['controller' => 'Publications', 'action' => 'index_admin']) ?></h3>
<h3><?= $this->Html->link(__('Usuarios'), ['controller' => 'Users', 'action' => 'index']) ?></h3>
<h3><?= $this->Html->link(__('Transfers'), ['controller' => 'TransfersProveedors', 'action' => 'index_admin']) ?></h3>
<h3><?= $this->Html->link(__('Tu Farma Point'), ['controller' => 'Descuentos', 'action' => 'index_admin']) ?></h3>
<h3><?= $this->Html->link(__('Reporte Ventas'), ['controller' => 'facturas', 'action' => 'import']) ?></h3>
<h3><?= $this->Html->link(__('Reporte Carro'), ['controller' => 'Carritos', 'action' => 'reporte_carro']) ?></h3>
<h3><?= $this->Html->link(__('Reporte Unidades APP MOVIL'), ['controller' => 'Pedidos', 'action' => 'index_admin_reporte']) ?></h3>

<h3>Admin</h3>
<ul class=toggle>
<li class=icn_settings><?= $this->Html->link(__('Impresoras'), ['controller' => 'Impresoras', 'action' => 'index']) ?></li>
<li class=icn_settings><?= $this->Html->link(__('Clima'), ['controller' => 'Climas', 'action' => 'index']) ?></li>
<li class=icn_settings><?= $this->Html->link(__('Buscar Imagen'), ['controller' => 'Articulos', 'action' => 'search_articulos']) ?></li>
<li class=icn_jump_back><?= $this->Html->link(__('Salir'), ['controller' => 'Users', 'action' => 'logout']) ?></li>
</ul>
<footer>
<hr/>
<p>Copyright © <?php echo date("o"); ?> Droguería Sur.</p>
</footer>
</aside>
<section id=main class=column>
<div id=content>
<div id=mensaje style=display:none>
<?= $this->Flash->render('changepass'); ?>
</div>
<div class=row>
<?= $this->fetch('content') ?>
</div>
</div>
</section>
</body>
<script>
    document.getElementById('menu-toggle').addEventListener('mouseover', function() {
    document.getElementById('sidebar').classList.add('active');
});

document.getElementById('sidebar').addEventListener('mouseleave', function() {
    document.getElementById('sidebar').classList.remove('active');
});


document.addEventListener('DOMContentLoaded', function() {
    const gifs = document.querySelectorAll('.hover-gif');
    
    gifs.forEach(function(gif) {
        gif.addEventListener('mouseover', function() {
            this.src = this.getAttribute('data-hover');
        });
        
        gif.addEventListener('mouseout', function() {
            this.src = this.getAttribute('data-static');
        });
    });
});

</script>
<script>
  $(function() {
      var c = document.getElementById("flashmensajesuccess");
      if (c != null) {
        if (c.innerHTML != "") {
          $.notifyBar({
            cssClass: "success",
            html: c.innerHTML,
            position: "bottom"
          })
        }
      }
      var b = document.getElementById("flashmensajeerror");
      if (b != null) {
        if (b.innerHTML != "") {
          $.notifyBar({
            cssClass: "error",
            html: b.innerHTML,
            close: true,
            closeOnClick: false
          })
        }
      }
      var a = document.getElementById("flashmensajewarning");
      if (a != null) {
        if (a.innerHTML != "") {
          $.notifyBar({
            cssClass: "warning",
            html: a.innerHTML
          })
        }
      }
    });
</script>
</html>
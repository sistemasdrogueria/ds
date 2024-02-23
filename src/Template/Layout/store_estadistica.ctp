<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<!-- Meta, title, CSS, favicons, etc. -->
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Drogueria Sur</title>
<?php
//<!-- Bootstrap -->
echo $this->Html->css('jquery-ui'); 
//echo $this->Html->script('jquery-ui'); 		
//echo $this->Html->css('vendors/bootstrap/dist/css/bootstrap.min');
echo $this->Html->css('estadistica/bootstrap.min');
//<!-- Font Awesome -->
//echo $this->Html->css('vendors/font-awesome/css/font-awesome.min');
echo $this->Html->css('estadistica/font-awesome.min');
//estadistica
//<!-- NProgress -->
//echo $this->Html->css('vendors/nprogress/nprogress');
echo $this->Html->css('estadistica/nprogress');
//<!-- Custom Theme Style -->
//echo $this->Html->css('build/css/custom.min'); 
echo $this->Html->css('estadistica/custom.min'); 
//echo $this->Html->css('vendors/select2/dist/css/select2.min');
echo $this->Html->css('estadistica/select2.min');
//<!-- Switchery -->
//echo $this->Html->css('vendors/switchery/dist/switchery.min');
echo $this->Html->css('estadistica/switchery.min');
//<!-- starrr -->
//echo $this->Html->css('vendors/starrr/dist/starrr');
echo $this->Html->css('estadistica/starrr');

//echo $this->Html->css('vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min');
echo $this->Html->css('estadistica/bootstrap-progressbar-3.3.4.min');
// <!-- bootstrap-daterangepicker -->
echo $this->Html->css('estadistica/daterangepicker');
//echo $this->Html->css('vendors/bootstrap-daterangepicker/daterangepicker');
//echo $this->Html->css('jquery-jvectormap-2.0.3');
?>


</head>

  <body class="nav-sm" onload="displayLineChart();">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
              <?php echo $this->Html->link($this->Html->image("logo_ds_simple.png", ["alt" => "DS",'width'=>'50px']),['controller'=>'carritos','action' => 'index'],['escape' => false,'class'=>'site_title']);?>
             </div>
            <div class="clearfix"></div>
            <!-- menu profile quick info -->
            <div class="profile clearfix">
              <div class="profile_pic">               
              </div>
              <div class="profile_info">
                <span>Bienvenido,</span>
                <h2><?php echo$this->request->session()->read('Auth.User.razon');?> </h2>
              </div>
            </div>
            <!-- /menu profile quick info -->
            <br />
            <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">

            </div>
            <!-- sidebar menu -->
            <!-- menu footer buttons -->
            <div class="sidebar-footer hidden-small">
              <a data-toggle="tooltip" data-placement="top" title="Settings">
                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="FullScreen">
                <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="Lock">
                <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="Logout" href="login.html">
                <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
              </a>
            </div>
            <!-- menu footer buttons -->
          </div>
        </div>

        <!-- top navigation -->
        <div class="top_nav">
          <div class="nav_menu">
            <nav>
              <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
              </div>

              <ul class="nav navbar-nav navbar-right">
                <li class="">
                  <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    Hola <?php echo$this->request->session()->read('Auth.User.razon');?>                
                    <span class=" fa fa-angle-down"></span>
                  </a>
                  <ul class="dropdown-menu dropdown-usermenu pull-right">
                    <!-- li><a href="javascript:;"> Profile</a></li -->
                       <!-- li><a href="javascript:;">Help</a></li -->
                       
                    <li>
                    <?php  
                          echo $this->Html->link('<i class="fa fa-sign-out pull-right"></i>VOLVER',['controller' => 'Carritos', 'action' => 'index'],['escape' => false]);?>
                    </li>
                  </ul>
                </li>

              </ul>
            </nav>
          </div>
        </div>
        <!-- top navigation -->
        <!-- page content -->
      <div class="right_col" role="main">
			  <div id="mensaje" style="display:none;"><?= $this->Flash->render('changepass'); ?></div>
          <?= $this->fetch('content') ?>
       </div>
        <!-- page content -->
        <!-- footer content -->
        <footer>
          <div class="pull-right">
          <span>Droguería Sur SA © <?php echo date("o"); ?> . Villarino 46/58 (B8000JIB) - Bahía Blanca - Buenos Aires </span>
           </div>
          <div class="clearfix"></div>
        </footer>
        <!-- footer content -->
       </div>
    </div>
<?php
    //<!-- jQuery -->
echo $this->Html->script('estadistica/jquery.min');
    //<!-- Bootstrap -->
echo $this->Html->script('jquery-ui-1.10.4.custom.min'); 		
echo $this->Html->script('estadistica/bootstrap.min');
//echo $this->Html->script('jquery-jvectormap-2.0.3.min');  
//echo $this->Html->script('jquery-jvectormap-ar-merc'); 
//echo $this->Html->script('jquery-jvectormap-ar-mill');
//<!-- FastClick -->
echo $this->Html->script('estadistica/fastclick');
    //<!-- NProgress -->
echo $this->Html->script('estadistica/nprogress');
    //<!-- Chart.js -->
echo $this->Html->script('estadistica/Chart');
echo $this->Html->script('estadistica/echarts.min');

echo $this->Html->script('estadistica/icheck.min');
// echo $this->Html->script('build/js/custom');
echo $this->Html->script('estadistica/moment.min'); 
echo $this->Html->script('estadistica/daterangepicker');
echo $this->Html->script('estadistica/es');
echo $this->Html->script('estadistica/bootstrap-datetimepicker.min');


echo $this->Html->css('jquery.notifyBar');
echo $this->Html->script('jquery.notifyBar');
echo $this->Html->script('estadistica/dropzone.min');

//
?>
<!--script src="js/locales/bootstrap-datepicker.es.js" charset="UTF-8"></script -->
<script>
$('#fecha').datetimepicker({format: "DD/MM/YYYY", locale: 'es'});
$('#fechahasta').datetimepicker({format: "DD/MM/YYYY" ,locale: 'es'});
$("#fechadesde").datetimepicker({format: "DD/MM/YYYY" ,locale: 'es'});



$(function() {
var UI=document.getElementById('flashmensajesuccess');
if (UI != null)
{
if (UI.innerHTML != '')
{ 
$.notifyBar({ cssClass: "success", html: UI.innerHTML ,position: "bottom"});
}
}
var UI2=document.getElementById('flashmensajeerror');
if (UI2 != null)
{
if (UI2.innerHTML != '')
{
$.notifyBar({ cssClass: "error", html: UI2.innerHTML, close: true, closeOnClick: false });
}
}
var UI3=document.getElementById('flashmensajewarning');
if (UI3 != null)
{
if (UI3.innerHTML != '')
{
$.notifyBar({ cssClass: "warning", html: UI3.innerHTML });
}
}   
});	
</script>
</body>
</html>
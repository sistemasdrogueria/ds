
<div class="content-section" style="margin-top:15px; padding-top:15px;padding-bottom:30px; background: #EFEFEF;">
<div class="container">
<div class="row">
<div class="col-md-12 section-title">
<h2>RECORDATORIOS</h2>
</div> <!-- /.section -->
</div> <!-- /.row -->

<div id="slider2_container" style="visibility: hidden; position: relative; margin: 0 auto; top: 0px; left: 0px; width: 1300px; height: 350px; overflow: hidden;">
<!-- Loading Screen -->
<!-- Slides Container -->
<div data-u="slides" style="position: absolute; left: 0px; top: 0px; width: 1300px; height: 350px; overflow: hidden;">
<?php foreach ($inicio_slider2 as $slider): 

echo '<div>'.$this->Html->image('publicaciones/'.$slider['imagen'],['data-u'=>'image']).'</div>';

endforeach; 
?>
</div>
<!--#region Bullet Navigator Skin Begin -->
<style>
.jssorb031 {position:absolute;}
.jssorb031 .i {position:absolute;cursor:pointer;}
.jssorb031 .i .b {fill:#000;fill-opacity:0.5;stroke:#fff;stroke-width:1200;stroke-miterlimit:10;stroke-opacity:0.3;}
.jssorb031 .i:hover .b {fill:#fff;fill-opacity:.7;stroke:#000;stroke-opacity:.5;}
.jssorb031 .iav .b {fill:#fff;stroke:#000;fill-opacity:1;}
.jssorb031 .i.idn {opacity:.3;}
</style>
<div data-u="navigator" class="jssorb031" style="position:absolute;bottom:12px;right:12px;" data-autocenter="1" data-scale="0.5" data-scale-bottom="0.75">
<div data-u="prototype" class="i" style="width:16px;height:16px;">
<svg viewBox="0 0 16000 16000" style="position:absolute;top:0;left:0;width:100%;height:100%;">
<circle class="b" cx="8000" cy="8000" r="5800"></circle>
</svg>
</div>
</div><!--#endregion Bullet Navigator Skin End -->
<!--#region Arrow Navigator Skin Begin -->
<style>
</style>
</div><!-- Jssor Slider End -->

</div> <!-- /.container -->
</div> <!-- /.content-section -->

<div class="product-item-3" style="margin-bottom:15px;">
<div id=slider_contenedor style="width:100%">
<div id="slider2_container" style="visibility: hidden; position: relative; margin: 0 auto; top: 0px; left: 0px; width: 1200px; height: 80px; overflow: hidden;">
<div data-u="slides" style="position: absolute; left: 0px; top: 0px; width: 1200px; height: 80px; overflow: hidden;">
<?php foreach ($banner_slider as $slider): 
echo '<div>'.$this->Html->image('publicaciones/'.$slider['imagen'],['url'=>['controller'=>$slider['url_controlador'], 'action'=>$slider['url_metodo'], $slider["url_campo"]],'data-u'=>'image'],['target' => '_blank','_full' => true,'escape' => false]).'</div>';
endforeach; ?>
</div>
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
</div>
</div>
</div>
</div>
</div> 


<?php //echo $this->Html->css('owl.carousel.min.css'); ?>
<style>
.lab_name{height:150px;width: 150px;   display: flex;   justify-content: center;  align-items: center;}
.lab_name a{ color: #000; font-size: 15px; text-align: center; font-weight: bold;}
.owl-carousel,.owl-carousel .owl-item{-webkit-tap-highlight-color:transparent;position:relative}
.owl-carousel{display:none;width:100%;z-index:1}
.owl-carousel .owl-stage{position:relative;-ms-touch-action:pan-Y;touch-action:manipulation;-moz-backface-visibility:hidden}
.owl-carousel .owl-stage:after{content:".";display:block;clear:both;visibility:hidden;line-height:0;height:0}
.owl-carousel .owl-stage-outer{position:relative;overflow:hidden;-webkit-transform:translate3d(0,0,0)}
.owl-carousel .owl-item,.owl-carousel .owl-wrapper{-webkit-backface-visibility:hidden;-moz-backface-visibility:hidden;-ms-backface-visibility:hidden;-webkit-transform:translate3d(0,0,0);-moz-transform:translate3d(0,0,0);-ms-transform:translate3d(0,0,0)}
.owl-carousel .owl-item{min-height:1px;float:left;-webkit-backface-visibility:hidden;-webkit-touch-callout:none}
.owl-carousel .owl-item img{display:block;width:100%}
.owl-carousel .owl-dots.disabled,.owl-carousel .owl-nav.disabled{display:none}
.no-js .owl-carousel,.owl-carousel.owl-loaded{display:block}
.owl-carousel .owl-dot,.owl-carousel .owl-nav .owl-next,.owl-carousel .owl-nav .owl-prev{cursor:pointer;-webkit-user-select:none;-khtml-user-select:none;-moz-user-select:none;-ms-user-select:none;user-select:none}
.owl-carousel .owl-nav button.owl-next,.owl-carousel .owl-nav button.owl-prev,.owl-carousel button.owl-dot{ border:none;}
.owl-carousel.owl-loading{opacity:0;display:block}
.owl-carousel.owl-hidden{opacity:0}
.owl-carousel.owl-refresh .owl-item{visibility:hidden}
.owl-carousel.owl-drag .owl-item{-ms-touch-action:pan-y;touch-action:pan-y;-webkit-user-select:none;-moz-user-select:none;-ms-user-select:none;user-select:none}
.owl-carousel.owl-grab{cursor:move;cursor:grab}.owl-carousel.owl-rtl{direction:rtl}.owl-carousel.owl-rtl .owl-item{float:right}
.owl-carousel .animated{animation-duration:1s;animation-fill-mode:both}.owl-carousel .owl-animated-in{z-index:0}
.owl-carousel .owl-animated-out{z-index:1}.owl-carousel .fadeOut{animation-name:fadeOut}@keyframes fadeOut{0%{opacity:1}100%{opacity:0}}.owl-height{transition:height .5s ease-in-out}
.owl-carousel .owl-item .owl-lazy{opacity:0;transition:opacity .4s ease}.owl-carousel .owl-item .owl-lazy:not([src]),.owl-carousel .owl-item .owl-lazy[src^=""]{max-height:0}
.owl-carousel .owl-item img.owl-lazy{transform-style:preserve-3d}
.nutricionmarcadiv2{margin:0 15px 15px 0;width:160px;height:160px;border:5px solid #bdd367;padding:0;display:inline-flex;justify-content:center;align-items:center;border-radius:4px;background:#fff}
.owl-nav button{background-color:#fff;border:none;color:#a5c74a;padding:10px;cursor:pointer;border-radius:5px;font-size:1.2em;margin:0 10px;transition:background-color .3s}
.owl-nav button span{color:#a5c74a;font-size:1.4em}
.owl-nav button:hover{background-color:#a5c74a;color:#fff!important}
.owl-nav .owl-prev{position:absolute!important;top:45%!important;left:-25px!important;transform:translateY(-50%)!important}
.owl-nav .owl-next{position:absolute!important;top:45%!important;right:-25px!important;transform:translateY(-50%)!important}
.gallery-cell2{width:190px;height:170px;margin-right:10px}
</style>
<?php 
echo $this->Html->script('owl.carousel');?>
<div class="owl-carousel owl-theme">
<?php foreach ($marcas2 as $marca): ?>
<div class="item">
<div class="gallery-cell2"> <!-- -->
<div class="product-item-6"> <!-- -->

<?php 

echo '<div class= nutricionmarcadiv2>';
//echo $this->Html->image('marcas/'.$oferta['imagen'],['url'=>['controller'=>'Carritos','action'=>'promocion',$oferta['busqueda'],$oferta['detalle']]], ['alt' => str_replace('"', '', $oferta['descripcion'])]);
$uploadPath = 'marcas/';
			if (file_exists('www.drogueriasur.com.ar/dsx/webroot/img/'.$uploadPath.$marca['marca']['imagen'] ))
				echo $this->Html->image($uploadPath.$marca['marca']['imagen'], ['alt' => str_replace('"', '', $marca['marca']['nombre']),'width' => 150]);
			else
				if ($marca['marca']['imagen'] != null)
				echo $this->Html->image($uploadPath.$marca['marca']['imagen'], ['alt' => str_replace('"', '', $marca['marca']['nombre']),'width' => 150, 'url' => ['controller' => 'Nutricion', 'action' => 'search',$marca['marca']['id'],$marca['grupo_id']]]);
				else
				echo '<div class=lab_name>'.$this->Html->link(str_replace('"', '', $marca['marca']['nombre']), ['controller' => 'Nutricion', 'action' => 'search',$marca['marca']['id'],$marca['grupo_id']]).'</div>';

        echo '</div>'
			?>
</div> 
</div> <!-- -->
</div> <!-- -->

<?php  endforeach; ?>

</div> <!-- -->

<script>
$(document).ready(function() {
var owl = $('.owl-carousel');
if (window.innerWidth > 768) {
    // Then log this message to the console
   media=1;
  }else{
    media=4;
  }
owl.owlCarousel({
//rtl: true,
margin: 10,
nav: true,
loop: true,
//items:media,
/*autoplay:true,
autoplayTimeout:2000,
autoplayHoverPause:true,*/
autoplay:<?php if ($autoplay==1) echo 'true'; else echo 'false'; ?>,
autoplayTimeout: 2000,
autoplayHoverPause:<?php if ($autoplay==1) echo 'true'; else echo 'false'; ?>,
responsive: {
0: {
items: 1
},
600: {
items: 3
},
900: {
items: 4
},
1000: {
items: 5
},
1100: {
items: 5
},
1300: {
items: 7
},
1400: {
items: 7
},
1500: {
items: 8
},
1700: {
items: 9
},
1900: {
items: 10
}
}
});
})


</script>
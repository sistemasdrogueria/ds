<div class=container>
<div class="col-md-12" >
<div class="product-item-3">
<div class="product-content" >
<?php
echo '<div class=row >'.$this->element('bienestar_search').'</div>';
echo '<div class=hide   id =bienestar_div_grupos_search> '.'</div>';
echo '<div class=row    id = bienestar_row_grupos ><br>'. $this->element('bienestar_grupos');
echo $this->element('bienestar_sin_result'); 
echo '</div>';
?>
</div> 
</div> 

</div> <!-- /.row -->
</div--> <!-- /.product-content -->
<?php 
echo $this->Html->script('paginacion');
?>
<script>

var intro = document.getElementById('main-nav');
intro.style.backgroundColor  = "linear-gradient(to right, #7abcc8 0%, #3f8992 60%, #7abcc8 100%)";
//= (intro.style.backgroundColor == 'rgb(204, 204, 204)') ? 'transparent' : '#CCCCCC';

</script>
<?= $this->Form->create('Estadisticas',['url'=>['controller'=>'estadisticas','action'=>'searchOfertsToLose'],'id'=>'searchform4']); ?>
<div >
<?= $this->Form->input('fechadesde', ['label'=>false,'id'=>'fechadesde','name'=>'fechadesde', 'type'=>'text','placeholder'=>'Fecha Desde:','style'=> 'margin-left: auto;margin-right: auto;']);?>
<?=	$this->Form->input('fechahasta', ['label'=>false,'id'=>'fechahasta','name'=>'fechahasta', 'type'=>'text','placeholder'=>'Fecha Hasta:','style'=> 'margin-left: auto;margin-right: auto;']);?>
    <input type="text" id="searchInput" class="search-input form-control" hidden style="width: 100%;max-width:100%!important;display:none!important;" placeholder="Buscar en la tabla...">
      <div style="    display: inline-flex;
    align-items: center;
    justify-content: center;
    align-content: center;
"> 
              <input type="checkbox" id="perdidas" name="perdidas"  />
    <label for="perdidas">Ofertas Perdidas</label>
        </div>
      <?= $this->Form->submit('Buscar',['id'=>'buttonsearch','name'=>'btnsearch','style'=>'margin-left: auto;margin-right: auto;']); ?>
</div> 
<script>
    document.getElementById('searchform4').addEventListener('submit', function(event) {
        var fechadesde = document.getElementById('fechadesde').value;
        var fechahasta = document.getElementById('fechahasta').value;

        if (!fechadesde || !fechahasta) {
            event.preventDefault(); // Previene el envío del formulario  
            alertify.alert('Por favor, ingrese ambas fechas: Desde y Hasta.');
        }
    });
</script>
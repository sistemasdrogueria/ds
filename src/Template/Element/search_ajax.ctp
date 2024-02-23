<div class="search-form">
    <?php  if(isset($codigobarras)){
              $barra =1;
            }else{
               $barra =0;
            }
              ?>
  <?php echo $this->Form->create('', ['url' => '', 'id' => 'searchform6', 'class' => 'carrito_search_form', 'onsubmit' => 'return false;']); ?>
  <?php
  $ofertastipo = [1 => 'Perfumería y Acces.', 2 => 'Patagonia Med', 3 => 'Todas las Ofertas'];
  echo $this->Form->input('terminobuscar', ['tabindex' => 1, 'label' => '', 'id' => 'terminobuscar', 'name' => 'terminobuscar', 'value' => '', 'type' => 'text', 'placeholder' => 'Buscar Producto',/* 'onchange'=>'javascript:document.confirmInput.submit();',*/ 'style' => 'height: 41px;width: 200px']);
  //echo $this->Form->input('terminobuscar', ['label'=>'','id'=>'terminobuscar','name'=>'terminobuscar','value'=>'', 'type'=>'text','placeholder'=>'Buscar Producto','style'=>'height: 41px;max-width: 180px;'/*, 'onchange'=>'javascript:document.confirmInput.submit()','style'=>'width: 15%'*/]);
  echo $this->Form->input('monodroga_id', ['options' => $Monodrogas,  'label' => '', 'empty' => 'Monodroga', 'class' => 'monodroga_id']);
  echo $this->Form->input('accionfar_id', ['options' => $AccionesFars, 'empty' => 'Acción Terapeutica', 'label' => '', 'class' => 'accionfar_id']);
  echo $this->Form->input('laboratorio_id', ['label' => '', 'options' => $laboratorios, 'empty' => 'Laboratorios', 'class' => 'laboratorio_id']);
  echo $this->Form->input('ofertas', ['label' => '', 'options' => $ofertastipo, 'empty' => 'Ofertas', 'class' => 'ofertas']);
  ?>
  <div id=checkbarra>
    <?php
    echo $this->Form->checkbox('codigobarras', ['hiddenField' => false, 'onclick' => 'validarChech();', 'value' => $barra, 'id' => 'codigobarras']);
    echo $this->Html->image('cb.png', ['id' => 'cbarras', 'alt' => 'Buscar por codigo de barras']); ?>
    <input type="hidden" value="0" class="search_barra_texto"  name="search_barra_texto">
</div>

  <div>
    <input type="submit" class="mainBtn" value="Buscar" onclick="busquedaClick()">
    <!-- onclick="busquedaClick()"-->
  </div>

  <?php
  echo $this->Form->end()
  ?>
</div>
<div> <span id="elSpan"></span></div>

<script>
  /*
document.getElementById("terminobuscar").focus();
function validar(){
//Almacenamos los valores
var nombre=$('#terminobuscar').val();
var laboratorio=$('#laboratorio-id').val();
var monodroga=$('#monodroga-id').val();
var accionfar=$('#accionfar-id').val();
var ofertas=$('#ofertas').val();
//Comprobamos la longitud de caracteres
if (nombre.length>2){ 
return true;
}
else {

if ((laboratorio.length>0) || (monodroga.length>0) || (accionfar.length>0) || (ofertas.length>0) )
{

return true;
}
else
{
var mensaje= 'Minimo 3 caracteres';
alert(mensaje);
return false;		
}
}
}
*/

/*
$('#codigobarras').on("change", function(){
     if($("#codigobarras").is(":checked")) {
        //$("#codigobarras").prop("checked", false);
        //$("#codigobarras").removeAttr("checked");
        $("#monodroga-id").prop("disabled", true);
        $("#accionfar-id").prop("disabled", true);
        $("#laboratorio-id").prop("disabled", true);
        $("#ofertas").prop("disabled", true);
        $("#terminobuscar").attr("placeholder", "Buscar Producto");
     }else{
       $("#monodroga-id").prop("disabled", false);
        $("#accionfar-id").prop("disabled", false);
        $("#laboratorio-id").prop("disabled", false);
        $("#ofertas").prop("disabled", false);
     }
});
*/

  $('#monodroga-id').on("change", function() {


    clickbusqueda();

  });
  $('#accionfar-id').on("change", function() {

    clickbusqueda();


  });
  $('#laboratorio-id').on("change", function() {

    clickbusqueda();


  });
  $('#ofertas').on("change", function() {

    clickbusqueda();

  });

  function busquedaClick() {
    var numeroCaracteres = 0;
    var textoArea = $("#terminobuscar").val();
    if (textoArea) {
      numeroCaracteres = textoArea.length;
    }
    if ($("#codigobarras").is(":checked")) {
       
      var codigobarras = 1;
    } else {

      var codigobarras = 0;
    }
    if ($("#terminobuscar").length) {
      var texto = document.getElementById("terminobuscar").value;      
       caracteres = isNaN(texto);        
            if(caracteres){
               //  $('.search_barra_texto').remove();
            $('.search_barra_texto').val(1);
           //$('#checkbarra').append('<input type="hidden" value="1" class="search_barra_texto"  name="search_barra_texto">');

            }else{

              $('.search_barra_texto').val(0);
            }
      var laboratorio = $("#laboratorio-id").val();
      var monodroga = $("#monodroga-id").val();
      var accionfar = $("#accionfar-id").val();
      var ofertas = $("#ofertas").val();
      var search_barra = $('.search_barra_texto').val();

      var terminobuscar = {
        terminobuscar: texto,
      };
      $("#tablasearch tbody").html('<?php echo $this->Html->image('loading-waiting.gif', ['id' => '', 'alt' => '']); ?>');
      if (
        terminobuscar == "" &&
        laboratorio == "" &&
        monodroga == "" &&
        accionfar == "" &&
        ofertas == ""
      ) {

        $("#footinteresarte").removeClass("hide");
        $("#refer").removeClass("hide");
        $(".page_cart1").remove();
        $(".page_cart1").remove();

      } else {
        if (numeroCaracteres >= 3) {
          $("#elSpan").text("");
          $.ajax({
            data: {
              terminobuscar: texto,
              monodroga_id: monodroga,
              accionfar_id: accionfar,
              laboratorio_id: laboratorio,
              ofertas: ofertas,
              codigobarras: codigobarras,
              search_barra_texto:search_barra

            },
            url: myBaseUrlsSearch_ajax,
            type: "post",
            success: function(response) {




              $("#resultarticulos").html("");
              $("#resultarticulos").html(response);
              if (codigobarras == 1) {
                if(search_barra== 0){
                $("#tab1").attr("val", 1);
                var inputValor = $("#tab1").val();
                var dataid = $("#tab1").attr("data-id");
                tab2 = "tab1";
                var cantidad = $("#tab1").attr("val");
                var datapvid = $("#tab1").attr("data-pv-id");
                $("#codigobarras").attr("checked", "checked");
                validarChech();

                if (inputValor == "") {
                  $("#tab1").val(1);
                  ajaxcartAgregar(dataid, cantidad, datapvid, tab2);
                } else {

                  var num = Number($("#tab1").val()) + 1;
                  $("#tab1").val(num);

                  dataid = $("#tab1").attr("data-id");
                  cantidad = num;
                  datapvid = $("#tab1").attr("data-pv-id");
                  tab2 = "tab1";

                  ajaxcart(dataid, cantidad, datapvid, tab2);
                }  
                $("#terminobuscar").focus();
                }else{


                  $("#terminobuscar").focus();
                }
                
              }else{


                     $("#tab1").focus();
              }
              //  $("#resultacarritos").remove();

            $("#terminobuscar").html("");
            $("#terminobuscar").text("");

              $(".page_cart1").remove();
              Paginacioncar();
              //makeAllSortable();
              $(".page_cart1").addClass("text-center");
              $(".paginator").remove();

              $('#idmonodroga-id').select2();
              $('#accionfar-id').select2();
              $('#laboratorio-id').select2();
            },
          });
        } else {
          $("#elSpan").addClass("text-danger");
          $("#elSpan").text("Ingrese mínimo tres caracteres y presione Enter");
        }
      }
    } else {
      //preguntar si no existe ese id no hacer nada
      //console.log("no existe este id");
    }
  }



  function clickbusqueda() {
    if ($("#terminobuscar").length) {
      var texto = document.getElementById("terminobuscar").value;
      var laboratorio = $("#laboratorio-id").val();
      var monodroga = $("#monodroga-id").val();
      var accionfar = $("#accionfar-id").val();
      var ofertas = $("#ofertas").val();
      var codigobarras = 0;
      $("#tablasearch tbody").html('<?php echo $this->Html->image('loading-waiting.gif', ['id' => '', 'alt' => '']); ?>');


      if (
        texto == "" &&
        laboratorio == "" &&
        texto == "" &&
        monodroga == "" &&
        accionfar == "" &&
        ofertas == ""
      ) {

        $("#footintemresarte").removeClass("hide");
        $("#refer").removeClass("hide");
        $(".page_cart1").remove();
        $(".page_cart1").remove();

        $("#galeriad").removeClass("hide");
        $("#terminobuscar1").prop("selectedIndex", 0);
        $("#laboratorio-id1").prop("selectedIndex", 0);
        $("#monodroga-id1").prop("selectedIndex", 0);
        $("#accionfar-id1").prop("selectedIndex", 0);
        $("#ofertas1").prop("selectedIndex", 0);


      } else {
        $.ajax({
          data: {
            terminobuscar: texto,
            monodroga_id: monodroga,
            accionfar_id: accionfar,
            laboratorio_id: laboratorio,
            ofertas: ofertas,
            codigobarras: codigobarras
          },
          url: myBaseUrlsSearch_ajax,
          type: "post",
          success: function(response) {

            //     $("#resultarticulos").html("");
            $("#resultarticulos").html(response);
             $("#terminobuscar").html("");
            $("#terminobuscar").text("");
            // $("#resultacarritos").remove();
            $("#tab1").focus();
            Paginacioncar();
            $(".page_cart1").addClass("text-center")

            $(".paginator").remove();
          },
        });
      }
    }
  }

  $('.monodroga_id').select2();
  $('.accionfar_id').select2();
  $('.laboratorio_id').select2();
  $('.ofertas').select2();
</script>
<fieldset>
  <div class="padre">
 
    <?= $this->Form->create('', ['url' => ['controller' => 'Articulos', 'action' => 'index_admin'], 'id' => 'searchformofertas', 'autocomplete' => "off", 'onsubmit' => 'return false;']); ?>
    <div class=search_prod>
    <?= $this->Form->input('terminobuscar', ['label' => 'Buscar x codigo de barras', 'id' => 'terminobuscar', 'name' => 'terminobuscar', 'type' => 'text', 'placeholder' => 'Buscar x EAN,  troquel o descripción', 'width' => '260px', 'onkeypress' => 'buscararticulo();']); ?>
    </div>
    <div class=search_prod>
    <?= $this->Form->input('terminobuscarfactura', ['label' => 'Buscar x por codigo de barras', 'id' => 'terminobuscarfactura', 'name' => 'terminobuscar', 'type' => 'text', 'placeholder' => 'Buscar x Factura', 'width' => '220px', 'onkeypress' => 'buscararticulofactura();']); ?>
    </div>
    <div class=search_prod>
    <?= $this->Form->submit('Buscar', ['class' => 'mainBtn', 'id' => 'btn', 'onclick' => 'ejesearch();']); ?>
    </div>
    <?= $this->Form->end() ?>

  </div>
  <br>
  <br>

  <div id="resultado"></div>
</fieldset>

<div id="myModal" class="modal">

  <img class="modal-content" id="img01"><span class="close">&times;</span>
  <div id="caption"></div>
</div>

<script>
  $(document).ready(function() {
    $('.zoom').hover(function() {
      $(this).addClass('transition');
    }, function() {
      $(this).removeClass('transition');
    });
  });


  $('#terminobuscar').focus();

  function ejesearch() {

    if ($("#terminobuscarfactura").val() !== "") {

      const ke = new KeyboardEvent("keyup", {
        bubbles: true,
        cancelable: true,
        keyCode: 13
      });
      document.getElementById('terminobuscarfactura').dispatchEvent(ke);
    } else {
      if ($("#terminobuscar").val() !== "") {

        const ke = new KeyboardEvent("keyup", {
          bubbles: true,
          cancelable: true,
          keyCode: 13
        });
        document.getElementById('terminobuscar').dispatchEvent(ke);


      } else {

        console.log("ambos input estan vacios");
      }
    }

  }


  function buscararticulo() {
    $("#terminobuscarfactura").val("");
    $("#terminobuscarfactura").text("");
    var numeroCaracteres = 0;
    var textoArea = $("#terminobuscar").val();
    numeroCaracteres = textoArea.length;

    var texto = document.getElementById("terminobuscar").value;
    var terminobuscar = {
      terminobuscar: texto,
    };

    if (
      terminobuscar == ""
    ) {} else {
      var keycode = event.keyCode;
      if (keycode == "13") {
        if (numeroCaracteres >= 3) {
          $("#elSpan").text("");

          $.ajax({
            data: {
              terminobuscar: texto,
            },
            url: '<?php echo \Cake\Routing\Router::url(array('controller' => 'Articulos', 'action' => 'buscar')); ?>',
            type: "post",
            success: function(response) {

              $("#terminobuscar").val("");
              $("#resultado").html(response);

            },
          });
        } else {
          $("#elSpan").addClass("text-danger");
          $("#elSpan").text("Ingrese mínimo tres caracteres y presione Enter");
        }
      }
    }
  }

  function buscararticulofactura() {
    $("#terminobuscar").val("");
    $("#terminobuscar").text("");
    var numeroCaracteres = 0;
    var textoArea = $("#terminobuscarfactura").val();
    numeroCaracteres = textoArea.length;
    var texto = document.getElementById("terminobuscarfactura").value;
    var codigoclienteparseado = textoArea.slice(0, 6);
    var numeroparseado = textoArea.slice(6, 14);;
    var notacomprobanteparseado = textoArea.slice(16, 22);

    if (
      numeroparseado == "" && codigoclienteparseado == "" && notacomprobanteparseado == ""
    ) {} else {
      var keycode = event.keyCode;
      if (keycode == "13") {
        if (numeroCaracteres >= 3) {
          $("#elSpan").text("");


          $.ajax({
            data: {
              codigocliente: codigoclienteparseado,
              numerocomprobante: numeroparseado,
              notacomprobante: notacomprobanteparseado,

            },
            url: '<?php echo \Cake\Routing\Router::url(array('controller' => 'Articulos', 'action' => 'buscarfactura')); ?>',
            type: "post",
            success: function(response) {

              $("#resultado").html(response);
              $("#terminobuscarfactura").val("");


            },
          });

        } else {
          $("#elSpan").addClass("text-danger");
          $("#elSpan").text("Ingrese mínimo tres caracteres y presione Enter");
        }
      }
    }
  }




function mostrarimggrande(obj){
var modal = document.getElementById('myModal');
var img = obj.id;
var modalImg = document.getElementById("img01");
var captionText = document.getElementById("caption");

    modal.style.display = "block";
    modalImg.src = obj.src;
    captionText.innerHTML = obj.alt;
}

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks on <span> (x), close the modal
span.onclick = function() { 
  var modal = document.getElementById('myModal');
    modal.style.display = "none";
}
  
</script>
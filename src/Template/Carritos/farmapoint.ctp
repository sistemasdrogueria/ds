<style>
    .product-item-3 label {
        width: 5px;
        font-weight: 400;
    }

    #terminobuscarfp {

        text-align: center;
        text-transform: uppercase;
        height: 40px;
        max-width: 240px;
        margin-bottom: 20px;
        width: 100% !important;
        border:2px solid #008d00;
    }

    #search-backf {
        text-align: center
    }

    .carrito_search_formfp select {
        border: 2px solid #008d00;
        border-radius: 5px;
        background: #fff;
        padding: 10px 10px 10px 8px;
        /* float: left; */
        /* margin: 0px 5px 0 5px; */
        width: 150px;
        
    }

    .carrito_search_formfp {
        display: inline-flex;
        justify-content: center;
        flex-flow: row wrap;
        flex-direction: row;
        flex-wrap: nowrap;
        align-content: center;
        align-items: center;
        text-align: center;
        border-radius: 4px
    }

    .alertify .ajs-header {
        font-size: 18px;
        color: #fff;
    }
/*
    .ajs-ok {
        color: #fff;
        background-color: #004cab;
        border-color: #004cab;
    }

    .ajs-cancel {
        color: #fff;
        background-color: #e11f1f;
        border-color: #e11f1f;
    }

    .alertify .ajs-footer .ajs-buttons .ajs-button {
        min-width: 140px;
        min-height: 40px;
    }

    .ajs-cancel {
        display: none;
    }
*/
    .ajs-message.ajs-custom {
        color: #fff;
        background-color: #004cab;
        border-color: #fff;
    }

    .cantidadoferta {
        background: #fff !important;
        border: 2px solid #008d00 !important;
        border-radius: 4px !important;
        padding: 11px 15px !important;
        width: 40px !important;
    }
</style>
<div class="col-md-9">
    <div class="product-item-3">
        <div class="product-content" style="background-color: #f3f3f3;">
            <?php echo $this->Html->image('logo_tufarmapoint.png', ['width'=>'100%','alt' => 'Farma Point', 'style' => 'margin-left: auto;max-width:500px;
    margin-right: auto;
    display: block;']); ?>
            <div id="search-backf">
                <?= $this->Form->create('', ['url' => '', 'id' => 'searchform6', 'class' => 'carrito_search_formfp', 'onsubmit' => 'return false;']); ?>
                <?php

                echo $this->Form->input('terminobuscarfp', ['label' => '', 'id' => 'terminobuscarfp', 'name' => 'terminobuscarfp', 'value' => '', 'type' => 'text', 'placeholder' => 'Buscar Producto', 'onkeyup' => 'doSearch()', 'style' => '']);
                echo $this->Form->input('Categoria', ['options' => $categorias,  'label' => '', 'id' => 'categoria', 'style' => 'text-transform: uppercase;', 'onchange' => 'doSearchSelectcat();',/*'onchange'=>'doSearchselectmarcas();'*/ 'empty' => 'categoria']);
                echo $this->Form->input('Marca', ['options' => $marcass,  'label' => '', 'id' => 'marca', 'style' => 'text-transform: uppercase;', 'onchange' => 'doSearchSelect();',/*'onchange'=>'doSearchselectmarcas();'*/ 'empty' => 'Marca']);
                echo $this->Form->input('Grupo', ['options' => $gruposs, 'onchange' => 'doSearchSelectG();', 'label' => '', 'style' => 'text-transform: uppercase;', 'empty' => 'Grupo']);
                ?>


                <?php
                echo $this->Form->end()
                ?>

            </div>
            <?php echo $this->element('carrito_search_result_imgfp');
            ?>
        </div> <!-- /.product-content -->
    </div> <!-- /.product-item -->
</div> <!-- /.col-md-3 -->

<div class="col-md-3">

    <?php echo $this->element('carro'); ?>


</div> <!-- /.col-md-4 -->
<script>
    /*
    	$('#terminobuscar').on("change", function(event) {

		$("#elSpan").text("");
		if ($('#terminobuscarfp').val() == 0 && $('#categoria').val() == 0 && $('#marca').val() == 0 && $('#grupo').val() == 0) {
			$("#vista4").removeClass("hide");

		} else {
			
				busquedaselect()
			

		}
	});

*/

    function busquedaselect() {
  var numeroCaracteres = 0;
  var textoArea = $("#terminobuscarfp").val();
  numeroCaracteres = textoArea.length;

  var texto = document.getElementById("terminobuscarfp").value;
  var categoria = $("#categoria").val();
  var marca = $("#marca").val();
  var grupo = $("#grupo").val();

  var terminobuscar = {
    terminobuscar: texto,
  };

  if (
    terminobuscar == "" &&
    categoria == "" &&
    marca == "" &&
    grupo == "" 
   
  ) {
    
  } else {
        $("#elSpan").text("");

        $.ajax({
          data: {
            terminobuscar: texto,
            categoria: categoria,
            marca: marca,
            grupo: grupo,
          },
          url: myBaseUrlsbuscarfp,
          type: "post",
          success: function (response) {
                   console.log(response);
             if(response =='vacio'){
                         $('.noSearch').attr('style',"display:'';")

                     }else{

       $("#cambiar").html(response);
                     }
            $("#mydivgal").addClass("hide");
            $("#refer").addClass("hide");
    
          },
        });
   
    
  }
}

    function busqueda() {
  var numeroCaracteres = 0;
  var textoArea = $("#terminobuscarfp").val();
  numeroCaracteres = textoArea.length;

  var texto = document.getElementById("terminobuscarfp").value;
  var categoria = $("#categoria").val();
  var marca = $("#marca").val();
  var grupo = $("#grupo").val();

  var terminobuscar = {
    terminobuscar: texto,
  };

  if (
    terminobuscar == "" &&
    categoria == "" &&
    marca == "" &&
    grupo == "" 
   
  ) {
    
  } else {
    var keycode = event.keyCode;
    if (keycode == "13") {
      if (numeroCaracteres >= 2) {
        $("#elSpan").text("");

        $.ajax({
          data: {
            terminobuscar: texto,
            categoria: categoria,
            marca: marca,
            grupo: grupo,
          },
          url: myBaseUrlsbuscarfp,
          type: "post",
          success: function (response) {
              console.log(response);
     
                     if(response =='vacio'){
                         $('.noSearch').attr('style',"display:'';")

                     }else{

       $("#cambiar").html(response);
                     }
            $("#mydivgal").addClass("hide");
            $("#refer").addClass("hide");
    
          },
        });
      } else {
        $("#elSpan").addClass("text-danger");
        $("#elSpan").text("Ingrese mínimo dos caracteres y presione Enter");
      }
    }
  }
}



    function doSearch() {
        const tableReg = document.getElementById('gallery-contenedor-fp');
        const searchText = document.getElementById('terminobuscarfp').value.toLowerCase();
        const categoria = document.getElementById('categoria').value.toLowerCase();
        const marca = document.getElementById('marca').value.toLowerCase();
        const grupo = document.getElementById('grupo').value.toLowerCase();
        const div = document.getElementsByClassName('gallery-producto-promocion');

        let total = 0;

        // Recorremos todas las filas con contenido de la tabla
        for (let i = 1; i < div.length; i++) {
            // Si el td tiene la clase "noSearch" no se busca en su cntenido
            if (div[i].classList.contains("noSearch")) {
                continue;
            }

            let found = false;

            const cellsOfRow = div[i].getElementsByClassName('product-item-6');
            const cellsOfRowcategoria = div[i].getElementsByClassName('imagen-f-categorias');
            const cellsOfRowmarca = div[i].getElementsByClassName('marcass');
            const cellsOfRowgrupo = div[i].getElementsByClassName('gruposs');
            // Recorremos todas las celdas
            for (let j = 0; j < cellsOfRow.length && !found; j++) {
                const compareWith = cellsOfRow[j].innerHTML.toLowerCase();

                // Buscamos el texto en el contenido de la celda

                if (searchText.length == 0 || compareWith.indexOf(searchText) > -1) {


                    found = true;
                    total++;
                } else {}
            }

            if (found) {
                div[i].style.display = '';
            } else {
                // si no ha encontrado ninguna coincidencia, esconde la
                // fila de la tabla
                div[i].style.display = 'none';
            }
        }

        // mostramos las coincidencias
        const lastTR = div[div.length - 1];
        const diva = lastTR.querySelector("div");
        //const dive=document.getElementsByClassName('noSearch');
        lastTR.classList.remove("hide", "red");
        if (searchText == "") {
            lastTR.classList.add("hide");
            $(".noSearch").attr('style', 'display:none;');
        } else if (total) {
            diva.innerHTML = "Se ha encontrado " + total + " coincidencia" + ((total > 1) ? "s" : "");
            $(".noSearch").attr('style', 'display:none;');
        } else {

            $(".noSearch").attr('style', '');

            alertify.set('notifier', 'position', 'bottom-right');

            alertify.notify('No se han encontrado coincidencias.', 'custom', 2, function() {}).dismissOthers();


        }
    }

    function doSearchSelect() {
        const tableReg = document.getElementById('producto-bus');

        const mar = document.getElementById('marca');
        var searchText = mar.options[mar.selectedIndex].text.toLowerCase().trim();
        if (searchText == 'marca') {
            var searchText = "";

        }
        console.log(searchText);
        const div = document.getElementsByClassName('gallery-producto-promocion');

        let total = 0;

        // Recorremos todas las filas con contenido de la tabla
        for (let i = 1; i < div.length; i++) {
            // Si el td tiene la clase "noSearch" no se busca en su cntenido
            if (div[i].classList.contains("noSearch")) {
                continue;
            }

            let found = false;
            const cellsOfRow = div[i].getElementsByClassName('marcass');
            // Recorremos todas las celdas
            for (let j = 0; j < cellsOfRow.length && !found; j++) {
                const compareWith = cellsOfRow[j].innerHTML.toLowerCase().trim();
                console.log(compareWith)
                // Buscamos el texto en el contenido de la celda
                if (searchText.length == 0 || compareWith.lastIndexOf(searchText.trim()) > -1) {
                    found = true;
                    total++;
                }
            }
            if (found) {
                div[i].style.display = '';
            } else {
                // si no ha encontrado ninguna coincidencia, esconde la
                // fila de la tabla
                div[i].style.display = 'none';
            }
        }

        // mostramos las coincidencias
        const lastTR = div[div.length - 1];
        const diva = lastTR.querySelector("div");
        //const dive=document.getElementsByClassName('noSearch');
        lastTR.classList.remove("hide", "red");
        if (searchText == "") {
            lastTR.classList.add("hide");
            $(".noSearch").attr('style', 'display:none;');
        } else if (total) {
            // diva.innerHTML = "Se ha encontrado " + total + " coincidencia" + ((total > 1) ? "s" : "");
            $(".noSearch").attr('style', 'display:none;');
        } else {

            $(".noSearch").attr('style', '');

            alertify.set('notifier', 'position', 'bottom-right');

            alertify.notify('No se han encontrado coincidencias.', 'custom', 2, function() {}).dismissOthers();


        }

    }

    function doSearchSelectcat() {
        const tableReg = document.getElementById('producto-bus');
        const cat = document.getElementById('categoria');
        var searchText = cat.options[cat.selectedIndex].text.toLowerCase().trim();
        if (searchText == 'categoria') {
            var searchText = "";

        }

        const div = document.getElementsByClassName('gallery-producto-promocion');

        let total = 0;

        // Recorremos todas las filas con contenido de la tabla
        for (let i = 1; i < div.length; i++) {
            // Si el td tiene la clase "noSearch" no se busca en su cntenido
            if (div[i].classList.contains("noSearch")) {
                continue;
            }

            let found = false;
            const cellsOfRow = div[i].getElementsByClassName('imagen-f-categorias');
            // Recorremos todas las celdas
            for (let j = 0; j < cellsOfRow.length && !found; j++) {
                const compareWith = cellsOfRow[j].innerHTML.toLowerCase();
                // Buscamos el texto en el contenido de la celda
                if (searchText.length == 0 || compareWith.lastIndexOf(searchText.trim(), 1) > -1) {
                    found = true;
                    total++;
                }
            }
            if (found) {
                div[i].style.display = '';
            } else {
                // si no ha encontrado ninguna coincidencia, esconde la
                // fila de la tabla
                div[i].style.display = 'none';
            }
        }

        // mostramos las coincidencias
        const lastTR = div[div.length - 1];
        const diva = lastTR.querySelector("div");
        //const dive=document.getElementsByClassName('noSearch');
        lastTR.classList.remove("hide", "red");
        if (searchText == "") {
            lastTR.classList.add("hide");
            $(".noSearch").attr('style', 'display:none;');
        } else if (total) {
            // diva.innerHTML = "Se ha encontrado " + total + " coincidencia" + ((total > 1) ? "s" : "");
            $(".noSearch").attr('style', 'display:none;');
        } else {

            $(".noSearch").attr('style', '');

            alertify.set('notifier', 'position', 'bottom-right');

            alertify.notify('No se han encontrado coincidencias.', 'custom', 2, function() {}).dismissOthers();


        }

    }

    function doSearchSelectSubg() {
        const tableReg = document.getElementById('producto-bus');
        const cat = document.getElementById('subgrupo');
        var searchText = cat.options[cat.selectedIndex].text.toLowerCase().trim();
        if (searchText == 'subgrupo') {
            var searchText = "";

        }
        const div = document.getElementsByClassName('gallery-producto-promocion');
        let total = 0;

        // Recorremos todas las filas con contenido de la tabla
        for (let i = 1; i < div.length; i++) {
            // Si el td tiene la clase "noSearch" no se busca en su cntenido
            if (div[i].classList.contains("noSearch")) {
                continue;
            }

            let found = false;
            const cellsOfRow = div[i].getElementsByClassName('subgruposs');
            // Recorremos todas las celdas
            for (let j = 0; j < cellsOfRow.length && !found; j++) {
                const compareWith = cellsOfRow[j].innerHTML.toLowerCase();
                // Buscamos el texto en el contenido de la celda
                if (searchText.length == 0 || compareWith.lastIndexOf(searchText.trim()) > -1) {
                    found = true;
                    total++;
                }
            }
            if (found) {
                div[i].style.display = '';
            } else {
                // si no ha encontrado ninguna coincidencia, esconde la
                // fila de la tabla
                div[i].style.display = 'none';
            }
        }

        // mostramos las coincidencias
        const lastTR = div[div.length - 1];
        const diva = lastTR.querySelector("div");
        //const dive=document.getElementsByClassName('noSearch');
        lastTR.classList.remove("hide", "red");
        if (searchText == "") {
            lastTR.classList.add("hide");
            $(".noSearch").attr('style', 'display:none;');
        } else if (total) {
            // diva.innerHTML = "Se ha encontrado " + total + " coincidencia" + ((total > 1) ? "s" : "");
            $(".noSearch").attr('style', 'display:none;');
        } else {

            $(".noSearch").attr('style', '');

            alertify.set('notifier', 'position', 'bottom-right');

            alertify.notify('No se han encontrado coincidencias.', 'custom', 2, function() {

            }).dismissOthers();


        }

    }

    function doSearchSelectG() {
        const tableReg = document.getElementById('producto-bus');

        const mar = document.getElementById('grupo');
        var searchText = mar.options[mar.selectedIndex].text.toLowerCase().trim();
        if (searchText == 'grupo') {
            var searchText = "";

        }
        console.log(searchText);
        const div = document.getElementsByClassName('gallery-producto-promocion');

        let total = 0;

        // Recorremos todas las filas con contenido de la tabla
        for (let i = 1; i < div.length; i++) {
            // Si el td tiene la clase "noSearch" no se busca en su cntenido
            if (div[i].classList.contains("noSearch")) {
                continue;
            }

            let found = false;
            const cellsOfRow = div[i].getElementsByClassName('gruposs');
            // Recorremos todas las celdas
            for (let j = 0; j < cellsOfRow.length && !found; j++) {
                const compareWith = cellsOfRow[j].innerHTML.toLowerCase().trim();
                console.log(compareWith)
                // Buscamos el texto en el contenido de la celda
                if (searchText.length == 0 || compareWith.lastIndexOf(searchText.trim()) > -1) {
                    found = true;
                    total++;
                }
            }
            if (found) {
                div[i].style.display = '';
            } else {
                // si no ha encontrado ninguna coincidencia, esconde la
                // fila de la tabla
                div[i].style.display = 'none';
            }
        }

        // mostramos las coincidencias
        const lastTR = div[div.length - 1];
        const diva = lastTR.querySelector("div");
        //const dive=document.getElementsByClassName('noSearch');
        lastTR.classList.remove("hide", "red");
        if (searchText == "") {
            lastTR.classList.add("hide");
            $(".noSearch").attr('style', 'display:none;');
        } else if (total) {
            // diva.innerHTML = "Se ha encontrado " + total + " coincidencia" + ((total > 1) ? "s" : "");
            $(".noSearch").attr('style', 'display:none;');
        } else {

            $(".noSearch").attr('style', '');

            alertify.set('notifier', 'position', 'bottom-right');

            alertify.notify('No se han encontrado coincidencias.', 'custom', 2, function() {}).dismissOthers();


        }

    }
</script>
<style>
    .new32 {
        width: 333px;
        background-color: #FFFFFF;
        font-family: Arial;
        border: solid 1px #d6d6d6;
        margin-right: 5px;
        display: inline-block;
    }

    .climas {

        display: flex;
        flex-direction: row;
        flex-wrap: wrap;
        align-content: flex-end;
        justify-content: center;
        align-items: center;
    }

    #padre {
        display: inline-block;

    }

    .new32 #wlink {
        font-size: 13px;
        font-weight: 500;
        padding: 0;
        margin: 0;
        width: 100%;

        float: left;
        text-align: center;
        color: #009EE2;
    }


    .new32 #wlink .slink {
        width: 100%;
        float: left;
        display: block;
        text-align: center;
        padding: 4px 0;
        text-transform: uppercase;

    }

    .new32 #wlink .fondo td span.nomDay {
        font-size: 10px;
        font-weight: 700;
        text-transform: uppercase;
        text-align: center;
        text-overflow: ellipsis;
        white-space: nowrap;
        overflow: hidden;
    }


    .new32 #wlink .fondo td span.simbDay {
        height: 60px;
    }

    .new32 .nomP {
        width: 98%;
        margin: 7px 10px 2px 0;
        font-size: 10px;
        font-weight: 500;
        text-align: right;
        color: #868686;
        font-family: Arial;
        line-height: 18px;
        display: inline-block
    }

    .new32 #wlink .fondo td {
        width: 110px;
        float: left;
        text-align: center;
    }

    .new32 #wlink .fondo td span.temps span.TMax {
        text-align: right;
        margin-right: 1%;
        color: #EB1924;
    }

    .new32 #wlink .fondo td span.temps span {
        width: 49%;
        float: left;
        font-size: 15px;
        font-weight: 500;
    }

    .new32 #wlink .fondo td span {
        width: 105px;
        float: left;
        display: block;
        color: #868686;
        margin-top: 1px;
    }

    .new32 #wlink .fondo td span.temps span.TMin {
        text-align: left;
        margin-left: 1%;
        color: #0076BA;
    }

    img {
        border: none;
    }

    .product-thumb {
        border: 1px solid #C4C4C4;
        height: 100%;
        padding: 10px;

    }

    input.mainBtn {
        border: 0;
        outline: 0;
        padding: 10px;
        color: #fff;
        background: #38d62c;
        margin: 10px;
        text-align: center;

    }

    .alink {

        color: #FFFFFF;
    }

    li.news:hover {
        background-color: blue;
        color: black;
    }


    .button4 {
        width: 14px;
        height: 14px;
        background-color: #fff;
        -moz-border-radius: 50px;
        font-size: 19px;
        color: #ec2a3c;
        font-weight: bold;
        line-height: 30px;
        border: none;
        position: absolute;
        padding-right: 15px;
    }

    .button4:hover {
        opacity: 0.70;
        -moz-opacity: .70;
        filter: alpha (opacity=70);
    }

    .button4 a {
        color: #fff;
        text-decoration: none;
        padding: 5px 5px 5px 0;
    }

    .button5 {
        width: 14px;
        height: 14px;
        background-color: #fff;
        -moz-border-radius: 50px;
        font-size: 19px;
        color: #03800b;
        font-weight: bold;
        line-height: 30px;
        border: none;
        position: absolute;
        padding-right: 15px;
    }

    .button5:hover {
        opacity: 0.70;
        -moz-opacity: .70;
        filter: alpha (opacity=70);
    }

    .button5 a {
        color: #fff;
        text-decoration: none;
        padding: 5px 5px 5px 0;
    }

    .principal {
        display: inline-flex;
        flex-direction: column;
        flex-wrap: wrap;
        align-content: stretch;
        justify-content: flex-end;
        align-items: flex-end;
    }

    .alertify-notifier .ajs-message.ajs-error {
        color: #fff;
    }
</style>

<div class="col-md-12 " id="result">
    <div class="product-item-3">
        <div class="product-thumb">
            <div autocomplete="off" class="climas index large-9 medium-8 columns content">
                <input class="terminobuscar hide" onkeyup="busquedalocalidad(this.value);" id="terminobuscar" placeholder="Ingrese la Localidad " style="text-align:center;text-transform: uppercase;height: 40px;max-width: 280px;margin-left: 80px" autocomplete="off">

                <form id="target" onsubmit="return false;" action="#"> </form>
                <?php echo $this->Form->input('provincia', ['options' => $provincias, 'class' => 'form-select', 'label' => '', 'onchange' => 'consultarlocalidades(this.value);', 'empty' => 'SELECIONE LA PROVINCIA', 'name' => "provincia", 'style' => 'text-align:center;text-transform: uppercase;height: 40px;max-width: 280px;margin-left: 30px']); ?>
                <select class="form-select" id="localidades" onchange="guardardatosinput(this);" empty="SELECIONE LA LOCALIDAD" name="localidades" style="text-align:center;text-transform: uppercase;height: 40px;max-width: 280px;margin-left: 10px">
                    <option selected>Selecione la localidad</option>
                </select>
                <input type="submit" id="enviar-btn" class="mainBtn" value="Agregar Localidad">

            </div>


        </div>

    </div> <!-- /.product-thumb -->
    <div class="product-content" id="buscarproduct" style="background-color: #fff;text-align: center;">

    </div>
    <div class="product-content" style="background-color: #fff;text-align: center;">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
            <label class="form-check-label" for="flexCheckDefault">
                Actualizar Clima
            </label>
        </div>
        <div id="padre">

            <?php foreach ($climas as $clima) : ?>


                <?php

                $file = @file_get_contents('http://api.meteored.com.ar/index.php?api_lang=ar&localidad=' . $clima->localidad_id_api . '&affiliate_id=up7kekq351gn&v=3.0');
                $items = json_decode($file, true);
                echo '<table id="webwid' . $clima['id'] . '" class="widget new32" "> 
 <tbody><tr> ';
                echo '<td id="wlink" class="wlink"><a   href="' . $items['url'] . '" target="_blank"> <span class="slink">' . preg_replace("/\[(.*?)\]/i", "", $items['location']) . '</span></a><div class="principal"><button class="text-center button button4"  onclick="preguntarSiNo(' . $clima['id'] . ',this);">x</button></div> 
<table class="fondo"> 
<tbody>
<tr> ';


                echo '<td> <span class="nomDay">' . $items['day'][1]['name'] . '</span> 
 <span class="simbDay"> ' . $this->Html->image('simbolo/weather/' . $items['day'][1]['symbol_value'] . '.png', ['alt' => '' . $items['day'][1]['symbol_description'] . '', 'title' => '' . $items['day'][1]['symbol_description'] . '']) . '
</span>
  <span class="temps"> <span class="TMax">' . $items['day'][1]['tempmax'] . '°</span> <span class="TMin">' . $items['day'][1]['tempmin'] . '°</span> </span> </td> ';


                echo '<td> <span class="nomDay">' . $items['day'][2]['name'] . '</span> 
 <span class="simbDay"> ' . $this->Html->image('simbolo/weather/' . $items['day'][2]['symbol_value'] . '.png', ['alt' => '' . $items['day'][2]['symbol_description'] . '', 'title' => '' . $items['day'][2]['symbol_description'] . '']) . '
</span>
  <span class="temps"> <span class="TMax">' . $items['day'][2]['tempmax'] . '°</span> <span class="TMin">' . $items['day'][2]['tempmin'] . '°</span> </span> </td> ';



                echo '<td> <span class="nomDay">' . $items['day'][3]['name'] . '</span> 
 <span class="simbDay"> ' . $this->Html->image('simbolo/weather/' . $items['day'][3]['symbol_value'] . '.png', ['alt' => '' . $items['day'][3]['symbol_description'] . '', 'title' => '' . $items['day'][3]['symbol_description'] . '']) . '
</span>
  <span class="temps"> <span class="TMax">' . $items['day'][3]['tempmax'] . '°</span> <span class="TMin">' . $items['day'][3]['tempmin'] . '°</span> </span> </td> ';


                echo '</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>';


                ?>

            <?php endforeach; ?>
        </div>
        <input name="transporte" class="hide" id="transporte" value="">
        <input name="localidadid" class="hide" id="localidadid" value="">
        <input name="nombre" class="hide" id="nombre" value="">
        <input name="localidadidapi" class="hide" id="localidadidapi" value="">
        <input name="provinciaidapi" class="hide" id="provinciaidapi" value="">

        <!-- /.product-content -->
    </div>




</div> <!-- /.col-md-3 -->

<script>
    function consultarlocalidades(e) {

        var idp = e;

        $.ajax({
            data: {
                idp: idp,
            },
            url: '<?php echo \Cake\Routing\Router::url(array('controller' => 'Climas', 'action' => 'localidad')); ?>',
            type: "POST",
            dataType: "json",
            success: function(response) {
                $('#localidades').html(response);
                document.getElementById("localidades").innerHTML += "<option>SELECIONE LA LOCALIDAD</option>"
                for (var i in response.localidad) {

                    if (response.localidad[i].localidad_id_api !== null) {
                        document.getElementById("localidades").innerHTML += "<option data-transporte='" + response.localidad[i].codigo + "' data-localidadid='" + response.localidad[i].id + "' data-nombre='" + response.localidad[i].nombre + "' data-provinciaidapi='" + response.localidad[i].provincia_id_api + "'  value='" + response.localidad[i].localidad_id_api + "'>" + response.localidad[i].nombre + "</option>";

                    }
                }
            },

        });

    }

    function busquedalocalidad(s) {

        var numeroCaracteres = 0;
        var textoArea = s;
        numeroCaracteres = textoArea.length;
        var texto = s;
        var terminobuscar = {
            terminobuscar: texto,
        };

        if (
            terminobuscar == ""
        ) {

            if ($("#dc").length) {
                $("#dc").remove();
                $("#bsd").remove();
            }
        } else {
            var keycode = event.keyCode;
            if (keycode == "13") {
                if (numeroCaracteres >= 3) {
                    $("#elSpan").text("");

                    $.ajax({
                        data: {
                            terminobuscar: texto,
                        },
                        url: '<?php echo \Cake\Routing\Router::url(array('controller' => 'Climas', 'action' => 'localidad')); ?>',
                        type: "post",
                        dataType: "json",
                        success: function(response) {
                            $('#listas').html("");
                            var local = response.localidad;
                            for (var i = 0 in local) {
                                var popup = document.getElementById("myPopup");
                                popup.classList.toggle("show");

                                $('#myPopup').append('<li  class="news"><a class="alink" onclick="mostrarbusqueda(' + local[i].localidad_id_api + ');">' + local[i].nombre + '</a></li>');
                            }
                        },
                    });
                } else {
                    $("#elSpan").addClass("text-danger");
                    $("#elSpan").text("Ingrese mínimo tres caracteres y presione Enter");
                }
            }
        }
    }
</script>

<script>
    $(document).ready(function() {

        var checkbox = document.getElementById('flexCheckDefault');

        checkbox.addEventListener("change", validaCheckbox, false);

        function validaCheckbox() {
            var checked = checkbox.checked;
            if (checked) {
                $("#padre").load(" #padre");

            }
        }
        setInterval(validaCheckbox, 600000);
    });


    $("#enviar-btn").click(function() {
            agregarclimalocalidad();

        });

    $("#mas-btn").click(function() {
        agregarclimalocalidad();

    });

    function guardardatosinput(e) {

        var selected = $(e).find('option:selected');
        var transporte = selected.data('transporte');
        var localidadid = selected.data('localidadid');
        var nombre = selected.data('nombre');
        var provinciaidapi = selected.data('provinciaidapi');
        var localidadidapi = $(e).val();
        if (transporte == "") {
            transporte = null;
        }
        $('#transporte').val(transporte);
        $('#localidadid').val(localidadid);
        $('#nombre').val(nombre);
        $('#localidadidapi').val(localidadidapi);
        $('#provinciaidapi').val(provinciaidapi);

        mostrarbusqueda(localidadidapi)
    }

    function mostrarbusqueda(localidadidapi) {

        $.ajax({
            type: "POST",
            url: '<?php echo \Cake\Routing\Router::url(array('controller' => 'Climas', 'action' => 'mostrarsearch')); ?>',
            data: {
                'localidadidapi': localidadidapi,
            },
            dataType: "html",
            success: function(response) {
                $('#buscarproduct').html(response);

            }
        });
    }

    function agregarclimalocalidad() {
        var nombre = $("input#nombre").val();
        var transporteid = $("input#transporte").val();
        var localidadid = $("input#localidadid").val();
        var localidadidapi = $("input#localidadidapi").val();
        var provinciaidapi = $("input#provinciaidapi").val();
        $.ajax({
            type: "POST",
            url: '<?php echo \Cake\Routing\Router::url(array('controller' => 'Climas', 'action' => 'add')); ?>',
            data: {
                'nombre': nombre,
                'transporte_id': transporteid,
                'localidad_id': localidadid,
                'localidad_id_api': localidadidapi,
                'provincia_id_api': provinciaidapi,
            },
            success: function(response) {
                $('#buscarproduct').html("");
                if (response == 1) {
                    location.reload(true);
                    var notification = alertify.notify('Localidad Agregada Correctamente.!!!', 'success', 5, function() {
                        console.log('dismissed');
                    });

                } else {
                    if (response == 0) {
                        console.log("los datos no fueron almacenados.!");
                    } else {

                        var notification = alertify.error('Los datos no fueron almacenados, ya se encuentran agregados en la pagina principal.', 'success', 10, function() {});

                    }
                }
            }
        });
        return false;
    }

    function preguntarSiNo(id, e) {
        alertify.prompt(
            "Eliminar Localidad",
            "¿Esta seguro de eliminar esta localidad?<br> Ingrese los numeros 123456 para eliminar",
            '',
            function() {
                if ($('.ajs-input').val() == 123456) {
                    eliminarlocalidad(id);
                } else {
                    alertify.error("Contraseña incorrecta");
                }

            },
            function() {
                alertify.error("Se canceló la operación");
            }
        );
    }

    function eliminarlocalidad(id) {
        $.ajax({
            type: "post",
            url: '<?php echo \Cake\Routing\Router::url(array('controller' => 'Climas', 'action' => 'delete')); ?>',
            data: {
                "id": id,
            },
            dataType: "json",
            success: function(data) {
                if (data == 1) {
                    $('#webwid' + id).remove();
                    alertify.notify('Localidad Eliminada Correctamente.!!!', 'success', 5, function() {});
                } else {
                    alertify.error('Error, No pudo ser eliminada esta localidad, contacte a un administrador.');
                }
            },
        });
    }
</script>
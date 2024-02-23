<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.8.0/jszip.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.8.0/xlsx.js"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<style>
    .hide {
        display: none;
    }

    #loadingmessage img {

    width: 100px;
    height: 100px;
    }
    #cbox2{
    margin-top: 15px;
    }

    .scrollingTable{
    height: 35em;
    overflow: auto;} 

</style>
<div class="search-form  text-center">
    <form class=" " id="searchform3" action="#" onsubmit="return false;">
        <p class="text-center">
        <h2><b><u>Selecione el rango de fechas</u></b></h2>
        </p>
        <div class="col-auto">
            <label for="fechai">
                <h4><b>Desde</b></h4>
                <input class="text-center" style="margin-left: 20px; border: 5px solid #2a80b9;" type="date" id="fechai" required>
            </label>
            <label for="fechaf">
                <h4><b>Hasta</b></h4>
                <input class="text-center" style="margin-left: 20px; border: 5px solid #2a80b9;" type="date" id="fechaf" required>
            </label>
            <button id="enviar" style="margin-left: 10px;" value="Enviar" type="button" class="btn btn-primary" onclick="ajaxupload();">Enviar</button>
        </div>
        <input type="checkbox" id="cbox2" value="second_checkbox"> <label for="cbox2">Busqueda General</label>
</div>
<br>

<?php
//echo $this->Form->input('namefile', ['id'=>'uploadFile','label'=>'Nombre Archivo','placeholder'=>'Nombre Archivo','disabled'=>'disabled']);
?>

<div id="drop_zone" style=" margin-left:auto; margin-right:auto; position: relative; border: 5px dashed #2a80b9;
    width: 440px;height: 272px;text-align: center;"><br> <br><br><br><br>
    Click Para Adjuntar Archivo <br>o<br> Arrastre El Excel.
    <input type="file" id="drop-area-b" style="opacity: 0.0; position: absolute; top:0; left: 0; bottom: 0; right:0; width: 100%; height:100%;" required />
</div>

<ul id="output"></ul>
<div id='loadingmessage' style='display:none'>
    <?php echo $this->Html->image('ajax-loader.gif', ['title' => 'Cargando, por favor espere!'], ['width' => '30px']); ?>
</div>
<button id="exceld" onclick="location.href='importresultredirect'" type="button" class="btn btn-success hide">Descargar Excel</button>

<!-- /.search-form -->




<script>
    $(document).ajaxStart(function() {
        // show loader on start
        $("#loader").css("display", "block");
    }).ajaxSuccess(function() {
        // hide loader on success
        $("#loader").css("display", "none");
    });


    function ajaxupload() {

        $('#tablaprue tbody').html("");
        $('#exceld').addClass('hide');
        var fechai = $('#fechai').val();
        var fechaf = $('#fechaf').val();
        var fechainn = fechai.split(" ")[0].split("/").reverse().join("/");
        var fechafin = fechaf.split(" ")[0].split("/").reverse().join("/");

        var drop = $('#drop-area-b').val();

        if (fechai !== "" && fechaf !== "" && drop !== "") {

            $('#loadingmessage').show();
        }
        var codigob = document.querySelector('#output1 table tbody');
        var codigobarras = [];
        var claveamp = [];
        var counttr = codigob.children.length - 1;

        for (let i = 1; i <= counttr; i++) {

            z = codigob.children[i].children[0].innerText; //codigo de barras
            clave = codigob.children[i].children[2].innerText; //clave amp

            if (z == "undefined") {

                claveamp.push(clave);

            } else {

                codigobarras.push(z);

            }

        }


        if (codigobarras.length) {
            var cbs = codigobarras.toString();
        } else {
            cbs = 0;
        }

        if ($('#cbox2').prop('checked')) {
            alert('Seleccionado');
            var todos = 0;

        } else {
            var todos = 1;
        }

        var clav = claveamp.toString();

        if (fechai !== "" && fechaf !== "" && drop !== "") {

            if(todos >0){
   $.ajax({

                type: "POST",
                url: "<?php echo \Cake\Routing\Router::url(array('controller' => 'Facturas', 'action' => 'importajax')); ?>",
                data: {
                    "fechain": fechainn,
                    "fechafi": fechafin,
                    "codigobarras": cbs,
                    "claveamp": clav

                },
                dataType: 'json',
                // contentType: "application / json",
                success: function(data) {
                    console.log(data.responseText);
                    if (data.responseText == 2) {
                        var concarro = data.resultadobarras;
                    } else {
                        if (data.responseText == 3) {
                            var concarro = data.resultadoamp;
                        }

                        if (data.responseText == 4) {
                            var concarro = data.resultadocombinado;
                        }
                    }


                    $('#exceld').removeClass('hide');
                    $('#navtt').removeClass('hide');
                    $('#loadingmessage').hide();


                    var ubicarid = concarro;
                    var notification = alertify.notify('Consulta Exitosa!', 'success', 5, function() {
                        console.log('dismissed');
                    });

                    for (var i = 0 in ubicarid) {

                        var porcentaje = (parseFloat(ubicarid[i].precio_total) * parseFloat(ubicarid[i].descuento)) / 100;
                        var date = new Date(ubicarid[i].facturas_cabecera.fecha);
                        const formatDate = (date) => {
                            let formatted_date = date.getDate() + "-" + (date.getMonth() + 1) + "-" + date.getFullYear()
                            return formatted_date;
                        }
                        $('#tablaprue tbody').append('<tr><td  style="width:70px;" class="">' + formatDate(date) + '</td><td style="width:63px;" class="">' + ubicarid[i].cantidad_facturada + '</td><td class="">' + ubicarid[i].pedido_ds + '</td><td class="">' + ubicarid[i].articulo.descripcion_sist + '</td><td class="">' + ubicarid[i].articulo.codigo_barras + '</td><td class="">' + ubicarid[i].descuento + '</td><td style="width:70px;" class="">' + ubicarid[i].precio_total + '</td><td class="">' + porcentaje.toFixed(2) + '</td><td class="">' + data.laboratorios[ubicarid[i].articulo.laboratorio_id] + '</td><td class="">' + ubicarid[i].facturas_cabecera.cliente.codigo + '</td><td class="">' + ubicarid[i].facturas_cabecera.cliente.razon_social + '</td><td class="">' + data.provincias[ubicarid[i].facturas_cabecera.cliente.provincia_id] + '</td><td style="width:100px;" class="">' + ubicarid[i].facturas_cabecera.cliente.cuit + '</td></tr>');
                    }
                   var tablastr= document.querySelectorAll('.table-info tbody tr');
                   console.log(tablastr);


                },

                error: function(jqXHR, exception) {
                    console.log(jqXHR);
                    getErrorMessage(jqXHR, exception);
                },
            });


            }else{
   $.ajax({

                type: "POST",
                url: "<?php echo \Cake\Routing\Router::url(array('controller' => 'Facturas', 'action' => 'importajaxcompleto')); ?>",
                data: {
                    "fechain": fechainn,
                    "fechafi": fechafin,
                    "codigobarras": cbs,
                    "claveamp": clav

                },
                dataType: 'json',
                // contentType: "application / json",
                success: function(data) {
                    console.log(data.responseText);
                    if (data.responseText == 2) {
                        var concarro = data.resultadobarras;
                    } else {
                        if (data.responseText == 3) {
                            var concarro = data.resultadoamp;
                        }

                        if (data.responseText == 4) {
                            var concarro = data.resultadocombinado;
                        }
                    }


                    $('#exceld').removeClass('hide');
                    $('#navtt').removeClass('hide');
                    $('#loadingmessage').hide();


                    var ubicarid = concarro;
                    var notification = alertify.notify('Consulta Exitosa!', 'success', 5, function() {
                        console.log('dismissed');
                    });

                    for (var i = 0 in ubicarid) {

                        var porcentaje = (parseFloat(ubicarid[i].precio_total) * parseFloat(ubicarid[i].descuento)) / 100;
                        var date = new Date(ubicarid[i].facturas_cabecera.fecha);
                        const formatDate = (date) => {
                            let formatted_date = date.getDate() + "-" + (date.getMonth() + 1) + "-" + date.getFullYear()
                            return formatted_date;
                        }
                        $('#tablaprue tbody').append('<tr><td  style="width:70px;" class="">' + formatDate(date) + '</td><td style="width:63px;" class="">' + ubicarid[i].cantidad_facturada + '</td><td class="">' + ubicarid[i].pedido_ds + '</td><td class="">' + ubicarid[i].articulo.descripcion_sist + '</td><td class="">' + ubicarid[i].articulo.codigo_barras + '</td><td class="">' + ubicarid[i].descuento + '</td><td style="width:70px;" class="">' + ubicarid[i].precio_total + '</td><td class="">' + porcentaje.toFixed(2) + '</td><td class="">' + data.laboratorios[ubicarid[i].articulo.laboratorio_id] + '</td><td class="">' + ubicarid[i].facturas_cabecera.cliente.codigo + '</td><td class="">' + ubicarid[i].facturas_cabecera.cliente.razon_social + '</td><td class="">' + data.provincias[ubicarid[i].facturas_cabecera.cliente.provincia_id] + '</td><td style="width:100px;" class="">' + ubicarid[i].facturas_cabecera.cliente.cuit + '</td></tr>');
                    }
                    var tablastr= document.querySelectorAll('.table-info tbody tr');
                    console.log(tablastr);

                },

                error: function(jqXHR, exception) {
                    console.log(jqXHR);
                    getErrorMessage(jqXHR, exception);
                },
            });

            }

         
        }
    }

    function getErrorMessage(jqXHR, exception) {
        var msg = '';
        if (jqXHR.status === 0) {
            msg = 'Not connect.\n Verify Network.';
        } else if (jqXHR.status == 404) {
            msg = 'Requested page not found. [404]';
        } else if (jqXHR.status == 500) {
            msg = 'Internal Server Error [500].';
        } else if (exception === 'parsererror') {
            msg = 'Requested JSON parse failed.';
        } else if (exception === 'timeout') {
            msg = 'Time out error.';
        } else if (exception === 'abort') {
            msg = 'Ajax request aborted.';
        } else {
            msg = 'Uncaught Error.\n' + jqXHR.responseText;
        }
        console.log(msg);

    }
</script>

<script>
    //limitar fechas hasta el dia de hoy.
    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth() + 1;
    var yyyy = today.getFullYear();
    if (dd < 10) {
        dd = '0' + dd
    }
    if (mm < 10) {
        mm = '0' + mm
    }

    today = yyyy + '-' + mm + '-' + dd;
    document.getElementById("fechaf").setAttribute("max", today);
    document.getElementById("fechai").setAttribute("max", today);





    function validard() {

        if ($('#uploadBtn').val().length == 0) {


        } else {

            var doc = $('#uploadBtn')[0].files[0];
            var yy = doc.size > 4000000;
            if (yy) {
                alert("archivo a subir maximo 4mb");
                return;
            }

            var data = new FormData();
            data.append("archivo", doc);
            $.ajax({
                url: "<?php echo \Cake\Routing\Router::url(array('controller' => 'Facturas', 'action' => 'importresult')); ?>",
                type: "post",
                data: {
                    "archivo": data,
                },

                processData: false,
                contentType: false,
                error: function(e) {
                    alert("Hubo error");
                },
                success: function(res, data) {
                    console.log(res, data);
                }
            });
        }



    }
</script>
<script>
    $('#uploadBtn,#drop-area-b').on("change", function() {
        $('#exceld').addClass('hide');
        Upload();

    });

    function Upload() {
        //Reference the FileUpload element.
        var fileUpload = document.getElementById("drop-area-b");

        //Validate whether File is valid Excel file.
        var regex = /^([a-zA-Z0-9\s_\\.\-:])+(.xls|.xlsx)$/;
        if (regex.test(fileUpload.value.toLowerCase())) {
            if (typeof(FileReader) != "undefined") {
                var reader = new FileReader();

                //For Browsers other than IE.
                if (reader.readAsBinaryString) {
                    reader.onload = function(e) {
                        ProcesarExcel(e.target.result);
                    };
                    reader.readAsBinaryString(fileUpload.files[0]);
                } else {
                    //For IE Browser.
                    reader.onload = function(e) {
                        var data = "";
                        var bytes = new Uint8Array(e.target.result);
                        for (var i = 0; i < bytes.byteLength; i++) {
                            data += String.fromCharCode(bytes[i]);
                        }
                        ProcesarExcel(data);
                    };
                    reader.readAsArrayBuffer(fileUpload.files[0]);
                }
            } else {
                alert("Este navegador no soporta  HTML5.");
            }
        } else {
            alert("Por favor, cargue un archivo excel valido.");
            $('.table-info').html("");
              $('.table-primary tbody').html("");
        }
    };



    function ProcesarExcel(data) {
        //Read the Excel File data.

        var workbook = XLSX.read(data, {
            type: 'binary'
        });

        //buscarean.indexOf("EAN");

        //console.log(buscarean.indexOf(element) )



        //Fetch the name of First Sheet.
        var firstSheet = workbook.SheetNames[0];

        //Read all rows from First Sheet into an JSON array.
        var excelRows = XLSX.utils.sheet_to_row_object_array(workbook.Sheets[firstSheet]);


        var cont = 0;

        for (var indice in excelRows) {
            if (typeof excelRows[indice].EAN !== 'undefined' || typeof excelRows[indice].CLAVE !== 'undefined') {
                var con = con + 1;

                cont = cont + 1;
            } else {
                var con = 0;
            }
        }

        if (con === 0 && cont < 1) {
            $("#output1").html("");
            alert("este documento no contiene clave EAN");

        } else {

            $('#tablaprue tbody').html("");
            var table = document.createElement("table");
            table.border = "1";
            table.className = "table table-info";

            var row = table.insertRow(-1);

            var headerCell = document.createElement("TH");
            headerCell.innerHTML = "EAN";
            row.appendChild(headerCell);

            headerCell = document.createElement("TH");
            headerCell.innerHTML = "DESCRIPCION";
            row.appendChild(headerCell);

            headerCell = document.createElement("TH");
            headerCell.innerHTML = "CLAVE";
            row.appendChild(headerCell);

            headerCell = document.createElement("TH");
            headerCell.innerHTML = "DTO";
            row.appendChild(headerCell);

            headerCell = document.createElement("TH");
            headerCell.innerHTML = "TIPO DTO";
            row.appendChild(headerCell);

            headerCell = document.createElement("TH");
            headerCell.innerHTML = "CONDICION";
            row.appendChild(headerCell);

            for (var i = 0; i < excelRows.length; i++) {

                var row = table.insertRow(-1);



                var cell = row.insertCell(-1);
                cell.innerHTML = excelRows[i].EAN;

                cell = row.insertCell(-1);
                cell.innerHTML = excelRows[i].DESCRIPCION;

                cell = row.insertCell(-1);
                cell.innerHTML = excelRows[i].CLAVE;

                cell = row.insertCell(-1);
                cell.innerHTML = excelRows[i].DTO;

                cell = row.insertCell(-1);
                cell.innerHTML = excelRows[i].TIPO;

                cell = row.insertCell(-1);
                cell.innerHTML = excelRows[i].CONDICION;
            }

            var dvExcel = document.getElementById("output1");
            dvExcel.innerHTML = "";
            dvExcel.appendChild(table);
            var notification = alertify.notify('archivo cargado  Exitosamente!', 'success', 5, function() {
        
            });
        }
  
    };

        
</script>
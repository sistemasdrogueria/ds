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

    #cbox2 {
        margin-top: 15px;
    }

    .scrollingTable {
        height: 35em;
        overflow: auto;
    }
</style>
<div class="search-form  text-center">
    <form class=" " id="searchform3" action="#" onsubmit="return false;">
     <h2><b><u>Reporte unidades APP MOVIL</u></b></h2> <br>
        <p class="text-center">
        <h3>Seleccioné un rango de fechas</h3>
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

</div>
<br>

<?php
//echo $this->Form->input('namefile', ['id'=>'uploadFile','label'=>'Nombre Archivo','placeholder'=>'Nombre Archivo','disabled'=>'disabled']);
?>


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



  document.addEventListener('DOMContentLoaded', function() {
    // Obtén la fecha actual
    var today = new Date();

    // Formatea la fecha en el formato YYYY-MM-DD
    var formattedDate = today.toISOString().slice(0, 10);

    // Asigna la fecha al campo de entrada
    document.getElementById('fechai').value = formattedDate;
    document.getElementById('fechaf').value = formattedDate;
  });

    function ajaxupload() {

        $('#tablaprue tbody').html("");
        $('#exceld').addClass('hide');
        var fechai = $('#fechai').val();
        var fechaf = $('#fechaf').val();
        var fechainn = fechai.split(" ")[0].split("/").reverse().join("/");
        var fechafin = fechaf.split(" ")[0].split("/").reverse().join("/");


        if (fechai !== "" && fechaf !== "") {

         
                $.ajax({

                    type: "POST",
                    url: "<?php echo \Cake\Routing\Router::url(array('controller' => 'Pedidos', 'action' => 'reportPedidosExcel')); ?>",
                    data: {
                        "fechain": fechainn,
                        "fechafi": fechafin,

                    },
                    dataType: 'json',
                    // contentType: "application / json",
                    success: function(data) {
                        console.log(data.responseText);
                        if (data.responseText == 2) {
                            var concarro = data.resultados;
                        } else {
                           
                        }


                        $('#exceld').removeClass('hide');
                        $('#navtt').removeClass('hide');
                        $('#loadingmessage').hide();


                        var ubicarid = concarro;
                        var notification = alertify.notify('Consulta Exitosa!', 'success', 5, function() {
                            console.log('dismissed');
                        });

                     
                        var tablastr = document.querySelectorAll('.table-info tbody tr');
                        console.log(tablastr);


                    },

                    error: function(jqXHR, exception) {
                        console.log(jqXHR);
                        getErrorMessage(jqXHR, exception);
                    },
                });


          


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


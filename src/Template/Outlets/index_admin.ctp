<style>
   .container {
    display: flex;
   }

    .select-div {
        border-radius: 8px;
        width: 100%;
        margin: 0 auto;
        display: flex;
        justify-content: space-between;
    }

    /* Icon buttons container */
    .icon-buttons {
        display: flex;
        flex-direction: row;
        gap: 10px;
    }

    /* Styling each icon button */
    .icon-btn {
        font-size: 26px;
        padding: 5px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        transition: background-color 0.3s ease;
        width: 45px;
    }

    /* Different colors for each button */
    .add {
        background-color: #4CAF50;
        color: white;
    }

    .attach {
        background-color: #2196F3;
        color: white;
    }

    .delete {
        background-color: #f44336;
        color: white;
    }

    .edit {
        background-color: #FF9800;
        color: white;
    }

    .icon-btn:hover {
        opacity: 0.8;
    }

    /* Result display styling */
    .result-display {
        text-align: center;
        flex-grow: 1;
        padding: 13px;
        border: 1px solid #ddd;
        border-radius: 8px;
        font-size: 18px;
        background-color: #f9f9f9;
        margin: 5px;
        font-weight: bolder;
    }

    .result-div {
        text-align: center;
        flex-grow: 1;
        padding: 13px;
        border: 1px solid #ddd;
        border-radius: 8px;
        font-size: 18px;
        background-color: #f9f9f9;
        margin: 5px;
        width: 98%;
        height: auto;

    }

    #result-div {
        display: inline-flex;
        justify-content: center;
        align-items: center;
        align-content: center;
        flex-direction: column;
    }

    .excel-format-container {
        display: flex;
        flex-direction: column;
        border: 1px solid #b7b7b7;
        border-radius: 5px;
        margin: 30px;
        padding: 15px;
        width: 80%;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        font-family: Arial, sans-serif;
        background-color: #f3f9fc;
    }

    .excel-format-container h3 {
        font-size: 1.2em;
        color: #1a73e8;
        margin-bottom: 10px;
        text-align: center;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
        font-size: 12px;
    }

    th,
    td {
        padding: 8px;
        text-align: left;
        border: 1px solid #b7b7b7;
    }

    thead tr {
        background-color: #e3f2fd;
        font-weight: bold;
        color: #333;
    }

    .text-red {
        color: #d32f2f;
        font-weight: bold;
    }

    tr:hover {
        background-color: #f1f8ff;
    }



    table {
        width: 100%;
        border-collapse: collapse;
        font-family: Arial, sans-serif;
        margin-top: 20px;
    }

    th,
    td {
        padding: 10px;
        text-align: left;
    }

    th {
        background-color: #4CAF50;
        color: white;
    }

    tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    tr:hover {
        background-color: #ddd;
    }



    .icon-btn:hover {
        background-color: #45a049;
    }

    .search-container-div {
        display: flex;
        align-items: center;
        width: 100%;
        max-width: 400px;
        margin: auto;
        border: 1px solid #ccc;
        border-radius: 4px;
        padding: 5px;
    }

    .search-input {
        flex: 1;
        border: none;
        outline: none;
        padding: 8px;
        font-size: 16px;
    }

    .search-button {
        background: none;
        border: none;
        cursor: pointer;
        padding: 5px;
    }

    .search-icon {
        width: 20px;
        height: 20px;
    }

    .attach-div {
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 20px;
        background-color: #f9f9f9;
        border: 1px solid #ddd;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        width: 96%;

    }

    .file-label {
        font-weight: bold;
        font-size: 16px;
        margin-bottom: 10px;
        color: #333;
    }

    .file-input {
        width: 100%;
        padding: 8px;
        font-size: 16px;
        border: 1px solid #ddd;
        border-radius: 4px;
        outline: none;
        margin-bottom: 20px;
        transition: border-color 0.3s;
    }

    .file-input:hover {
        border-color: #888;
    }

    .button-container {
        margin-top: 20px;
    }

    .attach-button {
        background-color: #4CAF50;
        color: white;
        padding: 10px 20px;
        font-size: 16px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .attach-button:hover {
        background-color: #45a049;
    }

    .almacenados {
        background-color: #45a049;
    }

    .noalmacenados {
        background-color: #d32f2f;

    }
    .cursosr-pointer{
        cursor: pointer;
    }
</style>

<article class="module width_3_quarter">
<header><h3 class="tabs_involved">OUTLETS</h3>

<div class="tabs_bt_nuevo">
		<?= $this->Html->image("admin/icn-nuevo.png", ["class"=>"cursosr-pointer", "alt" => "Nuevo","onclick"=>"showResult('Agregar')"]);?>
        
		<?= $this->Html->image("admin/adjuntar.png", ["class"=>"cursosr-pointer","alt" => "Nuevo",'onclick'=>"showResult('Attach')"]);?>
				<?= $this->Html->image("admin/search-outlet.png", ["class"=>"cursosr-pointer","alt" => "Nuevo",'onclick'=>"showResult('Buscar')"]);?>
        </div>
</header>

<div class="container">

    <div class="result-div" id="result-div">
        <div class="search-container-div">
            <input type="text" placeholder="Buscar..." class="search-input">
            <button class="search-button">
                🔍 <!-- Reemplaza 'search-icon.svg' por el ícono deseado -->
            </button>
        </div>
        <table>
            <thead>
                <tr>
                    <th>img</th>
                    <th>Descripción</th>
                    <th>Troquel</th>
                    <th>Fecha Inicio</th>
                    <th>Fecha finaliza</th>
                    <th>Cod barras</th>
                    <th>Venc.</th>
                    <th>Acciones</th>
                </tr>

            </thead>
            <tbody>
                <?php foreach ($outlets as $as):
                    echo "<tr>
                    
        <td>" . $this->Html->image('productos/' . $as['articulo']['imagen'], ['alt' => str_replace('"', '', $as['articulo']['descripcion']), 'height' => 100, 'class' => 'imgFoto']) . "</td>
            <td>" . $as['articulo']['descripcion_sist'] . "</td>
            <td>" . $as['articulo']['troquel'] . "</td>
            <td>" . $as['fecha_inicio'] . "</td>
            <td>" . $as['fecha_final'] . "</td>
            <td>" . $as['articulo']['codigo_barras']  . "</td>
            <td>" . $as['venc'] . "</td>
            <td>
            <a href='edit_admin/" . $as['id'] . "'><img src='/dsx/img/admin/admin_edit.png' class='hover-gif' style='width=50px'></a>";

                    echo $this->Form->postLink(
                        $this->Html->image('/img/admin/admin_delete.png', [
                            'alt' => 'Delete Icon',
                            'style' => ''
                        ]) . ' ' . __(''),
                        ['action' => 'delete_admin', $as->id],
                        [
                            'escape' => false, // Permite interpretar el HTML generado por Html->image()
                            'confirm' => __('Are you sure you want to delete # {0}?', $as->id)
                        ]
                    );
                    echo "</td> </td>
            </tr>";

                endforeach; ?>

            </tbody>
    </div>

</div>
</article>
<div class="modal fade" id="enlargeImageModal" tabindex="-1" role="dialog" aria-labelledby="enlargeImageModal" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <img src="" class="enlargeImageModalSource" style="width: 100%;">
            </div>
        </div>
    </div>
</div>
<?php
// Verificar si el parámetro está presente en la URL
$actionToRun = $this->request->getQuery('actionToRun');
?><script>
    document.addEventListener('DOMContentLoaded', function() {
        // Solo ejecutar la función si el parámetro existe
        <?php if (!empty($actionToRun)) : ?>
            showResult('<?= h($actionToRun) ?>');
        <?php endif; ?>
    });
</script>
<script>
    function showResult(action) {
        //const resultDisplay = document.getElementById('result-display');
        const resultDiv = document.getElementById('result-div');

       // resultDisplay.textContent = `${action}`;

        if (action === 'Attach') {
            resultDiv.innerHTML = `
            <div class="container">
    <div class="attach-div">
        <label for="excel-file" class="file-label">Selecciona un archivo Excel:</label>
        <input type="file" id="excel-file" accept=".xls, .xlsx" class="file-input">
        
        <div class="button-container">
            <button onclick="procesarArchivo()" class="attach-button">Adjuntar</button>
        </div>
    </div>
</div>
             <div style=" display: inline-flex;flex-direction: column;border: 1px solid #b7b7b7;border-radius: 5px;padding: 10px;margin-top: 10px;width: 97%;">
            <h3>Formato del archivo excel </h3>
            <table>
            <thead style="font-size: 12px;">
            <tr>
            <td class="text-red">Troquel</td>
            <td class="text-red">Venc.</td>
            <td class="text-red">Descripcion del Producto</td>
            <td class="text-red">Fecha finalizado</td>
            <td>Nombre  del  Proveedor</td>
            <td>Exist.Part</td>
            <td>Exist.Tot.</td>
            <td>Orden</td>    
            <td>Observaciones</td>    
            <td>Descuento</td>           			
            </tr></thead></table>
            </div>
            <div>
                <div style=" display: inline-flex;flex-direction: column;border: 1px solid #b7b7b7;border-radius: 5px;padding: 10px;margin-top: 10px;width: 97%;background-color: #86fb86d1;">
            <h3>outlets Almacenados: </h3>
            <table class="almacenados">
            <thead style="font-size: 12px;">
            <tr>
            <td class="">Descripción Articulo</td>
            <td class="">Venc.</td>
            <td class="">Descripción del Producto</td>
            <td>Fecha creado</td>
            <td class="">Fecha finalizado</td>
            <td>Condición</td>
            <td>Descuento por condición</td>
            <td>unidades Stock</td>          			
            </tr></thead><tbody id="tbody-almacenados"></tbody></table>
            </div>

                <div style=" display: inline-flex;flex-direction: column;border: 1px solid #b7b7b7;border-radius: 5px;padding: 10px;margin-top: 10px;width: 97%;background-color: #ef04046e;">
            <h3>Outlelt No Almacenados: </h3>
            <table class="noalmacenados">
            <thead style="font-size: 12px;">
            <tr>
            <td class="">Troquel</td>
            <td class="">Venc.</td>
            <td class="">Descripcion del Producto</td>
            <td class="">Fecha finalizado</td>
            <td>Nombre  del  Proveedor</td>
            <td>Exist.Part</td>
            <td>Exist.Tot.</td>
            <td>Orden</td>    
            <td>Observaciones</td>        			
            </tr></thead><tbody id="tbody-no-almacenados"></tbody></table>
            </div>
            </div>
        `;
        } else if (action === 'Agregar') {

            window.location.href = "add_admin";
        } else if (action === 'Buscar') {
            window.location.href = "index_admin";
        }
    }

    function buscar() {
        const searchInput = document.getElementById('search').value;
        alert(`Buscando el ID: ${searchInput}`);
    }

    function eliminar() {
        alert("Elemento eliminado");
    }


    function procesarArchivo() {
        const fileInput = document.getElementById('excel-file');
        const file = fileInput.files[0];
        if (!file) {
            alert("Por favor, selecciona un archivo Excel.");
            return;
        }
        const reader = new FileReader();
        reader.onload = (e) => {
            const data = new Uint8Array(e.target.result);
            const workbook = XLSX.read(data, {
                type: 'array'
            });
            // Convertimos la primera hoja a un array
            const sheetName = workbook.SheetNames[0];
            const worksheet = workbook.Sheets[sheetName];
            const sheetData = XLSX.utils.sheet_to_json(worksheet, {
                header: 1
            });
            // Enviamos los datos (como array) a donde necesites
            // console.log("Array del archivo Excel:", sheetData);
            // Ejemplo de envío: puedes usar fetch o axios para enviar los datos a tu servidor
            enviarDatos(sheetData);
        };
        reader.readAsArrayBuffer(file);
    }


    function enviarDatos(data) {
        //console.log(data);
        $.ajax({
            type: "post",
            url: '<?php echo \Cake\Routing\Router::url(array('controller' => 'outlets', 'action' => 'validateArticlesAdmin')); ?>',
            data: {
                arrayExcel: data
            },
            dataType: "json",
            success: function(data) {
                if (data.success) {
                    if (data.responseText == "Almacenado") {
                        alertify.success('Datos Almacenados');
                        data.resultados.almacenados.map(function(data) {
                            if (data.descuento_por_condicion) {
                                // Usa el valor si no es null o vacío
                                descuentoPorCondicion = 'Descuento:'+data.descuento_por_condicion+'';
                            } else {
                                descuentoPorCondicion = 'No hay descuento por condición';
                            }
                            if (data.unidades_stock) {
                                // Usa el valor si no es null o vacío
                                unidadesPorStock = data.unidades_stock;
                            } else {
                                unidadesPorStock = 'No hay Unidades agregadas';
                            }
                            $('#tbody-almacenados').append('<tr><td>'+data.descripcion_sist +'</td><td>' + data.venc + '</td><td>' + data.descripcion_sist + '</td><td>' + data.fecha_inicio + '</td><td>' + data.fecha_final + '</td><td>' + data.condicion + '</td><td>' + descuentoPorCondicion + '</td><td>' + unidadesPorStock + '</td></tr>')
                        });
                        data.sinprocesar.map(function(data) {
                            $('#tbody-no-almacenados').append('<tr><td>' + data[0] + '</td><td>' + data[1] + '</td><td>' + data[2] + '</td><td>' + data[3] + '</td><td>' + data[4] + '</td><td>' + data[5] + '</td><td>' + data[6] + '</td><td>' + data[7] + '</td><td>' + data[8] + '</td></tr>')
                        });
                    }
                }

            },
        });
    }

    $(function() {
        $('.imgFoto').on('click', function() {
            var str = $(this).attr('src');
            var res = str.replace("productos/", "productos/big_");
            var a = new XMLHttpRequest();
            a.open("GET", res, false);
            a.send(null);
            if (a.status === 404) {
                var res = $(this).attr('src');
                //var res = res.replace("foto.png", "productos/"+$(this).data("id"));
            }
            //var res =  $(this).attr('src');
            $('.enlargeImageModalSource').attr('src', res);
            $('#enlargeImageModal').modal('show');
        });
    });
</script>
<?php echo $this->Html->script('bootstrap'); ?>
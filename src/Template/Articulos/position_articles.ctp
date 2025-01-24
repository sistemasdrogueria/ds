<style>
    :root {
        --primary-color: #3498db;
        --secondary-color: #2ecc71;
        --danger-color: #e74c3c;
        --text-color: #333;
        --background-color: #f5f5f5;
    }

    .maincontenedor {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: var(--background-color);
        color: var(--text-color);
        line-height: 1.6;
        margin: 0;
        padding: 0;
    }

    .contenidoPrincipal {
        margin: 2rem auto;
        padding: 2rem;
        background-color: white;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .titlePosicion {
        color: var(--primary-color);
        text-align: center;
        margin-bottom: 2rem;
    }

    .formularioenviar {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .producto {
        display: flex;
        gap: 1rem;
        align-items: center;
        background-color: #f9f9f9;
        padding: 1rem;
        border-radius: 4px;
        transition: all 0.3s ease;
    }

    .producto:hover {
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .input-contenido {
        flex: 1;
        padding: 0.5rem;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 1rem;
    }

    .btnModificado {
        padding: 0.5rem 1rem;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 1rem;
        transition: background-color 0.3s ease;
    }

    /* Estilo base del botón */
    .btn-eliminar {
        background-color: #f44336;
        border: none;
        border-radius: 50%;
        color: white;
        width: 40px;
        height: 40px;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 18px;
        cursor: pointer;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: background-color 0.3s ease, transform 0.2s ease;
    }

    .btn-eliminar:hover {
        background-color: #d32f2f;
        transform: scale(1.1);
    }

    .icon-trash {
        display: inline-block;
        font-size: 20px;
    }



    #otroProducto {
        background-color: var(--secondary-color);
        color: white;
        align-self: flex-start;
    }

    #otroProducto:hover {
        background-color: #27ae60;
    }

    .botones {
        display: flex;
        justify-content: flex-end;
        gap: 1rem;
        margin-top: 2rem;
    }

    #cancelar {
        background-color: var(--danger-color);
        color: white;
    }

    #cancelar:hover {
        background-color: #c0392b;
    }

    #reset {
        background-color: #95a5a6;
        color: white;
    }

    #reset:hover {
        background-color: #7f8c8d;
    }

    #aceptar {
        background-color: var(--primary-color);
        color: white;
    }

    #aceptar:hover {
        background-color: #2980b9;
    }
</style>
<script src="https://cdn.jsdelivr.net/npm/xlsx/dist/xlsx.full.min.js"></script>
<?php //><script type="text/javascript">
$previous = "javascript:history.go(-1)";
if (isset($_SERVER['HTTP_REFERER'])) {
    $previous = $_SERVER['HTTP_REFERER'];
}
?>
<article class="module width_4_quarter">
    <header>
        <h3 class="tabs_involved">Cambiar de posición</h3>
        <div class="volveratras">
            <a href="<?= $previous ?>"><?php echo $this->Html->image('icn_volver.png'); ?></a>
        </div>
    </header>
    <div class="maincontenedor">
        <div class="contenidoPrincipal">
            <form class="formularioenviar" id="formularioProductos">
                <div id="listaProductos">
                    <div class="producto">
                        <label for="">Codigo de barras</label>
                        <input class="input-contenido" type="text" name="codigo_barras" placeholder="Código de barras" required>
                        <label for="">Posición</label>
                        <input class="input-contenido" type="text" name="posicion" placeholder="Posición" required>
                    </div>
                </div>
                <button class="btnModificado" type="button" id="otroProducto">+ Agregar Producto</button>
            </form>
            <div class="botones">
                <button class="btnModificado" id="cancelar">Cancelar</button>
                <button class="btnModificado" id="reset">Reset</button>
                <button class="btnModificado" id="aceptar">Aceptar</button>
            </div>
        </div>

        <script>
            document.getElementById('otroProducto').addEventListener('click', function() {
                const nuevoProducto = document.createElement('div');
                nuevoProducto.className = 'producto';
                nuevoProducto.innerHTML = `
                    <label for="">Código de barras</label>
                    <input class="input-contenido" type="text" name="codigo_barras" placeholder="Código de barras" required>
                    <label for="">Posición</label>
                    <input class="input-contenido" type="text" name="posicion" placeholder="Posición" required>
                    <button type="button" class="btn-eliminar" onclick="eliminarFila(this)">
                        <span class="icon-trash">🗑️</span>
                    </button>

                `;

                document.getElementById('listaProductos').appendChild(nuevoProducto);
            });

            document.getElementById('reset').addEventListener('click', function() {
                document.getElementById('formularioProductos').reset();
            });

            document.getElementById('cancelar').addEventListener('click', function() {
                if (confirm('¿Estás seguro de que quieres cancelar?')) {
                    window.location.href = "<?= $this->Url->build(['controller' => 'Articulos', 'action' => 'index_admin']); ?>";
                }
            });

            document.getElementById('aceptar').addEventListener('click', function() {
                if (document.getElementById('formularioProductos').checkValidity()) {
                    const productos = [];
                    const listaProductos = document.querySelectorAll('#listaProductos .producto');
                    listaProductos.forEach(producto => {
                        const codigoBarras = producto.querySelector('input[name="codigo_barras"]').value;
                        const posicion = producto.querySelector('input[name="posicion"]').value;
                        productos.push({
                            codigo_barras: codigoBarras,
                            posicion: posicion
                        });
                    });

                    saveData(productos);

                    // Aquí puedes agregar la lógica para enviar los datos
                } else {
                    alert('Por favor, completa todos los campos requeridos');
                }
            });
        </script>
    </div>
</article>

<script>
    function saveData(data) {
        const dataArray = JSON.stringify({
            data
        });
        console.log("Datos enviados:", dataArray);

        $.ajax({
            type: "post",
            contentType: "application/json",
            dataType: "json",
            url: myBaseUrlgetValidatePosition,
            data: dataArray,
            success: function(response) {

                if (response) {
                    generateExcelXls(response);
                    alertify.success("Generado archivo Excel (.xls)");
                } else {
                    alertify.error("Respuesta vacía del servidor.");
                }
            },
            error: function(xhr, status, error) {
                console.error("Error AJAX:", error);
                alertify.error("Error en la solicitud.");
            }
        });
    }

    function eliminarFila(button) {
        button.parentElement.remove();
    }

    function generateExcelXls(data) {
        // Estructura los datos para el Excel
        const worksheetData = data.map(item => [item.clave_amp, item.nuevaPosicion]);

        // Agrega encabezados
        worksheetData.unshift(['Clave', 'Posición']);

        // Crea un libro de trabajo y una hoja
        const workbook = XLSX.utils.book_new();
        const worksheet = XLSX.utils.aoa_to_sheet(worksheetData);

        // Añade la hoja al libro
        XLSX.utils.book_append_sheet(workbook, worksheet, 'Datos');

        // Configura las opciones para el formato .xls
        const excelBinary = XLSX.write(workbook, {
            bookType: 'xls', // Formato Microsoft Excel 97-2003
            type: 'binary'
        });

        // Convierte a Blob y descarga el archivo
        const blob = new Blob([s2ab(excelBinary)], {
            type: "application/vnd.ms-excel"
        });

        const link = document.createElement('a');
        link.href = URL.createObjectURL(blob);
        link.download = 'ENTRAORDEN.xls';
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }

    // Helper para convertir string a ArrayBuffer
    function s2ab(s) {
        const buf = new ArrayBuffer(s.length);
        const view = new Uint8Array(buf);
        for (let i = 0; i < s.length; i++) {
            view[i] = s.charCodeAt(i) & 0xFF;
        }
        return buf;
    }
</script>
<!-- 4005800137556 630344 -->
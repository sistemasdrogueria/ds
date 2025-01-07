<style>
    .table-container {
        width: 100%;
        margin: 0 auto;
        overflow-x: auto;
    

    }

    .styled-table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
    }

    .styled-table thead tr {
        background-color: #009879;
        color: #ffffff;
        text-align: left;
        font-weight: bold;
    }


    .styled-table th,
    .styled-table td {
        padding: 12px 15px;
        text-align: center;
        cursor: pointer;
        /* Cursor de mano para indicar que es clickeable */
        position: relative;
    }

    /* Indicador de ordenamiento ascendente/descendente */
    .styled-table th.sort-asc::after {
        content: "▲";
        position: absolute;
        right: 10px;
        font-size: 12px;
    }

    .styled-table th.sort-desc::after {
        content: "▼";
        position: absolute;
        right: 10px;
        font-size: 12px;
    }

    .styled-table tbody tr {
        border-bottom: 1px solid #dddddd;
    }

    .styled-table tbody tr:nth-of-type(even) {
        background-color: #f3f3f3;
    }

    .styled-table tbody tr:last-of-type {
        border-bottom: 2px solid #009879;
    }

    .styled-table tbody tr.active-row {
        font-weight: bold;
        color: #009879;
    }

    .bg-lose {
        background-color: #f8d7da !important;
        /* Rojo claro */
        color: #721c24;
        /* Rojo oscuro */
    }

    .bg-win {
        background-color: #d4edda !important;
        /* Verde claro */
        color: #155724;
        /* Verde oscuro */
    }

    .div-search {
        display: flex;
        justify-content: center;
        margin-top: 15px;
    }
</style>

<div class="table-container">
    <table class="styled-table">
        <thead>
            <tr><th class="text-center" onclick="sortTable(0)">Fecha</th>
                <th class="text-center" onclick="sortTable(1)">EAN</th>
                <th class="text-center" onclick="sortTable(2)">Descripción</th>
                <th class="text-center" onclick="sortTable(3)">Dto</th>
                <th class="text-center" onclick="sortTable(4)">Cantidad Facturada</th>
                <th class="text-center" onclick="sortTable(5)">U mínima</th>
                <th class="text-center" onclick="sortTable(6)">Ofertas</th>
            </tr>
        </thead>
        <tbody id="tableBody">
            <?php

            foreach ($data as $articulos) {
                foreach ($articulos as $items) {
                    $loseOffert = false;
                    $fechaOriginal = $items['fci']['creado']; // Suponiendo que esto es una cadena de fecha.
                    $fechaFormateada = date('d/m/Y', strtotime($fechaOriginal));
                    if($items['dd']['id']!== null && $items['dd']['dto_patagonia']!== null ){
                    $dto_patagonia =$items['dd']['dto_patagonia'];
                    $unidades_minimas= $items['dd']['uni_min'];
                    }else{
                    $unidades_minimas= $items['d']['uni_min'];
                    $dto_patagonia =$items['d']['dto_patagonia'];

                    }

                    if ($items['fci']['cantidad_facturada'] >= $unidades_minimas) {
                        $loseOffert = true;
                    }
                    echo '<tr class="' . ($loseOffert ? 'bg-win' : 'bg-lose') . '">
            <td  class="text-center">' . $fechaFormateada . '</td>
            <td>' .($items['a']['codigo_barras'] ?? 'N/A'). '</td>
                <td>' . $items['a']['descripcion_pag'] . '</td>
                    <td class="text-center">' .$dto_patagonia. '%</td>
                        <td class="text-center">' . $items['fci']['cantidad_facturada'] . '</td>
                            <td class="text-center">' . $unidades_minimas . '</td>
                                <td class="">' . ($loseOffert ? 'Adquirida' : 'Perdida') . '</td>
            </tr>';
                }
            }
            ?>
        </tbody>
    </table>
</div>

<script>
    // Variable para rastrear el orden actual
    let currentSort = {
        column: null,
        order: 'asc'
    };

    function sortTable(columnIndex) {
        const table = document.querySelector('.styled-table tbody');
        const rowsArray = Array.from(table.querySelectorAll('tr'));
        let sortOrder = 'asc';

        if (currentSort.column === columnIndex && currentSort.order === 'asc') {
            sortOrder = 'desc';
        }

        rowsArray.sort((a, b) => {
            const aText = a.querySelector(`td:nth-child(${columnIndex + 1})`).textContent.trim();
            const bText = b.querySelector(`td:nth-child(${columnIndex + 1})`).textContent.trim();

            if (columnIndex === 0) { // Ordenar por fecha
                return sortOrder === 'asc' ? new Date(aText) - new Date(bText) : new Date(bText) - new Date(aText);
            } else if ( columnIndex === 3 || columnIndex === 4) { // Ordenar por número
                return sortOrder === 'asc' ? parseFloat(aText) - parseFloat(bText) : parseFloat(bText) - parseFloat(aText);
            } else { // Ordenar por texto
                return sortOrder === 'asc' ? aText.localeCompare(bText) : bText.localeCompare(aText);
            }
        });

        // Elimina las clases de ordenamiento de todos los encabezados
        document.querySelectorAll('.styled-table th').forEach(th => th.classList.remove('sort-asc', 'sort-desc'));

        // Añade la clase de ordenamiento al encabezado seleccionado
        document.querySelector(`.styled-table th:nth-child(${columnIndex + 1})`).classList.add(sortOrder === 'asc' ? 'sort-asc' : 'sort-desc');

        // Vuelve a agregar las filas ordenadas al cuerpo de la tabla
        rowsArray.forEach(row => table.appendChild(row));

        // Actualiza el estado de ordenamiento actual
        currentSort.column = columnIndex;
        currentSort.order = sortOrder;
    }


    // Función para filtrar la tabla
    document.getElementById('searchInput').addEventListener('keyup', function() {
        const filter = this.value.toLowerCase();
        const rows = document.querySelectorAll('#tableBody tr');

        rows.forEach(row => {
            const cells = row.querySelectorAll('td');
            let match = false;

            cells.forEach(cell => {
                if (cell.textContent.toLowerCase().includes(filter)) {
                    match = true;
                }
            });

            row.style.display = match ? '' : 'none';
        });
    });
</script>
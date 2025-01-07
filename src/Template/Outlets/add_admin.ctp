<style>
    .outlet-form {
        max-width: 100%;
        margin: 0 auto;
        background-color: #f9f9f9;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        font-family: 'Arial', sans-serif;
        font-size: 1.2rem !important;
    }

   .input-field {
        font-size: 1.2rem !important;
    }

    .form-grid {
        width: 400px;
        margin-left: auto;
        margin-right: auto;
    }

    /* Estilos de los campos de entrada */
    .input-field {
        width: 100%;
        padding: 10px;
        margin-top: 8px;
        border: 1px solid #ddd;
        border-radius: 5px;
        transition: border-color 0.3s ease;
    }

    .input-field:focus {
        border-color: #6c63ff;
        outline: none;
    }

    /* Estilo para el checkbox */
    .checkbox-field {
        transform: scale(1.2);
        margin-right: 5px;
    }

    /* Etiquetas del formulario */
    .form-row label {
        font-weight: bold;
        color: #333;
        margin-bottom: 4px;
    }

    /* Contenedor del botón */
    .button-container {
        text-align: center;
        margin-top: 20px;
    }

    /* Botón de envío */
    .button-submit {
        background-color: #6c63ff;
        color: #fff;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
        transition: background-color 0.3s ease;
    }

    .button-submit-articulos {
        background-color: #63b9ff;
        color: #fff;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
        transition: background-color 0.3s ease;
    }

    .button-submit:hover {
        background-color: #574bcd;
    }

    /* Encabezado del formulario */
    div legend {
        font-size: 24px;
        font-weight: bold;
        color: #000;
        margin-bottom: 15px;
    }

    /* Espaciado entre las filas */
    .form-row {
        margin-bottom: 15px;
    }

    /* Fondo suave y sombra */
    .outlet-form {
        background: linear-gradient(135deg, #ffffff, #f3f3f3);
    }

    /* Ajuste para el diseño del formulario en pantallas pequeñas */
    @media (max-width: 768px) {
        .form-grid {
            display: block;
        }
    }

    .input-field[type="date"] {
        padding: 10px;
        border-radius: 5px;
        border: 1px solid #ddd;
        width: 100%;
        font-size: 16px;
        background-color: #fdfdfd;
        color: #333;
    }

    .input-field[type="date"]:focus {
        border-color: #6c63ff;
        outline: none;
    }

    .w-75 {
        width: 75%;
    }

    .w-25 {
        width: 25%;
    }

    .div-padre-search {

        display: inline-flex;
        align-content: flex-end;
        align-items: flex-end;
        justify-content: space-between;
        flex-direction: row;
    }
</style>
<article class="module width_3_quarter">
    
    <header>
        <h3 class="tabs_involved">Agregar Outlets</h3>
    <div class="tabs_bt_nuevo">
		<?= $this->Html->image("admin/icn-nuevo.png", ["class" => "cursosr-pointer", "alt" => "Nuevo", "onclick" => "showResult('Agregar')"]); ?>
		<?= $this->Html->image("admin/adjuntar.png", ["class" => "cursosr-pointer", "alt" => "Nuevo", 'onclick' => "showResult('Attach')",'url' => ['controller' => 'Outlets', 'action' => 'index_admin','?' => ['actionToRun' => 'Attach']]]); ?>
				<?= $this->Html->image("admin/search-outlet.png", ["class" => "cursosr-pointer", "alt" => "Nuevo", 'onclick' => "showResult('Buscar')",'url' => ['controller' => 'Outlets', 'action' => 'index_admin','?' => ['actionToRun' => 'Buscar']]]); ?>
        </div>
</header>
<div class="outlet-form">
    <div>

        <div class="form-grid">
            <div class="form-row">
                <div class="div-padre-search">
                    <div class="w-75">
                        <label for="fecha_final">Buscar Producto</label>
                        <input type="text" class="input-field search-input-descripcion" id="search-input-descripcion" placeholder="Ingrese para buscar un producto">
                    </div>
                    <div class="w-25">
                        <button id="buttonSearch" class='button-submit-articulos'>Buscar</button>
                    </div>
                    <img id="loadingGif" src="/img/icons8-carga.gif" alt="Cargando..." style="display:none;">


                </div>
                <select class="select-product input-field">
                    <option value="">Seleccione un producto</option>
                </select>
            </div>
        </div>
    </div>
    <?= $this->Form->create($outlets); ?>

    <div>

        <div class="form-grid">

            <input type="text" disabled id="articulo-descripcion" placeholder="Articulo " class="input-field" value="">
            <input type="hidden" name="articulo_id" id="articulo_id" class="input-field" value="">
 <div class="form-row">
                <label for="fecha_final">Fecha Inicio</label>
                <input type="date" disabled name="fecha_inicio" id="fecha_inicio" class="input-field hasDatepicker" value="">

            </div>
            <div class="form-row">
                <label for="fecha_final">Fecha finaliza</label>
                <input type="date" disabled name="fecha_final" id="fecha_final" class="input-field hasDatepicker" value="">

            </div>
            <div class="form-row">
                <?= $this->Form->control('condicion', [
                    'label' => 'Condición',
                    'class' => 'input-field',
                    'disabled' => true
                ]) ?>
            </div>
            <div class="form-row">
                <?= $this->Form->control('descuento_por_condicion', [
                    'label' => 'Descuento',
                    'class' => 'input-field',
                    'type' => 'number',
                    'disabled' => true
                ]) ?>
            </div>
            <div class="form-row">
                <?= $this->Form->control('activo', [
                    'label' => 'Activo',
                    'type' => 'checkbox',
                    'class' => 'checkbox-field',
                    'disabled' => true
                ]) ?>
            </div>
            <div class="form-row">
                <?= $this->Form->control('unidades_stock', [
                    'label' => 'Unidades en Stock',
                    'type' => 'number',
                    'class' => 'input-field',
                    'disabled' => true
                ]) ?>
            </div>
            <div class="form-row">
                <?= $this->Form->control('venc', [
                    'label' => 'Vencimiento',
                    'type' => 'text',
                    'class' => 'input-field',
                    'disabled' => true
                ]) ?>
            </div>
        </div>
    </div>
    <div class="button-container">
        <?= $this->Form->button(__('Guardar'), ['class' => 'button-submit']) ?>
    </div>
    <?= $this->Form->end() ?>
</div>
</article>
<script>
    $('#buttonSearch').on('click', function() {
        $(this).prop('disabled', true); // Deshabilita el botón
        $('#loadingGif').show(); 
        let descripcion = $('#search-input-descripcion').val();
        searchProduct(descripcion);
    });

    function searchProduct(descripcion) {
        $.ajax({
            type: "post",
            url: '<?php echo \Cake\Routing\Router::url(array('controller' => 'outlets', 'action' => 'searchArticulos')); ?>',
            data: {
                descripcion: descripcion
            },
            dataType: "json",
            success: function(data) {
                if (data.articulos) {
                    // Limpiar el select antes de insertar nuevos elementos
                    $('.select-product').empty().append('<option value="">Seleccione un producto</option>');
                    // Recorrer cada artículo y agregarlo como opción
                    data.articulos.forEach(function(articulo) {
                        $('.select-product').append(
                            $('<option>', {
                                value: articulo.id,
                                text: articulo.descripcion_sist
                            })
                        );
                    });
                }
            },
            complete: function() {
                $('#buttonSearch').prop('disabled', false); // Habilita el botón nuevamente
            $('#loadingGif').hide();
           }
        });
    }

    $('.select-product').on('change', function() {
        let selectedId = $(this).val(); // Obtiene el id seleccionado
        let selectedText = $(this).find('option:selected').text(); // Obtiene el texto de la opción seleccionada
        $('#articulo-descripcion').val(selectedText); // Inserta el texto en el campo de descripción
        $('#articulo_id').val(selectedId); // Inserta el id en el campo oculto
        $('#fecha_inicio').prop('disabled', false);
        $('#fecha_final').prop('disabled', false);
        $('#condicion').prop('disabled', false);
        $('#descuento-por-condicion').prop('disabled', false);
        $('#activo').prop('disabled', false);
        $('#unidades-stock').prop('disabled', false);
        $('#venc').prop('disabled', false);
        
    });
</script>
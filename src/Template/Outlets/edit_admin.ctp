<style>
    .outlet-form {
        max-width: 100%;
        margin: 0 auto;
        background-color: #f9f9f9;
        padding: 20px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        font-family: 'Arial', sans-serif;
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
</style>


<article class="module width_3_quarter">
       <header>
        <h3 class="tabs_involved">Editar Outlets</h3>
    <div class="tabs_bt_nuevo">
		<?= $this->Html->image("admin/icn-nuevo.png", ["class" => "cursosr-pointer", "alt" => "Nuevo", "onclick" => "showResult('Agregar')"]); ?>
		<?= $this->Html->image("admin/adjuntar.png", ["class" => "cursosr-pointer", "alt" => "Nuevo", 'onclick' => "showResult('Attach')",'url' => ['controller' => 'Outlets', 'action' => 'index_admin','?' => ['actionToRun' => 'Attach']]]); ?>
				<?= $this->Html->image("admin/search-outlet.png", ["class" => "cursosr-pointer", "alt" => "Nuevo", 'onclick' => "showResult('Buscar')",'url' => ['controller' => 'Outlets', 'action' => 'index_admin','?' => ['actionToRun' => 'Buscar']]]); ?>
        </div>
</header>
<div class="outlet-form">
    <?= $this->Form->create($outlets, ['class' => 'form-styled']) ?>
<?php
// Asegúrate de que la fecha esté en formato "YYYY-MM-DD"
$fechaInicio = !empty($outlets['fecha_inicio']) ? $outlets['fecha_inicio']->i18nFormat('yyyy-MM-dd') : '';
$fechaFinal = !empty($outlets['fecha_final']) ? $outlets['fecha_final']->i18nFormat('yyyy-MM-dd') : '';
?>
    <div>

        <div class="form-grid">


            <div class="form-row">
                <label for="fecha_final">Fecha Inicio</label>
                <input type="date" name="fecha_inicio" id="fecha_inicio" class="input-field hasDatepicker" value="<?php echo h($fechaInicio) ?>">

            </div>
            <div class="form-row">
                <label for="fecha_final">Fecha finaliza</label>
                <input type="date" name="fecha_final" id="fecha_final" class="input-field hasDatepicker" value="<?php echo h($fechaFinal) ?>">

            </div>
            <div class="form-row">
                <?= $this->Form->control('condicion', [
                    'label' => 'Condición',
                    'class' => 'input-field'
                ]) ?>
            </div>
            <div class="form-row">
                <?= $this->Form->control('descuento_por_condicion', [
                    'label' => 'Descuento',
                    'class' => 'input-field',
                    'type' => 'number'
                ]) ?>
            </div>
            <div class="form-row">
                <?= $this->Form->control('activo', [
                    'label' => 'Activo',
                    'type' => 'checkbox',
                    'class' => 'checkbox-field'
                ]) ?>
            </div>
            <div class="form-row">
                <?= $this->Form->control('unidades_stock', [
                    'label' => 'Unidades en Stock',
                    'type' => 'number',
                    'class' => 'input-field'
                ]) ?>
            </div>
            <div class="form-row">
                <?= $this->Form->control('venc', [
                    'label' => 'Vencimiento',
                    'type' => 'text',
                    'class' => 'input-field'
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
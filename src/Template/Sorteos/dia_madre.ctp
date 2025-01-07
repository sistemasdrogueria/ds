<style>
    .sorteo-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        width: 100%;
        margin: 0 auto;
        background: linear-gradient(135deg, #ff9a9e, #fad0c4);
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        animation: fadeIn 1.5s ease-out;
    }

    .main-image img {
        width: 100%;
        object-fit: cover;
        border-radius: 10px;
        transition: transform 0.3s ease-in-out;
    }

    .main-image .sorteo-img:hover {
        transform: scale(1.05);
    }

    .images-and-input {
        display: flex;
        justify-content: space-between;
        width: 100%;
        margin-top: 20px;
    }

    .image-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        width: 30%;
    }

    .image-item img {
        width: 100%;
        height: 500px;
        object-fit: cover;
        border-radius: 10px;
        /* filter: blur(5px);*/
        /* Efecto de desenfoque */
        transition: filter 0.3s ease-in-out, transform 0.3s ease-in-out;
        cursor: pointer;
    }

    .image-item .sorteo-img:hover {
        filter: blur(4px);
        /* Menos desenfoque al pasar el mouse */
        transform: scale(1.05);
        /* Zoom ligero al pasar el mouse */
    }

    .image-item input[type="text"] {
        margin-top: 10px;
        padding: 10px;
        font-size: 16px;
        width: 100%;
        border: 2px solid #fad0c4;
        border-radius: 5px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }

    .image-item input[type="text"]:focus {
        outline: none;
        border-color: #ff6b6b;
        box-shadow: 0 5px 15px rgba(255, 107, 107, 0.5);
    }

    .main-image {
        width: 100%;
    }

    .extra-content {
        margin-top: 20px;
    }

    .participar-btn {
        padding: 15px 30px;
        font-size: 18px;
        font-weight: bold;
        color: white;
        background: linear-gradient(135deg, #ff6b6b, #f06595);
        border: none;
        border-radius: 50px;
        cursor: pointer;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        transition: all 0.3s ease;
    }

    .participar-btn:hover {
        background: linear-gradient(135deg, #ff9a9e, #f06595);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
        transform: translateY(-5px);
    }

    .participar-btn:active {
        transform: translateY(0);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    }

    .participar-btn:focus {
        outline: none;
        box-shadow: 0 5px 15px rgba(255, 107, 107, 0.5);
    }

    .padre-btn {
        margin-top: 20px;
    }

    .extra-content {
        background-color: #fcbeb7;
        border: 9px solid #ffd7d3;
        /*padding: 20px;*/
        font-size: 20px;
        font-weight: bold;
        text-align: center;
        color: #2f3542;
        border-radius: 15px;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        position: relative;
        margin: 20px auto;
        /* max-width: 700px;*/
        text-transform: uppercase;
        letter-spacing: 2px;
    }

    .extra-content:before,
    .extra-content:after {
        content: '★';
        font-size: 30px;
        color: #f0932b;
        position: absolute;
        top: -20px;
    }

    .extra-content:before {
        left: -20px;
    }

    .extra-content:after {
        right: -20px;
    }

    .extra-content:hover {
        background-color: #fcc0b9;
        color: #d35400;
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.3);
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .arrow {
        width: 120px;
        height: 120px;
        /*border-right: 10px solid #ff66b2;
      border-bottom: 10px solid #ff66b2;*/
        transform: rotate(45deg);
        animation: bounce 2s infinite;
        margin-bottom: 20px;
        cursor: pointer;
        /* Espacio entre la flecha y el texto */
    }

    .arrow::before {
        content: '';
        position: absolute;
        width: 0;
        height: 0;
        border-left: 20px solid transparent;
        border-right: 20px solid transparent;
        /* border-top: 40px solid #ff66b2;*/
        margin-top: 30px;
        /* Flecha apuntando hacia abajo */
        animation: bounce 2s infinite;
    }

    @keyframes bounce {

        0%,
        20%,
        50%,
        80%,
        100% {
            transform: translateY(0);
        }

        40% {
            transform: translateY(-20px);
        }

        60% {
            transform: translateY(-10px);
        }
    }

    .message {
        font-family: 'Comic Sans MS', sans-serif;
        font-size: 2rem;
        color: #ff66b2;
        text-align: center;
    }

    .sorteo {
        font-size: 1.5rem;
        color: #ff3385;
        /* Color destacado */
        margin-top: 10px;
        text-align: center;
        animation: glow 2s infinite alternate;
    }

    @keyframes glow {
        from {
            text-shadow: 0 0 10px #ff3385, 0 0 20px #ff66b2, 0 0 30px #ff66b2;
        }

        to {
            text-shadow: 0 0 20px #ff3385, 0 0 30px #ff66b2, 0 0 40px #ff66b2;
        }
    }

    .border-red {
        border: 1px solid red !important;
    }

    .border-green {
        border: 1px solid green !important;
    }

    .modal {
        display: none;
        /* Ocultar por defecto */
        position: fixed;
        z-index: 1000;
        /* Mostrar por encima de otros elementos */
        padding-top: 60px;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.8);
        /* Fondo oscuro con opacidad */
    }

    .modal-content {
        margin: auto;
        display: block;
        width: 80%;
        max-width: 700px;
    }

    .close {
        position: absolute;
        top: 15px;
        right: 35px;
        color: #fff;
        font-size: 40px;
        font-weight: bold;
        cursor: pointer;
    }

    .close:hover,
    .close:focus {
        color: #ccc;
        text-decoration: none;
        cursor: pointer;
    }
</style>

<?php
$respuestaA = "";
$respuestaB = "";
$respuestaC = "";
if (isset($respuestas)) {
    if (isset($respuestas[0])) {
        if (!empty($respuestas[0])) {
            $respuestaA = $respuestas[0]['texto_generado'];
        }
    }
    if (isset($respuestas[1])) {
        if (!empty($respuestas[1])) {
            $respuestaB = $respuestas[1]['texto_generado'];
        }
    }
    if (isset($respuestas[2])) {
        if (!empty($respuestas[2])) {
            $respuestaC = $respuestas[2]['texto_generado'];
        }
    }
}


?>
<div class="sorteo-container">
    <!-- Primer Div: Imagen grande (opcional) -->
    <div class="main-image">
        <?php echo $this->Html->image('SLIDER-ENCABEZADO-SORTEO-DDM-2024.png', ['alt' => 'Drogueria Sur S.A.', 'width' => '100%']);
        ?>

    </div>
    <div class="extra-content">
        <?php echo $this->Html->image('PISTAS-DDMFINAL-2024.jpg', ['alt' => 'Drogueria Sur S.A.', 'width' => '100%']);
        ?>
    </div>
    <!-- Segundo Div: Tres imágenes con su propio input -->
    <div class="arrow" onclick="goingto()">
        <?php echo $this->Html->image('flecha-hacia-abajo-para-navegar.png', ['alt' => 'Drogueria Sur S.A.', 'width' => '100%']);
        ?>
    </div>


    <div class="images-and-input">
        <div class="image-item">
            <?php echo $this->Html->image('imagendifuminada1.jpg', ['alt' => 'Drogueria Sur S.A.', 'width' => '100%']); ?>
            <input id="respuesta1" type="text" value="<?php echo $respuestaA; ?>" placeholder="¿Quién es la persona que aparece en esta imagen?" />
        </div>
        <div class="image-item">
            <?php echo $this->Html->image('imagendifuminada2.jpg', ['alt' => 'Drogueria Sur S.A.', 'width' => '100%']); ?>
            <input id="respuesta2" type="text" value="<?php echo $respuestaB; ?>" placeholder="¿Quién es la persona que aparece en esta imagen?" />
        </div>
        <div class="image-item">
            <?php echo $this->Html->image('imagendifuminada3.jpg', ['alt' => 'Drogueria Sur S.A.', 'width' => '100%']); ?>
            <input id="respuesta3" type="text" value="<?php echo $respuestaC; ?>" placeholder="¿Quién es la persona que aparece en esta imagen?" />
        </div>
    </div>
    <div class="padre-btn"><button class="participar-btn">Participar</button></div>


    <!-- Tercer Div: Agrega más contenido si es necesario -->
    <div id="imageModal" class="modal">
        <span class="close">&times;</span>
        <img class="modal-content" id="modalImage">
    </div>
</div>

<script>
    // Obtener el modal
    var modal = document.getElementById("imageModal");

    // Obtener el contenido de la imagen en el modal
    var modalImg = document.getElementById("modalImage");

    // Obtener el elemento para cerrar el modal
    var span = document.getElementsByClassName("close")[0];

    // Añadir un evento a cada imagen
    document.querySelectorAll('.image-item img').forEach(function(image) {
        image.addEventListener('click', function() {
            modal.style.display = "block";
            modalImg.src = this.src;
        });
    });

    // Cerrar el modal cuando el usuario haga clic en la "X"
    span.onclick = function() {
        modal.style.display = "none";
    }

    // Cerrar el modal cuando el usuario haga clic fuera de la imagen
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
    let timeout;
    document.getElementById('respuesta1').addEventListener('input', function() {
        var pregunta = 1;
        clearTimeout(timeout); // Limpiar el temporizador para reiniciar el debounce

        timeout = setTimeout(() => {
      if (this.value.trim() !== "") {
            const inputText = this.value.trim();
            saveAsk(inputText, pregunta);
        }        
        }, 1000);
    });

    document.getElementById('respuesta2').addEventListener('input', function() {
        var pregunta = 2;
        clearTimeout(timeout); // Limpiar el temporizador para reiniciar el debounce

        timeout = setTimeout(() => {
              if (this.value.trim() !== "") {
            const inputText = this.value.trim();
            saveAsk(inputText, pregunta);
              }
        }, 1000);
    });

    document.getElementById('respuesta3').addEventListener('input', function() {
        var pregunta = 3;
        clearTimeout(timeout); // Limpiar el temporizador para reiniciar el debounce

        timeout = setTimeout(() => {
             if (this.value.trim() !== "") {
            const inputText = this.value.trim();
            saveAsk(inputText, pregunta);
              }
        }, 1000);
    });


    function saveAsk(texto, pregunta) {



        $.ajax({
            //aca es metodo POST
            type: "POST",
            url: saveSessionPregunta,
            data: {
                texto: texto,
                pregunta: pregunta,

            },
            dataType: "json",
            success: function(data, textStatus) {

                switch (data.responseText) {}

            },

            error: function(textStatus) {

            },
        });
    }

    $('.participar-btn').on('click', function() {
        if ($('#respuesta1').val().trim().length > 0 && $('#respuesta2').val().trim().length > 0 && $('#respuesta3').val().trim().length > 0) {
            validarRespuestas();
        } else {
            if ($('#respuesta1').val().trim().length == 0) {
                $('#respuesta1').addClass("border-red");
            } else {
                $('#respuesta1').addClass("border-green");
            }
            if ($('#respuesta2').val().trim().length == 0) {
                $('#respuesta2').addClass("border-red");
            } else {
                $('#respuesta2').addClass("border-green");
            }
            if ($('#respuesta3').val().trim().length == 0) {
                $('#respuesta3').addClass("border-red");
            } else {
                $('#respuesta3').addClass("border-green");
            }
            alertify.set('notifier', 'position', 'bottom-center');
            alertify.warning('Debés Completar todos los campos en rojo.');
        }


    });

    function validarRespuestas() {

        $.ajax({
            //aca es metodo POST
            type: "POST",
            url: validarParticipacion,
            data: {

            },
            dataType: "json",
            success: function(data, textStatus) {

                if (data) {

                    participando();
                } else {

                    alertify.error("Te faltan completar más, campos");
                    console.log(data.respuestas);
                }
            },

            error: function(textStatus) {

            },
        });


    }


    function participando() {
        $.ajax({
            //aca es metodo POST
            type: "POST",
            url: participandoEnd,
            data: {

            },
            dataType: "json",
            success: function(data, textStatus) {

                if (data) {
                    window.location.href = 'participandoVista';

                }
            },

            error: function(textStatus) {

            },
        });
    }

    function goingto() {
        $('.participar-btn').focus();
    }
</script>
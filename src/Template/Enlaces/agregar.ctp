<style>
    .contenedor-div {
        margin: auto;
        max-width: 90vw;
        width: 640px;
        font-family: 'docs-Roboto';
        font-weight: 400;
        line-height: 1.25;
        letter-spacing: 0;
    }

    ;

    .presentation-event {
        margin-top: 12px;
        background-color: #fff;
        border: 1px solid rgb(218, 220, 224);
        border-radius: 8px;
        margin-bottom: 12px;
        padding: 24px;
        padding-top: 22px;
        position: relative;
        width: 590px;
        height: 224px;
    }

    .contenedor-form {
        border-radius: 7px;
        border-top: 10px solid #007bff;
    }

    .logo-form {
        border-radius: 7px;
    }

    .logo-form img {
        max-height: 22.44375vw;
        max-width: 90vw;
        height: 159.60000000000002px;
        width: 640px;
        border-radius: 7px;
    }

    .presentation-event {
        border-radius: 7px;
    }

    ul li svg {
        width: 20px;
    }

    ul {
        list-style-type: none;
        border-radius: 20px;
        border: 1px solid #c2b9b9;
        width: 50%;
        margin-left: auto;
        margin-right: auto;
        background-color: #eeeeee;



    }

    ul li {
        align-items: flex-start;
    }

    .contenedor-div {
        margin: auto;
        max-width: 90vw;
        width: 640px;
        font-family: 'Roboto', sans-serif;
        font-weight: 400;
        line-height: 1.25;
        letter-spacing: 0;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        /* soft shadow for depth */
    }

    .presentation-event,
    .contenedor-form {
        background-color: #fff;
        border: 1px solid rgba(218, 220, 224, 0.5);
        border-radius: 8px;
        margin-bottom: 12px;
        padding: 24px;
        position: relative;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        /* lighter shadow for internal elements */
    }

    .form-control {
        border: 1px solid #ccc;
        border-radius: 4px;
        padding: 10px 15px;
        transition: border-color 0.3s, box-shadow 0.3s;
        /* smooth transition for focus */
    }

    .form-control:focus {
        border-color: #007bff;
        box-shadow: 0 0 8px rgba(0, 123, 255, 0.2);
        /* focus effect */
    }

    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
        padding: 10px 20px;
        border-radius: 5px;
        transition: background-color 0.3s;
        /* smooth background transition */
    }

    .btn-primary:hover {
        background-color: #0056b3;
        /* darker shade on hover */
    }

    .btn-primary:active {
        transform: scale(0.98);
        /* subtle press effect */
        background-color: #004080;
        /* even darker on press */
    }

    /* Adding a hover effect for list items */
    ul li:hover {
        background-color: #f8f9fa;
        /* light background on hover */
        cursor: pointer;
        /* change cursor to indicate interactivity */
    }

    /* Enhancing the overall typography and spacing */
    h2,
    p {
        margin: 0 0 15px;
        /* consistent spacing */
        color: #333;
        /* darker text for better readability */
    }

    p {
        font-size: 16px;
        /* slightly larger paragraph text */
    }

    label {
        display: block;
        margin-bottom: .5rem;
        color: #666;
    }

    /* Error styling */
    .input-error {
        border-color: #dc3545;
        /* red border for errors */
    }

    .error-message {
        color: #dc3545;
        font-size: 0.875em;
        margin-top: 0.25rem;
    }
</style>
<div class="contenedor-div">
    <div class="logo-form  bg-white mb-2 mt-2 ">
        <?php echo $this->Html->image('ENCABEZADO-ENCUESTA.jpg', ['id' => 'op2', 'alt' => 'logo', 'class' => 'zoom-in']); ?>
    </div>
    <div class="presentation-event bg-white mb-2 p-1">

        <?php
         if ($formulariosend) {
                echo "<p class='text-success text-center p-4 m-4'>Hemos recibido tu formulario, gracias por completarlo, te estaremos esperando.</p>";
           } else {
            echo "Hubo un error no pudimos almacenar tu formulario, envie nuevamente.";
        } ?>
    </div>


</div>
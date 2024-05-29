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

    ul li svg{
            width: 20px;
    }
    ul{
        list-style-type: none;
        border-radius: 20px;
        border:1px solid #c2b9b9;
        width: 50%;
        margin-left: auto;
        margin-right: auto;
        background-color: #eeeeee;
      

     
    }
    ul li{
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
    box-shadow: 0 4px 8px rgba(0,0,0,0.1); /* soft shadow for depth */
}

.presentation-event, .contenedor-form {
    background-color: #fff;
    border: 1px solid rgba(218, 220, 224, 0.5);
    border-radius: 8px;
    margin-bottom: 12px;
    padding: 24px;
    position: relative;
    box-shadow: 0 2px 4px rgba(0,0,0,0.05); /* lighter shadow for internal elements */
}

.form-control {
    border: 1px solid #ccc;
    border-radius: 4px;
    padding: 10px 15px;
    transition: border-color 0.3s, box-shadow 0.3s; /* smooth transition for focus */
}

.form-control:focus {
    border-color: #007bff;
    box-shadow: 0 0 8px rgba(0, 123, 255, 0.2); /* focus effect */
}

.btn-primary {
    background-color: #007bff;
    border-color: #007bff;
    padding: 10px 20px;
    border-radius: 5px;
    transition: background-color 0.3s; /* smooth background transition */
}

.btn-primary:hover {
    background-color: #0056b3; /* darker shade on hover */
}

.btn-primary:active {
    transform: scale(0.98); /* subtle press effect */
    background-color: #004080; /* even darker on press */
}

/* Adding a hover effect for list items */
ul li:hover {
    background-color: #f8f9fa; /* light background on hover */
    cursor: pointer; /* change cursor to indicate interactivity */
}

/* Enhancing the overall typography and spacing */
h2, p {
    margin: 0 0 15px; /* consistent spacing */
    color: #333; /* darker text for better readability */
}

p {
    font-size: 16px; /* slightly larger paragraph text */
}

label {
    display: block;
    margin-bottom: .5rem;
    color: #666;
}

/* Error styling */
.input-error {
    border-color: #dc3545; /* red border for errors */
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
        <h2 class="text-center">EXPO SUR 2024</h2>
       <p class="p-3 m-3">TE INVITAMOS A COMPARTIR UNA NOCHE DISTINTA, UN NUEVO ENCUENTRO PARA AFIANZAR VINCULOS.</p> 

    <ul class="flex flex-column p-2" >
        <li class="d-flex"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-primary">
  <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
</svg>
<p class="ps-1">DIA: <b>Viernes 10 de mayo</b></p></li>
         <li class="d-flex"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-success">
  <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
</svg>
 <p class="ps-1">HORARIO: <b>19:30 hs.</b></p></li>
          <li class="d-flex"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6  text-danger">
  <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
</svg>
 <p class="ps-1">LUGAR: <b>Yesterday(Av.Cabrera 4400)</b></p></li>
    </ul>
     
    </div>
    <div class="container contenedor-form bg-white mt-2 mb-2">
        <h2 class="mt-4 mb-4">Formulario de Asistencia</h2>
        <p class="mt-2 mb-4 text-danger">* Indica que la pregunta es obligatoria</p>
        
        <form action="/ds/enlaces/agregar"  method="POST" id="registroForm" onsubmit="return validarFormulario()">
            <div class="form-group">
                <label for="nombre">Nombre <b class="text-danger">*</b></label>
                <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Respuesta">
            </div>
            <div class="form-group">
                <label for="apellido">Apellido <b class="text-danger">*</b></label>
                <input type="text" class="form-control" id="apellido" name="apellido" placeholder="Respuesta">
            </div>
            <div class="form-group">
                <label for="codigo">Código de la Droguería <b class="text-danger">*</b></label>
                <input type="text" class="form-control" id="codigo" name="codigo_ds" placeholder="Respuesta">
            </div>
            <div class="form-group">
                <label for="email">Email <b class="text-danger">*</b></label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Respuesta">
            </div>
            <div class="form-group">
                <label for="telefono">Teléfono<b class="text-danger">*</b></label>
                <input type="tel" class="form-control" id="telefono" name="telefono" placeholder="Respuesta">
            </div>
            <div class="form-group">
                <label for="asistencia">¿Asistirá al evento? <b class="text-danger">*</b></label>
                <select class="form-control" id="asistencia" name="asistencia">
                    <option value=""> Seleccione una opción</option>
                    <option value="1">Sí</option>
                    <option value="0">No</option>
                </select>
            </div>
            <div class="text-center ">
                <button type="submit" class="btn btn-primary mb-4">Enviar</button>
            </div>

        </form>
    </div>

</div>

<script>
    function validarFormulario() {
        var nombre = document.getElementById('nombre').value.trim();
        var apellido = document.getElementById('apellido').value.trim();
        var codigo = document.getElementById('codigo').value.trim();
        var email = document.getElementById('email').value.trim();
        var telefono = document.getElementById('telefono').value.trim();
        var asistencia = document.getElementById('asistencia').value.trim();

        // Restablecer estilos de borde
        document.getElementById('nombre').style.borderColor = '';
        document.getElementById('apellido').style.borderColor = '';
        document.getElementById('codigo').style.borderColor = '';
        document.getElementById('email').style.borderColor = '';
        document.getElementById('telefono').style.borderColor = '';
        document.getElementById('asistencia').style.borderColor = '';

        // Validación de cada campo
        if (nombre === '') {
            document.getElementById('nombre').style.borderColor = 'red';
   
        } else {
            document.getElementById('nombre').style.borderColor = 'green';
        }

        if (apellido === '') {
            document.getElementById('apellido').style.borderColor = 'red';
  
        } else {
            document.getElementById('apellido').style.borderColor = 'green';
        }

        if (codigo === '') {
            document.getElementById('codigo').style.borderColor = 'red';
    
        } else {
            document.getElementById('codigo').style.borderColor = 'green';
        }

        if (email === '') {
            document.getElementById('email').style.borderColor = 'red';
        
        } else {
            document.getElementById('email').style.borderColor = 'green';
        }

        if (telefono === '') {
            document.getElementById('telefono').style.borderColor = 'red';
      
        } else {
            document.getElementById('telefono').style.borderColor = 'green';
        }


         if (asistencia === '') {
            document.getElementById('asistencia').style.borderColor = 'red';
      
        } else {
            document.getElementById('asistencia').style.borderColor = 'green';
        }
 if(nombre === ''|| apellido === ''||codigo === '' ||email === ''||telefono === '' || asistencia === ''){
          return false;
 }
        // Si todos los campos están completos, establecer borde verde y retornar true

        return true;
    }
</script>
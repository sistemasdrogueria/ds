   <style>
       * {
           margin: 0;
           padding: 0;
           box-sizing: border-box;
       }

       body {
           font-family: 'Arial', sans-serif;
           background-color: #ffe6e6;
           /* Fondo rosado suave */
           display: flex;
           justify-content: center;
           align-items: center;
           height: 100vh;
       }

       .container {
           display: flex;
           justify-content: center;
           align-items: center;
           height: 100%;
       }

       .card {
           background-color: #fff5f8;
           /* Fondo blanco-rosado */
           border-radius: 20px;
           box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15);
           text-align: center;
           padding: 40px;
           max-width: 450px;
           border: 2px solid #ffb3b3;
           /* Borde rosado */
       }

       h1 {
           font-size: 2.5rem;
           color: #ff6699;
           /* Título rosado brillante */
           margin-bottom: 10px;
           font-family: 'Cursive', sans-serif;
       }

       p {
           font-size: 1.3rem;
           color: #333;
           margin-bottom: 20px;
           line-height: 1.6;
       }

       strong {
           color: #ff4d4d;
           /* Acento de color en negritas */
       }

       img {
           width: 250px;
           border-radius: 15px;
           margin-bottom: 25px;
           border: 5px solid #ffe6e6;
           /* Borde de imagen acorde al fondo */
       }

       .btn  {
           background-color: #ff6699;
           color: white;
           padding: 12px 25px;
           font-size: 1.1rem;
           border: none;
           border-radius: 8px;
           cursor: pointer;
           transition: background-color 0.3s ease;
           font-family: 'Cursive', sans-serif;
       }
       
       .btn a {
           background-color: #ff6699;
           color: white;
           padding: 12px 25px;
           font-size: 1.1rem;
           border: none;
           border-radius: 8px;
           cursor: pointer;
           transition: background-color 0.3s ease;
           font-family: 'Cursive', sans-serif;
       }

       .capitalize {
           text-transform: capitalize;
           font-weight: 600;
           margin-top: 5px;
           margin-left: 10px;
       }

       .btn:hover {
           background-color: #ff4d88;
           /* Color más oscuro al pasar el mouse */
       }

       .padre-ask {
           display: flex;
           flex-direction: column;
           justify-content: flex-start;
           align-items: flex-start;
       }
       /* Confetti Animation */
/* Confetti Styles */
.confetti {
    position: absolute;
    width: 10px;
    height: 10px;
    background-color: #ff6699;
    border-radius: 50%;
    animation: confettiFall 5s linear infinite;
    top: -10px;
}

/* Diferentes tamaños y colores para los confetis */
.confetti:nth-child(odd) {
    background-color: #ff4d88;
}

.confetti:nth-child(even) {
    background-color: #ffcc99;
}

/* Posiciones aleatorias para los confetis */
.confetti:nth-child(1) {
    left: 10%;
    animation-delay: 0s;
}
.confetti:nth-child(2) {
    left: 20%;
    animation-delay: 0.5s;
}
.confetti:nth-child(3) {
    left: 30%;
    animation-delay: 1s;
}
.confetti:nth-child(4) {
    left: 40%;
    animation-delay: 1.5s;
}
.confetti:nth-child(5) {
    left: 50%;
    animation-delay: 2s;
}
.confetti:nth-child(6) {
    left: 60%;
    animation-delay: 2.5s;
}
.confetti:nth-child(7) {
    left: 70%;
    animation-delay: 3s;
}
.confetti:nth-child(8) {
    left: 80%;
    animation-delay: 3.5s;
}
.confetti:nth-child(9) {
    left: 90%;
    animation-delay: 4s;
}
.confetti:nth-child(10) {
    left: 100%;
    animation-delay: 4.5s;
}

/* Animación de Confetti */
@keyframes confettiFall {
    0% {
        transform: translateY(0) rotate(0deg);
        opacity: 1;
    }
    100% {
        transform: translateY(100vh) rotate(360deg);
        opacity: 0;
    }
}


   </style>
   <div class="container">
        <div class="confetti"></div>
                <div class="confetti"></div>
        <div class="confetti"></div>
        <div class="confetti"></div>
        <div class="confetti"></div>
        <div class="confetti"></div>
        <div class="confetti"></div>
            <div class="confetti"></div>
        <div class="confetti"></div>
        
       <div class="card">
           <h1 class="">¡Gracias por Participar!</h1>
           <p class="">Ya estás participando en el sorteo especial por el Día de la Madre 🎉</p>
           <div >
               <h3>Tus Respuestas:</h3>
               <div class="padre-ask">
                   <?php
                    $total = 1;
                    foreach ($respuestas as $respondio) {
                        echo '<p class="capitalize">Personaje ' . $total . ':  ' . $respondio['texto_generado'] . '</p>';
                        $total++;
                    }
                    ?>
               </div>
           </div>
           <p class="">Estaremos anunciando a los ganadores<strong> PRONTO!!</strong>. ¡Mucha suerte!</p>


           <button class="btn"> <?= $this->Html->link(__('Volver al Inicio'), ['controller' => 'Carritos', 'action' => 'index']) ?></button>
       </div>
   </div>
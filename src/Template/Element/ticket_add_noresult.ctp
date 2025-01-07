<div class="articulos index large-10 medium-9 columns">
    <div class="contenedor-manual">
        <h1>Manual de Procedimiento</h1>

        <section class="section" id="devoluciones" style="display: none;">
            <h2>Devoluciones</h2>
            <ol>
                <li class="puntos-list">No enviar la mercadería que se pretende devolver hasta conocer la resolución final del reclamo generado.</li>
                <li class="puntos-list">Podrá devolver la mercadería cuando la resolución de su devolución sea <span class="highlight" style="color: green;">"aprobada"</span>.</li>
                <li class="puntos-list">Si envía la mercadería con su trámite de devolución pendiente de resolución, "en curso", la misma no será aceptada en droguería. Lo mismo sucederá si la resolución es <span class="highlight" style="color: red;">"rechazada"</span>.</li>
                <li class="puntos-list">Las resoluciones se publican en 24hs hábiles.</li>
                <li class="puntos-list">Se procesará y aprobará la devolución bajo el motivo mercadería solicitada por error únicamente una vez por mes. La mercadería a devolver debe encontrarse en perfecto estado de conservación.</li>
                <li class="puntos-list">El pedido realizado de forma telefónica <strong>NO ADMITE</strong> devolución por motivo "mercadería mal facturada".</li>
                <li class="puntos-list">UNICAMENTE se iniciarán y procesarán las devoluciones cargadas en página.</li>
                <li class="puntos-list">Ingresar la devolución correspondiente y el motivo que genera la misma.</li>
                <li class="puntos-list">Especificar las cantidades que desea devolver.</li>
                <li class="puntos-list">Las cantidades especificadas no pueden superar a las solicitadas en la factura afectada a dicha devolución.</li>
                <li class="puntos-list">El producto a devolver debe ser exactamente el mismo que el declarado en la devolución. De lo contrario será rechazada.</li>
                <li class="puntos-list">Se pueden devolver aquellos productos adquiridos dentro de las 72hs previas a realizar la devolución.</li>
                <li class="puntos-list">Una vez cargada la devolución debe imprimir el comprobante obligatorio de devolución (COD). El mismo contiene un código único el cual nos permite identifícala para poder procesarla.</li>
                <li class="puntos-list">El COD debe enviarse junto con la devolución a realizar.</li>
                <li class="puntos-list">En caso de no imprimir el COD, informar vía mail N° Cuenta, Razón Social y n° de COD e indique en el comprobante (remito de la farmacia o copia de factura) que acompañe los productos N° Cuenta, Razón Social y n° de COD.</li>
                <li class="puntos-list">El mail de contacto es <a href="mailto:devoluciones@drogueriasur.com.ar">devoluciones@drogueriasur.com.ar</a></li>
                <li class="puntos-list">En el portal de devoluciones puede constatar el estado de su trámite de devolución.</li>
            </ol>
            <p>Los estados son:</p>
            <ul>
                <li class="puntos-list"><span class="highlight">En curso</span> (fue recibida y se está procesando)</li>
                <li class="puntos-list"><span class="highlight">Aprobada</span> (fue recibida, procesada y aprobada)</li>
                <li class="puntos-list"><span class="highlight">Rechazada</span> (fue recibida, procesada y rechazada)</li>
            </ul>
        </section>

        <section class="section" id="reclamos" style="display: none;">
            <h2>Reclamos</h2>
            <ol>
                <li class="puntos-list">Los reclamos sobre pedidos realizados, podrán efectuarse dentro de las 72hs hábiles posteriores a la fecha de factura del pedido en "conflicto". Habiendo transcurrido ese lapso e independientemente de la naturaleza del mismo, el reclamo NO será convalidado.</li>
                <li class="puntos-list">Ingresar el reclamo con el motivo correspondiente.</li>
                <li class="puntos-list">Especificar las cantidades.</li>
                <li class="puntos-list">Ingresar comentarios para mayores detalles en caso de ser necesario.</li>
                <li class="puntos-list">Registrar el número único de reclamo.</li>
                <li class="puntos-list">Puede verificar el estado de su reclamo en el portal de reclamos.</li>
            </ol>
        </section>

        <p>Implementando procesos de mejora continua, buscamos perfeccionar los procedimientos en materia de reclamos y devoluciones para darle una respuesta más rápida.</p>

        <p>Muchas gracias</p>

        <a href="#" class="button" id="toggleDevoluciones">Mostrar/Ocultar Devoluciones</a>
        <a href="#" class="button" id="toggleReclamos">Mostrar/Ocultar Reclamos</a>
    </div>

    <script>
        function toggleSection(sectionId) {
            const section = document.getElementById(sectionId);
            section.style.display = section.style.display === 'none' ? 'block' : 'none';
        }

        document.getElementById('toggleDevoluciones').addEventListener('click', function(e) {
            e.preventDefault();
            toggleSection('devoluciones');
        });

        document.getElementById('toggleReclamos').addEventListener('click', function(e) {
            e.preventDefault();
            toggleSection('reclamos');
        });
    </script>

</div>
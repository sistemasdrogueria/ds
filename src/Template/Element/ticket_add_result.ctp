<div class="articulos index large-10 medium-9 columns">
   <?php
   $x = 1;
   $indice = 0;
   ?>
   <div class="productos-container-info">
      <div class="article-grid" id="articleGrid">
         <?php
         $tabIndexCounter = 1;
         ?>

         <?php foreach ($articulos as $art): ?>
            <?php
            $indice += 1;
            $articulo = $art['articulo'];
            $articuloData = [
               'imagen' => $this->Url->build('/img/productos/big_' . $articulo->imagen, ['fullBase' => true]),
               'descripcionPag' => $articulo->descripcion_pag,
               'laboratorio' => $art->laboratorio_nombre,
               'categoria' => $articulo->categoria_id,
               'categorianombre' => $art->categoria_nombre,
               'troquel' => $articulo->troquel,
               'codigoBarras' => $articulo->codigo_barras,
               'iva' => $articulo->iva,
               'trazable' => $articulo->trazable,
               'cadenaFrio' => $articulo->cadena_frio,
               'pack' => $articulo->pack,
            ];
            ?>
            <div class="article-card">
               <div class="article-title"><?php echo $art->articulo->descripcion_pag ?></div>
               <div id="<?= $art->id ?>" onclick="cargarArticulo(<?= htmlspecialchars(json_encode($articuloData), ENT_QUOTES, 'UTF-8') ?>)" class="info-icon">ℹ️</div>
               <div class="article-info">Laboratorio: <?= $art->laboratorio_nombre; ?></div>
               <div class="article-info">EAN: <?= $art->articulo->codigo_barras; ?></div>
               <?= $this->Form->create('Tickets', ['url' => ['controller' => 'Tickets', 'action' => 'add_item']]); ?>
               <div class="form-grid">
                  <?php
                  echo $this->Form->input('articulo_id', ['type' => 'hidden', 'value' => $articulo['id'], 'class' => 'input-articulo']);
                  echo $this->Form->input('cantidad_facturada', ['type' => 'hidden', 'value' => $art['cantidad_facturada'], 'class' => 'input-articulo']);
                  echo $this->Form->input('descripcion', ['type' => 'hidden', 'value' => $articulo['descripcion_pag'], 'class' => 'input-articulo']);

                  echo $this->Form->control('cantidad', [
                     'label' => false,
                     'class' => 'input-articulo',
                     'placeholder' => 'Cantidad Máxima: ' . $art->cantidad_facturada,
                     'type' => 'number',
                     'max' => $art->cantidad_facturada,
                     'min' => 0,
                     'tabindex' => $tabIndexCounter++
                  ]);

                  echo $this->Form->input('fecha_vencimiento', [
                     'label' => false,
                     'class' => 'input-articulo',
                     'pattern' => '\d{2}/\d{4}',
                     'placeholder' => "mm/yyyy",
                     'tabindex' => $tabIndexCounter++
                  ]);

                  echo $this->Form->input('lote', [
                     'label' => false,
                     'class' => 'input-articulo',
                     'placeholder' => "Lote",
                     'tabindex' => $tabIndexCounter++
                  ]);

                  echo $this->Form->input('serie', [
                     'label' => false,
                     'class' => 'input-articulo',
                     'placeholder' => "Serie",
                     'tabindex' => $tabIndexCounter++
                  ]);
                  ?>
               </div>
               <?php echo $this->Form->submit('Cargar', ['class' => 'button-articulo', 'tabindex' => $tabIndexCounter++]); ?>
               <?= $this->Form->end() ?>
            </div>
         <?php endforeach; ?>

      </div>
   </div>
</div>

<div id="articuloModal" class="modal">
   <div class="modal-content">
      <span class="close">&times;</span>
      <h2 style="text-align: center;color: #2d68ab;margin-block-start: 10px;margin-block-end: 10px;">Detalle del Artículo</h2>
      <hr class="linea-divisor">
      <div class="modal-informacion">
         <div>
            <img class="imagen-modal" src="" alt="no-img">
         </div>
         <div>
            <p id="descripcion-pag"><strong>Descripción Pag:</strong> <span style="display:inline;"></span></p>
            <p id="laboratorio"><strong>Laboratorio:</strong> <span style="display:inline;"></span></p>
            <p id="categorianombre"><strong>Categoría:</strong> <span style="display:inline;"></span></p>
            <p id="troquel"><strong>Troquel:</strong> <span style="display:inline;"></span></p>
            <p id="codigo-barras"><strong>EAN:</strong> <span style="display:inline;"></span></p>
            <img style="display: none;height: 20px;width: 20px;" src=""id="tipo-product" alt="no-img">
         </div>
      </div>
   </div>
</div>



<!-- Script para mostrar Informacion Producto -->
<script>
   function cargarArticulo(data) {
      const modal = document.querySelector('#articuloModal');
      if (!modal) {
         console.error('Modal no encontrado');
         return;
      }

      const imagenModal = modal.querySelector('.imagen-modal');
      if (imagenModal) {
         imagenModal.src = data.imagen;
      }

      console.log(data.categorianombre);

      if (data.categoria == 6) {
         const baseUrl = '<?php echo $this->Url->build('/img/psi.png'); ?>';
         const imagenCategoria = modal.querySelector('#tipo-product');
         imagenCategoria.src = baseUrl;
         imagenCategoria.style.display = 'block';
      } else if (data.iva) {
         const baseUrl = '<?php echo $this->Url->build('/img/iva.png'); ?>';
         const imagenCategoria = modal.querySelector('#tipo-product');
         imagenCategoria.src = baseUrl;
         imagenCategoria.style.display = 'block';
      } else if (data.trazable) {
         const baseUrl = '<?php echo $this->Url->build('/img/trazable.png'); ?>';
         const imagenCategoria = modal.querySelector('#tipo-product');
         imagenCategoria.src = baseUrl;
         imagenCategoria.style.display = 'block';
      } else if (data.cadenaFrio) {
         const baseUrl = '<?php echo $this->Url->build('/img/cadenafrio.png'); ?>';
         const imagenCategoria = modal.querySelector('#tipo-product');
         imagenCategoria.src = baseUrl;
         imagenCategoria.style.display = 'block';
      } else if (data.pack) {
         const baseUrl = '<?php echo $this->Url->build('/img/pack.png'); ?>';
         const imagenCategoria = modal.querySelector('#tipo-product');
         imagenCategoria.src = baseUrl;
         imagenCategoria.style.display = 'block';
      } else{
         const baseUrl = '<?php echo $this->Url->build('/img/sinimagen.png'); ?>';
         const imagenCategoria = modal.querySelector('#tipo-product');
         imagenCategoria.src = baseUrl;
         imagenCategoria.style.display = 'none';
      }

      const fields = ['descripcionPag', 'troquel', 'codigoBarras', 'categorianombre', 'laboratorio', 'iva', 'trazable', 'cadenaFrio', 'pack'];

      fields.forEach(field => {
         const fieldElement = modal.querySelector(`#${field.replace(/([A-Z])/g, '-$1').toLowerCase()} span`);
         if (fieldElement) {
            fieldElement.textContent = data[field] || 'No disponible';
         }
      });



      modal.style.display = 'flex';

      document.addEventListener('scroll', cerrarModalAlEvento);
   }

   document.addEventListener('DOMContentLoaded', function() {
      const modal = document.querySelector('#articuloModal');

      const closeButton = modal.querySelector('.close');
      if (closeButton) {
         closeButton.addEventListener('click', function() {
            cerrarModal();
         });
      }

      modal.addEventListener('click', function(event) {
         if (event.target === modal) {
            cerrarModal();
         }
      });
   });

   function cerrarModal() {
      const modal = document.querySelector('#articuloModal');
      if (modal) {
         modal.style.display = 'none';
      }

      document.removeEventListener('scroll', cerrarModalAlEvento);
   }

   function cerrarModalAlEvento() {
      cerrarModal();
   }
</script>

<!-- Script Paginator -->
<script>
   $(document).ready(function() {
      var currentPage = 0;
      var numPerPage = 6;
      var $container = $('#articleGrid');
      var $items = $container.find('.article-card');

      function repaginate() {
         $items.hide().slice(currentPage * numPerPage, (currentPage + 1) * numPerPage).show();
      }

      repaginate();

      var numItems = $items.length;
      var numPages = Math.ceil(numItems / numPerPage);

      var $pager = $('<div class="paginator-table"></div>');
      for (var page = 0; page < numPages; page++) {
         $('<div class="page-number"></div>')
            .text(page + 1)
            .addClass('clickable')
            .on('click', {
               newPage: page
            }, function(event) {
               currentPage = event.data.newPage;
               repaginate();
               $(this).addClass('active').siblings().removeClass('active');
            })
            .appendTo($pager);
      }

      $pager.insertAfter($container).find('div.page-number:first').addClass('active');
   });
</script>
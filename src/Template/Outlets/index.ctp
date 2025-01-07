<style>
    .orderByOutlet {
        margin: 5px;
        padding-right: 75px;
        font-size: 15px;
    }

    .filterSelect {
        width: 86px !important;
    }

    #filterSelect {
        border-radius: 5px;
        text-align: center;
    }

    .warning-button {
        position: fixed;
        bottom: 20px;
        right: 20px;
        background-color: #ff6a49;
        /* Color de advertencia */
        color: #fff;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
        z-index: 1000;
        /* Asegura que esté sobre otros elementos */
        transition: opacity 0.5s;
        /* Transición suave */
    }

    #conditions {
        background-color: #f9f9f9;
        border: 1px solid #ddd;
        border-radius: 5px;
        padding: 30px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        font-family: 'Arial', sans-serif;
        color: #444;
        line-height: 1.8;
        margin: 20px 0;
        /* max-width: 800px; */
        text-align: left;
    }

    #conditions u {
        color: #2a6496;
        /* Color azul para el título */
        font-size: 16px;
        /* Tamaño del título */
    }

    #conditions p {
        font-size: 15px;
        /* Tamaño del texto */
    }

    #conditions strong {
        display: inline-block;
        margin-bottom: 10px;
        /* Espaciado inferior del título */
    }

    .card {
        background-color: white;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        padding: 24px;
        width: 100%;

    }

    .search-container {
        display: grid;
        gap: 5px;
    }

    @media (min-width: 768px) {
        .search-container {
            grid-template-columns: 1fr 1fr 1fr auto;
            align-items: end;
        }
    }

    .search-input {
        position: relative;
    }

    .search-input input {
        width: 80%;
        padding: 14px 10px 10px 40px;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 16px;
    }

    .search-input::before {
        content: '🔍';
        position: absolute;
        left: 10px;
        top: 50%;
        transform: translateY(-50%);
        color: #666;
    }

    select {
        width: 95%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 16px;
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='%23333' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 10px center;
    }

    .order-by {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .order-by span {
        white-space: nowrap;
        color: #666;
        font-size: 14px;
    }

    .order-by select {
        flex-grow: 1;
    }
</style>
<?php echo $this->element('banner_slider_outlet'); ?>
<div class=container>
    <div class="col-md-12">
        <div class="product-item-3">

            <button id="warningButton" class="warning-button" onclick="scrollToConditions()">
                Ver Condiciones
            </button>
            <div style="    font-family: 'Arial', sans-serif;
    background-color: #f0f0f0;
    margin: 0;
    padding: 20px;
    display: flex;
    justify-content: center;
    align-items: center;">
                <div class="card">
                    <div class="search-container">
                        <div class="search-input">
                            <input id="search-input" placeholder="Buscar producto..." oninput="filterProducts()">
                        </div>

                        <select id="brand-select">
                            <option value="">Seleccionar marca</option>
                            <?php
                            foreach ($marcasOutlet as $key => $value) {
                                if (!empty($value['nombre'])) {
                                    echo  '<option value="' . $value['nombre'] . '">' . $value['nombre'] . '</option>';
                                }
                            }

                            ?>
                        </select>

                        <select id="category-select">
                            <option value="">Seleccionar categoría</option>
                            <?php
                            foreach ($categoriasOutlet as $key => $value) {
                                if (!empty($value['nombre'])) {
                                    echo  '<option value="' . $value['nombre'] . '">' . $value['nombre'] . '</option>';
                                }
                            }
                            ?>
                        </select>

                        <div class="order-by">
                            <span>Ordenar por:</span>
                            <select id="filterSelect" name="filter" onChange="applyFilter(this.value)">
                                <option value="">Seleccionar filtro</option>
                                <option value="priceAsc">Menor Precio</option>
                                <option value="priceDesc">Mayor Precio</option>
                                <option value="expirySoon">Vencimiento Cercano</option>
                                <option value="expiryLate">Vencimiento Tardío</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="product-content-outlet" style="background-color: #f3f3f3;">


                <?php
                if (!is_null($articulos)) {
                    echo $this->element('carrito_search_result_img_vto', ['articulos' => $articulos, 'laboratorios' => $laboratorios, 'categorias' => $categorias]);
                }
                ?>
            </div> <!-- /.product-content -->
            <div id="conditions" class="product-content">
                <p>
                    <u><strong>CONDICIONES:</strong></u> <br>
                    <br>
                    1. Los productos ofrecidos pueden tener, fecha cercana de vencimiento, packaging dañado o pueden ser productos discontinuos. <br>
                    2. La fecha de caducidad de los productos de vencimiento cercano es de entre 30 y 90 días.. <br>
                    3. No se aceptan devoluciones de productos con fecha cercana de vencimiento, packaging dañado o discontinuos. <br>
                </p>
            </div>
            <div class="product-content">
                <?php echo $this->element('referencia');  ?>


            </div> <!-- /.product-content -->
        </div> <!-- /.product-item -->
    </div> <!-- /.col-md-9 -->

    <?php echo $this->Html->script('jssor.slider.min'); ?>
    <script>
        function scrollToConditions() {
            document.getElementById('conditions').scrollIntoView({
                behavior: 'smooth'
            });
        }

        // Ocultar botón al acercarse a la sección de condiciones
        window.addEventListener('scroll', function() {
            const button = document.getElementById('warningButton');
            const conditionsDiv = document.getElementById('conditions');
            const rect = conditionsDiv.getBoundingClientRect();

            // Oculta el botón cuando la sección de condiciones esté a menos de 150px de la ventana
            if (rect.top <= 600 && rect.bottom >= 0) {
                button.style.opacity = '0';
            } else {
                button.style.opacity = '1';
            }
        });
        jQuery(document).ready(function($) {
            var options = {
                $FillMode: 2,
                $AutoPlay: 1,
                $Idle: 1500,
                $PauseOnHover: 1,
                $ArrowKeyNavigation: 1,
                $SlideEasing: $Jease$.$OutQuint,
                $SlideDuration: 1500,
                $MinDragOffsetToSlide: 20,
                $SlideSpacing: 0,
                $UISearchMode: 1,
                $PlayOrientation: 1,
                $DragOrientation: 1,
                $BulletNavigatorOptions: {
                    $Class: $JssorBulletNavigator$,
                    $ChanceToShow: 2,
                    $SpacingX: 8,
                    $Orientation: 1
                },
                $ArrowNavigatorOptions: {
                    $Class: $JssorArrowNavigator$,
                    $ChanceToShow: 2
                }
            };
            var jssor_sliderZ = new $JssorSlider$("slider2_container", options);

            function ScaleSliderZocalo() {
                var bodyWidth = document.body.clientWidth;
                jssor_sliderZ.$scale
                jssor_sliderZ.$ScaleWidth($("#slider_contenedor").width());
            }
            ScaleSliderZocalo();
            $(window).bind("load", ScaleSliderZocalo);
            $(window).bind("resize", ScaleSliderZocalo);
            $(window).bind("orientationchange", ScaleSliderZocalo);
        });

        function applyFilter(value) {
            const products = document.querySelectorAll('.product-card');
            const container = document.querySelector('.gallery-outlet-container-items');
            let sortedProducts = Array.from(products);

            switch (value) {
                case "priceAsc":
                    sortedProducts.sort((a, b) => {
                        const priceA = parseFloat(a.querySelector('.final-price').innerText.replace(/[^0-9,.]/g, '').replace(',', '.'));
                        const priceB = parseFloat(b.querySelector('.final-price').innerText.replace(/[^0-9,.]/g, '').replace(',', '.'));
                        return priceA - priceB;
                    });
                    break;
                case "priceDesc":
                    sortedProducts.sort((a, b) => {
                        const priceA = parseFloat(a.querySelector('.final-price').innerText.replace(/[^0-9,.]/g, '').replace(',', '.'));
                        const priceB = parseFloat(b.querySelector('.final-price').innerText.replace(/[^0-9,.]/g, '').replace(',', '.'));
                        return priceB - priceA;
                    });
                    break;
                case "expirySoon":
                    sortedProducts.sort((a, b) => {
                        const expiryA = getExpiryDate(a.querySelector('.expiration').innerText);
                        const expiryB = getExpiryDate(b.querySelector('.expiration').innerText);
                        return expiryA - expiryB;
                    });
                    break;
                case "expiryLate":
                    sortedProducts.sort((a, b) => {
                        const expiryA = getExpiryDate(a.querySelector('.expiration').innerText);
                        const expiryB = getExpiryDate(b.querySelector('.expiration').innerText);
                        return expiryB - expiryA;
                    });
                    break;
                default:
                    return;
            }

            // Actualiza el DOM con los productos ordenados
            container.innerHTML = '';
            sortedProducts.forEach(product => container.appendChild(product));
        }

        // Función auxiliar para convertir la fecha de vencimiento a un objeto Date
        function getExpiryDate(expiryText) {
            const [month, year] = expiryText.replace('VENCE: ', '').split('/');
            return new Date(`20${year}`, month - 1); // Suponiendo fechas como 12/24
        }

      document.getElementById("search-input").addEventListener("input", filterProducts);
document.getElementById("brand-select").addEventListener("change", filterProducts);
document.getElementById("category-select").addEventListener("change", filterProducts);

function filterProducts() {
    const query = document.getElementById("search-input").value.toLowerCase();
    const queryMarca = document.getElementById('brand-select').value.toLowerCase();
    const queryCategory = document.getElementById('category-select').value.toLowerCase();
    console.log(queryMarca);
    console.log(queryCategory);
    const products = document.querySelectorAll(".product-card");

    products.forEach((product) => {
        const nameElement = product.querySelector(".product-name");
        const brandElement = product.querySelector(".product-marcas");
        const categoryElement = product.querySelector(".product-category");

        const name = nameElement ? nameElement.textContent.toLowerCase() : "";
        const brand = brandElement ? brandElement.textContent.toLowerCase() : "";
        const category = categoryElement ? categoryElement.textContent.toLowerCase() : "";

        // Verificar si el producto cumple con todos los criterios
        const matchesName = !query || name.includes(query);
        const matchesBrand = !queryMarca || brand.includes(queryMarca);
        const matchesCategory = !queryCategory || category.includes(queryCategory);

        if (matchesName && matchesBrand && matchesCategory) {
            product.style.display = ""; // Mostrar el producto
        } else {
            product.style.display = "none"; // Ocultar el producto
        }
    });
}
    </script>
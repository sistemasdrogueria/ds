<style>
    .product-card {
        width: 268px;
        background-color: #ffffff;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: box-shadow 0.3s ease;
        margin-bottom: 20px;
    }

    .product-card:hover {
        box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
    }

    .product-header {
        display: flex;
        justify-content: space-between;
        align-items: center;

        background: linear-gradient(to right, #ff6a49, #ff6a49);
        height: 40px;

    }

    .image-broken {
        position: absolute;
        width: 55px;
        z-index: 1000;
        float: right;
        /* padding-right: 20px; */
        bottom: 0;
        right: 5px;
        cursor: pointer;
    }

    .expiration {
        height: 35px;
        width: 60%;
        background-color: #ff6a49;
        border-top-left-radius: 5px;
        border-bottom-left-radius: 5px;
        color: black;
        font-weight: bold;
        font-size: 1.1em;
        display: flex;
        align-items: center;
        justify-content: center;
        /* box-shadow: 0px 1px 1px rgba(0, 0, 0, 0.3); */
        transition: transform 0.3s ease;
    }


    .discount-badge {

        height: 40px;
        width: 40%;
        background-color: #b7100a;
        border-top-right-radius: 5px;
        border-bottom-right-radius: 5px;
        color: white;
        font-weight: bold;
        font-size: 1.1em;
        display: flex;
        align-items: center;
        justify-content: center;
        /* box-shadow: 0px 0px 1px rgba(0, 0, 0, 0.3); */
        transition: transform 0.3s ease;
    }

    .square {
        position: absolute;
        width: 100%;
        height: 100%;
        background-color: #b7100a;
    }

    .square:nth-child(1) {
        transform: rotate(0deg);
    }

    .square:nth-child(2) {
        transform: rotate(25deg);
    }

    .square:nth-child(3) {
        transform: rotate(-25deg);
    }



    .product-image {
        height: 200px;
        display: flex;
        justify-content: center;
        align-items: center;
        background: linear-gradient(to bottom, #fff1f2, #ffffff);
        padding: 1rem;
    }

    .product-image img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
        transition: transform 0.3s ease;
    }

    .product-image img:hover {
        transform: scale(1.05);
    }

    .product-details {
        padding: 1rem;
    }

    .product-name {
        font-size: 0.8rem;
        font-weight: 600;
        color: #333;
        margin-bottom: 0.5rem;
        line-height: 1.2;
        height: 2.4em;
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }

    .product-price {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 0.25rem;
        justify-content: center;
    }

    .product-price-total {
        display: flex;
        justify-content: space-between;
        gap: 0.5rem;
        margin-bottom: 0.25rem;
    }

    .final-price-checked {
        text-decoration: line-through;
        font-size: 0.9rem;
    }

    .original-price {
        font-size: 1rem;
        color: #2a6496;
        text-align: center;

    }

    .discount-label {
        background-color: #fee2e2;
        color: #ef4444;
        padding: 2px 6px;
        border-radius: 4px;
        font-size: 0.8rem;
        font-weight: 700;
    }

    .final-price {
        font-size: 1.2rem;
        font-weight: 700;
        color: #111;
        margin-bottom: 1rem;
    }

    .add-to-cart {
        width: 100%;
        padding: 0.75rem;
        background-color: #10b981;
        color: white;
        border: none;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .add-to-cart:hover {
        background-color: #059669;
    }

    .gallery-contenedor-outlet {
        width: 100%;
        /* 5 columnas por defecto */
    }

    .gallery-outlet-container-items {
        display: grid;
        /* Espacio entre los elementos */
        grid-template-columns: repeat(5, 1fr);
        justify-items: center;
        align-items: stretch;
        justify-content: space-evenly;
        width: 95%;
        margin-left: auto;
        margin-right: auto;
    }

    @media (max-width: 1400px) {
        .gallery-outlet-container-items {
            display: grid;
            gap: 20px;
            /* Espacio entre los elementos */
            grid-template-columns: repeat(5, 1fr);
            justify-items: center;
            align-items: stretch;
            justify-content: space-between;

        }
    }


    @media (min-width: 1901px) {
        .gallery-outlet-container-items {
            grid-template-columns: repeat(6, 1fr) !important;
        }

        .product-card {
            width: 266px !important;
        }
    }


    .cartBtn {
        width: 97%;
           height: 37px;
        border: 1px solid #000;
    border: none;
    border-radius: 0px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 7px;
    color: white;
    font-weight: 500;
    position: relative;
    background-color: rgb(15, 185, 72);
    box-shadow: 0 20px 30px -7px rgba(27, 27, 27, 0.219);
    transition: all 0.3s ease-in-out;
    cursor: pointer;
    overflow: hidden;
    margin-left: auto;
    margin-right: auto;
    border-radius: 5px;
    margin-bottom: 5px;
    }

    .product {
        position: absolute;
        width: 12px;
        border-radius: 3px;
        content: "";
        left: 73px;
        bottom: 23px;
        opacity: 0;
        z-index: 1;
        fill: rgb(211, 211, 211);

    }

    .cartBtn:hover .product {
        animation: slide-in-top 1.2s cubic-bezier(0.250, 0.460, 0.450, 0.940) both;
    }

    .cartBtn:active {
        transform: scale(0.96);
    }

    .cartBtn:hover .cart {
        animation: slide-in-left 1s cubic-bezier(0.250, 0.460, 0.450, 0.940) both;
    }

    .div-quantity {
        display: flex;
        justify-content: center;
        align-items: stretch;
        width: 95%;
        margin-right: auto;
        margin-left: auto;

    }

    .quantity-button.plus {
        border-radius: 6px 0 0 6px;
        color: #059669;
        border: 1px solid #059669;

    }

    .quantity-button.minus {
        border-top-left-radius: 0;
        border-bottom-left-radius: 0;
        border-top-right-radius: 5px;
        border-bottom-right-radius: 5px;
        color: #b7100a;
        border: 1px solid #b7100a;
    }

    .quantity-button {
        width: 37px;
        height: 37px;
        border: 1px solid #e2e8f0;
        background-color: white;
        color: #333;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        transition: background-color 0.2s;
    }

    .quantity-button:hover:not(:disabled) {
        background-color: #f8f9fa;
    }

    .quantity-button:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    .quantity-input {
        width: 50px;
        height: 37px;
        border: 1px solid #666 !important;
        border-left: none;
        border-right: none;
        text-align: center;
        font-size: 14px;
        padding: 0;
        margin: 0;
        border-radius: 0 !important;
        -moz-appearance: textfield;
    }

    .quantity-input::-webkit-outer-spin-button,
    .quantity-input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
</style>
<div class="row" style="text-align: center;">
    <div class="gallery-contenedor-outlet">
        <div class="gallery-outlet-container-items">
            <?php
            $titulolab = 0;
            $preciot = "";
            $descuento_pf = $this->request->session()->read('Auth.User.pf_dcto');
            $condicion = $this->request->session()->read('Auth.User.condicion');
            $coef = $this->request->session()->read('Auth.User.coef');
            $condiciongeneral = 100 * (1 - ($descuento_pf * (1 - $condicion / 100)));
            $condiciongeneralmsd = 100 * (1 - ($descuento_pf));
            $condiciongeneralcf = 100 * (1 - ($descuento_pf * 1.0248 * (1 - $condicion / 100)));
            $condiciongeneralaz = 100 * (1 - ($descuento_pf * 0.892));
            $indice = 1;
            $coef_pyf = $this->request->session()->read('Auth.User.coef_pyf');
            ?>
            <?php foreach ($articulos as $articulo):
                $marca = "";
                $categoria = "";

                if (!empty($articulo['marca']['nombre'])) {
                    $marca = $articulo['marca']['nombre'];
                }

                if (!empty($articulo['Subcategorias']['nombre'])) {
                    $categoria = $articulo['Subcategorias']['nombre'];
                }


                $dtounimin = "";
                if (!empty($articulo['descuentos'])) {
                    $descuento = $articulo['descuentos'][0];
                    if ($descuento['tipo_venta'] == 'D') {
                        $descuento_off = $descuento['dto_drogueria'] ?? 0;
                        if ($descuento['tipo_oferta'] == "TH") {
                            $descuento_off += $condiciongeneral;
                        }
                        if ($descuento['uni_min'] > 1) {
                            $dtounimin = $descuento['uni_min'] . ' U.M';
                        }
                    }
                } else {
                    $descuento_off = 0;
                    if (!empty($articulo['descuento_por_condicion']) && $articulo['descuento_por_condicion'] != null && $articulo['descuento_por_condicion'] > 0) {
                        $descuento_off = $articulo['descuento_por_condicion'];
                    }
                } ?>
                <div class="product-card">
                    <div class="product-header">
                        <span class="expiration" <?php if ($descuento_off == 0) {
                                                        echo "";
                                                    } elseif ($articulo["fv_cerca"] == 0 &&  empty($articulo["outlet_venc"])) {
                                                        echo "style='display:none'";
                                                    } ?>> <?php
                                                            if ($articulo["fv_cerca"] && !isset($articulo["outlet_venc"]) &&  empty($articulo["outlet_venc"])) {
                                                                echo 'VENCE: ' . $articulo["fv"];
                                                            } elseif (isset($articulo["outlet_venc"]) &&  !empty($articulo["outlet_venc"])) {
                                                                echo 'VENCE: ' . $articulo["outlet_venc"];
                                                            } ?></span>
                        <div class="discount-badge" <?php if ($descuento_off == 0) {
                                                        echo "style='display:none'";
                                                    } ?>>

                            <div class="discount-text"><?php
                                                        echo is_int($descuento_off) ? $descuento_off . '% ' : number_format(round($descuento_off, 3), 0) . '% ';
                                                        ?>
                            </div>
                        </div>
                    </div>
                    <span class="product-marcas hide">
                        <?php echo  $marca; ?>
                    </span>
                    <span class="product-category hide">
                        <?php echo  $categoria; ?>

                    </span>
                    <div class="product-image">
                        <?php echo $this->Html->image('productos/' . $articulo['imagen'], ['alt' => str_replace('"', '', $articulo['descripcion_sist']), 'class' => 'imgFoto', 'loading' => 'lazy']); ?>

                    </div> <?php if (isset($articulo['outlet_condicion']) && !empty($articulo['outlet_condicion'])) {
                                echo $this->Html->image('Rotura-2.png', ['alt' => str_replace('"', '', $articulo['outlet_condicion']), 'title' => $articulo['outlet_condicion'], 'loading' => 'lazy', 'class' => 'image-broken',]);
                            } ?>
                    <div class="product-details">
                        <?php
                        if ($articulo['nuevo'])
                            echo $this->Html->image('icon_nuevo.png', ['alt' => 'nuevo', 'style' => "float: left;margin-top: -220px; z-index: 50; margin-left: 150px;  position: relative;"]); ?>
                        <h3 class="product-name"><?php echo str_replace('"', '', $articulo['descripcion_pag']);    ?></h3>
                        <div class="product-price">
                            <span class="original-price parpad">PP <?php echo $articulo['p_p']; ?></span>
                            <!--span class="discount-label">50% OFF</!--span-->
                        </div>
                        <div class="product-price-total">
                            <span class="final-price-checked"><?php if ($articulo['p_tach'] !=$articulo['pc_dto']) {
                                                                    echo '$';
                                                                    echo $articulo['p_tach'];
                                                                } ?></span>
                            <div class="final-price">$<?php if ($articulo['pc_dto'] > 0) {
                                                            echo $articulo['pc_dto'];
                                                        } else {
                                                            echo $articulo['p_tach'];
                                                        }  ?></div>
                            <!--span class="discount-label">50% OFF</!--span-->
                        </div>
                    </div>
                    <?php
                    $descuento_id = 0;
                    if (!empty($articulo['descuentos'])) {
                        if ($articulo['descuentos'][0]['tipo_venta'] == 'D') {
                            $descuento_id = $articulo['descuentos'][0]['id'];
                        } else
                            $descuento_id = 0;
                    }
                    if (!empty($articulo['carritos'])) {
                        echo ' <div class=product-promo-cant-um-s>
                    <span class="product-promo-cant">';
                    ?>
                        <?= $this->Form->create('Carritos', ['url' => ['controller' => 'Carritos', 'action' => '#'], 'id' => 'formaddcart' . $indice, 'onsubmit' => 'return false;']); ?>
                    <?php
                        if (!empty($articulo['carritos']))
                            $cantidadencarrito = $articulo['carritos'][0]['cantidad'];
                        else
                            $cantidadencarrito = "";


                        echo    '<div class="div-quantity"><button class="btn btn-sm suma quantity-button plus" onclick="increment(' . $articulo['id'] . ',' . $descuento_id . ',' . $articulo['id'] . ')">+</button> ';
                        echo $this->Form->input('cantidad', ['tabindex' => $indice, 'type' => 'number', 'value' => $cantidadencarrito, 'id' => 'cart-cant', 'class' => 'formcartcant quantity-input', 'target' => '_blank', 'data-id' => $articulo['id'], 'data-pv-id' => $descuento_id, 'label' => false, 'autocomplete' => 'off', 'style' => 'padding: 5px 5px; width:40px;text-align: center;']);
                        echo '<button class="btn btn-sm resta quantity-button minus" onclick="decrement(' . $articulo['id'] . ',' . $descuento_id . ',' . $articulo['id'] . ',' . $articulo['carritos'][0]['id'] . ')">-</button>';
                        $indice++;
                        $this->Form->end();
                        echo '</div> </div>';
                    } else {
                        echo    '<div><button class="cartBtn"  data-id="' . $articulo['id'] . '" data-pv-id= "' . $descuento_id . ' " >
                        <svg class="cart" fill="white" viewBox="0 0 576 512" height="1em" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0 24C0 10.7 10.7 0 24 0H69.5c22 0 41.5 12.8 50.6 32h411c26.3 0 45.5 25 38.6 50.4l-41 152.3c-8.5 31.4-37 53.3-69.5 53.3H170.7l5.4 28.5c2.2 11.3 12.1 19.5 23.6 19.5H488c13.3 0 24 10.7 24 24s-10.7 24-24 24H199.7c-34.6 0-64.3-24.6-70.7-58.5L77.4 54.5c-.7-3.8-4-6.5-7.9-6.5H24C10.7 48 0 37.3 0 24zM128 464a48 48 0 1 1 96 0 48 48 0 1 1 -96 0zm336-48a48 48 0 1 1 0 96 48 48 0 1 1 0-96z"></path>
                        </svg>
                        Agregar Carrito
                        <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 640 512" class="product">
                            <path d="M211.8 0c7.8 0 14.3 5.7 16.7 13.2C240.8 51.9 277.1 80 320 80s79.2-28.1 91.5-66.8C413.9 5.7 420.4 0 428.2 0h12.6c22.5 0 44.2 7.9 61.5 22.3L628.5 127.4c6.6 5.5 10.7 13.5 11.4 22.1s-2.1 17.1-7.8 23.6l-56 64c-11.4 13.1-31.2 14.6-44.6 3.5L480 197.7V448c0 35.3-28.7 64-64 64H224c-35.3 0-64-28.7-64-64V197.7l-51.5 42.9c-13.3 11.1-33.1 9.6-44.6-3.5l-56-64c-5.7-6.5-8.5-15-7.8-23.6s4.8-16.6 11.4-22.1L137.7 22.3C155 7.9 176.7 0 199.2 0h12.6z"></path>
                        </svg>
                    </button></div>
                   ';
                    } ?>


                </div>
            <?php endforeach; ?>
        </div>
    </div>

</div>


<div class="modal fade" id="enlargeImageModal" tabindex="-1" role="dialog" aria-labelledby="enlargeImageModal" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <img src="" class="enlargeImageModalSource" style="width: 100%;">
            </div>
        </div>
    </div>
</div>
<div id="imageModal" style="display: none;">
    <div class="modal-content">
        <span class="close-modal">&times;</span>
        <img id="modalImage" src="" alt="Imagen de Packaging" style="max-width: 100%;">
    </div>
</div>
<script>
    $('.cartBtn').on('click', function(s) {
        const button = $(this); // Referencia al botón clicado

        // Cambiar el contenido del botón a una imagen de cargando
        const loadingImg = '<img src="img/cargando.gif" alt="Cargando..." style="width: 20px; height: 20px;">';
        const originalContent = button.html(); // Guarda el contenido original del botón
        button.html(loadingImg); // Reemplaza el contenido por la imagen
        button.prop('disabled', true);
        ajaxcartAgregar($(this).attr("data-id"), 1, $(this).attr("data-pv-id"), null, "VC");
        setTimeout(() => {
            location.reload(true); // Recarga forzada sin usar caché
        }, 2000);
    });

    $(function() {
        $('.imgFoto').on('click', function() {
            var str = $(this).attr('src');
            //alert (str);
            //var str = str.replace("foto.png", "productos/"+$(this).data("id"));
            var res = str.replace("productos/", "productos/big_");
            var a = new XMLHttpRequest;
            a.open("GET", res, false);
            a.send(null);
            if (a.status === 404) {
                var res = $(this).attr('src');
                //var res = res.replace("foto.png", "productos/"+$(this).data("id"));
            }
            //var res =  $(this).attr('src');
            $('.enlargeImageModalSource').attr('src', res);
            $('#enlargeImageModal').modal('show');
        });
    });

    $('.image-broken').on('click', function() {

        // Obtener el src de la imagen que se ha clickeado
        let imageSrc = "/dsx/img/CartelDañadoGrande400x400.jpg";
        //Cartel-Dañado-Grande
        // Asignar el src al modalImage y mostrar el modal
        $('#modalImage').attr('src', imageSrc);
        $('#modalImage').attr('style', 'width:400px');
        $('#imageModal').fadeIn();
    });

    // Cerrar el modal al hacer clic en el botón de cierre o fuera del contenido del modal
    $('.close-modal, #imageModal').on('click', function(e) {
        // Si el usuario hace clic en el modal (fuera del contenido) o en el botón de cierre, cierra el modal
        if (e.target === this) {
            $('#imageModal').fadeOut();
        }
    });
</script>
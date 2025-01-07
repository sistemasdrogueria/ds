<style>
    .contenedorfiltros {
        text-align: center;
        padding: 20px;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    #termino {
        padding: 10px !important;
        font-size: 16px !important;
        border: 1px solid #ccc !important;
        border-radius: 5px !important;
        box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.1) !important;
        width: 200px !important;
    }

    #fecha {
        padding: 1.2px;
        font-size: 16px;
        border: 1px solid #ccc;
        border-radius: 5px;
        box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.1);
        width: 200px;
        height: 36px;
        text-align: center;
    }

    @media (max-width: 768px) {
        #searchForm {
            display: flex;
            flex-direction: column;
        }
    }


    .selectcategoria {
        padding: 10px;
        font-size: 16px;
        border: 1px solid #ccc;
        border-radius: 5px;
        box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.1);
        width: 200px;
    }
</style>

<div class="contenedorfiltros">
    <button onclick="history.back()" style="background: none; border: none; cursor: pointer;">
        <img src="https://cdn-icons-png.freepik.com/512/12334/12334825.png?uid=P145705485&ga=GA1.1.1985647457.1722957751" alt="Volver" style="width: 35px;">
    </button>
    <?= $this->Form->create(null, ['url' => ['controller' => 'Novedades', 'action' => 'search'], 'id' => 'searchForm']); ?>
    <input type="text" id="termino" name="termino" class="input-termino" placeholder="Buscar...">
    <select name="categoria" class="selectcategoria">
        <?php foreach ($categorias as $id => $nombre): ?>
            <option value="<?= h($id) ?>"><?= h($nombre) ?></option>
        <?php endforeach; ?>
    </select>


    <input type="date" name="fecha" id="fecha">

    <input type="submit" value="Buscar"
        style="background-color: #007bff; color: white; border: none; padding: 10px 20px; 
                font-size: 16px; border-radius: 5px; cursor: pointer;">
    <?= $this->Form->end() ?>
</div>
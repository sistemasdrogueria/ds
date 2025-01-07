<style>
    .sidebar {
        background-color: white;
        /*padding: 20px;*/
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }


    .switch-container {
        display: flex;
        justify-content: space-around;
        align-items: center;
        margin-bottom: 1rem;
        padding: 20px
    }

    .switch {
        position: relative;
        display: inline-block;
        width: 60px;
        height: 34px;
    }

    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .switch-btn {
        padding: 10px 20px;
        border: 2px solid #007bff;
        background-color: #fff;
        color: #007bff;
        cursor: pointer;
        border-radius: 20px;
        font-size: 16px;
        transition: background-color 0.3s, color 0.3s;
        margin: 0 5px;
        outline: none;
    }

    .switch-btn.active {
        background-color: #007bff;
        color: #fff;
    }

    .switch-btn:hover {
        background-color: #0056b3;
        color: #fff;
    }


    .news-list {
        list-style-type: none;
        padding: 10px;
    }

    .news-list li {
        display: flex;
        gap: 1rem;
        margin-bottom: 1rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid #eee;
    }

    .news-list li:last-child {
        border-bottom: none;
    }

    .news-list img {
        width: 150px;
        height: 150px;
        object-fit: cover;
        flex-shrink: 0;
    }

    .news-list li:last-child {
        transition: transform 0.3s ease;
        transform: translateY(0);
    }

    .news-list li:last-child:hover {
        transform: translateY(-5px);
    }

    .switch-btn {
        padding: 10px 20px;
        border: 2px solid #007bff;
        background-color: #fff;
        color: #007bff;
        cursor: pointer;
        border-radius: 20px;
        font-size: 16px;
        transition: background-color 0.3s, color 0.3s;
        margin: 0 5px;
        outline: none;
    }

    .switch-btn.active {
        background-color: #007bff;
        color: #fff;
    }

    .switch-btn:hover {
        background-color: #0056b3;
        color: #fff;
    }

    .tituloaside {
        color: #1e90ff;
        margin-bottom: 0.5rem;
    }

    @media (max-width: 900px) {
        .tituloaside {
            font-size: 22px;
        }

        .news-list img {
            margin-right: 10px;
        }
    }

    @media (max-width: 468px) {
        .tituloaside {
            font-size: 15px;
        }
    }
</style>

<aside class="sidebar">
    <div class="switch-container">

        <div class="switch-container">
            <button id="leidoBtn" class="switch-btn active">Lo Más Leído</button>
            <button id="nuevoBtn" class="switch-btn">Lo Más Nuevo</button>
        </div>
    </div>

    <ul class="news-list" id="news-list">

    </ul>
</aside>
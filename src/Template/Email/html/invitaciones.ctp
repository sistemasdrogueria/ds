<!-- src/Template/Emails/html/template_name.ctp -->

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Correo Electrónico</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
        }
        .header {
            background-color: #3498db;
            color: #ffffff;
            padding: 20px;
            text-align: center;
        }
        .content {
            padding: 20px;
        }
        .footer {
            background-color: #2c3e50;
            color: #ffffff;
            padding: 10px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Invitación enviada</h1>
        </div>
        <div class="content">
            <p>Hola <?= $nombre; ?>,</p>
            <p>Hemos recibido tu formulario de aceptación, Gracias por completarlo.</p>
           
           
        </div>
        <div class="footer">
            <p>© <?= date('Y') ?> Drogueria sur</p>
        </div>
    </div>
</body>
</html>
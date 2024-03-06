<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Índice</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
    }

    header {
      background-color: #333;
      color: white;
      text-align: center;
      padding: 5px;
    }

    header img {
      max-width: 30%;
      height: auto;
    }

    section {
      display: flex;
      justify-content: space-around;
      padding: 20px;
    }

    .pagina {
      border: 1px solid #ddd;
      padding: 20px;
      margin: 10px;
      text-align: center;
    }

    /* Quitar estilos de los enlaces */
    section a {
      text-decoration: none;
      color: inherit;
      width: 45%; /* Ajustar el ancho de la etiqueta <a> */
      display: block; /* Hacer que el enlace ocupe todo el contenedor */
      transition: color 0.3s, transform 0.3s; /* Transición para suavizar cambios */
    }

    section a img {
      max-width: 45%; /* Ajustar el tamaño máximo de las imágenes dentro de los enlaces */
      height: auto;
      display: block;
      margin: 0 auto; /* Centrar la imagen */
    }

    section a:hover {
      color: blue; /* Cambiar el color al pasar el ratón sin subrayar */
      transform: scale(1.1); /* Hacer la imagen un poco más grande al pasar el ratón */
    }
  </style>
</head>
<body>

  <header>
    <img src="./img/logo.png" alt="Logo de la empresa">
  </header>

  <section>
    <a href="./agenda.php">
      <div class="pagina">
        <img src="./img/prueba.png" alt="Imagen Agenda">
        <h2>Agenda</h2>
      </div>
    </a>

    <a href="./pacientes.html">
      <div class="pagina">
        <img src="./img/agenda.jpg" alt="Imagen Pacientes">
        <h2>Pacientes</h2>
      </div>
    </a>

  </section>

</body>
</html>

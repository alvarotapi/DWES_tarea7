<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>API DWES - Tarea 7 Álvaro Tapiador de la Torre</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div id="div">
        <h2>Álvaro Tapiador de la Torre</h2>
        <h3>77375226-Y</h3>
        <br>
        <?php
        if (isset($_GET["action"]) && isset($_GET["id"]) && $_GET["action"] == "get_datos_autor"){
            $app_info = file_get_contents('http://localhost/tarea7/api.php?action=get_datos_autor&id=' . $_GET["id"]);
            $app_info = json_decode($app_info);
        ?>
            <p>
                <td>Nombre: </td><td> <?php echo $app_info->datos->nombre ?></td>
            </p>
            <p>
                <td>Apellidos: </td><td> <?php echo $app_info->datos->apellidos ?></td>
            </p>
            <p>
                <td>País de nacimiento: </td><td> <?php echo $app_info->datos->nacionalidad ?></td>
            </p>
            <p>
                <td>Libros escritos:</td>
                    <td>
                        <ul>
                            <?php foreach($app_info->libros as $libro): ?>
                                <li>
                                    <a href="<?php echo "http://localhost/tarea7/cliente.php?action=get_datos_libro&id=" . $libro->id  ?>">
                                    <?php echo $libro->titulo ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </td>
            </p>  	
            <br />
            <a href="http://localhost/tarea7/cliente.php?action=get_listado_libros" alt="Lista de libros">Ir a la lista de libros</a>
            <a href="http://localhost/tarea7/cliente.php?action=get_listado_autores" alt="Lista de autores">Ir a la lista de autores</a>
        <?php
        }

        else if (isset($_GET["action"]) && isset($_GET["id"]) && $_GET["action"] == "get_datos_libro"){
            $app_info = file_get_contents('http://localhost/tarea7/api.php?action=get_datos_libro&id=' . $_GET["id"]);
            $app_info = json_decode($app_info);
        ?>
            <p>
                <td>Titulo: </td><td> <?php echo $app_info->datos->titulo ?></td>
            </p>
            <p>
                <td>Fecha de publicación: </td><td> <?php echo $app_info->datos->f_publicacion ?></td>
            </p>
            <p>
                <a href="<?php echo "http://localhost/tarea7/cliente.php?action=get_datos_autor&id=" . $app_info->datos->id_autor  ?>">
                <td>Autor: </td><td> <?php echo $app_info->datos->nombre . " " . $app_info->datos->apellidos ?></td>
            </p>
            <br />
            <a href="http://localhost/tarea7/cliente.php?action=get_listado_libros" alt="Lista de libros">Ir a la lista de libros</a>
            <a href="http://localhost/tarea7/cliente.php?action=get_listado_autores" alt="Lista de autores">Ir a la lista de autores</a>
        <?php
        }

        else if ((isset($_GET["action"]) && $_GET["action"] == "get_listado_libros"))
        {
            $lista_libros = file_get_contents('http://localhost/tarea7/api.php?action=get_listado_libros');
            $lista_libros = json_decode($lista_libros);
        ?> 
            <p>Libros de la base de datos:</p>
            <ul>
            <?php foreach($lista_libros as $libro): ?>
                <li>
                    <a href="<?php echo "http://localhost/tarea7/cliente.php?action=get_datos_libro&id=" . $libro->id  ?>">
                    <?php echo "Id: " . $libro->id . ", " .$libro->titulo ?>
                    </a>
                </li>
            <?php endforeach; ?>
            </ul>
            <a href="http://localhost/tarea7/cliente.php?action=get_listado_autores" alt="Lista de autores">Ir a la lista de autores</a>
        <?php
        }

        else if ((isset($_GET["action"]) && $_GET["action"] == "get_listado_autores"))
        {
            $lista_autores = file_get_contents('http://localhost/tarea7/api.php?action=get_listado_autores');
            $lista_autores = json_decode($lista_autores);
        ?>
            <p>Autores de la base de datos:</p>
            <ul>
            <?php foreach($lista_autores as $autores): ?>
                <li>
                    <a href="<?php echo "http://localhost/tarea7/cliente.php?action=get_datos_autor&id=" . $autores->id  ?>">
                    <?php echo $autores->nombre . " " . $autores->apellidos ?>
                    </a>
                </li>
            <?php endforeach; ?>
            </ul>
            <a href="http://localhost/tarea7/cliente.php?action=get_listado_libros" alt="Lista de libros">Ir a la lista de libros</a>
        <?php
        } ?>
    </div>
</body>
</html>
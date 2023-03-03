<?php
    /** 
    * Función que se encarga de retornar el listado de autores
    *
    * @return array $lista_autores Array con la lista de los autores
    * @author Álvaro Tapiador <alvarotapiador@gmail.com>
    * @version 1.0.0 Estable
    */
    function get_listado_autores(){
        $bd = "libros";
        $servidor = "localhost";
        $usuario = "alvaro";
        $contrasenia = "alvaro1234";
        $cadenaConexion = "mysql:dbname=$bd;host=$servidor";
        $pdo = new PDO($cadenaConexion, $usuario, $contrasenia, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

        $sql = "SELECT * FROM autor";
        $lectura = $pdo->query($sql);
        
        if ($lectura->rowCount() > 0){
            while ($fila = $lectura->fetchObject()){
                $lista_autores[] = $fila;
            }
        }

        return $lista_autores;
    }

    /** 
    * Función que se encarga de retornar los datos del autor según el id facilitado
    *
    * @param string $id del autor a buscar
    * @return object $info_autor Objeto con la información del autor
    * @author Álvaro Tapiador <alvarotapiador@gmail.com>
    * @version 1.0.0 Estable
    */
    function get_datos_autor($id){
        $bd = "libros";
        $servidor = "localhost";
        $usuario = "alvaro";
        $contrasenia = "alvaro1234";
        $cadenaConexion = "mysql:dbname=$bd;host=$servidor";
        $pdo = new PDO($cadenaConexion, $usuario, $contrasenia, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

        $info_autor = new stdClass();

        $sql = "SELECT * FROM autor where id='$id'";
        $lectura = $pdo->query($sql);
        $info_autor->datos = $lectura->fetchObject();

        $sql = "SELECT * FROM libro where id_autor='$id'";
        $lectura = $pdo->query($sql);

        if ($lectura->rowCount() > 0){
            while ($fila = $lectura->fetchObject()){
                $info_autor->libros[] = $fila;
            }
        }
        else $info_autor->libros = null;
        
        return $info_autor;
    }

    /** 
    * Función que se encarga de retornar el listado de libros total
    *
    * @return array $lista_libros Array con todos los libros
    * @author Álvaro Tapiador <alvarotapiador@gmail.com>
    * @version 1.0.0 Estable
    */
    function get_listado_libros(){
        $bd = "libros";
        $servidor = "localhost";
        $usuario = "alvaro";
        $contrasenia = "alvaro1234";
        $cadenaConexion = "mysql:dbname=$bd;host=$servidor";
        $pdo = new PDO($cadenaConexion, $usuario, $contrasenia, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

        $sql = "SELECT id, titulo FROM libro";
        $lectura = $pdo->query($sql);
        
        if ($lectura->rowCount() > 0){
            while ($fila = $lectura->fetchObject()){
                $lista_libros[] = $fila;
            }
        }

        return $lista_libros;
    } 

    /** 
    * Función que se encarga de retornar los datos del libro según el id facilitado
    *
    * @param string $id del libro a buscar
    * @return object $info_libro Objeto con la información del libro
    * @author Álvaro Tapiador <alvarotapiador@gmail.com>
    * @version 1.0.0 Estable
    */
    function get_datos_libro($id){
        $bd = "libros";
        $servidor = "localhost";
        $usuario = "alvaro";
        $contrasenia = "alvaro1234";
        $cadenaConexion = "mysql:dbname=$bd;host=$servidor";
        $pdo = new PDO($cadenaConexion, $usuario, $contrasenia, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

        $info_libro = new stdClass();

        $sql = "SELECT titulo, f_publicacion, nombre, apellidos, id_autor FROM autor JOIN libro ON autor.id = libro.id_autor 
            WHERE libro.id = '$id'";
        $lectura = $pdo->query($sql);
        $info_libro->datos = $lectura->fetchObject();

        if ($lectura->rowCount() > 0){
            while ($fila = $lectura->fetchObject()){
                $info_libro->libros[] = $fila;
            }
        }
        else $info_libro->libros = null;
        
        return $info_libro;

    }


    $posibles_URL = array("get_listado_autores", "get_datos_autor", "get_listado_libros", "get_datos_libro");

    $valor = "Ha ocurrido un error";

    if (isset($_GET["action"]) && in_array($_GET["action"], $posibles_URL))
    {
    switch ($_GET["action"])
        {
            case "get_listado_autores":
                $valor = get_listado_autores();
                break;
            case "get_datos_autor":
                if (isset($_GET["id"]))
                    $valor = get_datos_autor($_GET["id"]);
                else
                    $valor = "Argumento no encontrado";
                break;
            case "get_listado_libros":
                $valor = get_listado_libros();
                break;
            case "get_datos_libro":
                if (isset($_GET["id"]))
                    $valor = get_datos_libro($_GET["id"]);
                    else
                    $valor = "Argumento no encontrado";
                break;
        }
    }

    exit(json_encode($valor));
?>
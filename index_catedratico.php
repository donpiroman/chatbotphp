<?php
//DESHABILITAR EL MOSTRAR ERRORES
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(-1);

require 'vendor/autoload.php';
//IMPORTAR LAS LIBRERIAS DE RiveScript
use \Axiom\Rivescript\Rivescript;

//crear el token
$clave_token='Guatemala';

//recibimos desde fb para su verificación
$palabra_desafio=$_GET['hub_challenge'];

//es la clave que nos envia fb
$clave_verificacion=$_GET['hub_verify_token'];

//validamos con el token que creamos y el nos da fb
if ($clave_token === $clave_verificacion) {
    echo $palabra_desafio;
    exit;
}

//leer los mensajes enviados a través de whatsapp
$respuesta=file_get_contents("php://input");
//convertir el json en un arreglo
$respuesta=json_encode($respuesta, true);

//extraer el número de teléfono del arreglo
//$mensaje="Teléfono: " . $respuesta['entry'][0]['changes'][0]['value']['messages'][0]['from'] . "</br>";
//$mensaje .= "Mensaje: " . $respuesta['entry'][0]['changes'][0]['value']['messages'][0]['text']['body'];
$base = $respuesta['entry'][0]['changes'][0]['value']['messages'][0];

$mensaje = $base['text']['body'];
$telefono_cliente = $base['from'];
$id = $base['id'];
$timestamp = $base['timestamp'];

if ($mensaje!=null) {
    //guardar el mensaje en un archivo data.txt
    //file_put_contents("data.txt", $mensaje);
    //INSTANCIANDO RiveScript
    $rivescript = new Rivescript();
    $rivescript->load('cursos.rive');

    //OBTENEMOS LA RESPUESTA
    $respuesta = $rivescript->reply($mensaje);
    file_put_contents("data.txt", $respuesta);
}
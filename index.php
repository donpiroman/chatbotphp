<?php
// importar la liberiar de RiveScript
use \Axiom\Rivescript\Rivescript;

// deshabilitar  el mostrar errores,
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(-1);

require 'vendor/autoload.php';

// CODIGO DE ANGEL PUAC0
//crear el token
$clave_token = 'PalabraClave';

//recibimos desde fb para su verificación
$palabra_desafio = $_GET['hub_challenge'];

//es la clave que nos envia fb
$clave_verificacion = $_GET['hub_verify_token'];

//validamos con el token que creamos y el nos da fb
if ($clave_token === $clave_verificacion) {
    echo $palabra_desafio;
    exit;
}


$respuesta = file_get_contents("php://input");

//Convertimos el JSON en un arreglo
$respuesta = json_decode($respuesta, true);

// if ($respuesta->success !== true or $respuesta->status !== 200) {
//     file_put_contents('log.txt','respuesta con error!!');
//     ///die();
// } else {
//     file_put_contents('log.txt','Funciono bien!!');
// }

$baseMensaje = $respuesta['entry'][0]['changes'][0]['value']['messages'][0];
$mensaje = $baseMensaje['text']['body'];
$telefono_cliente = $baseMensaje['from'];
$id = $baseMensaje['id'];
$timestamp = $baseMensaje['timestamp'];

//leer los mensajes enviados a través de whatsapp
// $respuesta = file_get_contents("php://input");

// //convertir el json en un arreglo
// //$respuesta=json_encode($respuesta, true);
// $jsonrespuesta = json_decode($respuesta, true);

// if ($jsonrespuesta->success !== true or $jsonrespuesta->status !== 200) {
//     file_put_contents('log.txt','respuesta con error!!');
//     die();
// } else {
//     file_put_contents('log.txt','Funciono bien!!');
// }

//extraer el número de teléfono del arreglo
//$mensaje="Teléfono: " . $respuesta['etry'][0]['changes'][0]['value']['messages'][0]['from'] . "</br>";
//$mensaje .= "Mensaje: " . $respuesta['entry'][0]['changes'][0]['value']['messages'][0]['text']['body'];
// $base = $respuesta['entry'][0]['changes'][0]['value']['messages'][0];

// $mensaje = $base['text']['body'];
// $telefono_cliente = $base['from'];
// $id = $base['id'];
// $timestamp = $base['timestamp'];

// $base = $jsonrespuesta['entry'][0]['changes'][0]['value']['messages'][0];
// $mensaje = $base['text']['body'];
// $telefono_cliente = $base['from'];
// $id = $base['id'];
// $timestamp = $base['timestamp'];



// if ($mensaje == null) 
// {
//     $mensaje = "hola";
// }

if ($mensaje != null) {
    //vamos a instanciar rivescript
    $rivescript = new Rivescript();
    $rivescript->load('cursos.rive');
    $loquerespond = $rivescript->reply($mensaje);



    if ($loquerespond == "__chatgpt__") {
        require_once "chatgpt.php";
        $loquerespond = preguntarChatGPT($mensaje); 
    }


    require_once "almacena.php";
    //prueba();
    almacena($mensaje, $loquerespond, $id, $timestamp, $telefono_cliente);
}
/*
//CODIGO PARA GRABAR CODIGO EN ARCHIVO PLANO

// Nombre del archivo
$nombreArchivo = "data.txt";

// Abre el archivo en modo escritura ('a')
$archivo = fopen($nombreArchivo, 'a');

// Si el archivo NO Existe, primero lo crea
if (!$archivo) {
    // si no existe, Crea Primero el archivo
    $archivo = fopen($nombreArchivo, 'w');
}

// Escribe los datos enviados
//fwrite($archivo, $base . PHP_EOL);

fwrite($archivo,'ID:' . $id . ' TELEFONO:' . $telefono_cliente . ' TIME:' . $timestamp . ' MSG:' . $mensaje . ' RESP: ' . $loquerespond. PHP_EOL);
//fwrite($archivo,$respuesta);



// Cierra el archivo
fclose($archivo);
*/
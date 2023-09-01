<?php
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
$respuesta=json_decode($respuesta, true);

//extraer el número de teléfono del arreglo
$base = $respuesta['entry'][0]['changes'][0]['value']['messages'][0];

//extraer datos por separado
$mensaje = $base['text']['body'];
$telefono_cliente = $base['from'];
$id = $base['id'];
$timestamp = $base['timestamp'];

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
fwrite($archivo, 'ID:' . $id . ' TELEFONO:' . $telefono_cliente . ' TIME:' . $timestamp . ' MSG:' . $mensaje . PHP_EOL);

// Cierra el archivo
fclose($archivo);

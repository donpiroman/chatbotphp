<?php
// CODIGO DE ANGEL PUAC
//crear el token
$clave_token='PalabraClave';

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
//$respuesta=json_encode($respuesta, true);
$respuesta=json_decode($respuesta, true);

//extraer el número de teléfono del arreglo
//$mensaje="Teléfono: " . $respuesta['etry'][0]['changes'][0]['value']['messages'][0]['from'] . "</br>";
//$mensaje .= "Mensaje: " . $respuesta['entry'][0]['changes'][0]['value']['messages'][0]['text']['body'];
$base = $respuesta['entry'][0]['changes'][0]['value']['messages'][0];

$mensaje = $base['text']['body'];
$telefono_cliente = $base['from'];
$id = $base['id'];
$timestamp = $base['timestamp'];

// Nombre del archivo
$nombreArchivo = "data.txt";

// Abre el archivo en modo escritura ('w' sobreescribe el archivo si existe)
$archivo = fopen($nombreArchivo, 'a');

if ($archivo) 
{
    // Escribe los datos en el archivo existente
    //fwrite($archivo, $base . PHP_EOL);
    fwrite($archivo, $id . ' ' . ' ' . $telefono_cliente. ' ' . $timestamp . ' ' .$mensaje . PHP_EOL);

    // Cierra el archivo
    fclose($archivo);

} 
else 
{
    // si no existe, crea primero el archivo
    $archivo = fopen($nombreArchivo, 'w');

    if ($archivo) 
    {
        // Escribe los datos en el archivo
        //fwrite($archivo, $respuesta . PHP_EOL);
        fwrite($archivo, $id . ' ' . ' ' . $telefono_cliente. ' ' . $timestamp . ' ' .$mensaje . PHP_EOL);

        // Cierra el archivo
        fclose($archivo);
    }
}
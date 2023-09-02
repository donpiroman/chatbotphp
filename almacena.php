<?php

function almacena(
  $recibido,
  $enviado,
  $id,
  $timestamp,
  $telefono_cliente
) {


  require_once "conexion.php";

  //VARIABLE PARA VER LA CANTIDAD DE REGISTROS ENCONTRADOS
  $cantidad = 0;
  //VERIFICO A TRAVES DEL ID LOS MENSAJES
  $sql_cantidad = "SELECT COUNT(id) FROM wamensajes WHERE id='" . $id . "';";

  //file_put_contents('log.txt',$sql_cantidad);

  $resultado_cantidad = $conn->query($sql_cantidad);

  if ($resultado_cantidad) {
    //OBTENEMOS EL PRIMER REGISTRO
    $fila_cantidad = $resultado_cantidad->fetch_row();
    $cantidad = $fila_cantidad[0];
  }

  if ($cantidad == 0) {
    
    //VAMOS A RESPONDER A WHATSAPP
    //TOKEN DE FB
    $token = 'EAANlkYT1E1IBO4PpNw0YZBfU03xCd8xjY8ZCijZCltTk9hZCC2BwOBzpZB8QbrII1jlzTdCQCl3Q3OLtxBix4QZCijxZBZBxqvtHJv7W01NPbukE5M0qtCmUWEiTBAJzP2o2lM0N1GP5ZB3YCgbP6vIq1gRgmFXohGJwyxFNN8hANXSWFz8t58o6GS3R8g7KstRq0ynQ78VZC3F8L1LKvSKgZDZD';
    //TELEFONO
    $telefono = $telefono_cliente;

    $telefono_id = '101035446407741';

    //URL A DONDE SE ENVIA EL MENSAJE
    $url = 'https://graph.facebook.com/v17.0/'.$telefono_id.'/messages';
    $mensaje = ''
      . '{'
      . '"messaging_product":"whatsapp",'
      . '"recipient_type":"individual",'
      . '"to":"' . $telefono . '",'
      . '"text":'
      . '{'
      . '     "body":"' . $enviado . '",'
      . '     "preview_url":true,'
      . '}'
      . '}';;
    //DECLARAR LA CABECERA
    $header = array("Authorization: Bearer " . $token, 'Content-Type: application/json',);

    //INICIAMOS LA CURL
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $mensaje);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    //OBTENER LA RESPUESTA DEL ENVIO
    $respuestaAPI = json_decode(curl_exec($curl), true);

    //IMPRIMIENDO LA RESPUESTA
    //file_put_contents('log.txt',$respuestaAPI);

    //OBTENER EL CODIGO DE LA RESPUESTA
    $estatus_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);

    //CERRAMOS LA CURL
    curl_close($curl);



    $sql = "INSERT INTO wamensajes "
      . "(mensaje, telefono, id, Respuesta,timestamp) "
      . "VALUES('{$recibido}','{$telefono_cliente}','{$id}','{$enviado}','{$timestamp}')";

    $conn->query($sql);
  }
  $conn->close();

}

    <?php
    // token
    $token = "EAANlkYT1E1IBO5lCh3cRBCmmJIquCWx9H9ktZABc7hLOk1ZA4hbeTzyjzcF4356VBQ2ndZCKZCZCanG8EVKCXyZBtKDJvyT0iSAwbOV9ZBQ67ydob6sSZAId2ZAFyQVoDlNFlNZCvwhNp16NrnxF30ZAxEwCZCVw5lU2odOrZBZBJpJdhVZBtNVZByJYmYGg6iCiL4fd2yw4zfErhRAhaCbdngKb";
    // telefono 
    $telefono = "50250001836";
    // URL donde se envia el sms 
    $url = "https://graph.facebook.com/v17.0/101035446407741/messages";

    //mensaje
    
    $mensaje = ''

        . '{'
        . '"messaging_product":"whatsapp",'
        . '"to":"' . $telefono . '", '
        . '"type":"template", '
        . '"template": '
        . '{'
        . '"name":"hello_world", '
        . '"language":{"code":"en_US"}, '
        . '}'
        . '}';

    // declaramos la cabecera
    $header = array("Authorization: Bearer " . $token, "Content-Type: application/json", );

    // inicio con la curl
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $mensaje);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    // obtener respuesta del envio 
    $response = json_decode(curl_exec($curl), true);

    print_r($response);

    $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

    //cerras 
    curl_close($curl);

    ?>

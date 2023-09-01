    <?php

    // deshabilitar  el mostrar errores, 
    ini_set('display_errors',0);
    ini_set('display_startup_errors',0);
    error_reporting(-1);

    require 'vendor/autoload.php';

    // importar la liberiar de RiveScript 
    use \Axiom\Rivescript\Rivescript;

    // token configurado en webhooks
    $clave_token = "PalabraClave";

    // recibimos desde ffb para su verificacion
    $palabra_desafio = $_GET['hub_challenge'];

    // es la clave de nos envia FB

    $clave_verificacion = $_GET['hub_verify_token'];

    // Validamos con el token que creamo s el el nos da FB

    if($clave_token === $clave_verificacion)
    {
        echo $palabra_desafio;
        exit;
    }

    // leer los sms enviado de whatapp 

    $respuesta = file_get_contents("php://input");

    $respuesta =json_decode($respuesta,true);

    // codigo de prueba 

    // extraer nummero de celular 

    /* Extraccion de la info desde json 
    $mensaje = "Telefono: " . $respuesta['entry'][0]['changes'][0]['value'][0]['message'][0]['from'] . "</br>";
    $mensaje .= "Mensaje: " . $respuesta['entry'][0]['changes'][0]['value'][0]['message'][0]['text']['body'] . "</br>";
*/
    $base = $respuesta['entry'][0]['changes'][0]['value'][0]['message'][0];
    $mensaje = $base['text']['body'];
    $telefono_cliente = $base['from'];
    $id = $base['id'];
    $timeStamp = $base['timestamp'];

    // if ($mensaje != null)
    // {
    //     //file_put_contents("/.data.txt",$mensaje);
    //     file_put_contents("data.txt",$mensaje);
    //     // vamos a instanciar rivescript

    //     $rivescript = new Rivescript();
    //     $rivescript->load('cursos.rive');

    //     // obtenes la respuesta segun lo conifgurado en archivo de respuesta 
    //     $respuesta = $rivescript->reply($mensaje);
    //     file_put_contents("data.txt",$respuesta);
    // }


    // codigo de prueba 
    $nombreArchivo = "testoPrueba.txt";

    $archivo = fopen($nombreArchivo, 'a');

    if ($archivo)
    {
        // escribe en el archivo 
        fwrite($archivo,$base);

        fclose($archivo);

    }
    else 
    {
        $archivo = fopen($nombreArchivo, 'w');
        fwrite($archivo,$base);

        fclose($archivo);

    }
    



    ?>
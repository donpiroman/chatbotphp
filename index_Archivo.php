<?php
    // datos a almacenar en el archivo 
    //$datos = "Esto son los datos que quiero almacenar";
    if (isset($_GET['entrada']))
    {
        $datos = $_GET['entrada'];
        //echo "Entrada: ". $datos . "<br>";
    }
    // else
    // {
    //     echo "El parametro 'entrada' no ha sido recibido en la URL<br>";
    // }

    $data = array(
        'valor1' => 'hola',
        'valor2' => 42,
        'valor3' => true
    );
    
    $json = json_encode($data);
    //echo $json;

    $nombreArchivo = "data.txt";

    $archivo = fopen($nombreArchivo, 'w');

    if ($archivo )
    {
        // escribe en el archivo 
        fwrite($archivo,$datos);

        fclose($archivo);

        //echo "los datos han sido almacenados ' $nombreArchivo ";
    }else 
    {
        //echo "No se puede abrir el archivo ' $nombreArchivo ' para escritura";
    }
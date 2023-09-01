<?php

function preguntarChatGPT($pregunta)
{
    //api key chapGPT
    $gptKey = "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";
    //"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";

    // inicia la consulta CURL
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, 'https://api.openai.com/v1/chat/completions');
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($curl, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Authorization: Bearer ' . $gptKey,
    ]);

    // iniciar el Json 
    curl_setopt($curl, CURLOPT_POSTFIELDS, "{
        \"model\": \"gpt-3.5-turbo\",
        \"messages\": [{\"role\": \"user\", \"content\": \" " . $pregunta . " \"}],
        \"max_tokens\": 4000,
        \"temperature\": 0.7
    }");

    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

    // recuperamos el Json 
    $respuestaGPT = curl_exec($curl);
    curl_close($curl);

    $decode_json = json_decode($respuestaGPT, false);
    //file_put_contents('log.txt',$decode_json);
    //print_r($decode_json->choices[0]->messages->content);

    return $decode_json->choices[0]->message->content;

}

//$loqueRespondio = preguntarChatGPT("Quien es el presidente de Guatemala?");
//file_put_contents('log.txt', $loqueRespondio);
//echo $loqueRespondio;
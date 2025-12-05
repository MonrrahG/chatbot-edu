<?php 
    header("Content-Type: application/json; charset=UTF-8");

    $mensagem = $_POST["mensagem"] ?? "";

    $api_key = "AIzaSyCVV7CZgEXdUxAa5cmuS-rz_ffxeD6wW-M"; 

    $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=" . $api_key;
    
    $prompt_iot = "
    Você é um assistente virtual que explica conceitos básicos de enfermagem.
    Fale sempre de forma simples, como se estivesse falando para iniciantes.

    Mensagem do usuário: $mensagem
    ";

    $data = [
        "contents" => [
            [
                "parts" => [
                    ["text" => $prompt_iot]
                ]
            ]
        ]
    ];

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);

    if(curl_errno($ch)){
        echo json_encode(["resposta" => "Erro de conexão (cURL): " . curl_error($ch)]);
        exit;
    }
    curl_close($ch);

    $json = json_decode($response, true);

    if (isset($json['error'])) {
        $msg_erro = $json['error']['message'];
        echo json_encode(["resposta" => "Erro da API Gemini: " . $msg_erro]);
        exit;
    }

    $resposta = $json["candidates"][0]["content"]["parts"][0]["text"] 
        ?? "A IA não retornou texto. Verifique sua API KEY ou o console.";
    
    echo json_encode(["resposta" => $resposta]);
?>

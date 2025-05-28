<?php
try {
    $tienda = $_POST["tienda"];
    $stringUpdate = "Titulo=?, descr=?, link=?";
    $arrayUpdate = [$tienda["Titulo"], $tienda["descr"], $tienda["link"]];
    $salida = [
        "id" => 0,
        "Titulo" => $tienda["Titulo"],
        "descr" => $tienda["descr"],
        "link" => $tienda["link"],
        "img" => $tienda["img"],
        "profPic" => $tienda["profPic"],
    ];

    if (isset($tienda["img"]) && strpos($tienda["img"], "data") !== false) {
        $nombre = $tienda["id"] . generate_string("abcdefghijklmnopqrstuvwxyz") . ".webp";
        $directorio = "./fotos";
        $fotoBase64 = preg_replace('#^data:image/\w+;base64,#i', '', $tienda["img"]);
        $fotoBinaria = base64_decode($fotoBase64);
        if ($fotoBinaria === false) {
            echo json_encode(["codigo" => 500, "mensaje" => "No fue cargar la foto ingresar del item"]);
            exit;
        }
        $stringUpdate .= ", img=?";
        $arrayUpdate[] = $nombre;
        $tienda["img"] = $nombre;
        file_put_contents($directorio . "/" . $nombre, $fotoBinaria);
        $salida["img"] = $nombre;

    }
    if (isset($tienda["profPic"]) && strpos($tienda["profPic"], "data") !== false) {
        $nombre = $tienda["id"] . generate_string("abcdefghijklmnopqrstuvwxyz") . ".webp";
        $directorio = "./fotos";
        $fotoBase64 = preg_replace('#^data:image/\w+;base64,#i', '', $tienda["profPic"]);
        $fotoBinaria = base64_decode($fotoBase64);
        if ($fotoBinaria === false) {
            echo json_encode(["codigo" => 500, "mensaje" => "No fue cargar la foto ingresar del item"]);
            exit;
        }
        $stringUpdate .= ", profPic=?";
        $arrayUpdate[] = $nombre;
        $tienda["profPic"] = $nombre;
        file_put_contents($directorio . "/" . $nombre, $fotoBinaria);
        $salida["profPic"] = $nombre;
    }
    $arrayUpdate[] = $tienda["id"];
    $result = execQuery("UPDATE links SET $stringUpdate WHERE id=?", $arrayUpdate);
    if ($result) {
        echo json_encode(array("codigo" => 200, "mensaje" => "Tienda actualziada con éxito", "salida" => $salida));
    } else {
        echo json_encode(["codigo" => 500, "mensaje" => "No fue posible actualizar la Tienda"]);
    }

} catch (Exception $e) {
    $logFile = 'errores';

    $error = "[" . date('Y-m-d H:i:s') . "] " . PHP_EOL;
    $error .= "Mensaje: " . $e->getMessage() . PHP_EOL;
    $error .= "Archivo: " . $e->getFile() . PHP_EOL;
    $error .= "Línea: " . $e->getLine() . PHP_EOL;
    $error .= "Trace: " . $e->getTraceAsString() . PHP_EOL;
    $error .= str_repeat("-", 80) . PHP_EOL;

    file_put_contents($logFile, $error, FILE_APPEND);
    echo json_encode(["codigo" => 500, "mensaje" => "No fue posible actualizar la Tienda"]);
}
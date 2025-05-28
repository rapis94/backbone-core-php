<?php
try {
    $promo = $_POST["promo"];
    $stringUpdate = "";

   $salida = [
        "id"=>0,
        "Titulo"=>$promo["Titulo"],
        "descr"=>$promo["descr"],
        "link"=>$promo["link"],
        "img"=>$promo["img"],
    ];

    if (isset($promo["img"]) && strpos($promo["img"], "data") !== false) {
        $nombre = $promo["id"] . generate_string("abcdefghijklmnopqrstuvwxyz") . ".webp";
        $directorio = "./fotos";
        $fotoBase64 = preg_replace('#^data:image/\w+;base64,#i', '', $promo["img"]);
        $fotoBinaria = base64_decode($fotoBase64);
        if ($fotoBinaria === false) {
            echo json_encode(["codigo" => 500, "mensaje" => "No fue cargar la foto ingresar del item"]);
            exit;
        }
        $stringUpdate .= ", img='$nombre'";
        $promo["img"] = $nombre;
        file_put_contents($directorio . "/" . $nombre, $fotoBinaria);
        $salida["img"] = $nombre;

    }
    
    $result = execQuery("UPDATE producto_destacado SET Titulo=?, descr=?, link=? WHERE id=?", [$promo["Titulo"], $promo["descr"], $promo["link"], $promo["id"]]);
    if ($result) {
        echo json_encode(array("codigo" => 200, "mensaje" => "Promo actualziada con éxito", "salida"=>$salida));
    } else {
        echo json_encode(["codigo" => 500, "mensaje" => "No fue posible actualizar la Promo"]);
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
    echo json_encode(["codigo" => 500, "mensaje" => "No fue posible actualizar la Promo"]);
}
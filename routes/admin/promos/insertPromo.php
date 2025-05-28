<?php
try {
    $promo = $_POST["promo"];
    
    $salidaInsert = [
        "id"=>0,
        "Titulo"=>$promo["Titulo"],
        "descr"=>$promo["descr"],
        "link"=>$promo["link"],
        "img"=>"",
    ];
    $result = execQuery("INSERT INTO producto_destacado (Titulo, descr, link, activo, img) VALUES (?,?,?,?)", [$promo["Titulo"], $promo["descr"], $promo["link"], 1,'']);


    if ($result) {
        $salidaInsert["id"] = $result;

        if (isset($promo["img"]) && strpos($promo["img"], "data") !== false) {
            $nombre = $result . generate_string("abcdefghijklmnopqrstuvwxyz") . ".webp";
            $directorio = "./fotos";
            $fotoBase64 = preg_replace('#^data:image/\w+;base64,#i', '', $promo["img"]);
            $fotoBinaria = base64_decode($fotoBase64);
            if ($fotoBinaria === false) {
                echo json_encode(["codigo" => 500, "mensaje" => "No fue cargar la foto ingresar del item"]);
                exit;
            }

            $promo["img"] = $nombre;
            file_put_contents($directorio . "/" . $nombre, $fotoBinaria);
            execQuery("UPDATE producto_destacado SET img=? WHERE id=?", [$nombre, $result]);
            $salidaInsert["img"] = $nombre;
        }
        
        echo json_encode(["codigo" => 200, "mensaje" => "Promo ingresada con éxito", "salida"=>$salidaInsert]);
    } else {
        
        echo json_encode(["codigo" => 500, "mensaje" => "No fue posible ingresar la Promo"]);
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
    echo json_encode(["codigo" => 500, "mensaje" => "No fue posible ingresar la Promo"]);
}
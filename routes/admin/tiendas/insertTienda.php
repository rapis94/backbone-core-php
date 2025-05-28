<?php
try {
    $tienda = $_POST["tienda"];
    $stringTabla = "links";
    $stringProps = "";
    $stringInsertValues = "'{$tienda["Titulo"]}', '{$tienda["descr"]}', '{$tienda["link"]}', 1,'', ''";
    $salidaInsert = [
        "id"=>0,
        "Titulo"=>$tienda["Titulo"],
        "descr"=>$tienda["descr"],
        "link"=>$tienda["link"],
        "img"=>"",
        "profPic"=>"",
    ];
    $result = execQuery("INSERT INTO links (Titulo, descr, link, activo, img, profPic) VALUES (?, ?, ?, 1,'', '')", [$tienda["Titulo"], $tienda["descr"], $tienda["link"]]);


    if ($result) {
        $salidaInsert["id"] = $result;

        if (isset($tienda["img"]) && strpos($tienda["img"], "data") !== false) {
            $nombre = $result . generate_string("abcdefghijklmnopqrstuvwxyz") . ".webp";
            $directorio = "./fotos";
            $fotoBase64 = preg_replace('#^data:image/\w+;base64,#i', '', $tienda["img"]);
            $fotoBinaria = base64_decode($fotoBase64);
            if ($fotoBinaria === false) {
                echo json_encode(["codigo" => 500, "mensaje" => "No fue cargar la foto ingresar del item"]);
                exit;
            }

            $tienda["img"] = $nombre;
            file_put_contents($directorio . "/" . $nombre, $fotoBinaria);
            execQuery("UPDATE links SET img='$nombre' WHERE id=$result");
            $salidaInsert["img"] = $nombre;
        }
        if (isset($tienda["profPic"]) && strpos($tienda["profPic"], "data") !== false) {
            $nombre = $result . generate_string("abcdefghijklmnopqrstuvwxyz") . ".webp";
            $directorio = "./fotos";
            $fotoBase64 = preg_replace('#^data:image/\w+;base64,#i', '', $tienda["profPic"]);
            $fotoBinaria = base64_decode($fotoBase64);
            if ($fotoBinaria === false) {
                echo json_encode(["codigo" => 500, "mensaje" => "No fue cargar la foto ingresar del item"]);
                exit;
            }

            $tienda["profPic"] = $nombre;
            file_put_contents($directorio . "/" . $nombre, $fotoBinaria);
            execQuery("UPDATE links SET profPic='$nombre' WHERE id=$result");
            $salidaInsert["profPic"] = $nombre;
        }

        echo json_encode(["codigo" => 200, "mensaje" => "Tienda ingresada con éxito", "salida"=>$salidaInsert]);
    } else {
        
        echo json_encode(["codigo" => 500, "mensaje" => "No fue posible ingresar la Tienda"]);
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
    echo json_encode(["codigo" => 500, "mensaje" => "No fue posible ingresar la Tienda"]);
}
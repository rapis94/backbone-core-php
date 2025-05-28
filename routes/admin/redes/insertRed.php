<?php
try {
    $red = $_POST["red"];
  
    $salidaInsert = [
        "id"=>0,
        "Titulo"=>$red["Titulo"],
        "idRed"=>$red["idRed"],
        "url"=>$red["url"],
    ];
    $result = execQuery("INSERT INTO redes_sociales (Titulo, url, idRed) VALUES (?,?,?)", [$red["Titulo"], $red["url"],$red["idRed"]]);


    if ($result) {
        $salidaInsert["id"] = $result;

       
        echo json_encode(["codigo" => 200, "mensaje" => "Red ingresada con éxito", "salida"=>$salidaInsert]);
    } else {
        
        echo json_encode(["codigo" => 500, "mensaje" => "No fue posible ingresar la Red"]);
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
    echo json_encode(["codigo" => 500, "mensaje" => "No fue posible ingresar la Red"]);
}
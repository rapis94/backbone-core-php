<?php
try {
    $red = $_POST["red"];
    $salida = [
        "id" => $red["id"],
        "Titulo" => $red["Titulo"],
        "idRed" => $red["idRed"],
        "url" => $red["url"],
    ];
    $result = execQuery(
        "UPDATE redes_sociales SET Titulo=?, idRed=?, url=? WHERE id={}",
        [$red["Titulo"], $red["idRed"], $red["url"], $red["id"]]
    );


    if ($result) {
        $salida["Red"] = execQuery("SELECT Nombre FROM red_social WHERE id={$red["idRed"]}")[0]->Nombre;
        echo json_encode(array("codigo" => 200, "mensaje" => "Red actualziada con éxito", "salida" => $salida));
    } else {
        echo json_encode(["codigo" => 500, "mensaje" => "No fue posible actualizar la Red"]);
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
    echo json_encode(["codigo" => 500, "mensaje" => "No fue posible actualizar la Red"]);
}
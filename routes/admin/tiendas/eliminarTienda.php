<?php
try {
    $tienda = $_POST;
   
    $result = execQuery("DELETE FROM links WHERE id=?", [$tienda["id"]]);


    if ($result) {

        echo json_encode(["codigo" => 200, "mensaje" => "Tienda eliminada con éxito"]);
    } else {
        
        echo json_encode(["codigo" => 500, "mensaje" => "No fue posible eliminar la Tienda"]);
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
    echo json_encode(["codigo" => 500, "mensaje" => "No fue posible eliminar la Tienda"]);
}
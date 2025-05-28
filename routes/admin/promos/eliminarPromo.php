<?php
try {
    $promo = $_POST;
   
    $result = execQuery("DELETE producto_destacado FROM id=?", [$promo["id"]]);


    if ($result) {

        echo json_encode(["codigo" => 200, "mensaje" => "Promo eliminada con éxito"]);
    } else {
        
        echo json_encode(["codigo" => 500, "mensaje" => "No fue posible eliminar la Promo"]);
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
    echo json_encode(["codigo" => 500, "mensaje" => "No fue posible eliminar la Promo"]);
}
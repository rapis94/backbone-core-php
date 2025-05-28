<?php
try {
    $result = execQuery("SELECT usuario.*, tipo_usuario.Nombre AS Tipo FROM usuario, tipo_usuario WHERE tipo_usuario.id = tipoUsuario ORDER By tipoUsuario, usuario.Nombre");

    echo json_encode(["codigo" => 200, "usuarios" => $result]);
} catch (Exception $e) {
    $logFile = 'errores';

    $error = "[" . date('Y-m-d H:i:s') . "] " . PHP_EOL;
    $error .= "Mensaje: " . $e->getMessage() . PHP_EOL;
    $error .= "Archivo: " . $e->getFile() . PHP_EOL;
    $error .= "Línea: " . $e->getLine() . PHP_EOL;
    $error .= "Trace: " . $e->getTraceAsString() . PHP_EOL;
    $error .= str_repeat("-", 80) . PHP_EOL;

    file_put_contents($logFile, $error, FILE_APPEND);
    echo json_encode(["codigo" => 500, "mensaje" => "Hubo un error al cargar usuarios"]);
}
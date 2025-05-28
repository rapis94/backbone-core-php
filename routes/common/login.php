<?php
try {

    $pass = hash_password($_POST["pass"]);
    $result = execQuery("SELECT * FROM usuario WHERE Nombre=? and password=?", [$_POST['usuario'], $pass]);
    if ($result) {
        $jwt = generarJWT($result[0], secret);

        echo json_encode(["codigo" => 200, "mensaje" => "Sesión correcta", "token"=>$jwt, "usuario" => $result[0]]);

    } else {
        echo json_encode(["codigo" => 401, "mensaje" => "Error en usuario y/o contraseña"]);

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
    echo json_encode(["codigo" => 500, "mensaje" => "Hubo un error al abrir la sesión"]);
}


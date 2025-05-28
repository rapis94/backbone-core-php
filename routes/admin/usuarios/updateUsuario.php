<?php
try {
    $usuario = $_POST['usuario'];
    $updateString = "Nombre=?, tipoUsuario =?";
    $arrayUpdate = [$usuario['Nombre'], $usuario["tipoUsuario"]];
    if ($usuario["password"] != "") {
        $password = hash_password($usuario["password"]);
        $updateString .= ", password=?";
        $arrayUpdate[] = $password;
    }
    $arrayUpdate[] = $usuario["id"];
    $result = execQuery(
        "UPDATE usuario SET $updateString WHERE id=?",
        $arrayUpdate
    );


    echo json_encode(["codigo" => 200, "mensaje" => "usuario ingresado con éxito"]);


} catch (Exception $e) {
    $logFile = 'errores';

    $error = "[" . date('Y-m-d H:i:s') . "] " . PHP_EOL;
    $error .= "Mensaje: " . $e->getMessage() . PHP_EOL;
    $error .= "Archivo: " . $e->getFile() . PHP_EOL;
    $error .= "Línea: " . $e->getLine() . PHP_EOL;
    $error .= "Trace: " . $e->getTraceAsString() . PHP_EOL;
    $error .= str_repeat("-", 80) . PHP_EOL;

    file_put_contents($logFile, $error, FILE_APPEND);
    echo json_encode(["codigo" => 500, "mensaje" => "No fue posible ingresar el usuario"]);
}
?>
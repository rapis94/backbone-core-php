<?php
date_default_timezone_set("America/Argentina/Buenos_Aires");
define("RESTAURANTE", "Pampa Burger");
define("URL_ENCODE_NAME", "Pampa%20Burger");
define("WEB_URL", "www.pampa.uy");
define("CODE_PREFIX", "PAMPA");
define("CODE_CHAIN", "PMA0123456789");
define("WA", "59899372473");
define("TELEFONO", "099372473");
define("PIX", "55997008711");
define("DIRECCION", "Faustino Carambula 1038");
define("MAPS", "https://www.google.com/maps/dir//Faustino+Car%C3%A1mbula+1038,+40000+Rivera,+Departamento+de+Rivera/@-30.8985933,-55.5431848,17z/data=!4m8!4m7!1m0!1m5!1m1!1s0x95a9fef6da2e0cc9:0x4ce44481e40e99dd!2m2!1d-55.5406151!2d-30.8986052?entry=ttu");
define("DESCRIPCION", "O Pampa Burger é um restaurante em Rivera que oferece pizzas por metro com sabores à escolha e hambúrgueres artesanais feitos na parrilla. Uma experiência única e saborosa!");
function Config()
{

    $datos = [
        0 => "localhost",
        1 => "root",
        2 => "4563-Lemos",
        3 => "mrpollo"
    ];
    return $datos;
}


/*

function Config()
{
$datos = array(
0 => "localhost",
1 => "pampa_root",
2 => "Pampa-2023",
3 => "pampa_base"
);
return $datos;
}
*/
function execQuery(string $query, array $params = [])
{
    $conn = getConnection();
    $stmt = $conn->prepare($query);
    if (!$stmt) {
        throw new Exception("Error al preparar la consulta: " . $conn->error);
    }

    if (!empty($params)) {
        $types = '';
        foreach ($params as $param) {
            if (is_int($param)) {
                $types .= 'i';
            } elseif (is_float($param)) {
                $types .= 'd';
            } elseif (is_string($param)) {
                $types .= 's';
            } else {
                $types .= 'b';
            }
        }

        $stmt->bind_param($types, ...$params);
    }

    if (!$stmt->execute()) {
        throw new Exception("Error al ejecutar la consulta: " . $stmt->error);
    }

    $result = $stmt->get_result();
    if ($result !== false) {
        $stmt->close();
        $data = [];
        while ($obj = $result->fetch_object()) {
            $data[] = $obj;
        }

        return count($data) > 0 ? $data : false;
    } else {
        $insertId = $stmt->insert_id;
        $affectedRows = $stmt->affected_rows;
        $stmt->close();

        if ($insertId > 0) {
            return $insertId;
        } elseif ($affectedRows > 0) {
            return $affectedRows;
        } else {
            return false;
        }
    }
}



function getConnection()
{

    $datos = Config();

    $conn = new mysqli($datos[0], $datos[1], $datos[2], $datos[3]);
    if ($conn->connect_error) {
        throw new Exception("Conexión fallida: " . $conn->connect_error);
    }

    return $conn;
}

function calcularCotizacion($monto, $cot, $operacion)
{

    return $operacion == "/" ? ceil($monto / $cot) : $monto * $cot;
}
function hash_password($password)
{
    $SALT = 'pitogordo';
    return hash('sha256', $SALT . $password);
}

function generate_string($input, $strength = 16)
{
    $input_length = strlen($input);
    $random_string = '';
    for ($i = 0; $i < $strength; $i++) {
        $random_character = $input[mt_rand(0, $input_length - 1)];
        $random_string
            .= $random_character;
    }
    return $random_string;
}
function convertDate($fecha, $tipo = 1)
{
    $date = date_create_from_format("Y-m-d H:i:s", $fecha);
    if ($tipo == 1) {
        return $date->format("d-m-Y H:i:s");
    } else {
        return $date;
    }
}

function getBrowser($user_agent)
{

    if (strpos($user_agent, 'MSIE') !== FALSE) {
        return 'Internet explorer';
    } elseif (strpos($user_agent, 'Edge') !== FALSE) { //Microsoft Edge
        return 'Microsoft Edge';
    } elseif (strpos($user_agent, 'Trident') !== FALSE) { //IE 11
        return 'Internet explorer';
    } elseif (strpos($user_agent, 'Opera Mini') !== FALSE) {
        return "Opera Mini";
    } elseif (strpos($user_agent, 'Opera') !== FALSE || strpos($user_agent, 'OPR') !== FALSE) {
        return "Opera";
    } elseif (strpos($user_agent, 'Firefox') !== FALSE) {
        return 'Mozilla Firefox';
    } elseif (strpos($user_agent, 'Chrome') !== FALSE) {
        return 'Google Chrome';
    } elseif (strpos($user_agent, 'Safari') !== FALSE) {
        return "Safari";
    } else {
        return $user_agent;
    }
}
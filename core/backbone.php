<?php
date_default_timezone_set("America/Argentina/Buenos_Aires");
function Config()
{

    $datos = [
        0 => "localhost",
        1 => "usuario",
        2 => "contraseña",
        3 => "basededatos"
    ];
    return $datos;
}


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



function hash_password($password)
{
    $SALT = 'saltencuestion';
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

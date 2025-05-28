<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, auth");
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}
require_once './core/jwt/JWT.php';
require_once './core//jwt/Key.php';
define("RUTA_BASE", dirname(realpath(__FILE__)) . "/");
define("RUTA_NAVEGADOR", "/");
define("secret", "queElAlientoDelDragonDeLosInjustosNoIncinereTuRectitud");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_POST = json_decode(file_get_contents("php://input"), true);
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $params = $_GET; 
}

function generarJWT($datos, $clave, $expSegundos = 3600)
{
    $payload = [
        'iat' => time(),
        'exp' => time() + 60 * 60 * 60 * 24,
        'datos' => $datos
    ];

    return \Firebase\JWT\JWT::encode($payload, $clave, 'HS256');
}

function verificarJWT($token, $clave)
{
    try {
        $decoded = \Firebase\JWT\JWT::decode($token, new \Firebase\JWT\Key($clave, 'HS256'));
        return $decoded->datos;
    } catch (Exception $e) {
        return false;
    }
}
class NAVEGADOR
{

    private $vista;
    public $variables = [];
    function __construct($headers)
    {
        $this->headers = $headers;
    }

    function navegar($uri)
    {
        global $usuario;
        $token = "";

        if (strpos($uri, "login") === false && strpos($uri, "polling") === false && strpos($uri, "public") === false) {
            try {
                if (!isset($this->headers["auth"])) {
                    echo json_encode(["codigo" => 401, "mensaje" => "Acceso no autorizado 1"]);
                    exit();
                }
                $token = $this->headers["auth"];
                if (!$user = verificarJWT($token, secret)) {
                    echo json_encode(["codigo" => 401, "mensaje" => "Acceso no autorizado 2"]);
                    exit();
                }
            } catch (Exception $e) {
                echo json_encode(["codigo" => 401, "mensaje" => "Acceso no autorizado 3"]);
            }


            $usuario = $user;
        }

        $ruta = "routes/" . $uri . ".php";

        if (file_exists($ruta)) {
            include $ruta;
        } else {
            http_response_code(404);
            echo json_encode([
                "status" => "error",
                "message" => "Ruta no encontrada"
            ]);
        }
    }

    function descomponerLink($uri)
    {
        return explode("/", $uri);
    }

}

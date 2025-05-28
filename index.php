<?php




include_once './core/core.php';
include_once './core/backbone.php';
$headers = getallheaders();

$navegador = new NAVEGADOR($headers);
if (isset($_GET['uri'])) {
 $navegador->navegar($_GET['uri']);
} else {
  echo json_encode(array("status" => "error", 'message' => 'La ruta no existe'));
}
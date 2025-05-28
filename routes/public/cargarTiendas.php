<?php
$where = "";
if(isset($_POST["activos"])){
    $where .= " WHERE activo = 1";
}
$result = execQuery("SELECT * FROM links". $where);

echo json_encode($result);
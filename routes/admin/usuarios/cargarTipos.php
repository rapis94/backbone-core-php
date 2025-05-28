<?php
$tipos = execQuery("SELECT * FROM tipo_usuario");

echo json_encode($tipos);
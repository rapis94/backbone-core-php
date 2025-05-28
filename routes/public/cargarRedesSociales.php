<?php

$result = execQuery("SELECT redes_sociales.*, red_social.Nombre as Red FROM redes_sociales, red_social WHERE idRed = red_social.id");

echo json_encode($result);
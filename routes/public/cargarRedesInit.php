<?php
$result = execQuery("SELECT * FROM red_social");

echo json_encode($result);
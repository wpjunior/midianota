<?php

    $file = $_GET['arquivo'];

    header("Content-Type: application/save");
    header("Content-Length:" . filesize($file));
    header('Content-Disposition: attachment; filename="' . $file . '"');
    header("Content-Transfer-Encoding: binary");
    header('Expires: 0');
    header('Pragma: no-cache');


    $fp = fopen("$file", "r");
    fpassthru($fp);
    fclose($fp);
    
?>
<?php

        include("../../funcoes/util.php");
        session_start();
        session_destroy();
        Redireciona("../certidoes.php");
        
?>
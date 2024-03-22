<?php

    $to = "gatitocrazy21@outlook.es";
    $subject = "Este es un mail de prueba";
    $message = "Estoy probando el envio de un correo";
    $headers = "From: cj7ulises@gmail.com";

    mail($to, $subject, $message, $headers);

    echo "Email enviado, revisa tu correo";

?>
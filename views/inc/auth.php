<?php

include_once filter_input(INPUT_SERVER, 'DOCUMENT_ROOT') . '/config.php';
include_once ESSENCIAIS;

$params = anti_injection($_POST);

if (empty($_COOKIE['tos_key'])) {
    if ($params['senha'] == 'topzera.') {
        setcookie("tos_key", base64_encode(serialize(md5('topzera.'))), time() + 60 * 60 * 24 * 7, "/", "", "", true);
        header('location: /principal');
    } else {
        $_SESSION['error'] = 'Não tem nada aqui, vai embora.. ';
        header('location:' . URLANTERIOR);
    }
}
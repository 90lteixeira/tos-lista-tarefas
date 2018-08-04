<?php

function logMsg($msg, $level = 'info', $query = '') {
    // variável que vai armazenar o nível do log (INFO, WARNING ou ERROR)
    $levelStr = '';

    // verifica o nível do log
    switch ($level) {
        case 'info':
            // nível de informação
            $levelStr = 'INFO';
            break;

        case 'warning':
            // nível de aviso
            $levelStr = 'WARNING';
            break;

        case 'error':
            // nível de erro
            $levelStr = 'ERROR';
            break;
    }

    // data atual
    $date = date('Y-m-d H:i:s');

    // formata a mensagem do log
    // data atual
    // nível da mensagem (INFO, WARNING ou ERROR)
    //  a mensagem propriamente dita
    //  comando executado com erro
    // 5o: PHP_EOL quebra de linha
    $msg = sprintf("[%s] LOG [%s]: [BASE: " . $_SESSION['lembrar']['user_bd'] . " - " . $_SESSION['lembrar']['pw_bd'] . "] %sQUERY[%s] %s%s%s", $date, $levelStr, PHP_EOL, $query, PHP_EOL, $msg, PHP_EOL);

    $dir = $dir = __DIR__ . '/log';
    $dir = filter_input(INPUT_SERVER, 'DOCUMENT_ROOT') . '/log';

    if (!is_dir($dir)) {
        mkdir($dir);
    }

    $file = $dir . "/" . date('Y-m-d') . ".txt";

    // escreve o log no arquivo
    // é necessário usar FILE_APPEND para que a mensagem seja escrita no final do arquivo, preservando o conteúdo antigo do arquivo
    file_put_contents($file, $msg, FILE_APPEND);
}

//limitar texto
if (!function_exists("limitarTexto")) {

    function limitarTexto($texto, $limite) {
        $contador = strlen($texto);
        if ($contador >= $limite) {
            $texto = substr($texto, 0, strrpos(substr($texto, 0, $limite), ' ')) . '...';
            return $texto;
        } else {
            return $texto;
        }
    }

}

function converterDataExibicao($data) {

    if (!$data)
        return date('d/m/Y');
    $novaData = date('d/m/Y', strtotime($data));
    return $novaData;
}

function converterReal($valor, $decimal = false) {
    if (!$valor)
        $valor = 0;

    if ($decimal) {
        
        $valor = (string)$valor;
        $regra = "/^([1-9]{1}[\d]{0,2}(\.[\d]{3})*(\,[\d]{0,2})?|[1-9]{1}[\d]{0,}(\,[\d]{0,2})?|0(\,[\d]{0,2})?|(\,[\d]{1,2})?)$/";
        if(preg_match($regra,$valor)) {
            $valor = str_replace(',', '.', str_replace('.', '', $valor));
        } else {
            $valor = str_replace(',', '', $valor);
        }
        
        return $valor;
    }

    return number_format($valor, 2, ',', '.');
}

//anti injection
if (!function_exists("anti_injection")) {

    function anti_injection($valor, $array = true) {

        $vetor = array();
        $vowels = array("--", "'", '"', "\\", "&", "#", "script");

        if ($array) {
            foreach ($valor as $key => $vet) {
                $vetor[$key] = addslashes(str_replace($vowels, "", $vet));
            }

            return $vetor;
        }

        $valor_tratado = addslashes(str_replace($vowels, "", $valor));
        return $valor_tratado;
    }

}

//retorna json
function return_json($status, $msg, $data = array()) {
    header('Content-Type: application/json');
    echo json_encode(array(
        'status' => $status,
        'msg' => $msg,
        'data' => $data
    ));
    die();
}

//retorna session
function return_session($msg, $status = 'error', $url = '') {

    switch ($status) {
        case 200: $status = 'success';
            break;
        case 500: $status = 'error';
            break;
    }
    $_SESSION[$status] = $msg;
    header('location: ' . ($url ? $url : URLANTERIOR));
    die();
}

//dia da semana
function mesPorExtenso($mes) {

    switch ($mes) {
        case 1: $mes = "Janeiro";
            break;
        case 2: $mes = "Fevereiro";
            break;
        case 3: $mes = "Março";
            break;
        case 4: $mes = "Abril";
            break;
        case 5: $mes = "Maio";
            break;
        case 6: $mes = "Junho";
            break;
        case 7: $mes = "Julho";
            break;
        case 8: $mes = "Agosto";
            break;
        case 9: $mes = "Setembro";
            break;
        case 10: $mes = "Outubro";
            break;
        case 11: $mes = "Novembro";
            break;
        case 12: $mes = "Dezembro";
            break;
    }

    return $mes;
}

//dia da semana
function diaSemana($data) {
    $dia = substr($data, 0, 2);
    $mes = substr($data, 3, 2);
    $ano = substr($data, 6, 9);
    $diasemana = date("w", mktime(0, 0, 0, $mes, $dia, $ano));

    switch ($diasemana) {
        case"0": $diasemana = "Domingo";
            break;
        case"1": $diasemana = "Segunda-Feira";
            break;
        case"2": $diasemana = "Terça-Feira";
            break;
        case"3": $diasemana = "Quarta-Feira";
            break;
        case"4": $diasemana = "Quinta-Feira";
            break;
        case"5": $diasemana = "Sexta-Feira";
            break;
        case"6": $diasemana = "Sábado";
            break;
    }

    echo "$diasemana";
}

//ip
if (!function_exists("getIp")) {

    function getIp() {

        if (!empty(filter_input(INPUT_SERVER, 'HTTP_CLIENT_IP'))) {
            $ip = filter_input(INPUT_SERVER, 'HTTP_CLIENT_IP');
        } elseif (!empty(filter_input(INPUT_SERVER, 'HTTP_X_FORWARDED_FOR'))) {
            $ip = filter_input(INPUT_SERVER, 'HTTP_X_FORWARDED_FOR');
        } else {
            $ip = filter_input(INPUT_SERVER, 'REMOTE_ADDR');
        }

        return $ip;
    }

}

//ataque csrf
if (!class_exists("csrf")) {

    class csrf {

        public function gen() {
            $_SESSION['csrf_token'] = md5(uniqid());
        }

        public function get() {
            return $_SESSION['csrf_token'];
        }

        public function check($token) {
            return ($token == $_SESSION['csrf_token']);
        }

    }

}

//gera numero aletório
if (!function_exists("geraSenha")) {

    function geraSenha($tamanho = 8, $maiusculas = true, $numeros = true, $simbolos = false) {
        $lmin = 'abcdefghijklmnopqrstuvwxyz';
        $lmai = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $num = '1234567890';
        $simb = '!@#$%*-';
        $retorno = '';
        $caracteres = '';
        $caracteres .= $lmin;
        if ($maiusculas): $caracteres .= $lmai;
        endif;
        if ($numeros): $caracteres .= $num;
        endif;
        if ($simbolos): $caracteres .= $simb;
        endif;
        $len = strlen($caracteres);

        for ($n = 1; $n <= $tamanho; $n++) {
            $rand = mt_rand(1, $len);
            $retorno .= $caracteres[$rand - 1];
        }

        return $retorno;
    }

}

//validar e-mail
function validarEmail($email) {
    if (filter_var($email, FILTER_VALIDATE_EMAIL))
        return true;
    else
        return false;
}

//converter data
if (!function_exists("converterData")) {

    function converterData($date, $hora_fim = false) {

        if (!$date)
            $date = date('d/m/Y');
        
        // EN-Date to GE-Date
        if (strstr($date, "-") || strstr($date, "/")) {
            $date = preg_split("/[\/]|[-]+/", $date);
            $date = $date[2] . "-" . $date[1] . "-" . $date[0];
            return $date . ($hora_fim ? ' 23:59:59' : '');
        }
        // GE-Date to EN-Date
        else if (strstr($date, ".")) {
            $date = preg_split("[.]", $date);
            $date = $date[2] . "-" . $date[1] . "-" . $date[0];
            return $date . ($hora_fim ? ' 23:59:59' : '');
        }
        return false;
    }

}

//converter numero para reais em extenso
function reciboValorExtenso($valor = 0, $maiusculas = false) {
    if (!$maiusculas) {
        $singular = ["centavo", "real", "mil", "milhão", "bilhão", "trilhão", "quatrilhão"];
        $plural = ["centavos", "reais", "mil", "milhões", "bilhões", "trilhões", "quatrilhões"];
        $u = ["", "um", "dois", "três", "quatro", "cinco", "seis", "sete", "oito", "nove"];
    } else {
        $singular = ["CENTAVO", "REAL", "MIL", "MILHÃO", "BILHÃO", "TRILHÃO", "QUADRILHÃO"];
        $plural = ["CENTAVOS", "REAIS", "MIL", "MILHÕES", "BILHÕES", "TRILHÕES", "QUADRILHÕES"];
        $u = ["", "um", "dois", "TRÊS", "quatro", "cinco", "seis", "sete", "oito", "nove"];
    }
    $c = ["", "cem", "duzentos", "trezentos", "quatrocentos", "quinhentos", "seiscentos", "setecentos", "oitocentos", "novecentos"];
    $d = ["", "dez", "vinte", "trinta", "quarenta", "cinquenta", "sessenta", "setenta", "oitenta", "noventa"];
    $d10 = ["dez", "onze", "doze", "treze", "quatorze", "quinze", "dezesseis", "dezesete", "dezoito", "dezenove"];

    $z = 0;
    $rt = "";

    $valor = number_format($valor, 2, ".", ".");
    $inteiro = explode(".", $valor);
    for ($i = 0; $i < count($inteiro); $i++)
        for ($ii = strlen($inteiro[$i]); $ii < 3; $ii++)
            $inteiro[$i] = "0" . $inteiro[$i];

    $fim = count($inteiro) - ($inteiro[count($inteiro) - 1] > 0 ? 1 : 2);
    for ($i = 0; $i < count($inteiro); $i++) {
        $valor = $inteiro[$i];
        $rc = (($valor > 100) && ($valor < 200)) ? "cento" : $c[$valor[0]];
        $rd = ($valor[1] < 2) ? "" : $d[$valor[1]];
        $ru = ($valor > 0) ? (($valor[1] == 1) ? $d10[$valor[2]] : $u[$valor[2]]) : "";

        $r = $rc . (($rc && ($rd || $ru)) ? " e " : "") . $rd . (($rd &&
                $ru) ? " e " : "") . $ru;
        $t = count($inteiro) - 1 - $i;
        $r .= $r ? " " . ($valor > 1 ? $plural[$t] : $singular[$t]) : "";
        if ($valor == "000")
            $z++;
        elseif ($z > 0)
            $z--;
        if (($t == 1) && ($z > 0) && ($inteiro[0] > 0))
            $r .= (($z > 1) ? " de " : "") . $plural[$t];
        if ($r)
            $rt = $rt . ((($i > 0) && ($i <= $fim) && ($inteiro[0] > 0) && ($z < 1)) ? ( ($i < $fim) ? ", " : " e ") : " ") . $r;
    }

    if (!$maiusculas) {
        $return = $rt ? $rt : "zero";
    } else {
        if ($rt)
            $rt = ereg_replace(" E ", " e ", ucwords($rt));
        $return = ($rt) ? ($rt) : "Zero";
    }

    return $return;
}

//permissão de acesso
function temAcesso($arAcesso, $controller = false) {

    $arAcessosUsuario = explode(',', $_SESSION['lembrar']['acesso']);
    $msgAcesso = $arAcesso;
    $arAcesso .= ($arAcesso ? ', 9999' : '9999'); //acesso administrador
    $newArAcesso = explode(',', trim($arAcesso));

    foreach ($newArAcesso as $acesso) {
        if (in_array(trim($acesso), $arAcessosUsuario))
            return;
    }

    if ($controller) {
        $_SESSION['warning'] = "<i class='fa fa-user-secret'></i> Não foi possível continuar, acesso negado ($msgAcesso).<br>
                Entre em contato com o seu administrador para mais detalhes.";
        header('location:' . URLANTERIOR);
        exit();
    }

    echo "<div class='panel panel-primary'>    
            <div class='panel-heading'><i class='fa fa-user'></i> Permissão de acesso</div>   
            <ol class='breadcrumb'>
                <li>
                    <i class='fa fa-home'></i> <a href='/principal-resumo/'>Principal</a>
                </li>
                    <li class='active'>
                    <i class='fa fa-user'></i> Permissão de acesso
                </li> 
            </ol> 
            <div class='separadorCadastro' style='margin:10px;'>
                <i class='fa fa-user-secret'></i> Não foi possível continuar,
                acesso negado ($msgAcesso).<br>
                Entre em contato com o seu administrador para mais detalhes.<br>
                <div style='margin-top:35px;'>
                    <a href='javascript:window.history.go(-1)'>clique aqui</a> para voltar a página anterior.
                </div>
            </div>             
        </div>";

    die();
}

//verificar limite de proprietários por plano
function limiteProprietarios($plano) {

    require_once filter_input(INPUT_SERVER, 'DOCUMENT_ROOT') . '/s/controllers/proprietarioController.php';
    $proprietarios = new Proprietarios();
    $quantidadeProprietarios = $proprietarios->getQuantidadeProprietarios();
    $limite = false;

    switch ($plano) {
        //simples
        case 1 :
        case 4 :
            if ($quantidadeProprietarios >= 500) //500 Proprietarios
                $limite = true;
            break;

        //basico
        case 2 :
        case 5 :
            if ($quantidadeProprietarios >= 1500) //1500 Proprietarios
                $limite = true;
            break;
    }

    if ($limite) {
        echo "<div class='panel panel-primary'>    
                <div class='panel-heading'><i class='fa fa-genderless'></i> Plano Banhosoft</div>   
                <ol class='breadcrumb'>
                    <li>
                        <i class='fa fa-home'></i> <a href='/principal-resumo/'>Principal</a>
                    </li>
                        <li class='active'>
                        <i class='fa fa-genderless'></i> Plano Banhosoft
                    </li> 
                </ol> 
                <div class='separadorCadastro' style='margin:10px;'>
                    <i class='fa fa-genderless'></i> Não foi possível continuar,
                    Você chegou no limite de cadastros para proprietários, referente ao seu plano. <br>[<strong><a href='/pagamento'>faça upgrade do seu plano</a></strong>].<br>
                    <br>Entre em contato com a equipe do Banhosoft, para mais detalhes.<br>
                    <div style='margin-top:35px;'>
                        <a href='javascript:window.history.go(-1)'>clique aqui</a> para voltar a página anterior.
                    </div>
                </div>             
            </div>";

        die();
    }
}

//verificar limite de usuários por plano
function limiteUsuario($plano) {

    require_once filter_input(INPUT_SERVER, 'DOCUMENT_ROOT') . '/controllers/usuarioController.php';
    $usuarios = new Usuarios();
    $quantidadeUsuarios = $usuarios->getQuantidadeUsuarios();
    $limite = false;

    switch ($plano) {
        //simples
        case 1 :
        case 4 :
            if ($quantidadeUsuarios >= 3) //3 usuarios
                $limite = true;
            break;

        //basico
        case 2 :
        case 5 :
            if ($quantidadeUsuarios >= 10) //10 usuarios
                $limite = true;
            break;
    }

    if ($limite) {
        echo "<div class='panel panel-primary'>    
                <div class='panel-heading'><i class='fa fa-genderless'></i> Plano Banhosoft</div>   
                <ol class='breadcrumb'>
                    <li>
                        <i class='fa fa-home'></i> <a href='/principal-resumo/'>Principal</a>
                    </li>
                        <li class='active'>
                        <i class='fa fa-genderless'></i> Plano Banhosoft
                    </li> 
                </ol> 
                <div class='separadorCadastro' style='margin:10px;'>
                    <i class='fa fa-genderless'></i> Não foi possível continuar,
                    Você chegou no limite de cadastros para usuários, referente ao seu plano. <br>[<strong><a href='/pagamento'>faça upgrade do seu plano</a></strong>].<br>
                    <br>Entre em contato com a equipe do Banhosoft, para mais detalhes.<br>
                    <div style='margin-top:35px;'>
                        <a href='javascript:window.history.go(-1)'>clique aqui</a> para voltar a página anterior.
                    </div>
                </div>             
            </div>";

        die();
    }
}

//verificar plano banhosoft
function temPlano($arPlano) {

    $planoPet = $_SESSION['lembrar']['cod_plano'];
    $newArPlano = explode(',', trim($arPlano));

    if (!in_array(trim($planoPet), $newArPlano))
        return;

    echo "<div class='panel panel-primary'>    
            <div class='panel-heading'><i class='fa fa-genderless'></i> Plano Banhosoft</div>   
            <ol class='breadcrumb'>
                <li>
                    <i class='fa fa-home'></i> <a href='/principal-resumo/'>Principal</a>
                </li>
                    <li class='active'>
                    <i class='fa fa-genderless'></i> Plano Banhosoft
                </li> 
            </ol> 
            <div class='separadorCadastro' style='margin:10px;'>
                <i class='fa fa-genderless'></i> Não foi possível continuar,
                Você não tem acesso a essa função do sistema. <br>[<strong><a href='/pagamento'>faça upgrade do seu plano</a></strong>].<br>
                <br>Entre em contato com a equipe do Banhosoft, para mais detalhes.<br>
                <div style='margin-top:35px;'>
                    <a href='javascript:window.history.go(-1)'>clique aqui</a> para voltar a página anterior.
                </div>
            </div>             
        </div>";

    die();
}

<?php

//LOG
$LOG_CAMINHO = defineCaminhoLog();
if (isset($LOG_CAMINHO)) {
    $LOG_NIVEL = defineNivelLog();
    $identificacao = date("dmYHis") . "-PID" . getmypid() . "-" . "notasparametros_inserir";
    if (isset($LOG_NIVEL)) {
        if ($LOG_NIVEL >= 1) {
            $arquivo = fopen(defineCaminhoLog() . "notasservico_" . date("dmY") . ".log", "a");
        }
    }
}
if (isset($LOG_NIVEL)) {
    if ($LOG_NIVEL == 1) {
        fwrite($arquivo, $identificacao . "\n");
    }
    if ($LOG_NIVEL >= 2) {
        fwrite($arquivo, $identificacao . "-ENTRADA->" . json_encode($jsonEntrada) . "\n");
    }
}
//LOG

$idEmpresa = $jsonEntrada["idEmpresa"];
$conexao = conectaMysql($idEmpresa);
if (isset($jsonEntrada['idEmpresa'])) {
    $fornecedor = isset($jsonEntrada['fornecedor'])  && $jsonEntrada['fornecedor'] !== "" ? "'". $jsonEntrada['fornecedor']."'"  : "null";
    $access_token = isset($jsonEntrada['access_token'])  && $jsonEntrada['access_token'] !== "" ? "'". $jsonEntrada['access_token']."'"  : "null";
    $provedor = isset($jsonEntrada['provedor'])  && $jsonEntrada['provedor'] !== "" ? "'". $jsonEntrada['provedor']."'"  : "null";
    $ambiente = isset($jsonEntrada['ambiente'])  && $jsonEntrada['ambiente'] !== "" ? "'". $jsonEntrada['ambiente']."'"  : "null";
    $tpAmb = isset($jsonEntrada['tpAmb'])  && $jsonEntrada['tpAmb'] !== "" ?  $jsonEntrada['tpAmb']    : "null";
    $verAplic = isset($jsonEntrada['verAplic'])  && $jsonEntrada['verAplic'] !== "" ? "'". $jsonEntrada['verAplic']."'"  : "null";
    $cTribNac = isset($jsonEntrada['cTribNac'])  && $jsonEntrada['cTribNac'] !== "" ?  $jsonEntrada['cTribNac']    : "null";
    $cNBS = isset($jsonEntrada['cNBS'])  && $jsonEntrada['cNBS'] !== "" ?  $jsonEntrada['cNBS']    : "null";    ['cNBS'];
    $tribISSQN = isset($jsonEntrada['tribISSQN'])  && $jsonEntrada['tribISSQN'] !== "" ?  $jsonEntrada['tribISSQN']    : "null";
    $tpRetISSQN = isset($jsonEntrada['tpRetISSQN'])  && $jsonEntrada['tpRetISSQN'] !== "" ?  $jsonEntrada['tpRetISSQN']    : "null";
    $CST = isset($jsonEntrada['CST'])  && $jsonEntrada['CST'] !== "" ?  $jsonEntrada['CST']    : "null";
    $pAliqPis = isset($jsonEntrada['pAliqPis'])  && $jsonEntrada['pAliqPis'] !== "" ?  $jsonEntrada['pAliqPis']    : "null";
    $pAliqCofins = isset($jsonEntrada['pAliqCofins'])  && $jsonEntrada['pAliqCofins'] !== "" ?  $jsonEntrada['pAliqCofins']    : "null";
    $tpRetPisCofins = isset($jsonEntrada['tpRetPisCofins'])  && $jsonEntrada['tpRetPisCofins'] !== "" ?  $jsonEntrada['tpRetPisCofins']    : "null";
    $vTotTribFed = isset($jsonEntrada['vTotTribFed'])  && $jsonEntrada['vTotTribFed'] !== "" ?  $jsonEntrada['vTotTribFed']    : "null";
    $vTotTribEst = isset($jsonEntrada['vTotTribEst'])  && $jsonEntrada['vTotTribEst'] !== "" ?  $jsonEntrada['vTotTribEst']    : "null";
    $vTotTribMun = isset($jsonEntrada['vTotTribMun'])  && $jsonEntrada['vTotTribMun'] !== "" ?  $jsonEntrada['vTotTribMun']    : "null";

    $sql = "INSERT INTO `notasparametros`(`idEmpresa`, `fornecedor`, `access_token`, `provedor`, `ambiente`, `tpAmb`, `verAplic`, `cTribNac`, `cNBS`,
                        `tribISSQN`, `tpRetISSQN`, `CST`, `pAliqPis`, `pAliqCofins`, `tpRetPisCofins`, `vTotTribFed`, `vTotTribEst`, `vTotTribMun`) 
                        VALUES ($idEmpresa, $fornecedor, $access_token, $provedor, $ambiente, $tpAmb, $verAplic, $cTribNac, $cNBS,
                        $tribISSQN, $tpRetISSQN, $CST, $pAliqPis, $pAliqCofins, $tpRetPisCofins, $vTotTribFed, $vTotTribEst, $vTotTribMun)";
    //LOG
    if (isset($LOG_NIVEL)) {
        if ($LOG_NIVEL >= 3) {
            fwrite($arquivo, $identificacao . "-SQL->" . $sql . "\n");
        }
    }
    //LOG

    //TRY-CATCH
    try {

        $atualizar = mysqli_query($conexao, $sql);
        if (!$atualizar)
            throw new Exception(mysqli_error($conexao));

        $jsonSaida = array(
            "status" => 200,
            "retorno" => "ok"
        );
    } catch (Exception $e) {
        $jsonSaida = array(
            "status" => 500,
            "retorno" => $e->getMessage()
        );
        if ($LOG_NIVEL >= 1) {
            fwrite($arquivo, $identificacao . "-ERRO->" . $e->getMessage() . "\n");
        }
    } finally {
        // ACAO EM CASO DE ERRO (CATCH), que mesmo assim precise
    }
    //TRY-CATCH
} else {
    $jsonSaida = array(
        "status" => 400,
        "retorno" => "Faltaram parametros"
    );
}

//LOG
if (isset($LOG_NIVEL)) {
    if ($LOG_NIVEL >= 2) {
        fwrite($arquivo, $identificacao . "-SAIDA->" . json_encode($jsonSaida) . "\n\n");
    }
}
//LOG

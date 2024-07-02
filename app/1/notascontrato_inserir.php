<?php
// helio 31012023 criacao
//echo "-ENTRADA->".json_encode($jsonEntrada)."\n";

//LOG
$LOG_CAMINHO = defineCaminhoLog();
if (isset($LOG_CAMINHO)) {
    $LOG_NIVEL = defineNivelLog();
    $identificacao = date("dmYHis") . "-PID" . getmypid() . "-" . "notasservico_inserir";
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
if (isset($jsonEntrada['idContrato'])) {

    //Busca dados Empresa
    $conexaoEmpresa = conectaMysql(null);
    $sql_parametros = "SELECT * FROM empresa where idEmpresa = $idEmpresa";
    $buscar_parametros = mysqli_query($conexaoEmpresa, $sql_parametros);
    $empresa = mysqli_fetch_array($buscar_parametros, MYSQLI_ASSOC);

    $idPessoaPrestador = $empresa['idPessoa'];

    $idPessoaTomador = isset($jsonEntrada['idPessoaTomador']) && $jsonEntrada['idPessoaTomador'] !== "" && $jsonEntrada['idPessoaTomador'] !== "null" ? "'" . $jsonEntrada['idPessoaTomador'] . "'" : "null";
    $valorNota = isset($jsonEntrada['valorNota']) && $jsonEntrada['valorNota'] !== "" && $jsonEntrada['valorNota'] !== "null" ? "'" . $jsonEntrada['valorNota'] . "'" : "null";
    $codMunicipio = isset($jsonEntrada['codMunicipio']) && $jsonEntrada['codMunicipio'] !== "" && $jsonEntrada['codMunicipio'] !== "null" ? "'" . $jsonEntrada['codMunicipio'] . "'" : "null";
    $condicao = isset($jsonEntrada['condicao']) && $jsonEntrada['condicao'] !== "" && $jsonEntrada['condicao'] !== "null" ? "'" . $jsonEntrada['condicao'] . "'" : "null";
    $descricaoServico = isset($jsonEntrada['descricaoServico']) && $jsonEntrada['descricaoServico'] !== "" && $jsonEntrada['descricaoServico'] !== "null" ? "'" . $jsonEntrada['descricaoServico'] . "'" : "null";
    $dataCompetencia = isset($jsonEntrada['dataCompetencia']) && $jsonEntrada['dataCompetencia'] !== "" && $jsonEntrada['dataCompetencia'] !== "null" ? "'" . $jsonEntrada['dataCompetencia'] . "'" : "CURRENT_TIMESTAMP";
    $idContrato = isset($jsonEntrada['idContrato']) && $jsonEntrada['idContrato'] !== "" && $jsonEntrada['idContrato'] !== "null" ? "'" . $jsonEntrada['idContrato'] . "'" : "null";


    $sql = "INSERT INTO `notasservico`(`idPessoaPrestador`, `idPessoaTomador`, `valorNota`,`codMunicipio`, `condicao`, `descricaoServico`, `dataCompetencia`) 
                                VALUES ($idPessoaPrestador,$idPessoaTomador,$valorNota,$codMunicipio,$condicao, $descricaoServico, $dataCompetencia)";

    //LOG
    if (isset($LOG_NIVEL)) {
        if ($LOG_NIVEL >= 3) {
            fwrite($arquivo, $identificacao . "-SQL->" . $sql . "\n");
        }
    }
    //LOG

    //TRY-CATCH
    try {

        $atualizar1 = mysqli_query($conexao, $sql);
        $idGerado = mysqli_insert_id($conexao); 
        $sql2 = "INSERT INTO notascontrato (idNotaServico, idContrato) VALUES ($idGerado, $idContrato)";
        
   /* echo $sql2; */
        $atualizar2 = mysqli_query($conexao, $sql2);
 
        if (!$atualizar1 && !$atualizar2)
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

<?php
// helio 31012023 criacao
//echo "-ENTRADA->".json_encode($jsonEntrada)."\n";

//LOG
$LOG_CAMINHO = defineCaminhoLog();
if (isset($LOG_CAMINHO)) {
    $LOG_NIVEL = defineNivelLog();
    $identificacao = date("dmYHis") . "-PID" . getmypid() . "-" . "notasservico_alterar";
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
if (isset($jsonEntrada['idNotaServico'])) {
    $idNotaServico = $jsonEntrada['idNotaServico'];
    //Verifica dados da nota
    $sql_consulta = "SELECT * FROM notasservico WHERE idNotaServico = $idNotaServico";
    $buscar_consulta = mysqli_query($conexao, $sql_consulta);
    $row_consulta = mysqli_fetch_array($buscar_consulta, MYSQLI_ASSOC);
    
    $idPessoaTomador  = isset($jsonEntrada['idPessoaTomador'])  && $jsonEntrada['idPessoaTomador'] !== "" && $jsonEntrada['idPessoaTomador'] !== "null" ? "'" . $jsonEntrada['idPessoaTomador']. "'"  : "'" . $row_consulta['idPessoaTomador']. "'";
    $valorNota  = isset($jsonEntrada['valorNota'])  && $jsonEntrada['valorNota'] !== "" && $jsonEntrada['valorNota'] !== "null" ? "'" . $jsonEntrada['valorNota']. "'"  : "'" . $row_consulta['valorNota']. "'";
    $codMunicipio  = isset($jsonEntrada['codMunicipio'])  && $jsonEntrada['codMunicipio'] !== "" && $jsonEntrada['codMunicipio'] !== "null" ? "'" . $jsonEntrada['codMunicipio']. "'"  : "'" . $row_consulta['codMunicipio']. "'";
    $condicao  = isset($jsonEntrada['condicao'])  && $jsonEntrada['condicao'] !== "" && $jsonEntrada['condicao'] !== "null" ? "'" . $jsonEntrada['condicao']. "'"  : "'" . $row_consulta['condicao']. "'";
    $descricaoServico  = isset($jsonEntrada['descricaoServico'])  && $jsonEntrada['descricaoServico'] !== "" && $jsonEntrada['descricaoServico'] !== "null" ? "'" . $jsonEntrada['descricaoServico']. "'"  : "'" . $row_consulta['descricaoServico']. "'";
    $dataCompetencia  = isset($jsonEntrada['dataCompetencia'])  && $jsonEntrada['dataCompetencia'] !== "" && $jsonEntrada['dataCompetencia'] !== "null" ? "'" . $jsonEntrada['dataCompetencia']. "'"  : "'" . $row_consulta['dataCompetencia']. "'";

    $sql = "UPDATE `notasservico` SET `idPessoaTomador`=$idPessoaTomador,`valorNota`= $valorNota,`dataCompetencia`=$dataCompetencia,
                    `codMunicipio`=$codMunicipio,`condicao`=$condicao,`descricaoServico`=$descricaoServico
    WHERE idNotaServico = $idNotaServico";

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

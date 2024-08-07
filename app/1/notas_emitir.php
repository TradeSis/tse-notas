<?php
//gabriel 04122023

//LOG
$LOG_CAMINHO = defineCaminhoLog();
if (isset($LOG_CAMINHO)) {
  $LOG_NIVEL = defineNivelLog();
  $identificacao = date("dmYHis") . "-PID" . getmypid() . "-" . "emitirNota";
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

date_default_timezone_set('America/Sao_Paulo');
$idEmpresa = $jsonEntrada["idEmpresa"];
$conexao = conectaMysql($idEmpresa);
if (isset($jsonEntrada['idNotaServico'])) {

  $idNotaServico = $jsonEntrada['idNotaServico'];
  $dataEmissao = date('Y-m-d H:i:s');

  //Busca parametros nota
  $sql_parametros = "SELECT * FROM notasparametros where idEmpresa = $idEmpresa";
  $buscar_parametros = mysqli_query($conexao, $sql_parametros);
  $parametros = mysqli_fetch_array($buscar_parametros, MYSQLI_ASSOC);

  //Verifica dados da nota
  $sql_consulta = "SELECT * FROM notasservico WHERE idNotaServico = $idNotaServico";
  $buscar_consulta = mysqli_query($conexao, $sql_consulta);
  $row_consulta = mysqli_fetch_array($buscar_consulta, MYSQLI_ASSOC);

  $idPessoaPrestador = $row_consulta['idPessoaPrestador'];
  $idPessoaTomador = $row_consulta['idPessoaTomador'];
  $dataCompetencia = $row_consulta['dataCompetencia'];
  $valorNota = $row_consulta['valorNota'];
  $condicao = $row_consulta['condicao'];
  $descricaoServico = $row_consulta['descricaoServico'];
  $codMunicipio = $row_consulta['codMunicipio'];


  //Busca pessoa
  $sql_consulta1 = "SELECT * FROM pessoas WHERE idPessoa = $idPessoaPrestador";
  $buscar_consulta1 = mysqli_query($conexao, $sql_consulta1);
  $prestador = mysqli_fetch_array($buscar_consulta1, MYSQLI_ASSOC);

  $sql_consulta2 = "SELECT * FROM pessoas WHERE idPessoa = $idPessoaTomador";
  $buscar_consulta2 = mysqli_query($conexao, $sql_consulta2);
  $tomador = mysqli_fetch_array($buscar_consulta2, MYSQLI_ASSOC);

  if ($parametros['fornecedor'] === "nuvemfiscal") {
    $acao = "emitir";
    include 'nuvemfiscal.php';
  }

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
      "retorno" => $retornoNFSE
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


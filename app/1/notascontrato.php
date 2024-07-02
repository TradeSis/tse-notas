<?php
//echo "-ENTRADA->".json_encode($jsonEntrada)."\n";

//LOG
$LOG_CAMINHO = defineCaminhoLog();
if (isset($LOG_CAMINHO)) {
  $LOG_NIVEL = defineNivelLog();
  $identificacao = date("dmYHis") . "-PID" . getmypid() . "-" . "notascontrato";
  if (isset($LOG_NIVEL)) {
    if ($LOG_NIVEL >= 1) {
      $arquivo = fopen(defineCaminhoLog() . "notascontrato_" . date("dmY") . ".log", "a");
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

$idEmpresa = null;
if (isset($jsonEntrada["idEmpresa"])) {
  $idEmpresa = $jsonEntrada["idEmpresa"];
}

$conexao = conectaMysql($idEmpresa);
$notas = array();

$sql = "SELECT notascontrato.*, notasservico.*, prestador.nomePessoa as nomePessoaPrestador, tomador.nomePessoa as nomePessoaTomador FROM notascontrato 
        INNER JOIN notasservico on notasservico.idNotaServico = notascontrato.idNotaServico
        LEFT JOIN pessoas as prestador ON prestador.idPessoa = notasservico.idPessoaPrestador
        LEFT JOIN pessoas as tomador ON tomador.idPessoa = notasservico.idPessoaTomador  ";
if (isset($jsonEntrada["idContrato"])) {
  $sql = $sql . " where idContrato = " . $jsonEntrada["idContrato"];
}  

//LOG
if (isset($LOG_NIVEL)) {
  if ($LOG_NIVEL >= 3) {
    fwrite($arquivo, $identificacao . "-SQL->" . $sql . "\n");
  }
}
//LOG

$rows = 0;
$buscar = mysqli_query($conexao, $sql);
while ($row = mysqli_fetch_array($buscar, MYSQLI_ASSOC)) {
  array_push($notas, $row);
  $rows = $rows + 1;
}

if (isset($jsonEntrada["idNotaServico"]) && $rows == 1) {
  $notas = $notas[0];
}
$jsonSaida = $notas;


//LOG
if (isset($LOG_NIVEL)) {
  if ($LOG_NIVEL >= 2) {
    fwrite($arquivo, $identificacao . "-SAIDA->" . json_encode($jsonSaida) . "\n\n");
  }
}
//LOG

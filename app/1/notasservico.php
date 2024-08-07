<?php
// Lucas 120923 - $jsonEntrada["buscanotas"] pode trazer os valores de idNotasServico ou numeroNota
//echo "-ENTRADA->".json_encode($jsonEntrada)."\n";

//LOG
$LOG_CAMINHO = defineCaminhoLog();
if (isset($LOG_CAMINHO)) {
  $LOG_NIVEL = defineNivelLog();
  $identificacao = date("dmYHis") . "-PID" . getmypid() . "-" . "notasservico";
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

$idEmpresa = null;
if (isset($jsonEntrada["idEmpresa"])) {
  $idEmpresa = $jsonEntrada["idEmpresa"];
}

$conexao = conectaMysql($idEmpresa);
$notas = array();

$sql = "SELECT notasservico.*, prestador.nomePessoa as nomePessoaPrestador, tomador.nomePessoa as nomePessoaTomador FROM notasservico 
        LEFT JOIN pessoas as prestador ON prestador.idPessoa = notasservico.idPessoaPrestador
        LEFT JOIN pessoas as tomador ON tomador.idPessoa = notasservico.idPessoaTomador ";
if (isset($jsonEntrada["idNotaServico"])) {
  $sql = $sql . " where notasservico.idNotaServico = " . $jsonEntrada["idNotaServico"];
} else {
  $where = " where ";
  if (isset($jsonEntrada["buscanotas"])) {
    $sql = $sql . $where . " notasservico.idNotaServico="  . $jsonEntrada["buscanotas"] . " or . notasservico.numeroNota like " . "'%" . $jsonEntrada["buscanotas"] . "%'" ;
    $where = " and ";
  }
  if (isset($jsonEntrada["idPessoaPrestador"])) {
    $sql = $sql . $where . " notasservico.idPessoaPrestador = " . $jsonEntrada["idPessoaPrestador"] ;
    $where = " and ";
  }
  if (isset($jsonEntrada["statusNota"])) {
    $sql = $sql . $where . " notasservico.statusNota like " . $jsonEntrada["statusNota"];
    $where = " and ";
  }
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

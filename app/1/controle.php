<?php

//echo "metodo=".$metodo."\n";
//echo "funcao=".$funcao."\n";
//echo "parametro=".$parametro."\n";

if ($metodo == "GET") {

  switch ($funcao) {

    case "notasservico":
      include 'notasservico.php';
      break;

    case "notascontrato":
      include 'notascontrato.php';
      break;

    case "notasparametros":
      include 'notasparametros.php';
      break;
    
    default:
      $jsonSaida = json_decode(json_encode(
        array(
          "status" => "400",
          "retorno" => "Aplicacao " . $aplicacao . " Versao " . $versao . " Funcao " . $funcao . " Invalida" . " Metodo " . $metodo . " Invalido "
        )
      ), TRUE);
      break;
  }
}

if ($metodo == "PUT") {
  switch ($funcao) {

    case "notasservico":
      include 'notasservico_inserir.php';
      break;

    case "notascontrato":
      include 'notascontrato_inserir.php';
      break;
  
    case "notasparametros":
      include 'notasparametros_inserir.php';
      break;
  

    default:
      $jsonSaida = json_decode(json_encode(
        array(
          "status" => "400",
          "retorno" => "Aplicacao " . $aplicacao . " Versao " . $versao . " Funcao " . $funcao . " Invalida" . " Metodo " . $metodo . " Invalido "
        )
      ), TRUE);
      break;
  }
}

if ($metodo == "POST") {

  switch ($funcao) {

    case "notasservico":
      include 'notasservico_alterar.php';
      break;

    case "notasparametros":
      include 'notasparametros_alterar.php';
      break;

    case "emitirnota":
      include 'notas_emitir.php';
      break;

    case "baixarnota":
      include 'notas_baixar.php';
      break;

    case "buscarnota":
      include 'notas_buscar.php';
      break;

      default:
      $jsonSaida = json_decode(json_encode(
        array(
          "status" => "400",
          "retorno" => "Aplicacao " . $aplicacao . " Versao " . $versao . " Funcao " . $funcao . " Invalida" . " Metodo " . $metodo . " Invalido "
        )
      ), TRUE);
      break;
  }
}

if ($metodo == "DELETE") {
  switch ($funcao) {

    case "notasservico":
      include 'notasservico_excluir.php';
      break;



    default:
      $jsonSaida = json_decode(json_encode(
        array(
          "status" => "400",
          "retorno" => "Aplicacao " . $aplicacao . " Versao " . $versao . " Funcao " . $funcao . " Invalida" . " Metodo " . $metodo . " Invalido "
        )
      ), TRUE);
      break;
  }
}

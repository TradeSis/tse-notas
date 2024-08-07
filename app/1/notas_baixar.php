<?php
//gabriel 04122023
$idEmpresa = $jsonEntrada["idEmpresa"];
$conexao = conectaMysql($idEmpresa);
if (isset($jsonEntrada['idNotaServico'])) {

    $idNotaServico = $jsonEntrada['idNotaServico'];
    $visualizar = $jsonEntrada['visualizar'];

    //Busca parametros nota
    $sql_parametros = "SELECT * FROM notasparametros where idEmpresa = $idEmpresa";
    $buscar_parametros = mysqli_query($conexao, $sql_parametros);
    $parametros = mysqli_fetch_array($buscar_parametros, MYSQLI_ASSOC);

    //Verifica dados da nota
    $sql_consulta = "SELECT * FROM notasservico WHERE idNotaServico = $idNotaServico";
    $buscar_consulta = mysqli_query($conexao, $sql_consulta);
    $row_consulta = mysqli_fetch_array($buscar_consulta, MYSQLI_ASSOC);

    $idProvedor = $row_consulta['idProvedor'];

    $jsonSaida = array(
        "status" => 200,
        "retorno" => "ok"
    );

    if ($parametros['fornecedor'] === "nuvemfiscal") {
        $acao = "baixar";
        include 'nuvemfiscal.php';
    }
   

} else {
    $jsonSaida = array(
        "status" => 400,
        "retorno" => "Faltaram parametros"
    );
}

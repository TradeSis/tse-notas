<?php

//Chamar Function config nuvemfiscal
$config = NuvemFiscal\Configuration::getDefaultConfiguration()
    ->setHost('https://api.sandbox.nuvemfiscal.com.br')
    ->setApiKey('Authorization', 'Bearer')
    ->setAccessToken($parametros['access_token']);
$apiInstance = new NuvemFiscal\Api\NfseApi(
    new GuzzleHttp\Client(),
    $config
);

$retornoNFSE = "ok";

if ($acao == "emitir") {

    //montagem json começo *******************
    $endNac = array(
        'cMun' => $codMunicipio,
        'CEP' => $tomador['cep']
    );
    $end = array(
        'endNac' => $endNac,
        'xLgr' => $tomador['endereco'],
        'nro' => $tomador['endNumero'],
        'xBairro' => $tomador['bairro']
    );
    $prest = array(
        'CNPJ' => $prestador['cpfCnpj']
    );
    $toma = array(
        'CNPJ' => $tomador['cpfCnpj'],
        'xNome' => $tomador['nomePessoa'],
        'end' => $end
    );
    $locPrest = array(
        'cLocPrestacao' => $codMunicipio
    );
    $cServ = array(
        'cTribNac' => $parametros['cTribNac'],
        'xDescServ' => $descricaoServico,
        'cNBS' => $parametros['cNBS']
    );
    $serv = array(
        'locPrest' => $locPrest,
        'cServ' => $cServ
    );
    $tribMun = array(
        'tribISSQN' => intval($parametros['tribISSQN']),
        'tpRetISSQN' => intval($parametros['tpRetISSQN'])
    );
    // *********** Calculo PIS e COFINS *********** //
    $vPis = floatval(number_format($valorNota * ($parametros['pAliqPis'] / 100), 2, '.', ''));
    $vCofins = floatval(number_format($valorNota * ($parametros['pAliqCofins'] / 100), 2, '.', ''));
    $piscofins = array(
        'CST' => $parametros['CST'],
        'vBCPisCofins' => floatval($valorNota),
        'pAliqPis' => floatval($parametros['pAliqPis']),
        'pAliqCofins' => floatval($parametros['pAliqCofins']),
        'vPis' => $vPis,
        'vCofins' => $vCofins,
        'tpRetPisCofins' => intval($parametros['tpRetPisCofins'])
    );
    $tribFed = array(
        'piscofins' => $piscofins
    );
    $vTotTrib = array(
        'vTotTribFed' => floatval($parametros['vTotTribFed']),
        'vTotTribEst' => intval($parametros['vTotTribEst']),
        'vTotTribMun' => intval($parametros['vTotTribMun'])
    );
    $totTrib = array(
        'vTotTrib' => $vTotTrib
    );
    $trib = array(
        'tribMun' => $tribMun,
        'tribFed' => $tribFed,
        'totTrib' => $totTrib
    );
    $vServPrest = array(
        'vServ' => floatval($valorNota)
    );
    $valores = array(
        'vServPrest' => $vServPrest,
        'trib' => $trib
    );
    $infDPS = array(
        'tpAmb' => intval($parametros['tpAmb']),
        'dhEmi' => $dataEmissao,
        'verAplic' => $parametros['verAplic'],
        'dCompet' => $dataCompetencia,
        'prest' => $prest,
        'toma' => $toma,
        'serv' => $serv,
        'valores' => $valores
    );
    $jsonEmissao = array(
        'provedor' => $parametros['provedor'],
        'ambiente' => $parametros['ambiente'],
        'infDPS' => $infDPS
    );
    //montagem json fim *******************

    //LOG
    if (isset($LOG_NIVEL)) {
        if ($LOG_NIVEL >= 3) {
            fwrite($arquivo, $identificacao . "-jsonEmissao->" . json_encode($jsonEmissao) . "\n");
        }
    }
    //LOG  

    $body = $jsonEmissao;
    $nfse = $apiInstance->emitirNfseDps($body);

    //LOG
    if (isset($LOG_NIVEL)) {
        if ($LOG_NIVEL >= 3) {
            fwrite($arquivo, $identificacao . "-NFSE->" . $nfse . "\n");
        }
    }
    //LOG

    sleep(2);
    $dadosNFSE = $apiInstance->consultarNfse($nfse['id']);

    //LOG
    if (isset($LOG_NIVEL)) {
        if ($LOG_NIVEL >= 3) {
            fwrite($arquivo, $identificacao . "-dadosNFSE->" . $dadosNFSE . "\n");
        }
    }
    //LOG

    if ($dadosNFSE['status'] === "processando") {
        $statusNota = 1; //Processando
    }
    if ($dadosNFSE['status'] === "autorizada") {
        $statusNota = 2; //Autorizada/Emitida
        $dataEmissao = $dadosNFSE['data_emissao']->format('Y-m-d H:i:s');
        $serie = $dadosNFSE->getDPS()->getSerie();
        $nDPS = $dadosNFSE->getDPS()->getNDPS();

    }
    if ($dadosNFSE['status'] === "negada") {
        $statusNota = 3; //Negada
        $retornoNFSE = isset($dadosNFSE['mensagens'][0]['descricao']) ? $dadosNFSE['mensagens'][0]['descricao'] : "erro generico";
    }

    $sql = "UPDATE `notasservico` SET `statusNota`='$statusNota', `idProvedor`='" . $dadosNFSE['id'] . "', `provedor`='" . $parametros['fornecedor'] . "' ";

    if ($dadosNFSE['status'] === "autorizada") {
        $sql = $sql . " , `dataEmissao`='$dataEmissao', `url`='" . $dadosNFSE['link_url'] . "', `CodVerifica`='" . $dadosNFSE['codigo_verificacao'] . "',
        `serieDPS`='$serie', `numeroDPS`='$nDPS', `serieNota`='$serie', `numeroNota`='" . $dadosNFSE['numero'] . "', `XML`='$xmlContent' ";
    }

    $sql = $sql . " WHERE idNotaServico = $idNotaServico";

    
}


if ($acao == "buscar") {
    $dadosNFSE = $apiInstance->consultarNfse($idProvedor);

    //LOG
    if (isset($LOG_NIVEL)) {
        if ($LOG_NIVEL >= 3) {
            fwrite($arquivo, $identificacao . "-dadosNFSE->" . $dadosNFSE . "\n");
        }
    }
    //LOG

    if ($dadosNFSE['status'] == "autorizada") {
        $statusNota = 2; //Autorizada/Emitida
        $retornoNFSE = "ok";
        $dataEmissao = $dadosNFSE['data_emissao']->format('Y-m-d H:i:s');
        $serie = $dadosNFSE->getDPS()->getSerie();
        $nDPS = $dadosNFSE->getDPS()->getNDPS();

        $XML = $apiInstance->baixarXmlNfse($idProvedor);
        $xmlContent = file_get_contents($XML->getPathname());
    } else {
        $statusNota = 3; //Aberto/Negada
        $retornoNFSE = $dadosNFSE['mensagens'][0]['descricao'];
    }

    $sql = "UPDATE `notasservico` SET `statusNota`='$statusNota' ";

    if ($dadosNFSE['status'] === "autorizada") {
        $sql = $sql . " , `dataEmissao`='$dataEmissao', `url`='" . $dadosNFSE['link_url'] . "', `CodVerifica`='" . $dadosNFSE['codigo_verificacao'] . "',
        `serieDPS`='$serie', `numeroDPS`='$nDPS', `serieNota`='$serie', `numeroNota`='" . $dadosNFSE['numero'] . "', `XML`='$xmlContent' ";
    }

    $sql = $sql . " WHERE idNotaServico = $idNotaServico";

}

if ($acao == "baixar") {
    if ($jsonEntrada['visualizar'] == "pdf") {
        $logotipo = null;
        $mensagem_rodape = null;
        $PDF = $apiInstance->baixarPdfNfse($idProvedor, $logotipo, $mensagem_rodape);
        $pdfContent = file_get_contents($PDF->getPathname());
        $base64PdfContent = base64_encode($pdfContent);
        $jsonSaida['pdf_content'] = $base64PdfContent;
    }

    if ($jsonEntrada['visualizar'] == "xml") {

        if (isset($row_consulta['XML']) && !empty($row_consulta['XML'])) {
            $jsonSaida['xml_content'] = $row_consulta['XML'];
        } else {
            $XML = $apiInstance->baixarXmlNfse($idProvedor);
            $xmlContent = file_get_contents($XML->getPathname());
            $jsonSaida['xml_content'] = $xmlContent;


            $sql = "UPDATE `notasservico` SET `XML`='$xmlContent' ";
            $atualizar = mysqli_query($conexao, $sql);
        }
    } 
}

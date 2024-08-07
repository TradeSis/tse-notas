<?php
include_once __DIR__ . "/../conexao.php";

function buscaNotasServico($idNotaServico=null)
{
	
	$notas = array();
	
	$idEmpresa = null;
	if (isset($_SESSION['idEmpresa'])) {
    	$idEmpresa = $_SESSION['idEmpresa'];
	}
	

	$apiEntrada = array(
		'idEmpresa' => $idEmpresa,
		'idNotaServico' => $idNotaServico
		
	);
	
	$notas = chamaAPI(null, '/notas/notasservico', json_encode($apiEntrada), 'GET');

	return $notas;
}


if (isset($_GET['operacao'])) {

	$operacao = $_GET['operacao'];

	if ($operacao=="inserir") {
		$condicao = strip_tags($_POST['condicao']);
		$descricaoServico = strip_tags($_POST['descricaoServico']);
		$apiEntrada = array(
			'idEmpresa' => $_SESSION['idEmpresa'],
			'idPessoaTomador' => $_POST['idPessoaTomador'],
			'dataCompetencia' => $_POST['dataCompetencia'],
    		'valorNota' => $_POST['valorNota'],
    		'codMunicipio' => $_POST['codMunicipio'],
    		'descricaoServico' => $descricaoServico,
    		'condicao' => $condicao
		);
		/* echo json_encode($apiEntrada);
		return; */
		$notas = chamaAPI(null, '/notas/notasservico', json_encode($apiEntrada), 'PUT');
	}

	//chama api de notascontrato onde grava registro na tabela de notasservico e notascontrato
	if ($operacao=="inserir_notascontrato") {
		$condicao = strip_tags($_POST['condicao']);
		$descricaoServico = strip_tags($_POST['descricaoServico']);
		$apiEntrada = array(
			'idEmpresa' => $_SESSION['idEmpresa'],
			'idContrato' => $_POST['idContrato'],
			'idPessoaTomador' => $_POST['idPessoaTomador'],
			'dataCompetencia' => $_POST['dataCompetencia'],
    		'valorNota' => $_POST['valorNota'],
    		'codMunicipio' => $_POST['codMunicipio'],
    		'descricaoServico' => $descricaoServico,
    		'condicao' => $condicao
		);
		/* echo json_encode($apiEntrada);
		return; */
		$notas = chamaAPI(null, '/notas/notascontrato', json_encode($apiEntrada), 'PUT');
		header('Location: ../servicos/contratos/visualizar.php?id=notascontrato&&idContrato=' . $apiEntrada['idContrato']);
	}

	if ($operacao=="alterar") {
		$condicao = strip_tags($_POST['condicao']);
		$descricaoServico = strip_tags($_POST['descricaoServico']);
		$apiEntrada = array(
			'idEmpresa' => $_SESSION['idEmpresa'],
			'idNotaServico' => $_POST['idNotaServico'],
			'idPessoaTomador' => $_POST['idPessoaTomador'],
			'dataCompetencia' => $_POST['dataCompetencia'],
    		'valorNota' => $_POST['valorNota'],
    		'codMunicipio' => $_POST['codMunicipio'],
    		'descricaoServico' => $descricaoServico,
    		'condicao' => $condicao
		);
		/* echo json_encode($apiEntrada);
		return; */
		$notas = chamaAPI(null, '/notas/notasservico', json_encode($apiEntrada), 'POST');
	}




	//busca os dados para passar ao modal de notas Servico 
	if ($operacao == "buscar") {
        $idNotaServico = $_POST['idNotaServico'];
        if ($idNotaServico == "") {
            $idNotaServico = null;
        }
        $apiEntrada = array(
            'idEmpresa' => $_SESSION['idEmpresa'],
            'idNotaServico' => $idNotaServico
        );
        $notas = chamaAPI(null, '/notas/notasservico', json_encode($apiEntrada), 'GET');

        echo json_encode($notas);
        return $notas;
    }

	//chama a api de notascontrato passando idContrato como parametro(usado na tab de contrato) 
	if ($operacao == "buscarnotascontrato") {

		$idContrato = $_POST["idContrato"];

		if ($idContrato == ""){
			$idContrato = null;
		}
	
		$apiEntrada = array(
			'idEmpresa' => $_SESSION['idEmpresa'],
			'idContrato' => $idContrato
			
		);
		
		$notas = chamaAPI(null, '/notas/notascontrato', json_encode($apiEntrada), 'GET');

		echo json_encode($notas);
		return $notas;

	}

	//busca com filtro da tabela principal de notas
	if ($operacao == "filtrar") {

		$buscanotas = $_POST["buscanotas"];
		$idPessoaPrestador = $_POST["idPessoaPrestador"];
		$statusNota = $_POST["statusNota"];

		if ($buscanotas == ""){
			$buscanotas = null;
		}

		if ($idPessoaPrestador == ""){
			$idPessoaPrestador = null;
		}

		if ($statusNota == ""){
			$statusNota = null;
		}
	
		$apiEntrada = array(
			'idEmpresa' => $_SESSION['idEmpresa'],
			'idNotaServico' => null,
			'buscanotas' => $buscanotas,
			'idPessoaPrestador' => $idPessoaPrestador,
			'statusNota' => $statusNota,
		);
		
		$notas = chamaAPI(null, '/notas/notasservico', json_encode($apiEntrada), 'GET');

		echo json_encode($notas);
		return $notas;

	}

	if ($operacao == "emitirnota") {

		$apiEntrada = array(
			'idEmpresa' => $_SESSION['idEmpresa'],
			'idNotaServico' => $_POST['idNotaServico']
		);
		
		$notas = chamaAPI(null, '/notas/emitirnota', json_encode($apiEntrada), 'POST');

		echo json_encode($notas);
		return $notas;
	}
	if ($operacao == "buscarnota") {

		$apiEntrada = array(
			'idEmpresa' => $_SESSION['idEmpresa'],
			'idNotaServico' => $_POST['idNotaServico']
		);
		
		$notas = chamaAPI(null, '/notas/buscarnota', json_encode($apiEntrada), 'POST');

		echo json_encode($notas);
		return $notas;
	}
	if ($operacao == "baixarnota") {

		$apiEntrada = array(
			'idEmpresa' => $_SESSION['idEmpresa'],
			'idNotaServico' => $_POST['idNotaServico'],
			'visualizar' => $_POST['visualizar']
		);
		
		$notas = chamaAPI(null, '/notas/baixarnota', json_encode($apiEntrada), 'POST');

		echo json_encode($notas);
		return $notas;
	}

	

	header('Location: ../notasservico/index.php');
	
}

?>


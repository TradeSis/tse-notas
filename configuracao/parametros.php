<?php
include_once(__DIR__ . '/../header.php');
include_once(__DIR__ . '/../database/notasparametros.php');

$parametros = buscarParametros();
?>
<!doctype html>
<html lang="pt-BR">

<head>

    <?php include_once ROOT . "/vendor/head_css.php"; ?>

</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <BR> <!-- MENSAGENS/ALERTAS -->
        </div>
        <div class="row">
            <BR> <!-- BOTOES AUXILIARES -->
        </div>

        <div class="row align-items-center"> <!-- LINHA SUPERIOR A TABLE -->
            <div class="col-3 text-start">
                <!-- TITULO -->
                <h2 class="ts-tituloPrincipal">Parâmetros NFS-e</h2>
            </div>
            <div class="col-7">
                <!-- FILTROS -->
            </div>

            <div class="col-2 text-end">
                <button type="button" class="btn btn-success mr-4" data-bs-toggle="modal"
                    data-bs-target="#inserirModal"><i class="bi bi-plus-square"></i>&nbsp Novo</button>
            </div>
        </div>

        <div class="table mt-2 ts-divTabela">
            <table class="table table-hover table-sm align-middle">
                <thead class="ts-headertabelafixo">
                    <tr>
                        <th>fornecedor</th>
                        <th>provedor</th>
                        <th>ambiente</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <?php foreach ($parametros as $parametro) { ?>
                    <tr>
                        <td><?php echo $parametro['fornecedor'] ?></td>
                        <td><?php echo $parametro['provedor'] ?></td>
                        <td><?php echo $parametro['ambiente'] ?></td>
                        <td><button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#alterarmodal" 
                            data-idEmpresa="<?php echo $parametro['idEmpresa'] ?>"><i class="bi bi-pencil-square"></i></button>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </div>
    </div>

    <!--------- INSERIR --------->
    <div class="modal" id="inserirModal" tabindex="-1" aria-labelledby="inserirModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Inserir Parâmetros</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" id="inserirForm">
                        <div class="row">
                            <div class="col-md">
                                <div class="row mt-3">
                                    <div class="col-md-3">
                                        <label class="form-label ts-label">fornecedor</label>
                                        <input type="text" class="form-control ts-input" name="fornecedor">
                                    </div>
                                    <div class="col-md-9">
                                        <label class="form-label ts-label">access_token</label>
                                        <input type="text" class="form-control ts-input" name="access_token">
                                    </div>
                                </div><!--fim row 1-->
                                <div class="row mt-3">
                                    <div class="col-md-3">
                                        <label class="form-label ts-label">provedor</label>
                                        <input type="text" class="form-control ts-input" name="provedor">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label ts-label">ambiente</label>
                                        <input type="text" class="form-control ts-input" name="ambiente">
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label ts-label">tpAmb</label>
                                        <input type="text" class="form-control ts-input" name="tpAmb">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label ts-label">verAplic</label>
                                        <input type="text" class="form-control ts-input" name="verAplic">
                                    </div>
                                </div><!--fim row 2-->
                                <div class="row mt-3">
                                    <div class="col-md-3">
                                        <label class="form-label ts-label">cTribNac</label>
                                        <input type="text" class="form-control ts-input" name="cTribNac">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label ts-label">cNBS</label>
                                        <input type="text" class="form-control ts-input" name="cNBS">
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label ts-label">tribISSQN</label>
                                        <input type="text" class="form-control ts-input" name="tribISSQN">
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label ts-label">tpRetISSQN</label>
                                        <input type="text" class="form-control ts-input" name="tpRetISSQN">
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label ts-label">CST</label>
                                        <input type="text" class="form-control ts-input" name="CST">
                                    </div>
                                </div><!--fim row 3-->
                                <div class="row mt-3">
                                    <div class="col-md-2">
                                        <label class="form-label ts-label">pAliqPis</label>
                                        <input type="number" class="form-control ts-input" name="pAliqPis">
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label ts-label">pAliqCofins</label>
                                        <input type="number" class="form-control ts-input" name="pAliqCofins">
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label ts-label">tpRetPisCofins</label>
                                        <input type="number" class="form-control ts-input" name="tpRetPisCofins">
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label ts-label">vTotTribFed</label>
                                        <input type="number" class="form-control ts-input" name="vTotTribFed">
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label ts-label">vTotTribEst</label>
                                        <input type="number" class="form-control ts-input" name="vTotTribEst">
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label ts-label">vTotTribMun</label>
                                        <input type="number" class="form-control ts-input" name="vTotTribMun">
                                    </div>
                                </div>
                            </div>
                        </div>
                </div><!--body-->
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Cadastrar</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <!--------- ALTERAR --------->
    <div class="modal" id="alterarmodal" tabindex="-1" aria-labelledby="alterarmodalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Alterar Parâmetros</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" id="alterarForm">
                        <div class="row">
                            <div class="col-md">
                                <div class="row mt-3">
                                    <div class="col-md-3">
                                        <label class="form-label ts-label">fornecedor</label>
                                        <input type="text" class="form-control ts-input" name="fornecedor" id="fornecedor">
                                        <input type="hidden" class="form-control ts-input" name="idEmpresa" id="idEmpresa">
                                    </div>
                                    <div class="col-md-9">
                                            <label class="form-label ts-label">access_token</label>
                                            <input type="text" class="form-control ts-input" name="access_token" id="access_token">
                                    </div>
                                </div><!--fim row 1-->
                                <div class="row mt-3">
                                    <div class="col-md-3">
                                        <label class="form-label ts-label">provedor</label>
                                        <input type="text" class="form-control ts-input" name="provedor" id="provedor">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label ts-label">ambiente</label>
                                        <input type="text" class="form-control ts-input" name="ambiente" id="ambiente">
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label ts-label">tpAmb</label>
                                        <input type="text" class="form-control ts-input" name="tpAmb" id="tpAmb">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label ts-label">verAplic</label>
                                        <input type="text" class="form-control ts-input" name="verAplic" id="verAplic">
                                    </div>
                                </div><!--fim row 2-->
                                <div class="row mt-3">
                                    <div class="col-md-3">
                                        <label class="form-label ts-label">cTribNac</label>
                                        <input type="text" class="form-control ts-input" name="cTribNac" id="cTribNac">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label ts-label">cNBS</label>
                                        <input type="text" class="form-control ts-input" name="cNBS" id="cNBS">
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label ts-label">tribISSQN</label>
                                        <input type="text" class="form-control ts-input" name="tribISSQN" id="tribISSQN">
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label ts-label">tpRetISSQN</label>
                                        <input type="text" class="form-control ts-input" name="tpRetISSQN" id="tpRetISSQN">
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label ts-label">CST</label>
                                        <input type="text" class="form-control ts-input" name="CST" id="CST">
                                    </div>
                                </div><!--fim row 3-->
                                <div class="row mt-3">
                                    <div class="col-md-2">
                                        <label class="form-label ts-label">pAliqPis</label>
                                        <input type="text" class="form-control ts-input" name="pAliqPis" id="pAliqPis">
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label ts-label">pAliqCofins</label>
                                        <input type="text" class="form-control ts-input" name="pAliqCofins" id="pAliqCofins">
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label ts-label">tpRetPisCofins</label>
                                        <input type="text" class="form-control ts-input" name="tpRetPisCofins" id="tpRetPisCofins">
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label ts-label">vTotTribFed</label>
                                        <input type="text" class="form-control ts-input" name="vTotTribFed" id="vTotTribFed">
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label ts-label">vTotTribEst</label>
                                        <input type="text" class="form-control ts-input" name="vTotTribEst" id="vTotTribEst">
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label ts-label">vTotTribMun</label>
                                        <input type="text" class="form-control ts-input" name="vTotTribMun" id="vTotTribMun">
                                    </div>
                                </div>
                            </div>
                        </div>
                </div><!--body-->
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Salvar</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <!-- LOCAL PARA COLOCAR OS JS -->

    <?php include_once ROOT . "/vendor/footer_js.php"; ?>

    <script>

        $(document).ready(function () {

            $(document).on('click', 'button[data-bs-target="#alterarmodal"]', function () {
                var idEmpresa = $(this).attr("data-idEmpresa");
                $.ajax({
                    type: 'POST',
                    dataType: 'json',
                    url: '../database/notasparametros.php?operacao=buscar',
                    data: {
                        idEmpresa: idEmpresa
                    },
                    success: function (data) {
                        $('#idEmpresa').val(data.idEmpresa);
                        $('#fornecedor').val(data.fornecedor);
                        $('#access_token').val(data.access_token);
                        $('#provedor').val(data.provedor);
                        $('#ambiente').val(data.ambiente);
                        $('#tpAmb').val(data.tpAmb);
                        $('#verAplic').val(data.verAplic);
                        $('#cTribNac').val(data.cTribNac);
                        $('#cNBS').val(data.cNBS);
                        $('#tribISSQN').val(data.tribISSQN);
                        $('#tpRetISSQN').val(data.tpRetISSQN);
                        $('#CST').val(data.CST);
                        $('#pAliqPis').val(data.pAliqPis);
                        $('#pAliqCofins').val(data.pAliqCofins);
                        $('#tpRetPisCofins').val(data.tpRetPisCofins);
                        $('#vTotTribFed').val(data.vTotTribFed);
                        $('#vTotTribEst').val(data.vTotTribEst);
                        $('#vTotTribMun').val(data.vTotTribMun);
                        $('#alterarmodal').modal('show');
                    }
                });
            });

            $("#inserirForm").submit(function (event) {
                event.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    url: "../database/notasparametros.php?operacao=inserir",
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: refreshPage,
                });
            });

            $("#alterarForm").submit(function (event) {
                event.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    url: "../database/notasparametros.php?operacao=alterar",
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: refreshPage,
                });
            });

            function refreshPage() {
                window.location.reload();
            }

        });
    </script>

    <!-- LOCAL PARA COLOCAR OS JS -FIM -->

</body>

</html>
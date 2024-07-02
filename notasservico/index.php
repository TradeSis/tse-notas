<?php
// lucas 11102023 novo padrao
include_once(__DIR__ . '/../header.php');
include_once(__DIR__ . '/../database/notasservico.php');
include_once(ROOT . '/cadastros/database/pessoas.php');

$pessoas = buscarPessoa();
$cidades = buscarCidades();
?>
<!doctype html>
<html lang="pt-BR">

<head>

    <?php include_once ROOT . "/vendor/head_css.php"; ?>
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

</head>

<body>
    <div class="container-fluid">

        <div class="row">
            <!-- MENSAGENS/ALERTAS -->
        </div>
        <div class="row">
            <!-- BOTOES AUXILIARES -->
        </div>

        <div class="row d-flex align-items-center justify-content-center mt-1 pt-1 ">

            <div class="col-2 col-lg-1 order-lg-1">
                <button class="btn btn-outline-secondary ts-btnFiltros" type="button"><i
                        class="bi bi-funnel"></i></button>
            </div>

            <div class="col-4 col-lg-3 order-lg-2">

                <h2 class="ts-tituloPrincipal">Notas Serviço</h2>
                <span>Filtro Aplicado</span>

            </div>
            <div class="col-6 col-lg-2 order-lg-3">
                <!-- FILTRO -->
            </div>
            <div class="col-12 col-lg-6 order-lg-4">
                <div class="input-group">
                    <input type="text" class="form-control ts-input" id="buscanotas"
                        placeholder="Buscar por id ou numero da nota">
                    <button class="btn btn-primary rounded" type="button" id="buscar"><i
                            class="bi bi-search"></i></button>
                    <button type="button" class="ms-4 btn btn-success" data-bs-toggle="modal"
                        data-bs-target="#inserirModal"><i class="bi bi-plus-square"></i>&nbsp Novo</button>
                </div>
            </div>

        </div>


        <!-- MENUFILTROS -->
        <div class="ts-menuFiltros mt-2 px-3">
            <label>Filtrar por:</label>
            <div class="col-12">
                <form class="d-flex" action="" method="post">
                    <select class="form-control" name="idPessoaPrestador" id="FiltroPessoas">
                        <option value="<?php echo null ?>">
                            <?php echo "Pessoa" ?>
                        </option>
                        <?php
                        foreach ($pessoas as $pessoa) {
                            ?>
                            <option <?php
                            /*  if ($pessoa['idPessoa'] == $idPessoa) {
                                echo "selected";
                            } */
                            ?> value="<?php echo $pessoa['idPessoa'] ?>">
                                <?php echo $pessoa['nomePessoa'] ?>
                            </option>
                        <?php } ?>
                    </select>
                </form>
            </div>
            <div class="col-12 mt-2">
                <form class="d-flex" action="" method="post">
                    <select class="form-control" name="statusNota" id="FiltroStatusNota">
                        <option value="<?php echo null ?>">
                            <?php echo "statusNota" ?>
                        </option>
                        <option value="0">Aberto</option>
                        <option value="1">Emitida</option>
                        <option value="2">Recebida</option>
                        <option value="3">Cancelada</option>
                    </select>
                </form>
            </div>


            <div class="col-sm text-end mt-2">
                <a onClick="limpar()" role=" button" class="btn btn-sm bg-info text-white">Limpar</a>
            </div>
        </div>

        <div class="table mt-2 ts-divTabela ts-tableFiltros text-center">
            <table class="table table-sm table-hover">
                <thead class="ts-headertabelafixo">
                    <tr>
                        <th>Nota</th>
                        <th>Tomador</th>
                        <th>Competencia</th>
                        <th>Emissao</th>
                        <th>Serie</th>
                        <th>Número</th>
                        <th>serieDPS</th>
                        <th>numeroDPS</th>
                        <th>Valor</th>
                        <th>Status</th>
                        <th colspan="2">Ação</th>
                    </tr>
                </thead>

                <tbody id='dados' class="fonteCorpo">

                </tbody>
            </table>
        </div>



        <!--------- INSERIR --------->
        <div class="modal fade bd-example-modal-lg" id="inserirModal" tabindex="-1" aria-labelledby="inserirModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Inserir Nota</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="post" id="inserirFormNotaServico">
                            <div class="row mt-2">
                                <div class="col-md-4">
                                    <label class="form-label ts-label">Tomador/Cliente</label>
                                    <select class="form-select ts-input" name="idPessoaTomador">
                                        <?php
                                        foreach ($pessoas as $pessoa) {
                                            ?>
                                        <option value="<?php echo $pessoa['idPessoa'] ?>">
                                            <?php echo $pessoa['nomePessoa'] ?>
                                        </option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class='form-label ts-label'>Competência</label>
                                    <input type="date" class="form-control ts-input" name="dataCompetencia"
                                        autocomplete="off">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label ts-label">Município</label>
                                    <select class="form-select ts-input" name="codMunicipio">
                                        <?php
                                        foreach ($cidades as $cidade) {
                                            ?>
                                        <option value="<?php echo $cidade['codigoCidade'] ?>">
                                            <?php echo $cidade['nomeCidade'] ?>
                                        </option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label class='form-label ts-label'>valorNota</label>
                                    <input type="text" class="form-control ts-input" name="valorNota" autocomplete="off"
                                        required>
                                </div>
                                
                            </div>
                            <div class="row mt-2">
                                <div class="col">
                                    <span class="tituloEditor">Descrição/Título Serviço</span>
                                </div>
                                <div class="quill-descricaoServicoinserir" style="height:20vh !important"></div>
                                <textarea style="display: none" id="quill-descricaoServicoinserir" name="descricaoServico"></textarea>
                            </div>
                            <div class="row mt-2">
                                <div class="col">
                                    <span class="tituloEditor">condicao</span>
                                </div>
                                <div class="quill-condicaoinserir" style="height:20vh !important"></div>
                                <textarea style="display: none" id="quill-condicaoinserir" name="condicao"></textarea>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Cadastrar</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>

        <!--------- ALTERAR --------->
        <div class="modal fade bd-example-modal-lg" id="alterarModal" tabindex="-1" aria-labelledby="alterarModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Alterar Nota</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="post" id="alterarFormNotaServico">
                            <div class="row mt-2">
                                <div class="col-md-4">
                                    <label class="form-label ts-label">Tomador/Cliente</label>
                                    <select class="form-select ts-input" name="idPessoaTomador" id="idPessoaTomador">
                                        <?php
                                        foreach ($pessoas as $pessoa) {
                                            ?>
                                        <option value="<?php echo $pessoa['idPessoa'] ?>">
                                            <?php echo $pessoa['nomePessoa'] ?>
                                        </option>
                                        <?php } ?>
                                    </select>
                                    <input type="hidden" class="form-control ts-input" name="idNotaServico" id="idNotaServico">
                                </div>
                                <div class="col-md-3">
                                    <label class='form-label ts-label'>Competência</label>
                                    <input type="date" class="form-control ts-input" name="dataCompetencia" id="dataCompetencia">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label ts-label">Município</label>
                                    <select class="form-select ts-input" name="codMunicipio" id="codMunicipio">
                                        <?php
                                        foreach ($cidades as $cidade) {
                                            ?>
                                        <option value="<?php echo $cidade['codigoCidade'] ?>">
                                            <?php echo $cidade['nomeCidade'] ?>
                                        </option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label class='form-label ts-label'>valorNota</label>
                                    <input type="text" class="form-control ts-input" name="valorNota" id="valorNota" required>
                                </div>
                                
                            </div>
                            <div class="row mt-2">
                                <div class="col">
                                    <span class="tituloEditor">Descrição/Título Serviço</span>
                                </div>
                                <div class="quill-descricaoServicoalterar" style="height:20vh !important"></div>
                                <textarea style="display: none" id="quill-descricaoServicoalterar" name="descricaoServico"></textarea>
                            </div>
                            <div class="row mt-2">
                                <div class="col">
                                    <span class="tituloEditor">condicao</span>
                                </div>
                                    <div class="quill-condicaoalterar" style="height:20vh !important"></div>
                                    <textarea style="display: none" id="quill-condicaoalterar" name="condicao"></textarea>
                                </div>
                            </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success" id="salvarBtn">Salvar</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>


        <!--------- VISUALIZAR --------->
        <div class="modal fade bd-example-modal-lg" id="visualizarModal" tabindex="-1"
            aria-labelledby="visualizarModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Visualizar Nota</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="pdfViewer"></div>
                        <div id="xmlViewer"></div>
                    </div>
                </div>
            </div>
        </div>

    </div><!--container-fluid-->

    <!-- LOCAL PARA COLOCAR OS JS -->

    <?php include_once ROOT . "/vendor/footer_js.php"; ?>
    <!-- QUILL editor -->
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
    <!-- script para menu de filtros -->
    <script src="<?php echo URLROOT ?>/sistema/js/filtroTabela.js"></script>
    <script>
        buscar($("#FiltroPessoas").val(), $("#buscanotas").val(), $("#FiltroStatusNota").val());

        function limpar() {
            buscar(null, null, null, null);
            window.location.reload();
        }

        function buscar(idPessoaPrestador, buscanotas, statusNota) {
            //alert (buscanotas);
            $.ajax({
                type: 'POST',
                dataType: 'html',
                url: '<?php echo URLROOT ?>/notas/database/notasservico.php?operacao=filtrar',
                beforeSend: function () {
                    $("#dados").html("Carregando...");
                },
                data: {
                    idPessoaPrestador: idPessoaPrestador,
                    buscanotas: buscanotas,
                    statusNota: statusNota
                },
                success: function (msg) {

                    var json = JSON.parse(msg);
                    var linha = "";
                    for (var $i = 0; $i < json.length; $i++) {
                        var object = json[$i];

                        function formatDate(dateString) {
                            if (dateString !== null && !isNaN(new Date(dateString))) {
                                var date = new Date(dateString);
                                var day = date.getUTCDate().toString().padStart(2, '0');
                                var month = (date.getUTCMonth() + 1).toString().padStart(2, '0');
                                var year = date.getUTCFullYear().toString().padStart(4, '0');
                                return day + "/" + month + "/" + year;
                            }
                            return "";
                        }

                        var dataCompetenciaFormatada = formatDate(object.dataCompetencia);
                        var dataEmissaoFormatada = formatDate(object.dataEmissao);

                        if (object.statusNota == 0) {
                            var novoStatusNota = "Aberto";
                        }
                        if (object.statusNota == 1) {
                            var novoStatusNota = "Processando";
                        }
                        if (object.statusNota == 2) {
                            var novoStatusNota = "Autorizada";
                        }
                        if (object.statusNota == 3) {
                            var novoStatusNota = "Negada";
                        }
                        if (object.statusNota == 4) {
                            var novoStatusNota = "Cancelada";
                        }

                        linha += "<tr>";
                        linha += "<td>" + object.idNotaServico + "</td>";
                        linha += "<td>" + object.nomePessoaTomador + "</td>";
                        linha += "<td>" + dataCompetenciaFormatada + "</td>";
                        linha += "<td>" + dataEmissaoFormatada + "</td>";
                        linha += "<td>" + object.serieNota + "</td>";
                        linha += "<td>" + object.numeroNota + "</td>";
                        linha += "<td>" + object.serieDPS + "</td>";
                        linha += "<td>" + object.numeroDPS + "</td>";
                        linha += "<td>" + object.valorNota + "</td>";
                        linha += "<td>" + novoStatusNota + "</td>";
                        linha += "<td>";
                        if (object.statusNota == 0 || object.statusNota == 3) {
                            linha += "<button type='button' class='btn btn-success btn-sm' id='emitir' data-idNotaServico='" + object.idNotaServico + "' title='Emitir Nota'><i class='bi bi-file-earmark-plus-fill'></i></button>";
                            linha += "<button type='button' class='btn btn-warning btn-sm' data-bs-toggle='modal' data-bs-target='#alterarModal' data-idNotaServico='" + object.idNotaServico + "'><i class='bi bi-pencil-square'></i></button>";
                        }
                        if (object.statusNota == 1) {
                            linha += "<button type='button' class='btn btn-success btn-sm' id='consulta' data-idNotaServico='" + object.idNotaServico + "' title='Atualizar'><i class='bi bi-arrow-clockwise'></i></button>";
                        }
                        if (object.statusNota == 2) {
                            linha += "<button type='button' class='btn btn-primary btn-sm' id='xml' data-idNotaServico='" + object.idNotaServico + "' title='Visualizar XML'><i class='bi bi-filetype-xml'></i></button>";
                            linha += "<button type='button' class='btn btn-info btn-sm' id='pdf' data-idNotaServico='" + object.idNotaServico + "' title='Visualizar PDF'><i class='bi bi-filetype-pdf'></i></button>";
                        }
                        linha += "</td>";
                        linha += "</tr>";
                    }
                    $("#dados").html(linha);
                }
            });
        }

        $("#FiltroPessoas").change(function () {
            buscar($("#FiltroPessoas").val(), $("#buscanotas").val(), $("#FiltroStatusNota").val());
        })

        $("#buscar").click(function () {
            buscar($("#FiltroPessoas").val(), $("#buscanotas").val(), $("#FiltroStatusNota").val());
        })

        $("#FiltroStatusNota").change(function () {
            buscar($("#FiltroPessoas").val(), $("#buscanotas").val(), $("#FiltroStatusNota").val());
        })

        document.addEventListener("keypress", function (e) {
            if (e.key === "Enter") {
                buscar($("#FiltroPessoas").val(), $("#buscanotas").val(), $("#FiltroStatusNota").val());
            }
        });

        $(document).on('click', 'button[data-bs-target="#alterarModal"]', function () {
            var idNotaServico = $(this).attr("data-idNotaServico");
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: '<?php echo URLROOT ?>/notas/database/notasservico.php?operacao=buscar',
                data: {
                    idNotaServico: idNotaServico
                },
                success: function (data) {
                    condicaoalterar.root.innerHTML = data.condicao;
                    descricaoServicoalterar.root.innerHTML = data.descricaoServico;
                    $('#idNotaServico').val(data.idNotaServico);
                    $('#idPessoaTomador').val(data.idPessoaTomador);
                    $('#dataCompetencia').val(data.dataCompetencia);
                    $('#valorNota').val(data.valorNota);
                    $('#codMunicipio').val(data.codMunicipio);
                    $('#alterarModal').modal('show');
                }
            });
        });

        $(document).on('click', '#emitir', function () {
            var idNotaServico = $(this).attr("data-idNotaServico");
            $('body').css('cursor', 'wait');
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: '<?php echo URLROOT ?>/notas/database/notasservico.php?operacao=emitirnota',
                data: {
                    idNotaServico: idNotaServico
                },
                success: function (msg) {
                    if (msg.retorno == "ok") {
                        window.location.reload();
                    } else {
                        alert(msg.retorno);
                        window.location.reload();
                    }
                }
            });
        });

        $(document).on('click', '#consulta', function () {
            var idNotaServico = $(this).attr("data-idNotaServico");
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: '<?php echo URLROOT ?>/notas/database/notasservico.php?operacao=buscarnota',
                data: {
                    idNotaServico: idNotaServico
                },
                success: function (msg) {
                    if (msg.retorno == "ok") {
                        window.location.reload();
                    } else {
                        alert(msg.retorno);
                        window.location.reload();
                    }
                }
            });
        });

        $(document).on('click', '#xml, #pdf', function () {
            var idNotaServico = $(this).attr("data-idNotaServico");
            var visualizarTipo = $(this).attr("id") === "xml" ? "xml" : "pdf";
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: '<?php echo URLROOT ?>/notas/database/notasservico.php?operacao=baixarnota',
                data: {
                    idNotaServico: idNotaServico,
                    visualizar: visualizarTipo
                },
                success: function (msg) {
                    $('#visualizarModal').modal('show');
                    $('#pdfViewer iframe').remove();
                    $('#xmlViewer pre').remove();
                    $('#xmlViewer button').remove();

                    if (visualizarTipo === 'pdf') {
                        var pdfDataUri = "data:application/pdf;base64," + msg.pdf_content;

                        var iframe = document.createElement('iframe');
                        iframe.src = pdfDataUri;
                        iframe.width = '100%';
                        iframe.height = '600px';

                        $('#pdfViewer').append(iframe);

                    } if (visualizarTipo === 'xml') {
                        var xmlContent = msg.xml_content;

                        var Xml = formatXml(xmlContent);

                        var preElement = $('<pre>').html($('<div>').text(Xml).html());
                        $('#xmlViewer').append(preElement)
                        var downloadButton = $('<button>')
                            .attr('type', 'button')
                            .addClass('btn btn-info btn-sm float-end')
                            .text('Download XML')
                            .click(function () {
                                downloadXml(Xml, idNotaServico + '.xml');
                            });

                        $('#xmlViewer').append(downloadButton);
                    }
                }
            });
            function formatXml(xmlString) {
                var string = '';
                var reg = /(>)(<)(\/*)/g;
                xmlString = xmlString.replace(reg, '$1\r\n$2$3');
                var pad = 0;
                jQuery.each(xmlString.split('\r\n'), function (index, node) {
                    var indent = 0;
                    if (node.match(/.+<\/\w[^>]*>$/)) {
                        indent = 0;
                    } else if (node.match(/^<\/\w/)) {
                        if (pad !== 0) {
                            pad -= 1;
                        }
                    } else if (node.match(/^<\w[^>]*[^\/]>.*$/)) {
                        indent = 1;
                    } else {
                        indent = 0;
                    }

                    var padding = '';
                    for (var i = 0; i < pad; i++) {
                        padding += '  ';
                    }

                    string += padding + node + '\r\n';
                    pad += indent;
                });

                return string;
            }
            function downloadXml(xmlContent, filename) {
                var blob = new Blob([xmlContent], { type: 'application/xml' });
                var link = document.createElement('a');
                link.href = window.URL.createObjectURL(blob);
                link.download = filename;
                link.click();
            }
        });



        var inserirModal = document.getElementById("inserirModal");

        var inserirBtn = document.querySelector("button[data-bs-target='#inserirModal']");

        inserirBtn.onclick = function () {
            inserirModal.style.display = "block";
        };

        window.onclick = function (event) {
            if (event.target == inserirModal) {
                inserirModal.style.display = "none";
            }
        };

        $(document).ready(function () {
            $("#inserirFormNotaServico").submit(function (event) {
                var quillContent = descricaoServicoinserir.getText().trim();

                if (quillContent === "") {
                    alert("Por favor preencha a descrição do serviço.");
                    event.preventDefault(); 
                } else {
                    var formData = new FormData(this);
                    $.ajax({
                        url: "../database/notasservico.php?operacao=inserir",
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: refreshPage,
                    });
                }
            });
            $("#alterarFormNotaServico").submit(function (event) {
                event.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    url: "../database/notasservico.php?operacao=alterar",
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

        var condicaoinserir = new Quill('.quill-condicaoinserir', {
            theme: 'snow'
        });
        var condicaoalterar = new Quill('.quill-condicaoalterar', {
            theme: 'snow'
        });

        var descricaoServicoinserir = new Quill('.quill-descricaoServicoinserir', {
            theme: 'snow'
        });
        var descricaoServicoalterar = new Quill('.quill-descricaoServicoalterar', {
            theme: 'snow'
        });

        condicaoinserir.on('text-change', function (delta, oldDelta, source) {
            $('#quill-condicaoinserir').val(condicaoinserir.container.firstChild.innerHTML);
        });
        condicaoalterar.on('text-change', function (delta, oldDelta, source) {
            $('#quill-condicaoalterar').val(condicaoalterar.container.firstChild.innerHTML);
        });

        descricaoServicoinserir.on('text-change', function (delta, oldDelta, source) {
            $('#quill-descricaoServicoinserir').val(descricaoServicoinserir.container.firstChild.innerHTML);
        });
        descricaoServicoalterar.on('text-change', function (delta, oldDelta, source) {
            $('#quill-descricaoServicoalterar').val(descricaoServicoalterar.container.firstChild.innerHTML);
        });
    </script>
    <!-- LOCAL PARA COLOCAR OS JS -FIM -->

</body>

</html>
<?php
include_once filter_input(INPUT_SERVER, 'DOCUMENT_ROOT') . '/config.php';
include_once HEADER;
?>

<div class="row conteudo">
    <h1><i class="glyphicon glyphicon-file"></i> Cadastro </h1>
    <hr>
    <div class="col-md-12">
        <div class="content-box-large">
            <div class="panel-heading">
                <div class="panel-title">Quiz</div>
            </div>
            <div class="panel-body">
                <form action="/views/cadastro/salvar/quiz.php" class="form-horizontal" method="POST">
                    <div class="form-group">
                        <label for="pergunta_qui" class="col-sm-2 control-label">Pergunta:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="pergunta_qui" name="pergunta_qui" placeholder="Digite palavra chave ou parte da pergunta">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="resposta_qui" class="col-sm-2 control-label">Resposta:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="resposta_qui" name="resposta_qui" placeholder="Digite a resposta">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-primary">Salvar cadastro</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
include_once FOOTER;


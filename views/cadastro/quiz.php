<?php
include_once filter_input(INPUT_SERVER, 'DOCUMENT_ROOT') . '/config.php';
include_once HEADER;
include_once SERVIDOR . '/controllers/quiz.php';

$quiz = new Quiz();
$params = anti_injection($_GET);
$cod = $params['id_quiz'];
$questionario = array();
if ($cod)
    $questionario = $quiz->getQuiz('', $cod);
?>

<div class="row conteudo">
    <?php
    if ($cod && !$questionario['id_quiz'])
        echo '<span class="alert alert-danger col-md-12">Nenhuma pergunta foi encontrada para editar.</span>';
    ?>
    <h1>
        <i class="glyphicon <?= $cod ? 'glyphicon-edit ' : 'glyphicon-file' ?> "></i> <?= $cod ? 'Editar' : 'Novo Cadastro' ?> 
    </h1>
    <a href="/quiz" class="text-muted"><i class="glyphicon glyphicon-arrow-left"></i> lista de perguntas</a>
    <hr>
    <div class="col-md-12">
        <div class="content-box-large">
            <div class="panel-heading">
                <div class="panel-title">Quiz</div>
            </div>
            <div class="panel-body">
                <form action="/views/cadastro/salvar/quiz.php" class="form-horizontal" method="POST">
                    <input value="<?= $questionario['id_quiz'] ?>" type="hidden" class="form-control" id="id_quiz" name="id_quiz">
                    <div class="form-group">
                        <label for="pergunta_qui" class="col-sm-2 control-label">Pergunta:</label>
                        <div class="col-sm-10">
                            <input required="true" value="<?= $questionario['pergunta_qui'] ?>" type="text" class="form-control" id="pergunta_qui" name="pergunta_qui" placeholder="Digite palavra chave ou parte da pergunta">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="resposta_qui" class="col-sm-2 control-label">Resposta:</label>
                        <div class="col-sm-10">
                            <input required="true" value="<?= $questionario['resposta_qui'] ?>" type="text" class="form-control" id="resposta_qui" name="resposta_qui" placeholder="Digite a resposta">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-primary"> <?= $cod ? 'Editar' : 'Salvar' ?> cadastro</button>
                            <?php if ($cod) { ?>
                                <button type="submit" name="excluir" value="1" class="btn btn-danger">Excluir</button>
                            <?php } ?>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
include_once FOOTER;


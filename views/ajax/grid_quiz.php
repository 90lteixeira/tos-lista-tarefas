<?php
include_once filter_input(INPUT_SERVER, 'DOCUMENT_ROOT') . '/config.php';
include_once DB;
include_once HDO;
include_once ESSENCIAIS;

include_once SERVIDOR . '/controllers/quiz.php';

$quiz = new Quiz();
$params = anti_injection($_POST);
$arPerguntas = $quiz->getQuiz($params['busca']);
?>   

<div class="content-box-large">
    <div class="panel-heading">
        <div class="panel-title">Perguntas e respostas</div>

        <div class="panel-options text-muted">
            Palavra pesquisada: <?= $params['busca'] ? $params['busca'] : '-----' ?>
        </div>
    </div>
    <div class="panel-body">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Perguntas / Respostas</th> 
                    <th>#</th> 
                </tr>
            </thead>
            <tbody>
                <?php foreach ($arPerguntas as $pergunta) { ?>
                    <tr>
                        <td class="col-md-10">
                            <span class="text-muted">Pergunta:</span> <?= $pergunta['pergunta_qui'] ?><br>
                            <span class="text-muted">Resposta:</span> <?= $pergunta['resposta_qui'] ?>
                        </td> 
                        <td  class="col-md-2">
                            <a href="/cadastro-quiz/<?= $pergunta['id_quiz'] ?>"><span class="glyphicon glyphicon-edit alert-info"></span></a>
                        </td> 
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <?= !count($arPerguntas) ? '<span class="alert alert-warning col-md-12">Nenhuma resposta encontrada.</span>' : '' ?>
    </div>
    <div class="col-md-12 text-right"> Total de perguntas cadastradas: <?= count($arPerguntas) ?></div>
</div>
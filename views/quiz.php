<?php
include_once filter_input(INPUT_SERVER, 'DOCUMENT_ROOT') . '/config.php';
include_once HEADER;
?>

<div class="row conteudo">
    <h1><i class="glyphicon glyphicon-question-sign"></i> Quiz</h1>
    <hr>
    <div class="col-md-12 row">

        <form class="form-inline" action="javascript:void(0)" method="get" >
            <div class="col-md-12"> 
                <div class="input-group input-group-sm">
                    <div id="search" class="input-group-addon"><i class="glyphicon glyphicon-search"></i> </div>
                    <input style="max-width: 510px;" class="form-control" type="search" id="busca" name="busca" placeholder="Digite palavra chave da pergunta" >
                </div>
            </div><!-- /input-group -->   
        </form> 

        <span class="clearfix"></span>
        <br>
        <div class="col-md-12" id="pesquisa-painel">
        </div>

    </div>
</div>

<script type="text/javascript">

    $(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });

    campoPesquisa('/views/ajax/grid_quiz.php', 1);
</script>  

<?php
include_once FOOTER;


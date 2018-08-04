<?php

include filter_input(INPUT_SERVER, 'DOCUMENT_ROOT') . '/config.php';
include_once DB;
include_once HDO;
include_once ESSENCIAIS; 

/*
  quiz
 */

class Quiz {

    private $tb;
    private $tabela = 'quiz';

    public function __construct() {
        $this->tb = new TablePdo();
    }

    public function getQuiz($pergunta = '') {
        
        $this->tb->setClear();
        $this->tb->setAll();
        $this->tb->setTabela($this->tabela);
        
        if ($pergunta)
            $this->tb->setWhereLk('pergunta_qui', $pergunta);
        
        $this->tb->query();
        return $this->tb->getRst();
    }
    
    public function save($params) {
                                        
        $this->tb->setClear();
        $this->tb->setCampo('pergunta_qui', $params['pergunta_qui']);
        $this->tb->setCampo('resposta_qui', $params['resposta_qui']);
        $this->tb->setTabela($this->tabela);

        if ($this->tb->insert()) {
            return_session('Pergunta cadastrada com sucesso.', 'success');
        } else {
            return_session('Não foi possível continuar, tente novamente');
        }
        
    }
    
}

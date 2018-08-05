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

    public function getQuiz($pergunta = '', $cod = '') {

        $this->tb->setClear();
        $this->tb->setAll();
        $this->tb->setTabela($this->tabela);

        if ($cod)
            $this->tb->setWhere('id_quiz', $cod);

        if ($pergunta)
            $this->tb->setWhereLk('pergunta_qui', $pergunta);

        $this->tb->query();
        return $cod ? $this->tb->getRst()[0] : $this->tb->getRst();
    }

    public function save($params) {

        //delete
        if ($params['excluir'])
            $this->_delete($params);
            
        $this->tb->setClear();
        $this->tb->setCampo('pergunta_qui', $params['pergunta_qui']);
        $this->tb->setCampo('resposta_qui', $params['resposta_qui']);
        $this->tb->setTabela($this->tabela);

        //insert
        if (!$params['id_quiz']) {
            if ($this->tb->insert()) {
                return_session('Pergunta cadastrada com sucesso.', 'success');
            } else {
                return_session('Não foi possível continuar, tente novamente');
            }

            //update    
        } else {
            $this->tb->setWhere('id_quiz', $params['id_quiz']);
            if ($this->tb->update()) {
                return_session('Pergunta atualizada.', 'success', '/quiz');
            } else {
                return_session('Não foi possível continuar, tente novamente');
            }
        }
    }

    protected function _delete($params) {

        $this->tb->setClear();
        $this->tb->setTabela($this->tabela);
        $this->tb->setWhere('id_quiz', $params['id_quiz']);
        if ($this->tb->delete()) {
            return_session('Pergunta deletada com sucesso.', 'error', '/quiz');
        } else {
            return_session('Não foi possível continuar, tente novamente');
        }
    }

}

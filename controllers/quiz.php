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
    private $essenciais = '';

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
        $this->tb->setCampo('nome_for', $params['nome_for']);
        $this->tb->setCampo('nomefantasia_for', $params['nomefantasia_for']);
        $this->tb->setCampo('cpfcnpj_for', $params['cpfcnpj_for']);
        $this->tb->setCampo('telefone_for', $params['telefone_for']);
        $this->tb->setCampo('observacao_for', $params['observacao_for']);
        $this->tb->setCampo('cep_for', $params['cep_for']);
        $this->tb->setCampo('cidade_for', $params['cidade_for']);
        $this->tb->setCampo('endereco_for', $params['endereco_for']);
        $this->tb->setCampo('estado_for', $params['estado_for']);
        $this->tb->setCampo('bairro_for', $params['bairro_for']);
        $this->tb->setCampo('cod_pet_fk', $_SESSION['lembrar']['cod_pet']);
        $this->tb->setTabela($this->tabela);

        if ($this->tb->insert()) {
            $_SESSION['lastfornecedor'] = $this->tb->ultimoRegistro();
            $this->essenciais->setLog('Cadastro de Fornecedor', $this->tabela);
            return_session('Fornecedor cadastrado com sucesso.', 'success', '/fornecedor/'.$_SESSION['lastfornecedor']);
        } else {
            $this->essenciais->setLog('[ERRO] Cadastro de Fornecedor', $this->tabela);
            return_session('Não foi possível continuar, tente novamente');
        }
        
    }
    
}

<?php defined('BASEPATH') OR exit('No direct script access allowed');

class FuncionariosFinder extends MY_Model {
    
    // tabela
    public $table = "Funcionarios";
    
    // entidade
    public $entity = "Funcionario";

    // chave primária
    public $primaryKey = "CodFuncionario";

   /**
    * __construct
    *
    * metodo construtor
    *
    */
    public function __construct() {
        parent::__construct();
    }

    /**
    * grid
    *
    * funcao usada para gerar o grid
    *
    */
    public function grid() {
        $this->db->from( $this->table )
        ->select( 'CodFuncionario as Código, Nome, CodFuncionario as Ações' );
        return $this;
    }

   /**
    * email
    *
    * pesquisa os usuário por email
    *
    */
    public function email( $email ) {

        // pesquisa o email
        $this->where( " Email = '$email' " );
        return $this;
    }

   /**
    * uid
    *
    * filtra por uid
    *
    */
    public function segmento( $segmento ) {

        // pesquisa o email
        $this->where( " CodSegmento = $segmento " );
        return $this;
    }

   /**
    * ignorarAtual
    *
    * ignora o usuário logado
    *
    */
    public function ignorarAtual() {

        // pega o usuario atual
        $uid = $this->guard->currentUser()->UID;

        // adiciona no where
        $this->clean()->where( " UID <> '$uid' " );
        
        // retorna uma instancia
        return $this;
    }

    
    /**
    * filtro
    *
    * volta o array para formatar os filtros
    *
    */
    public function filtro() {

        // prepara os dados
        $this->db->from( $this->table )
        ->select( 'CodFuncionario as Valor, Nome as Label' );

        // faz a busca
        $busca = $this->db->get();

        // verifica se existe resultados
        if ( $busca->num_rows() > 0 ) {

            // seta o array de retorna
            $ret = [];

            // percorre todos os dados
            foreach( $busca->result_array() as $item ) {
                $ret[$item['Valor']] = $item['Label'];
            }

            // retorna os dados
            return $ret;

        } else return [];
    }

}

/* end of file */
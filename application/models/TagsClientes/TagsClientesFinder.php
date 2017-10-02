<?php defined('BASEPATH') OR exit('No direct script access allowed');

class TagsClientesFinder extends MY_Model {

    // entidade
    public $entity = 'TagCliente';

    // tabela
    public $table = 'TagsClientes';

    // chave primaria
    public $primaryKey = 'CodTagCliente';

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
    * proposta
    *
    * faz o filtro pelo proposta
    *
    */
    public function tag( $CodTag ) {
        $this->where( " CodTag = $CodTag " );
        return $this;
    }

    /**
    * funcionario
    *
    * faz o filtro pelo funcionario
    *
    */
    public function cliente( $CodCliente ) {
        $this->where( " CodCliente = $CodCliente " );
        return $this;
    }
    
}

/* end of file */

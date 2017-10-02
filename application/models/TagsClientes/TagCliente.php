<?php defined('BASEPATH') OR exit('No direct script access allowed');

require 'TagsClientesFinder.php';

class TagCliente extends TagsClientesFinder {

    // id da proposta
    public $CodTagCliente;

    // tag
    public $tag;

    // cliente
    public $cliente;

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

}

/* end of file */

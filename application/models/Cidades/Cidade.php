<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once "CidadesFinder.php";

class Cidade extends CidadesFinder {

    // id da cidade
    public $CodCidade;

    // estado
    public $estado;

    // nome
    public $nome;

    // entidade
    public $entity = 'Cidade';
    
    // tabela
    public $table = 'Cidades';

    // chave primaria
    public $primaryKey = 'CodCidade';

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

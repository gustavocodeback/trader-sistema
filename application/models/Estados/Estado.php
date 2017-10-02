<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once "EstadosFinder.php";

class Estado extends EstadosFinder {

    // id do estado
    public $CodEstado;

    // nome
    public $nome;

    // uf
    public $uf;

    // entidade
    public $entity = 'Estado';
    
    // tabela
    public $table = 'Estados';

    // chave primaria
    public $primaryKey = 'CodEstado';

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

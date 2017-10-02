<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once "SegmentosFinder.php";

class Segmento extends SegmentosFinder {

    // id do grupo
    public $CodSegmento;

    // nome
    public $nome;

    // entidade
    public $entity = 'Segmento';
    
    // tabela
    public $table = 'Segmentos';

    // chave primaria
    public $primaryKey = 'CodSegmento';

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

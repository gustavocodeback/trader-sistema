<?php defined('BASEPATH') OR exit('No direct script access allowed');

require 'TagsFinder.php';

class Tag extends TagsFinder {

    // id do descricao
    public $CodTag;

    // descricao
    public $descricao;

    // entidade
    public $entity = 'Tag';
    
    // tabela
    public $table = 'Tags';

    // chave primaria
    public $primaryKey = 'CodTag';

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
    * setCod
    *
    * seta o CodTag
    *
    */
    public function setCod( $CodTag ) {
        $this->CodTag = $CodTag;
    }

   /**
    * setTag
    *
    * seta o descricao
    *
    */
    public function setDescricao( $descricao ) {
        $this->descricao = $descricao;
    }
}

/* end of file */

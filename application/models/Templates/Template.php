<?php defined('BASEPATH') OR exit('No direct script access allowed');

require 'TemplatesFinder.php';

class Template extends TemplatesFinder {

    // id do descricao
    public $CodTemplate;

    // descricao
    public $nome;

    // corpo
    public $corpo;

    // entidade
    public $entity = 'Template';
    
    // tabela
    public $table = 'Templates';

    // chave primaria
    public $primaryKey = 'CodTemplate';

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
    * seta o CodTemplate
    *
    */
    public function setCod( $CodTemplate ) {
        $this->CodTemplate = $CodTemplate;
    }

   /**
    * setNome
    *
    * seta o nome
    *
    */
    public function setNome( $nome ) {
        $this->nome = $nome;
    }

    /**
    * setCorpo
    *
    * seta o corpo
    *
    */
    public function setCorpo( $corpo ) {
        $this->corpo = $corpo;
    }
}

/* end of file */

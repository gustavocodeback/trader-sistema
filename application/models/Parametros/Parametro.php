<?php defined('BASEPATH') OR exit('No direct script access allowed');

require 'ParametrosFinder.php';

class Parametro extends ParametrosFinder {

    // id do descricao
    public $CodParametro;

    // descricao
    public $descricao;

    // valor
    public $valor;

    // entidade
    public $entity = 'Parametro';
    
    // tabela
    public $table = 'Parametros';

    // chave primaria
    public $primaryKey = 'CodParametro';

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
    * seta o CodParametro
    *
    */
    public function setCod( $CodParametro ) {
        $this->CodParametro = $CodParametro;
    }

   /**
    * setDescricao
    *
    * seta o descricao
    *
    */
    public function setDescricao( $descricao ) {
        $this->descricao = $descricao;
    }

    /**
    * setValor
    *
    * seta o valor
    *
    */
    public function setValor( $valor ) {
        $this->valor = $valor;
    }
}

/* end of file */

<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once "LogsFinder.php";

class Log extends LogsFinder {

    // id do estado
    public $CodLog;

    // entidade
    public $entidade;

    // funcionario
    public $funcionario;

    // mensagem
    public $mensagem;

    // status
    public $status;

    // data
    public $data;
    
    // acao
    public $acao;

    // entidade
    public $entity = 'Log';
    
    // tabela
    public $table = 'Logs';

    // chave primaria
    public $primaryKey = 'CodLog';

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

<?php defined('BASEPATH') OR exit('No direct script access allowed');

require 'PropostasClientesFinder.php';

class PropostaCliente extends PropostasClientesFinder {

    // id da proposta
    public $CodPropostaCliente;

    // proposta
    public $proposta;

    // cliente
    public $cliente;

    // status
    public $status;

    // dataDisparo
    public $dataDisparo;

    // dataVencimento
    public $dataVencimento;

    // dataResposta
    public $dataResposta;

    // entidade
    public $entity = 'PropostaCliente';
    
    // tabela
    public $table = 'PropostasClientes';

    // chave primaria
    public $primaryKey = 'CodPropostaCliente';

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

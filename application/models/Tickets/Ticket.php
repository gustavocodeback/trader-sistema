<?php defined('BASEPATH') OR exit('No direct script access allowed');

require 'TicketsFinder.php';

class Ticket extends TicketsFinder {

    // id da proposta
    public $CodTicket;

    // proposta
    public $cliente;

    // funcionario
    public $funcionario;

    // nome
    public $nome;

    // status
    public $status;

    // avaliacao
    public $avaliacao;

    // elogio
    public $elogio;

    // reclamacao
    public $reclamacao;

    // sugestao
    public $sugestao;

    // dataAbertura
    public $dataAbertura;

    // dataMovimentacao
    public $dataMovimentacao;

    // descricao
    public $descricao;

    // entidade
    public $entity = 'Ticket';
    
    // tabela
    public $table = 'Tickets';

    // chave primaria
    public $primaryKey = 'CodTicket';

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

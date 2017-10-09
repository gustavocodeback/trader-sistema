<?php defined('BASEPATH') OR exit('No direct script access allowed');

class TicketsFinder extends MY_Model {

    // entidade
    public $entity = 'Ticket';

    // tabela
    public $table = 'Tickets';

    // chave primaria
    public $primaryKey = 'codTicket';

    // labels
    public $labels = [
        'proposta'       => 'Ticket',
        'nome'           => 'Nome',
        'descricao'      => 'Descrição',
        'dias'           => 'Dias',        
        'CodFuncionario' => 'Funcionário',
    ];

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
    * getTicket
    *
    * pega a instancia da proposta
    *
    */
    public function getTicket() {
        return new $this->entity();
    }

   /**
    * grid
    *
    * funcao usada para gerar o grid
    *
    */
    public function grid( $CodCliente ) {
        $this->db->from( $this->table.' t' )
        ->select( 'CodTicket as Andamento, t.Nome, DataAbertura as Data Abertura, Status, Descricao' )
        ->where( " CodCliente = $CodCliente " );
        return $this;
    }

    /**
    * cliente
    *
    * faz o filtro pelo cliente
    *
    */
    public function cliente( $cliente ) {
        $this->where( " CodCliente = $cliente " );
        return $this;
    }
    
   /**
    * orderByPontos
    *
    * ordena pelos pontos
    *
    */
    public function orderByData() {
        $this->db->order_by( 'DataAbertura', 'DESC' );
        return $this;
    }
}

/* end of file */

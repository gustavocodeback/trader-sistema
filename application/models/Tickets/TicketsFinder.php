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
    public function grid() {
        $this->db->from( $this->table.' p' )
        ->select( 'p.CodTicket as Código, p.nome, f.Nome as Funcionário, dias, CodTicket as Ações' )
       ->join( 'Funcionarios f', 'p.CodFuncionario = f.CodFuncionario', 'left' );
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
        $this->db->order_by( 'DataAbertura', 'ASC' );
        return $this;
    }
}

/* end of file */

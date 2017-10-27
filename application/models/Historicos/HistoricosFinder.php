<?php defined('BASEPATH') OR exit('No direct script access allowed');

class HistoricosFinder extends MY_Model {
    
    // tabela
    public $table = "Historico";
    
    // entidade
    public $entity = "Historico";

    // chave primária
    public $primaryKey = "CodHistorico";

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
    * timeline
    *
    * Pega o historico de uma timeline
    *
    */
    public function timeline( $segmento, $cliente ) {
        $this->where( " CodSegmento = $segmento->CodSegmento OR CodCliente = $cliente->CodCliente " );
        $this->db->order_by( 'Data', 'DESC' );
        return $this;
    }
}

/* end of file */
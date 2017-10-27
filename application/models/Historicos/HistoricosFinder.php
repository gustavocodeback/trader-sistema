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

    /**
     * ultimoDoCliente
     *
     * pega o ultimo historico do cliente em uma proposta
     *
     */
    public function ultimoDoCliente( $cliente, $proposta ) {

        // seta o where
        $this->where( " CodCliente = $cliente->CodCliente AND CodProposta = $proposta->CodProposta " );
        $this->db->order_by( 'Data', 'DESC' );
        return $this;
    }

    /**
     * flag
     *
     * filtra pelo flag
     *
     */
    public function flag( $flag ) {
        $this->where( "Flag = '$flag' " );
        return $this;
    }
}

/* end of file */
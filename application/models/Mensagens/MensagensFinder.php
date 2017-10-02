<?php defined('BASEPATH') OR exit('No direct script access allowed');

class MensagensFinder extends MY_Model {

    // entidade
    public $entity = 'Mensagem';

    // tabela
    public $table = 'Mensagens';

    // chave primaria
    public $primaryKey = 'CodMensagem';

    // labels
    public $labels = [
        'Nome'  => 'Nome',
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
    * getMensagem
    *
    * pega a instancia da mensagem
    *
    */
    public function getMensagem() {
        return new $this->entity();
    }

   /**
    * grid
    *
    * funcao usada para gerar o grid
    *
    */
    public function grid() {
        $this->db->from( $this->table.' b' )
        ->select( 'CodMensagem as Código, b.Nome as Nome, CodMensagem as Ações' );
        return $this;
    }

   /**
    * evento
    *
    * seta o codigo do evento
    *
    */
    public function cliente( $CodCliente ) {

        // seta o where
        $this->where( " CodCliente = $CodCliente" );
        return $this;
    }

    /**
    * nLida
    *
    * seta o codigo do evento
    *
    */
    public function nLida() {

        // seta o where
        $this->where( " Visualizado = 'N' " );
        return $this;
    }

    /**
    * cli
    *
    * seta o codigo do evento
    *
    */
    public function cli() {

        // seta o where
        $this->where( " CodCliente is not null " );
        return $this;
    }

   /**
    * obter_abertas
    *
    * obtem as mensagens abertas
    *
    */
    public function obter_abertas( $cod_colaborador ) {

        // prepara a query
        $this->db->select( '*' )
        ->from( 'Eventos e' )
        ->join( 'Mensagens m', 'e.CodEvento = m.CodEvento', 'inner' )
        ->where( " e.CodColaborador = $cod_colaborador AND m.Visualizado = 'N' AND m.CodColaborador IS NULL" );

        // faz a busca
        $busca = $this->db->get();

        // retorna os resultados
        return ( $busca->num_rows() > 0 ) ? $busca->result_array() : [];
    }
}

/* end of file */

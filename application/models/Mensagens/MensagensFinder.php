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
    * evento
    *
    * seta o codigo do evento
    *
    */
    public function funcionario( $CodFuncionario ) {

        // seta o where
        $this->where( " CodFuncionario = $CodFuncionario" );
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
        $this->where( " Visualizada = 'N' " );
        return $this;
    }

    /**
    * autor
    *
    * filtra pelo autor
    *
    */
    public function autor( $autor ) {

        // seta o where
        $this->where( " Autor = '$autor' " );
        return $this;
    }
    
   /**
    * orderByData
    *
    * ordenar pela data de envio
    *
    */
    public function orderByData() {
        $this->db->order_by( 'DataEnvio', 'ASC' );
        return $this;
    }
    
   /**
    * orderByPontos
    *
    * ordena pelos pontos
    *
    */
    public function orderByDataNew() {
        $this->db->order_by( 'DataEnvio', 'DESC' );
        return $this;
    }
    
   /**
    * orderByPontos
    *
    * ordena pelos pontos
    *
    */
    public function lastMsg( $cod ) {
        
        // seta o where
        $this->where( " CodMensagem > $cod" );
        return $this;
    }

   /**
    * newerThan
    *
    * mensagens mais novas
    *
    */
    public function newerThan( $timestamp ) {

        // seta o where
        $this->where( " DataEnvio > '".date( 'Y-m-d H:i:s', $timestamp )."'" );
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

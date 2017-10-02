<?php defined('BASEPATH') OR exit('No direct script access allowed');

class CidadesFinder extends MY_Model {

    // entidade
    public $entity = 'Cidade';

    // tabela
    public $table = 'Cidades';

    // chave primaria
    public $primaryKey = 'CodCidade';

    // labels
    public $labels = [
        'Nome'  => 'Nome',
        'CodEstado' => 'Estado',
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
    * getCidade
    *
    * pega a instancia do cidade
    *
    */
    public function getCidade() {
        return new $this->entity();
    }

   /**
    * grid
    *
    * funcao usada para gerar o grid
    *
    */
    public function grid() {
        $this->db->from( $this->table.' c' )
        ->select( 'CodCidade as Código, c.Nome, e.Nome as Estado, CodCidade as Ações' )
        ->join( 'Estados e', 'e.CodEstado = c.CodEstado' );
        return $this;
    }

   /**
    * porEstado
    *
    * obtem as cidades do estado
    *
    */
    public function porEstado( $estado ) {

        // seta o codigo
        $cod = isset( $estado->CodEstado ) ? $estado->CodEstado : $estado;

        // seta o where
        $this->where( " CodEstado = $cod" );
        return $this;
    }
}

/* end of file */

<?php defined('BASEPATH') OR exit('No direct script access allowed');

class EstadosFinder extends MY_Model {

    // entidade
    public $entity = 'Estado';

    // tabela
    public $table = 'Estados';

    // chave primaria
    public $primaryKey = 'CodEstado';

    // labels
    public $labels = [
        'nome'  => 'Nome',
        'uf' => 'UF',
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
    * getEstado
    *
    * pega a instancia do estado
    *
    */
    public function getEstado() {
        return new $this->entity();
    }

   /**
    * grid
    *
    * funcao usada para gerar o grid
    *
    */
    public function grid() {
        $this->db->from( $this->table )
        ->select( 'CodEstado as Código, Nome, Uf, CodEstado as Ações' );
        return $this;
    }
}

/* end of file */

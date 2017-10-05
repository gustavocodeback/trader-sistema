<?php defined('BASEPATH') OR exit('No direct script access allowed');

class PostsFinder extends MY_Model {

    // entidade
    public $entity = 'Post';

    // tabela
    public $table = 'Posts';

    // chave primaria
    public $primaryKey = 'CodPost';

    // labels
    public $labels = [
        'titulo'   => 'Titulo'
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
    * grid
    *
    * funcao usada para gerar o grid
    *
    */
    public function grid() {
        $this->db->from( $this->table )
        ->select( 'CodPost as Código, titulo, CodPost as Ações' );
        return $this;
    }
    
   /**
    * orderByPontos
    *
    * ordena pelos pontos
    *
    */
    public function orderByData() {
        $this->db->order_by( 'Data', 'ASC' );
        return $this;
    }

}

/* end of file */

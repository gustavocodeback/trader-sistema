<?php defined('BASEPATH') OR exit('No direct script access allowed');

class TagsFinder extends MY_Model {

    // entidade
    public $entity = 'Tag';

    // tabela
    public $table = 'Tags';

    // chave primaria
    public $primaryKey = 'CodTag';

    // labels
    public $labels = [
        'descricao'   => 'Descricao',
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
        ->select( 'CodTag as Código, descricao, CodTag as Ações' );
        return $this;
    }
}

/* end of file */

<?php defined('BASEPATH') OR exit('No direct script access allowed');

class TemplatesFinder extends MY_Model {

    // entidade
    public $entity = 'Template';

    // tabela
    public $table = 'Templates';

    // chave primaria
    public $primaryKey = 'CodTemplate';

    // labels
    public $labels = [
        'nome'   => 'Nome',
        'corpo'   => 'Corpo',
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
        ->select( 'CodTemplate as Código, nome, corpo, CodTemplate as Ações' );
        return $this;
    }

    public function template( $template ) {
        
        // pesquisa o email
        $this->where( " nome = '$template' " );
        return $this;
    }
}

/* end of file */

<?php defined('BASEPATH') OR exit('No direct script access allowed');

class ParametrosFinder extends MY_Model {

    // entidade
    public $entity = 'Parametro';

    // tabela
    public $table = 'Parametros';

    // chave primaria
    public $primaryKey = 'CodParametro';

    // labels
    public $labels = [
        'descricao' => 'Descricao',
        'valor'     => 'Valor',
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
        ->select( 'CodParametro as Código, descricao, valor, CodParametro as Ações' );
        return $this;
    }
}

/* end of file */

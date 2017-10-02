<?php defined('BASEPATH') OR exit('No direct script access allowed');

class SegmentosFinder extends MY_Model {

    // entidade
    public $entity = 'Segmento';

    // tabela
    public $table = 'Segmentos';

    // chave primaria
    public $primaryKey = 'CodSegmento';

    // labels
    public $labels = [
        'nome'   => 'Nome',
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
        ->select( 'CodSegmento as Código, nome as Nome, CodSegmento as Ações' );
        return $this;
    }
    
    /**
    * filtro
    *
    * volta o array para formatar os filtros
    *
    */
    public function filtro() {

        // prepara os dados
        $this->db->from( $this->table )
        ->select( 'CodSegmento as Valor, Nome as Label' );

        // faz a busca
        $busca = $this->db->get();

        // verifica se existe resultados
        if ( $busca->num_rows() > 0 ) {

            // seta o array de retorna
            $ret = [];

            // percorre todos os dados
            foreach( $busca->result_array() as $item ) {
                $ret[$item['Valor']] = $item['Label'];
            }

            // retorna os dados
            return $ret;

        } else return [];
    }
}

/* end of file */

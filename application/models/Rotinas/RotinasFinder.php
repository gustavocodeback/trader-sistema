<?php defined('BASEPATH') OR exit('No direct script access allowed');

class RotinasFinder extends MY_Model {

    // entidade
    public $entity = 'Rotina';

    // tabela
    public $table = 'Rotinas';

    // chave primaria
    public $primaryKey = 'rid';

    // labels
    public $labels = [
        'rotina'   => 'Rotina',
        'link' => 'Link',        
        'CodClassificacao' => 'Classificação',
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
    * getRotina
    *
    * pega a instancia da rotina
    *
    */
    public function getRotina() {
        return new $this->entity();
    }

   /**
    * grid
    *
    * funcao usada para gerar o grid
    *
    */
    public function grid() {
        $this->db->from( $this->table.' r' )
        ->select( 'r.rid as Código, rotina, c.Nome as Classificacao, link, rid as Ações' )
       ->join( 'Classificacoes c', 'r.CodClassificacao = c.CodClassificacao', 'left' );
        return $this;
    }

   /**
    * nome
    *
    * faz o filtro pelo nome
    *
    */
    public function nome( $nome ) {
        $this->where( " rotina = '$nome' " );
        return $this;
    }

    /**
    * nome
    *
    * faz o filtro pelo nome
    *
    */
    public function classificacao( $classificacao ) {
        $this->where( " CodClassificacao = $classificacao " );
        return $this;
    }
}

/* end of file */

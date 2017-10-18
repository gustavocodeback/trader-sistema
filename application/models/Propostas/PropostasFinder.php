<?php defined('BASEPATH') OR exit('No direct script access allowed');

class PropostasFinder extends MY_Model {

    // entidade
    public $entity = 'Proposta';

    // tabela
    public $table = 'Propostas';

    // chave primaria
    public $primaryKey = 'codProposta';

    // labels
    public $labels = [
        'proposta'       => 'Proposta',
        'nome'           => 'Nome',
        'descricao'      => 'Descrição',
        'dias'           => 'Dias',        
        'CodFuncionario' => 'Funcionário',
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
    * getProposta
    *
    * pega a instancia da proposta
    *
    */
    public function getProposta() {
        return new $this->entity();
    }

   /**
    * grid
    *
    * funcao usada para gerar o grid
    *
    */
    public function grid( $acessor = false ) {

        // verifica se é um pedido do acessor
        if ( $acessor ) {
            $this->db->from( $this->table.' p' )
            ->select( 'p.CodProposta as Código, p.nome, f.Nome as Funcionário, dias' )
            ->join( 'Funcionarios f', 'p.CodFuncionario = f.CodFuncionario', 'left' );
        } else {
            $this->db->from( $this->table.' p' )
            ->select( 'p.CodProposta as Código, p.nome, f.Nome as Funcionário, dias, CodProposta as Ações' )
            ->join( 'Funcionarios f', 'p.CodFuncionario = f.CodFuncionario', 'left' );
        }
        
        return $this;
    }

    /**
    * grid_assessor
    *
    * funcao usada para gerar o grid
    *
    */
    // public function grid_assessor( $CodFuncionario ) {
    //     $this->db->from( $this->table.' p' )
    //     ->select( 'p.CodProposta as Código, p.nome, p.descricao, dias, CodProposta as Ações' )
    //    ->join( 'Funcionarios f', 'p.CodFuncionario = f.CodFuncionario', 'left' )
    //    ->where( "p.CodFuncionario = $CodFuncionario" );
    //     return $this;
    // }

   /**
    * proposta
    *
    * faz o filtro pelo proposta
    *
    */
    public function proposta( $proposta ) {
        $this->where( " proposta = '$proposta' " );
        return $this;
    }

    /**
    * dias
    *
    * busca os dias
    *
    */
    public function dias( $dias ) {
        $this->where( " dias = '$dias' " );
        return $this;
    }

    /**
    * funcionario
    *
    * faz o filtro pelo funcionario
    *
    */
    public function funcionario( $funcionario ) {
        $this->where( " CodFuncionario = $funcionario " );
        return $this;
    }
}

/* end of file */

<?php defined('BASEPATH') OR exit('No direct script access allowed');

class PropostasClientesFinder extends MY_Model {

    // entidade
    public $entity = 'PropostaCliente';

    // tabela
    public $table = 'PropostasClientes';

    // chave primaria
    public $primaryKey = 'CodPropostaCliente';

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
    public function grid() {
        $this->db->from( $this->table.' p' )
        ->select( 'p.CodProposta as Código, p.nome, f.Nome as Funcionário, dias, CodProposta as Ações' )
       ->join( 'Funcionarios f', 'p.CodFuncionario = f.CodFuncionario', 'left' );
        return $this;
    }

    /**
    * grid_assessor
    *
    * funcao usada para gerar o grid
    *
    */
    public function grid_assessor( $CodFuncionario ) {
        $this->db->from( $this->table.' a' )
        ->select( 'a.CodPropostaCliente as Código, p.nome as Proposta, c.nome as Cliente, a.DataVencimento as Vencimento, a.Status as Status' )
       ->join( 'Propostas p', 'a.CodProposta = p.CodProposta', 'left' )
       ->join( 'Clientes c', 'a.CodCliente = c.CodCliente', 'left' )
       ->where( "p.CodFuncionario = $CodFuncionario" )
       ->order_by( 'a.DataVencimento', 'DESC' );
        return $this;
    }

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
    
    /**
    * periodo
    *
    * faz o filtro pelo funcionario
    *
    */
    public function periodo( $CodProposta, $CodCliente, $data ) {
        $this->where( " CodProposta = $CodProposta AND CodCliente= $CodCliente AND DataVencimento > '$data' " );
        return $this;
    }
}

/* end of file */

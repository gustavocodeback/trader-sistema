<?php defined('BASEPATH') OR exit('No direct script access allowed');

class ClientesFinder extends MY_Model {
    
    // tabela
    public $table = "Clientes";
    
    // entidade
    public $entity = "Cliente";

    // chave primária
    public $primaryKey = "CodCliente";

    // labels
    public $labels = [
        'CodFuncionario'   => 'Assessor',
        'CodSegmento'      => 'Segmento',
        'AtributoSegmento' => 'Atributo Segmento'
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
        $this->db->from( $this->table .' c')
        ->select( ' CodCliente as Código, 
                    c.Nome, 
                    c.Email,
                    f.Nome as Assessor, 
                    s.Nome as Segmento, 
                    AtributoSegmento, 
                    CodCliente as Ações' )
        ->join( 'Funcionarios f', 'c.CodFuncionario = f.CodFuncionario' )
        ->join( 'Segmentos s', 'f.CodSegmento = s.CodSegmento' );
        return $this;
    }

    /**
    * grid
    *
    * funcao usada para gerar o grid
    *
    */
    public function grid_func( $CodFuncionario ) {
        $this->db->from( $this->table .' c' )
        ->select( ' c.CodCliente as Código, 
                    c.Nome, 
                    c.Email,
                    COUNT(m.CodMensagem) as \'Novas Mensagens\', 
                    c.AtributoSegmento, 
                    c.CodCliente as Ações' )
        ->join( 'Mensagens m', "c.CodCliente = m.CodCliente and m.Autor = 'C' and m.Visualizada = 'N'", 'left' )
        // ->join( 'Mensagens m', "c.CodCliente = m.CodCliente and m.Autor = 'C'", 'left' )
        ->where( "c.CodFuncionario = $CodFuncionario" )
        ->group_by( 'm.CodCliente' )
        ->order_by('COUNT(m.CodMensagem)', 'DESC');
        return $this;
    }

   /**
    * trader
    *
    * pega os clientes da trader
    *
    */
    public function trader() {

        // pesquisa o email
        $this->where( " AtributoSegmento = 'T' " );
        return $this;
    }

   /**
    * inativo
    *
    * obtem os clientes inativos
    *
    */
    public function inativo() {

        // pesquisa o email
        $this->where( " AtributoSegmento = 'I' " );
        return $this;
    }

   /**
    * email
    *
    * pesquisa o cliente por email
    *
    */
    public function email( $email ) {

        // pesquisa o email
        $this->where( " Email = '$email' " );
        return $this;
    }

   /**
    * codXp
    *
    * obtem os clientes pelo codXp
    *
    */
    public function codXp( $codXp ) {

        // pesquisa o email
        $this->where( " CodXp = '$codXp' " );
        return $this;
    }

   /**
    * tokenEmail
    *
    * filtra por tokenEmail
    *
    */
    public function tokenEmail( $tokenEmail ) {

        // pesquisa o email
        $this->where( " TokenEmail = '$tokenEmail' " );
        return $this;
    }

   /**
    * funcionario
    *
    * filtra por funcionario
    *
    */
    public function funcionario( $funcionario ) {

        // pesquisa o email
        $this->where( " CodFuncionario = $funcionario " );
        return $this;
    }

    /**
    * meusClientes
    *
    * obtem os clientes do funcionário logado
    *
    */
    public function meusClientes() {

        // seta o where
        $id = $this->guard->currentUser()->CodFuncionario;
        $this->where( " CodFuncionario =  $id " );
        return $this;
    }

    /**
    * buscaClientePorSegmento
    *
    * Busca o cliente pelo segmento
    *
    */
    public function buscaClientePorSegmento( $segmento ) {

        // monta a query
        $retorno = $this->db->query("  SELECT c.*
                            FROM Clientes c
                            INNER JOIN Funcionarios f ON c.CodFuncionario = f.CodFuncionario
                            WHERE f.CodSegmento = $segmento
                            ORDER BY c.CodCliente ASC ");
        
        $dados =  $retorno->result_array();
        $ret = [];
        foreach( $dados as $dado ) {
            $var = $this->getEntity();
            $var->parse($dado);
            $ret[] = $var; 
        }
        return $ret;
    }
}

/* end of file */
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
        ->select( 'CodCliente as Código, c.Nome, f.Nome as Assessor, s.Nome as Segmento, AtributoSegmento, CodCliente as Ações' )
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
        ->select( 'c.CodCliente as Código, c.Nome, COUNT(m.CodMensagem) as Mensagens, c.AtributoSegmento, c.CodCliente as Ações' )
        ->join( 'Mensagens m', "c.CodCliente = m.CodCliente and m.Autor = 'C' and m.Visualizada = 'N'", 'left' )
        // ->join( 'Mensagens m', "c.CodCliente = m.CodCliente and m.Autor = 'C'", 'left' )
        ->where( "c.CodFuncionario = $CodFuncionario" );
        return $this;
    }

   /**
    * email
    *
    * pesquisa o cliente por email
    *
    */
    public function trader() {

        // pesquisa o email
        $this->where( " AtributoSegmento = 'T' " );
        return $this;
    }

   /**
    * email
    *
    * pesquisa o cliente por email
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
    * ignorarAtual
    *
    * ignora o usuário logado
    *
    */
    public function ignorarAtual() {

        // pega o usuario atual
        $uid = $this->guard->currentUser()->UID;

        // adiciona no where
        $this->clean()->where( " UID <> '$uid' " );
        
        // retorna uma instancia
        return $this;
    }
    
}

/* end of file */
<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
* Guard
*
* classe de protecao de acessos
*
*/
class Guard {

    // instancia do ci
    public $ci;

   /**
    * __construct
    *
    * metodo construtor
    *
    */
    public function __construct() {

        // pega a instancia do codeigniter
        $this->ci =& get_instance();
    }

   /**
    * currentUser
    *
    * pega o usuário atualmente logado
    *
    */
    public function currentUser() {

        // carrega a model
        $this->ci->load->model( 'Funcionarios/Funcionario' );

        // pega o uid da sessao
        $CodFuncionario = $this->ci->session->userdata( 'funcionario' );

        // pega pelo uid
        $funcionario = $this->ci->Funcionario->clean()->key( $CodFuncionario )->get( true );

        // verifica se existe um usuário
        if ( $funcionario ) {

            // pega o token da sessao
            $token = $this->ci->session->userdata( 'token' );

            // verifica se os tokens são iguais
            if ( $token == $funcionario->token ) return $funcionario;

            // limpa a sessao
            $funcionario->logout();
        }

        // retorna nulo por padrao
        return null;
    }
}

/* end of file */

<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends MY_Controller {

    // somente para usuários logados
    public $isFreeToEveryOne = true;
    
   /**
    * __construct
    *
    * metodo construtor
    *
    */
    public function __construct() {
        parent::__construct();
    
        // carrega as libraries
        $this->load->library( [ 'Request', 'Response' ] );
    }

   /**
    * login
    *
    * faz o login no aplicativo
    *
    */
    public function login() {

        // carrega a model de clientes
        $this->load->model( 'Clientes/Cliente' );

        // pega o email
        $email = $this->input->post( 'email' );
        $senha = $this->input->post( 'senha' );

        // carrega o cliente com o email
        $cliente = $this->Cliente->clean()->email( $email )->get( true );
        if ( !$cliente ) return $this->response->reject( 'E-mail não cadastrado' );

        // verifica a senha
        if ( $cliente->verificarSenha( $senha ) ) {

            // gera o token
            if ( $cliente->gerarToken()->save() ) {
                $cliente = [
                    'email' => $cliente->email,
                    'token' => $cliente->token
                ];
                $this->response->resolve( $cliente );
            } else return $this->response->reject( 'Não foi possivel logar.' );
        } else return $this->response->reject( 'A senha digitada está incorreta' );
    }

    public function autenticada() {

        // verifica se o usuario esta logado
        $this->request->logged();

        // mensagem de teste
        $this->response->resolve( $this->request->cliente->nome );
    }
}

/* end of file */

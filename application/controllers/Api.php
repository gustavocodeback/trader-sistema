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
        
        // adiciona o json ao post
        $data = json_decode(file_get_contents('php://input'), true);
        if ( $data ) $_POST = $data; 
    
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
                return $this->response->resolve( $cliente );
            } else return $this->response->reject( 'Não foi possivel logar.' );
        } else return $this->response->reject( 'A senha digitada está incorreta' );
    }
    
   /**
    * resetar
    *
    * resetar a senha
    *
    */
    public function resetar() {

        // carrega o model
        $this->load->model( [ 'Clientes/Cliente' ] );
        $user = $this->Cliente->clean()->email( $this->input->post( 'email' ) )->get( true );
        if ( !$user ) {
            return $this->response->reject( 'Email inexistente no sistema.' );
        }
        $user->set( 'tokenEmail', md5( uniqid( time() * rand() ) ) );
        $user->save();

        // verifica se o dado foi salvo
        if ( $this->enviarEmailVerificacao( $user->email, $user->tokenEmail ) ) {
            return $this->response->resolve( [ 'mensagem' => "Senha resetada com sucesso." ] );
        } else {
            return $this->response->reject( 'Não foi possivel no momento, tente novamente mais tarde.' );
        }
    }

   /**
    * enviarEmailVerificacao
    *
    * envia o email de verificacao
    *
    */
    private function enviarEmailVerificacao( $email, $token ) {

        // carrega o template
        $this->load->model( 'Templates/Template' );
        $template = $this->Template->template( 'TEMPLATE_RECOVERY_CLIENTE' )->get( true );
        
        // adiciona os parametros customizaveis
        $template->corpo = str_replace( '%_TOKEN_%', site_url( 'recovery/recovery_cliente/'.$token ), $template->corpo );

        // configuracoes do email
        $config = [
            'mailtype' => 'html',
            'charset'  => 'iso-8859-1'
        ];

        // carrega a library
        $this->load->library( 'email', $config );

        // seta os emails
        $this->email->from( 'vihh.fernando@gmail.com', "Suporte" )
        ->to( $email )

        // seta o corpo
        ->subject( 'Recuperacao de Senha Equipe Trader' )
        ->message( $template->corpo )
        ->set_mailtype( 'html' );
        
        // envia o email
        if( $this->email->send() ) {
            return true;
        } else {
            return false;
        }
    }

    public function autenticada() {

        // verifica se o usuario esta logado
        $this->request->logged();

        // mensagem de teste
        $this->response->resolve( $this->request->cliente->nome );
    }
}

/* end of file */

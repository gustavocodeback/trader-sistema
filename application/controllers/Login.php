<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends MY_Controller {

    // somente para usuários não logados
    public $unloggedUsersOnly = true;

   /**
    * __construct
    *
    * metodo construtor
    *
    */
    public function __construct() {
        parent::__construct();

        // carrega a model de usuário
        $this->load->model( 'Funcionarios/Funcionario' );
    }

   /**
    * index
    *
    * mostra o formulário de login
    *
    */
    public function index() {

        // carrega a pagina
        $this->view->module( 'login' )->setTitle( 'Entrar' )->render( 'login/login' );
    }

   /**
    * signup
    *
    * mostra o formulário de cadastro
    *
    */
    public function signup() {

        // carrega a pagina
        $this->view->module( 'login' )->setTitle( 'Nova conta' )->render( 'login/signup' );
    }

   /**
    * forgot_password
    *
    * mostra o formulário de esqueci minha senha
    *
    */
    public function forgot_password() {
        
        // carrega a pagina
        $this->view->module( 'login' )->setTitle( 'Esqueci minha senha' )->render( 'login/forgot-password' );
    }

   /**
    * nova_conta
    *
    * cria uma nova conta
    *
    */
    public function nova_conta() {
        
        // carrega a nova instancia do usuário
        $usuario = $this->Usuario->getEntity();

        // verifica se o usuário é válido
        if( $usuario->validar() ) {

            // pega os dados do usuário do formulário enviado
            $usuario->gerarUID()->form()->save();

        }  else {

            // seta os erros
            $this->view->set( 'errors', validation_errors() );

            // carrega a pagina
            $this->view->module( 'login' )->setTitle( 'Nova conta' )->render( 'login/signup' );
        }
    }

   /**
    * logar
    *
    * faz o login
    *
    */
    public function logar() {

        // carrega o usuario pelo email
        $funcionario = $this->Funcionario->clean()->email( $this->input->post( 'email' ) )->get( true );
        
        // verifica se existe um funcionário
        if ( !$funcionario ) {
            $this->view->set( 'error', 'O e-mail digitado não está cadastrado' );
            return $this->index();
        }

        // faz a validacao da senha
        if ( !$funcionario->verificarSenha( $this->input->post( 'senha' ) ) ) {
            $this->view->set( 'error', 'O senha digitada está incorreta' );
            return $this->index();
        }

        // faz o login
        if ( $funcionario->login() ) {

            // redireciona para a home
            redirect( site_url( 'home' ) );
        } else {

            // seta a mensagem de erro
            $this->view->set( 'error', 'Não foi possivel fazer login' );
            return $this->index();
        }
    }
}

/* end of file */

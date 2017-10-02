<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MY_Controller {

    // somente para usuários logados
    public $loggedUsersOnly = true;
    
   /**
    * __construct
    *
    * metodo construtor
    *
    */
    public function __construct() {
        parent::__construct();

        // carrega o módulo da capa
        $this->view->module( 'cover' )->set( 'navbar-index', 1 );
    }

   /**
    * index
    *
    * mostra o formulário de login
    *
    */
    public function index() {

        // carrega a pagina
        $this->view->module( 'login' )->setTitle( 'Entrar' )->render( 'home/home' );
    }

   /**
    * logout
    *
    * faz o logout
    *
    */
    public function logout() {

        // carrega o usuário
        $usuario = $this->guard->currentUser();

        // faz o logout
        $usuario->logout();

        // redireciona para o login
        redirect( site_url() );
    }
}

/* end of file */

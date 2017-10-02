<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Acessos extends MY_Controller {

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
        $this->view->module( 'acessos' )->set( 'aside-index', 4 );
    }

   /**
    * index
    *
    * mostra o formulário de login
    *
    */
    public function index() {

        // carrega a pagina
        $this->view->setTitle( 'Minha Agenda' )->render( 'acessos/acessos' );
    }

   /**
    * buscar_usuarios
    *
    * busca os usuaŕios por e-mail
    *
    */
    public function buscar_usuarios() {
        
        // pega o filtro enviado no post
        $email    = $this->input->post( 'email' );
        $usuarios = [];
        
        // se um e-mail tiver sido enviado
        if ( $email ) {
            // carrega a model
            $this->load->model( 'Usuarios/Usuario' );
        
            // pega os usuarios pelo email
            $usuarios = $this->Usuario->ignorarAtual()->email( $email )->get();
        }

        // carrega a view
        $this->view->set( 'usuarios', $usuarios );
        $this->view->render( 'acessos/users', false );
    }
}

/* end of file */

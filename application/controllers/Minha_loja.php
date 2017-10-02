<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Minha_loja extends MY_Controller {

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
        $this->view->module( 'minha_loja' )->set( 'navbar-index', 1 );
    }

   /**
    * index
    *
    * mostra o formulário de login
    *
    */
    public function index() {

        // carrega a pagina
        $this->view->module( 'login' )
                   ->set( 'aside-index', 1 )
                   ->setTitle( 'Minha loja' )
                   ->render( 'minha_loja/minha_loja' );
    }
}

/* end of file */

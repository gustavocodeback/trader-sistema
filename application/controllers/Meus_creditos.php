<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Meus_creditos extends MY_Controller {

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
        $this->view->module( 'meus_creditos' )->set( 'navbar-index', 1 );
    }

   /**
    * index
    *
    * mostra o formulário de login
    *
    */
    public function index() {

        // carrega a pagina
        $this->view->set( 'aside-index', 5 )
                   ->setTitle( 'Meus créditos' )
                   ->render( 'meus_creditos/index' );
    }
}

/* end of file */

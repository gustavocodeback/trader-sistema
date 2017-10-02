<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Agenda extends MY_Controller {

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
        $this->view->module( 'calendar' )->set( 'navbar-index', 2 );
    }

   /**
    * index
    *
    * mostra o formulário de login
    *
    */
    public function index() {

        // carrega a pagina
        $this->view->setTitle( 'Minha Agenda' )->render( 'agenda/agenda' );
    }
}

/* end of file */

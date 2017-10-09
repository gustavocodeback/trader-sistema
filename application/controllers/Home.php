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

        // carrega o finder
        $this->load->model( [ 'Mensagens/Mensagem', 'Tickets/Ticket', 'Clientes/Cliente' ] );

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
        
        // Pega o id do funcionario logado
        $user = $this->guard->currentUser();
        
        // pega todas as empresas ativas
        $num_clientes_geral = $this->Cliente->clean()->funcionario( $user->CodFuncionario )->get();
        $this->view->set( 'num_clientes_geral', count( $num_clientes_geral ) );
        
        // pega todas as empresas ativas
        $num_clientes_trader = $this->Cliente->clean()->funcionario( $user->CodFuncionario )->trader()->get();
        $this->view->set( 'num_clientes_trader', count( $num_clientes_trader ) );
        
        // pega todas as empresas ativas
        $num_clientes_inativo = $this->Cliente->clean()->funcionario( $user->CodFuncionario )->inativo()->get();
        $this->view->set( 'num_clientes_inativo', count( $num_clientes_inativo ) );
        
        // pega todas as empresas ativas
        $num_mensagens_new = $this->Mensagem->clean()->funcionario( $user->CodFuncionario )->nLida()->autor( 'C' )->get();
        $this->view->set( 'num_mensagens_new', count( $num_mensagens_new ) );

        // pega todas as empresas inativas
        $num_tickets_abertos = $this->Ticket->clean()->funcionario( $user->CodFuncionario )->status( 'A' )->get();
        $this->view->set( 'num_tickets_abertos', count( $num_tickets_abertos ) );

        // pega todas as empresas inativas
        $num_tickets_resolvendo = $this->Ticket->clean()->funcionario( $user->CodFuncionario )->status( 'R' )->get();
        $this->view->set( 'num_tickets_resolvendo', count( $num_tickets_resolvendo ) );

        // pega todas as empresas inativas
        $num_tickets_resolvidos = $this->Ticket->clean()->funcionario( $user->CodFuncionario )->status( 'F' )->get();
        $this->view->set( 'num_tickets_resolvidos', count( $num_tickets_resolvidos ) );

        // carrega a pagina
        $this->view->module( 'login' )->setTitle( 'Home' )->render( 'home/home' );
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
